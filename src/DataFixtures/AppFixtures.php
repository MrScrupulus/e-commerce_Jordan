<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        $basketProducts = [
            [
                'name' => 'Air Jordan 1 Retro High OG',
                'model' => 'azerty1',
                'price' => 170.00,
                'quantity' => 15,
                'image' => 'jordan-1-retro-high-og-white-black-red.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 4 Retro',
                'model' => 'azerty2',
                'price' => 200.00,
                'quantity' => 12,
                'image' => 'jordan-4-retro-black-cement.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 11 Retro',
                'model' => 'azerty3',
                'price' => 220.00,
                'quantity' => 8,
                'image' => 'jordan-11-retro-concord.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 6 Retro',
                'model' => 'azerty4',
                'price' => 190.00,
                'quantity' => 10,
                'image' => 'jordan-6-retro-black-infrared.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 12 Retro',
                'model' => 'azerty5',
                'price' => 210.00,
                'quantity' => 6,
                'image' => 'jordan-12-retro-flu-game.jpg',
                'type' => 'basket'
            ]
        ];

      
        $clothingProducts = [
            [
                'name' => 'Jordan Jumpman Fleece Hoodie',
                'model' => 'azerty6',
                'price' => 85.00,
                'quantity' => 20,
                'image' => 'jordan-jumpman-fleece-hoodie-black.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Flight Heritage Jacket',
                'model' => 'azerty7',
                'price' => 120.00,
                'quantity' => 15,
                'image' => 'jordan-flight-heritage-jacket-red.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Jumpman Pro Shorts',
                'model' => 'azerty8',
                'price' => 45.00,
                'quantity' => 25,
                'image' => 'jordan-jumpman-pro-shorts-black.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Flight Legend T-Shirt',
                'model' => 'azerty9',
                'price' => 35.00,
                'quantity' => 30,
                'image' => 'jordan-flight-legend-tshirt-white.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Jumpman Fleece Pants',
                'model' => 'azerty10',
                'price' => 75.00,
                'quantity' => 18,
                'image' => 'jordan-jumpman-fleece-pants-grey.jpg',
                'type' => 'vêtement'
            ]
        ];

        
        $allProducts = array_merge($basketProducts, $clothingProducts);

        foreach ($allProducts as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setModel($productData['model']);
            $product->setPrice($productData['price']);
            $product->setQuantity($productData['quantity']);
            $product->setImage($productData['image']);
            $product->setType($productData['type']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
