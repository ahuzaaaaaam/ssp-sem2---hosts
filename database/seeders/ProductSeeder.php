<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Margherita Pizza',
                'description' => 'Classic cheese pizza with tomato sauce and fresh basil',
                'price' => 9.99,
                'image_url' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002',
                'veg' => 'Yes',
                'featured' => 'Yes',
            ],
            [
                'name' => 'Pepperoni Pizza',
                'description' => 'Classic pepperoni pizza with tomato sauce and mozzarella',
                'price' => 11.99,
                'image_url' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e',
                'veg' => 'No',
                'featured' => 'Yes',
            ],
            [
                'name' => 'Vegetarian Supreme',
                'description' => 'Loaded with bell peppers, mushrooms, onions, olives, and tomatoes',
                'price' => 12.99,
                'image_url' => 'https://images.unsplash.com/photo-1604917877934-07d8d248d396',
                'veg' => 'Yes',
                'featured' => 'Yes',
            ],
            [
                'name' => 'BBQ Chicken Pizza',
                'description' => 'Grilled chicken with BBQ sauce, red onions, and cilantro',
                'price' => 13.99,
                'image_url' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38',
                'veg' => 'No',
                'featured' => 'No',
            ],
            [
                'name' => 'Hawaiian Pizza',
                'description' => 'Ham and pineapple with tomato sauce and mozzarella',
                'price' => 12.49,
                'image_url' => 'https://images.unsplash.com/photo-1594007654729-407eedc4fe0f',
                'veg' => 'No',
                'featured' => 'No',
            ],
            [
                'name' => 'Mushroom Truffle Pizza',
                'description' => 'Assorted mushrooms with truffle oil and fresh arugula',
                'price' => 14.99,
                'image_url' => 'https://images.unsplash.com/photo-1571407970349-bc81e7e96d47',
                'veg' => 'Yes',
                'featured' => 'No',
            ],
            [
                'name' => 'Meat Lovers Pizza',
                'description' => 'Loaded with pepperoni, sausage, bacon, and ground beef',
                'price' => 15.99,
                'image_url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591',
                'veg' => 'No',
                'featured' => 'Yes',
            ],
            [
                'name' => 'Buffalo Chicken Pizza',
                'description' => 'Spicy buffalo chicken with blue cheese and ranch drizzle',
                'price' => 13.99,
                'image_url' => 'https://images.unsplash.com/photo-1593246049226-ded77bf90326',
                'veg' => 'No',
                'featured' => 'No',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
