<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Categories');

        // in addition to a string, the argument of the singular and plural label methods
        // can be a closure that defines two nullable arguments: entityInstance (which will
        // be null in 'index' and 'new' pages) and the current page name


        // the Symfony Security permission needed to manage the entity
        // (none by default, so you can manage all instances of the entity)
//            ->setEntityPermission('ROLE_EDITOR')
//            ;
    }

}
