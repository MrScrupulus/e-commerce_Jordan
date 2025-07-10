<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $user = $this->getUser();
        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
        }

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function addToCart(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
        }

        $existingCartItem = null;
        foreach ($cart->getCartItems() as $cartItem) {
            if ($cartItem->getProduct()->getId() === $product->getId()) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        // Vérifier le stock restant
        if ($product->getQuantity() <= 0) {
            $this->addFlash('error', 'Ce produit n\'est plus disponible.');
            return $this->redirectToRoute('app_product');
        }

        if ($existingCartItem) {
            // On ne peut pas ajouter plus que le stock restant
            if ($product->getQuantity() < 1) {
                $this->addFlash('error', "Il n'y a plus de stock pour ce produit.");
                return $this->redirectToRoute('app_product');
            }
            $existingCartItem->setQuantity($existingCartItem->getQuantity() + 1);
            $product->setQuantity($product->getQuantity() - 1);
        } else {
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQuantity(1);
            $entityManager->persist($cartItem);
            $product->setQuantity($product->getQuantity() - 1);
        }

        $cart->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->flush();

        $this->addFlash('success', 'Produit ajouté au panier !');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function updateQuantity(CartItem $cartItem, Request $request, EntityManagerInterface $entityManager): Response
    {
        $quantity = (int) $request->request->get('quantity', 1);
        $product = $cartItem->getProduct();
        $currentQuantity = $cartItem->getQuantity();

        if ($quantity <= 0) {
            // Remettre le stock si on supprime l'item
            $product->setQuantity($product->getQuantity() + $currentQuantity);
            $entityManager->remove($cartItem);
        } else {
            // Calculer la différence
            $diff = $quantity - $currentQuantity;

            if ($diff > 0) {
                // On veut augmenter la quantité
                if ($diff <= $product->getQuantity()) {
                    $cartItem->setQuantity($quantity);
                    $product->setQuantity($product->getQuantity() - $diff);
                } else {
                    $this->addFlash('error', "Il n'y a que {$product->getQuantity()} produits en stock, choisis une valeur égale ou inférieur.");
                    return $this->redirectToRoute('app_cart');
                }
            } elseif ($diff < 0) {
                // On veut diminuer la quantité
                $cartItem->setQuantity($quantity);
                $product->setQuantity($product->getQuantity() + abs($diff));
            }
            // Si diff = 0, rien à faire
        }

        $cartItem->getCart()->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->flush();

        $this->addFlash('success', 'Panier mis à jour !');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function removeFromCart(CartItem $cartItem, EntityManagerInterface $entityManager): Response
    {
        $product = $cartItem->getProduct();
        $product->setQuantity($product->getQuantity() + $cartItem->getQuantity()); // Remet le stock
        $entityManager->remove($cartItem);
        $cartItem->getCart()->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->flush();

        $this->addFlash('success', 'Produit retiré du panier !');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/clear', name: 'app_cart_clear', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function clearCart(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cart = $user->getCart();

        if ($cart) {
            foreach ($cart->getCartItems() as $cartItem) {
                $product = $cartItem->getProduct();
                $product->setQuantity($product->getQuantity() + $cartItem->getQuantity()); // Remet le stock
                $entityManager->remove($cartItem);
            }
            $cart->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();
        }

        $this->addFlash('success', 'Panier vidé !');
        return $this->redirectToRoute('app_cart');
    }
}
