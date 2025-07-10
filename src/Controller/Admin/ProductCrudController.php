<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Product;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            ->setPageTitle('index', 'Gestion des produits Jordan')
            ->setPageTitle('new', 'Ajouter un produit')
            ->setPageTitle('edit', 'Modifier le produit')
            ->setPageTitle('detail', 'Détails du produit');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom')
                ->setRequired(true)
                ->setHelp('Le nom du produit est obligatoire'),
            TextField::new('model', 'Modèle')
                ->setRequired(true)
                ->setHelp('Le modèle du produit est obligatoire'),
            MoneyField::new('price', 'Prix')
                ->setCurrency('EUR')
                ->setStoredAsCents(false)
                ->setRequired(true)
                ->setHelp('Le prix doit être positif (ex: 170.00 pour 170€)')
                ->setFormTypeOption('attr', ['min' => 0.01, 'step' => 0.01]),
            IntegerField::new('quantity', 'Quantité')
                ->setRequired(true)
                ->setHelp('La quantité en stock (0 = rupture de stock)')
                ->setFormTypeOption('attr', ['min' => 0]),
            ChoiceField::new('type', 'Type')
                ->setRequired(true)
                ->setChoices([
                    'Basket' => 'basket',
                    'Vêtement' => 'vêtement'
                ])
                ->setHelp('Le type doit être soit "vêtement" soit "basket"'),
            ImageField::new('image', 'Image')
                ->setBasePath('images/products/')
                ->setUploadDir('public/images/products/')
                ->setRequired(true)
                ->setHelp('Format accepté: JPG, PNG, WEBP. Taille max: 2MB')
                ->setFormTypeOption('attr', ['accept' => 'image/*'])
        ];
    }
}
