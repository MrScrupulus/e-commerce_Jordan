<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Produits Jordan - Baskets
        $basketProducts = [
            [
                'name' => 'Air Jordan 1 Retro High OG',
                'model' => '555088-101',
                'price' => 170.00,
                'quantity' => 15,
                'image' => 'jordan-1-retro-high-og-white-black-red.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 4 Retro',
                'model' => '308497-060',
                'price' => 200.00,
                'quantity' => 12,
                'image' => 'jordan-4-retro-black-cement.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 11 Retro',
                'model' => '378037-123',
                'price' => 220.00,
                'quantity' => 8,
                'image' => 'jordan-11-retro-concord.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 6 Retro',
                'model' => '384664-060',
                'price' => 190.00,
                'quantity' => 10,
                'image' => 'jordan-6-retro-black-infrared.jpg',
                'type' => 'basket'
            ],
            [
                'name' => 'Air Jordan 12 Retro',
                'model' => '130690-123',
                'price' => 210.00,
                'quantity' => 6,
                'image' => 'jordan-12-retro-flu-game.jpg',
                'type' => 'basket'
            ]
        ];

        // Produits Jordan - Vêtements
        $clothingProducts = [
            [
                'name' => 'Jordan Jumpman Fleece Hoodie',
                'model' => 'DD8955-010',
                'price' => 85.00,
                'quantity' => 20,
                'image' => 'jordan-jumpman-fleece-hoodie-black.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Flight Heritage Jacket',
                'model' => 'DD8956-010',
                'price' => 120.00,
                'quantity' => 15,
                'image' => 'jordan-flight-heritage-jacket-red.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Jumpman Pro Shorts',
                'model' => 'DD8957-010',
                'price' => 45.00,
                'quantity' => 25,
                'image' => 'jordan-jumpman-pro-shorts-black.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Flight Legend T-Shirt',
                'model' => 'DD8958-010',
                'price' => 35.00,
                'quantity' => 30,
                'image' => 'jordan-flight-legend-tshirt-white.jpg',
                'type' => 'vêtement'
            ],
            [
                'name' => 'Jordan Jumpman Fleece Pants',
                'model' => 'DD8959-010',
                'price' => 75.00,
                'quantity' => 18,
                'image' => 'jordan-jumpman-fleece-pants-grey.jpg',
                'type' => 'vêtement'
            ]
        ];

        // Créer tous les produits
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
