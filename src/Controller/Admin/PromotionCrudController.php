<?php

namespace App\Controller\Admin;

use App\Entity\Promotion;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promotion::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('teaser'),
            TextEditorField::new('text'),
            AssociationField::new('shop'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Promotion')
            ->setEntityLabelInPlural('Promotions');

        // in addition to a string, the argument of the singular and plural label methods
        // can be a closure that defines two nullable arguments: entityInstance (which will
        // be null in 'index' and 'new' pages) and the current page name


        // the Symfony Security permission needed to manage the entity
        // (none by default, so you can manage all instances of the entity)
//            ->setEntityPermission('ROLE_EDITOR')
//            ;
    }

}
