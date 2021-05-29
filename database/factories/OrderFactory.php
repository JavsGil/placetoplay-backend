<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'=> rand(1,1),
            'customer_name'=> $this->faker->name(80),
            'customer_email'=> $this->faker->email(),
            'customer_mobile'=> rand(1,11),
            'status'=> 'CREATED'
        ];
    }
}
