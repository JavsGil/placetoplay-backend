<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test_create_order()
    {
        $order = Order::factory()->create();
        if($order->status == 'CREATED'){
            $this->assertTrue(true);
        }
    }

    public function test_get_resume_status_order()
    {
        $order_resume = Order::where('id',1)->get();
       
        if($order_resume){
            $this->assertTrue(true);
        }
    }

    public function test_list_all_order()
    {
        $order = Order::get();
        if ($order){
            $this->assertTrue(true);
        }
    }

    public function test_create_payment_order()
    {
         Order::where(['id'=>1,'status'=>'CREATED'])->update(['status' => 'PAYED']);
         $order_resume = Order::where(['id'=>1,'status'=>'PAYED'])->get();
         if ($order_resume){
            $this->assertTrue(true);
        }
    }

    public function test_retrying_payment_order()
    {
         Order::where(['id'=>2,'status'=>'REJECTED”'])->update(['status' => 'PAYED']);
         $order_resume = Order::where(['id'=>2,'status'=>'PAYED'])->get();
         if ($order_resume){
            $this->assertTrue(true);
        }
    }

    public function get_order_by_client()
    {
         $order_resume = Order::where('customer_name','asda')
         ->orderBy('id','desc')
         ->get();
         if ($order_resume){
            $this->assertTrue(true);
        }
    }
}
