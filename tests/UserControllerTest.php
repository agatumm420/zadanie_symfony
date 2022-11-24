<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function test_register(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/register',[

                'email'=>'agnieszkatumm@gmail.com',
                'password'=>'GuGu2325'

        ]);

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Hello World');
    }
//    public function test_login():void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('POST', '/api/login_check',[
//
//            'email'=>'agnieszkatumm@gmail.com',
//            'password'=>'GuGu2325'
//
//        ]);
//
//        $this->assertResponseIsSuccessful();
//
//    }
//    public function test_refresh():void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('POST', '/api/token/refresh',[
//
//            'email'=>'agnieszkatumm@gmail.com',
//            'password'=>'GuGu2325'
//
//        ]);
//
//        $this->assertResponseIsSuccessful();
//    }


}
