<?php

namespace App\Http\Controllers;

// use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Http\Services\PlaceToPay;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    protected $PlaceToPay;

    public function __construct(PlaceToPay $PlaceToPay)
    {
        $this->PlaceToPay = $PlaceToPay;
    }

    public function CreateOrder(Request $request): Object
    {
        try {
            $order = Order::create($request->all());
            return response()->json($order, 200);
        } catch (ModelNotFoundException $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function CreatePaymentOrder(Request $request): Object
    {
        try {
            $response =  $this->PlaceToPay->PaymentGateway($request->all());
            return  response()->json($response->original);
        } catch (ModelNotFoundException $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function GetResumeOrderStatus(int $id): Object
    {
        try {
            $order = Order::where('id', $id)->first();
            $total = Order::where('id', $id)->count();
            return response()->json(['detail' => $order, 'total' => $total], 200);
        } catch (ModelNotFoundException $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function GetListOrderStore(): Object
    {
        try {
            $order = Order::orderBy('id', 'desc')->get();
            return response()->json($order, 200);
        } catch (ModelNotFoundException $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function GetOrderByClient(): Object
    {
        try {
            $order = Order::where('customer_name', 'test1')
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($order, 200);
        } catch (ModelNotFoundException $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function InfoTransaction(Request $request)
    {
        try {
            $trans = $this->PlaceToPay->TransActionInfo($request['requestId']);
            
            $status =  response()->json($trans->original->status->status);

            switch ($status) {
                case 'PAYED':
                    Order::where(['id' => $request['reference'], 'status' => 'CREATED'])
                        ->Orwhere(['id' => $request['reference'], 'status' => 'REJECT'])
                        ->update(['status' => 'PAYED']);
                    break;

                case 'REJECT':
                    Order::where(['id' => $request['reference'], 'status' => 'CREATED'])->update(['status' => 'REJECT']);
                    break;

                default:
                     return response()->json($trans->original);
                    break;
            }

            return response()->json('Order ID #: ' . $request['reference'] . ' updated to ' . $request['status'], 200);
            

        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

}
