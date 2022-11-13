<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(ShopRepository $shopRepository) :JsonResponse
    {
        $shops=$shopRepository->findAll();
        return $this->json([
            'data'=>[
                array_map(function ($shop){
                    return ['shop_id'=>$shop->getId(),
                        'name'=>$shop->getName(),
                        'box'=>$shop->getBox(),
                        'level'=>$shop->getLevel(),
                        'categories'=>$shop->getCategories()->map(function ($cat){
                            return [
                                'id'=>$cat->getId(),
                                'name'=>$cat->getName()
                            ];
                        })->toArray(),
                        'promotions'=>$shop->getPromotions()->map(function ($promo){
                            return [
                                'id'=>$promo->getId(),
                                'name'=>$promo->getName(),
                                'teaser'=>$promo->getTeaser(),
                                'text'=>$promo->getText()
                            ];
                        })->toArray(),];
                }, $shops)
            ]
        ]);

    }
    #[Route('/shop_show/{id}', name: 'shop.show')]
    public function show($id, ShopRepository $shopRepository) :JsonResponse{
        $shop=$shopRepository->find($id);
         //dd($shop->getCategories()->toArray()); //to tutaj jest
        return $this->json([
           'data'=>[
               'shop_id'=>$shop->getId(),
               'name'=>$shop->getName(),
               'box'=>$shop->getBox(),
               'level'=>$shop->getLevel(),
               'categories'=>$shop->getCategories()->map(function ($cat){
                   return [
                       'id'=>$cat->getId(),
                       'name'=>$cat->getName()
                   ];
               })->toArray(),
               'promotions'=>$shop->getPromotions()->map(function ($promo){
                   return [
                       'id'=>$promo->getId(),
                       'name'=>$promo->getName(),
                       'teaser'=>$promo->getTeaser(),
                       'text'=>$promo->getText()
                   ];
               })->toArray(),
           ]
        ]);
    }
}
