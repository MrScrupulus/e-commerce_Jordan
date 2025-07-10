<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $type = $request->query->get('type');

        if ($type && in_array($type, ['basket', 'vêtement'])) {
            $products = $productRepository->findByType($type);
        } else {
            $products = $productRepository->findAvailable();
        }

        return $this->render('product/product.html.twig', [
            'products' => $products,
        ]);
    }
}
