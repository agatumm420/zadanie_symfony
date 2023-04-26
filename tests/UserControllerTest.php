<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
{
//    public function test_register(): void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('POST', '/api/register',[
//                'name'=>'Bunia',
//                'surname'=>'Tumm',
//                'email'=>'bunia@gmail.com',
//                'password'=>'GuGu2325',
//                'repeated'=>'GuGu2325'
//
//        ]);
//
//        $this->assertResponseIsSuccessful();
//        //$this->assertSelectorTextContains('h1', 'Hello World');
////    }
//    public function test_login():void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('POST', '/api/login_token',[
//
//            'email'=>'bunia@gmail.com',
//            'password'=>'GuGu2325'
//
//        ]);
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//
//    }
//    public function test_list():void
//    {
//        $client = static::createClient();
//        $token='eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI0MjQ0MDUsImV4cCI6MTY4MjQyODAwNSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.XkpqOq_2X1hoYw9oBfEeU4H7OVswemjLrdyQXdA7Z9LJJcq6WemKZpX-r_74pxxPGpoIbFvlWg3arT2Pgp6Dpvk61vQhsC9PuqMopEXD-YrEMDHqW3j3Z3IMm0VGmwWE6kG_71N3BxXRdqrEiNmYvIxjcWXwiacHpyh56wI4gi5r2cwsEgxcBCNvI9aQlBrDX-JE4Mn8XgyRE84sAZC0X4m5MCupNtho_f5_oJC13Hokvc3muBAP4ZOMnsxuH2LknVMKfsn72z6hSOG_y_DCVIhGKh6sxD9PEFdRV-K0U18c4qQoxKkBMvHqPT2Iped-Wx-NZLC-cE2t86hV5MZKKyUkc11E310QVVwaNDczFLQYsHDHdvlzxOZcVmW4HgA5evDXs8THp7AK2IKrnrul_LEZ7hCKENng0a5z_AqrAPU31-tFa4kJSsq_uL1Y7_Vc8w2CcdJatiSOWfVN4QAoZ8uRRME_Iuh461qSDVRNy4XQDYJlU6IMuFVng_15K2NfO6NEk6edTLENeVn8jbivk8zTcCVsiqcNZKWEOLp-fBqgBRvcc913YInihYPI_ZwkG8tsdj7eNixECpNCnrVmLo6n2VU-gFhXnWD7qiocn4vXDyAMIhbRMzmyAsXTVXX0rubh1jA5tANWaDAkaR7GafmmswOTxJKEG7AVdk833zM'; $crawler = $client->request('GET', '/api/book',[], [], [
//            'HTTP_Authorization' => 'Bearer ' . $token,
//        ]);
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//
//    }
//public function test_add_digits():void{
//        $client = static::createClient();
//        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI1MjgzMjUsImV4cCI6MTY4MjUzMTkyNSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.sINbPD1ECE9dZjEjg1KGu9Q4OsHBb7edPu-vAw2EJi9ZAhA5LNv_OHqP0l7i1u47X7_2vO_ZRMGHKqNm6IXHKDW4KZYiE44AVim73OLm-AhMjNLetTEFr3kVPqZcX-PmzfXWi4DnzE3dBYA3m675Gp19D_bAamIBxrlv_V8XngSAUjZhSemqWJEk70CGLeDR1EJHjjATB_7mFBhVaUPkzZLUbhhxDDwPYpexKb0Bx236OcHdnkmu6jXO_J-cBen0Dbd_EP3V2luK9O4i7VJThXbLnHVhb98dJEX3hUpLdKJOL3lBIMwEAX1F_9pB-4yPhwc1CQXbOFuffvlDMP3ho8BNhS24WdPByuxoXq9YovAatvRyfkUNG_LhTdN7-pavdoUXv95vWq3N4MluKUdT7rc89llryPbKayJlXWhJ0Yhr_9yFk_hib3h3gTTNT6JIh6z9WRoe6wPNqPtsTVJU-tMXsTNGIR8JrELIyvR6w51NeKFrd27ZCx-3II13sLZGo7v3Q_DHcqiy5jeCPOBzTnwPDTAJWHECbND-AXWlcrXCqhMPfXW8hDIaGZON5-zdINAzHRbDd4e8Zqg2xGnyTqUkeSCcer3wTBcYNxwTGhqEEiZq-xojeODRtu8Ynb_OV95sWT9JJ0PFO5zNv_FszziyN9Xo_LEX2B84sxjm2Fc';   $data = [
//            'title' => 'Worong',
//            'description' => 'Fav',
//            'ISBN' => '666'
//        ];
//
//        $crawler = $client->request(
//            'POST', // Change the method to POST
//            '/api/book/add',
//            [],
//            [],
//            [
//                'HTTP_Authorization' => 'Bearer ' . $token,
//                'CONTENT_TYPE' => 'application/json', // Set the content type
//            ],
//            json_encode($data) // Encode the data as a JSON string
//        );
//
//        $response = $client->getResponse();
////        dump($response);
//
//        $this->assertResponseStatusCodeSame(400, $response->getStatusCode());
//}

//    public function test_add(): void
//    {
//        $client = static::createClient();
//        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI0OTIzNjUsImV4cCI6MTY4MjQ5NTk2NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.D1EWZC_d9fKwvAsVrNwlr5c2NZKdMbyQiQzktTD9S6pIm-byOOQBbWjobBeH1lf1eVWgmJ5mENFeVnP3RBM01rPUbIjvPJmjtjNt9QxiqkpFq4ca6sIGqZuTZsbLfint4rcguaWapy9CKfN8Paj3T5BmqvNdsXB2ORiru51TpAHtmk1D_p6Ti_iE7xvs7mewRO9imDFaFJyZ2by6kcc_cYP1I-DQ13ENyQCjTFY-72hVx0csrMyX0Wh7wT2IXarQkGUQhQOpSj5jIm2c5IieyWAwN2P7FkXJlNr-jQ62trYK22ukJUmgfCFORWG5kuvVFX3Nws0bOQxQ_I3tAykxXlRN6Jn714ZmY6VfjJ7GmYeJH9c0uhakJ2O0YeZGbkDJoqjkwHH5CIjYDjnApwgpcmuWHFtJmfh52TIIv3DCNCXCOWyj5ZE6ZeXD6x9S1qJAkM2wBzKwVbvawhqUEK0aEQu_c5-TkAT64mhFPoOSRJ7uF7eIMalRCz7FoF4lX4rfktwriTJKmqtg8bk5FsuUYIeQWMFVLbiOcI3EnaI3mQMG6ovmMhAPfYzXddG3uOti2oYs9oa8eYTeQdKAyPviS1CsjHx5j3wyX8Dvu8Jyu8BMlI_7YJ6nG2M4kSURfSHDDUYBFL5gD3nVFhn4Yvby-Ch51TFH2yYjKGujrFFxz5Q';
//        $data = [
//            'title' => 'Morfina',
//            'description' => 'Fav',
//            'ISBN' => '66666703'
//        ];
//
//        $crawler = $client->request(
//            'POST', // Change the method to POST
//            '/api/book/add',
//            [],
//            [],
//            [
//                'HTTP_Authorization' => 'Bearer ' . $token,
//                'CONTENT_TYPE' => 'application/json', // Set the content type
//            ],
//            json_encode($data) // Encode the data as a JSON string
//        );
//
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//    }
//    public function test_update(): void
//    {
//        $client = static::createClient();
//        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI0MjU1NjYsImV4cCI6MTY4MjQyOTE2Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.CtsOiQ-3dM8HXno86_Z9FP8EAUyXIDC_DWUCxCS0HRsHPYJkJRxrr2joQIp19KmgiQbUdFXt5TU7sQV_qUtUlOFpiKYwMlaFcuzavVSpIogFQOAJqVo0o7DJMTPBmqXsWDac3c9ywrr_QLJlWbdVs26wcPF9JSqGdBBv-s9zv4ejgx7wqIo_y2ZX6ijlzfBrURWRZ5aTV6UlIZcvqyNj_IQIEn5z31uQfK9l4hiTow6rcEKGSj1CwhAgKNq5_G-almXCeQe3xcGbYZaOq1NbgxIXKdYk6dfDxiqyoHdXeCfBSmRcfM8i_7PsIfvXyH5W4UPM1_duxM40IjP8VzHMXBduR38qBVIcnzdeQ6nXdTFKm__9QpaSxPOC4i6bvyB4JeYT5a-doTwsXEk2dLq_afp5J8QYkkRzgn9LvBixHgUwW5q9P2xcHMa9ASBMgwlXIcgu5y5o1xLkVAstZiyzKnofur9OVSaUA48NiBTS9X0ye3mhFxCpWjVRhEVkWc6BuhfXJrt9VRvzXN-DkWgg0jYkH9igoa3XQikJpm8wzQdLoMm9m1mIBIZQqc8rMMYonI_6DW0C3D3VcJ8p9ZPDsf4nQClDpvoCP-ub__iXXiW7ZCh_vbHKMLtA3W0FG8z176EAqyB101XnvtCCSTa8Q62tsdBvXuwFRgCmuJ1Slmk';
//        $data = [
//
//            'description' => 'Read it or eat shit ',
//            'ISBN' => '66666699'
//        ];
//
//        $crawler = $client->request(
//            'POST', // Change the method to POST
//            '/api/book/update',
//            [],
//            [],
//            [
//                'HTTP_Authorization' => 'Bearer ' . $token,
//                'CONTENT_TYPE' => 'application/json', // Set the content type
//            ],
//            json_encode($data) // Encode the data as a JSON string
//        );
//
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//    }
//    public function test_delete(): void
//    {
//        $client = static::createClient();
//        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI0MjU1NjYsImV4cCI6MTY4MjQyOTE2Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.CtsOiQ-3dM8HXno86_Z9FP8EAUyXIDC_DWUCxCS0HRsHPYJkJRxrr2joQIp19KmgiQbUdFXt5TU7sQV_qUtUlOFpiKYwMlaFcuzavVSpIogFQOAJqVo0o7DJMTPBmqXsWDac3c9ywrr_QLJlWbdVs26wcPF9JSqGdBBv-s9zv4ejgx7wqIo_y2ZX6ijlzfBrURWRZ5aTV6UlIZcvqyNj_IQIEn5z31uQfK9l4hiTow6rcEKGSj1CwhAgKNq5_G-almXCeQe3xcGbYZaOq1NbgxIXKdYk6dfDxiqyoHdXeCfBSmRcfM8i_7PsIfvXyH5W4UPM1_duxM40IjP8VzHMXBduR38qBVIcnzdeQ6nXdTFKm__9QpaSxPOC4i6bvyB4JeYT5a-doTwsXEk2dLq_afp5J8QYkkRzgn9LvBixHgUwW5q9P2xcHMa9ASBMgwlXIcgu5y5o1xLkVAstZiyzKnofur9OVSaUA48NiBTS9X0ye3mhFxCpWjVRhEVkWc6BuhfXJrt9VRvzXN-DkWgg0jYkH9igoa3XQikJpm8wzQdLoMm9m1mIBIZQqc8rMMYonI_6DW0C3D3VcJ8p9ZPDsf4nQClDpvoCP-ub__iXXiW7ZCh_vbHKMLtA3W0FG8z176EAqyB101XnvtCCSTa8Q62tsdBvXuwFRgCmuJ1Slmk';
//        $data = [
//
//
//            'ISBN' => '66666699'
//        ];
//
//        $crawler = $client->request(
//            'POST', // Change the method to POST
//            '/api/book/delete',
//            [],
//            [],
//            [
//                'HTTP_Authorization' => 'Bearer ' . $token,
//                'CONTENT_TYPE' => 'application/json', // Set the content type
//            ],
//            json_encode($data) // Encode the data as a JSON string
//        );
//
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//    }
//   public function test_list_all(): void
//    {
//        $client = static::createClient();
//        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI0OTIzNjUsImV4cCI6MTY4MjQ5NTk2NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.D1EWZC_d9fKwvAsVrNwlr5c2NZKdMbyQiQzktTD9S6pIm-byOOQBbWjobBeH1lf1eVWgmJ5mENFeVnP3RBM01rPUbIjvPJmjtjNt9QxiqkpFq4ca6sIGqZuTZsbLfint4rcguaWapy9CKfN8Paj3T5BmqvNdsXB2ORiru51TpAHtmk1D_p6Ti_iE7xvs7mewRO9imDFaFJyZ2by6kcc_cYP1I-DQ13ENyQCjTFY-72hVx0csrMyX0Wh7wT2IXarQkGUQhQOpSj5jIm2c5IieyWAwN2P7FkXJlNr-jQ62trYK22ukJUmgfCFORWG5kuvVFX3Nws0bOQxQ_I3tAykxXlRN6Jn714ZmY6VfjJ7GmYeJH9c0uhakJ2O0YeZGbkDJoqjkwHH5CIjYDjnApwgpcmuWHFtJmfh52TIIv3DCNCXCOWyj5ZE6ZeXD6x9S1qJAkM2wBzKwVbvawhqUEK0aEQu_c5-TkAT64mhFPoOSRJ7uF7eIMalRCz7FoF4lX4rfktwriTJKmqtg8bk5FsuUYIeQWMFVLbiOcI3EnaI3mQMG6ovmMhAPfYzXddG3uOti2oYs9oa8eYTeQdKAyPviS1CsjHx5j3wyX8Dvu8Jyu8BMlI_7YJ6nG2M4kSURfSHDDUYBFL5gD3nVFhn4Yvby-Ch51TFH2yYjKGujrFFxz5Q';
//        $data = [
//
//
//            'ISBN' => '66666699'
//        ];
//        $page = 1;
//        $title = "";
//        $desc = "Eww";
//
//        $crawler = $client->request(
//            'GET',
//            "/api/book/list/all/page/{$page}?title={$title}&desc={$desc}",
//            [],
//            [],
//            [
//                'HTTP_Authorization' => 'Bearer ' . $token,
//                'CONTENT_TYPE' => 'application/json',
//            ]
//        );
//
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//    }
//    public function test_add_review(): void
//    {
//        $client = static::createClient();
//        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODI0OTYxNDIsImV4cCI6MTY4MjQ5OTc0Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiYnVuaWFAZ21haWwuY29tIn0.bXeBa_DAanR_tsC-olF5Tgu3BkR8YZowpjbmJ-gB4YVo_EtuYh6s17QRanXeRBvn_vrDKvoLTusG1tYgcultPUdPX19Fk0AKc1u-caNRBwI7zO7someIkhMatYx2b2CSzDWI_7d9zXnWngvfUNVODhhXyRdxj61bxRX9EWr1GuGAyewaSvEWnT4I61q6Do2rjURFcL2Wk4wpINTiEioFhLOAEj8x4czaZyIfmYMV-q85HMbziprisQ615VU3IjGWLeBmRP5TyauIMBSDfRlxvbDKTbialUm9sqgJ6dnDqFAfL4szl3gI-JSoVGyYgfgGCvW3eK7MoIQllSdGchpRCk85bvoDd6i2Xww9l88jhzCaO5WxQTR7h4-obMlDGgD3r6itHfXkmPsQT1BSrffLYwd42P0m_xJqPAkMjm9zkKpSDgX9O46xE7xPRDDVfGTFyMA5_eS7UATsKAbXP1ySdYyqGQPlLZxnP5Lxy5ME0oYxn8Q1HUY5qBr_R_A1e9mD9UKsR0zaDQCWs4-NVBMHkPyw2AiXT4GQuiXYApLEq0_VbBXS6MWpepgcQAJYcP4-AN2LlEOtvadzaxDVR89hnKWsyGuPQxOpIN_UrZqqbQSzXLbVXxn2d39Eq96iuMk_N9xd3p5cBD8iqTsrRDFadZ7hEv7KN7MVLPPZfm-iXyM';
//        $data = [
//            'rating'=>5,
//            'author'=>'xxx',
//            'description' => 'Read it or eat shit ',
//            'ISBN' => '66666700'
//        ];
//
//        $crawler = $client->request(
//            'POST', // Change the method to POST
//            '/api/add/review',
//            [],
//            [],
//            [
//                'HTTP_Authorization' => 'Bearer ' . $token,
//                'CONTENT_TYPE' => 'application/json', // Set the content type
//            ],
//            json_encode($data) // Encode the data as a JSON string
//        );
//
//        $response = $client->getResponse();
//        dump($response);
//
//        $this->assertResponseIsSuccessful();
//    }
////    public function test_refresh():void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('POST', '/api/token/refresh',[
//
//            'email'=>'bunia@gmail.com',
//            'password'=>'GuGu2325'
//
//        ]);
//
//        $this->assertResponseIsSuccessful();
//    }


}
