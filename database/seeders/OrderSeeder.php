<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users except admin
        $users = User::where('role', '!=', 'admin')->get();
        
        // Get all products
        $products = Product::all();
        
        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }
        
        // Create 2-5 orders for each user
        foreach ($users as $user) {
            $orderCount = rand(2, 5);
            
            for ($i = 0; $i < $orderCount; $i++) {
                // Create order with random status
                $statuses = ['pending', 'processing', 'completed', 'cancelled'];
                $status = $statuses[array_rand($statuses)];
                
                $subtotal = 0;
                
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => $status,
                    'address_line1' => fake()->streetAddress(),
                    'address_line2' => rand(0, 1) ? fake()->secondaryAddress() : null,
                    'city' => fake()->city(),
                    'state' => fake()->state(),
                    'postal_code' => fake()->postcode(),
                    'payment_method' => rand(0, 1) ? 'credit_card' : 'paypal',
                    'payment_status' => $status === 'cancelled' ? 'failed' : (in_array($status, ['completed', 'processing']) ? 'paid' : 'pending'),
                    'subtotal' => 0, // Will be updated after adding items
                    'tax' => 0, // Will be updated after adding items
                    'total' => 0, // Will be updated after adding items
                ]);
                
                // Add 1-5 random products to the order
                $itemCount = rand(1, 5);
                $orderProducts = $products->random($itemCount);
                
                foreach ($orderProducts as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    
                    // For pizza products, add random options
                    $options = null;
                    if (stripos($product->name, 'pizza') !== false) {
                        $crusts = ['Classic Hand Tossed', 'Thin Crust', 'Pan Pizza', 'Stuffed Crust'];
                        $toppings = ['Pepperoni', 'Mushrooms', 'Onions', 'Sausage', 'Bacon', 'Extra Cheese', 'Black Olives', 'Green Peppers'];
                        
                        $options = [
                            'crust' => $crusts[array_rand($crusts)],
                            'toppings' => array_slice($toppings, 0, rand(0, 5)),
                        ];
                    }
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'options' => $options,
                    ]);
                    
                    $subtotal += $price * $quantity;
                }
                
                // Update order totals
                $tax = round($subtotal * 0.08, 2); // 8% tax
                $total = $subtotal + $tax;
                
                $order->update([
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                ]);
            }
        }
    }
}
