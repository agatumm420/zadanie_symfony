<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\UserDto;
use App\ResponseRegistration;
use App\LoginResponse;
#[Route('/api', name: 'api')]
class UserController extends AbstractController
{
    /**
     * Registers user.
     *
     * If the email is already taken it will return error message.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ResponseRegistration::class, ))
     *     )
     * )

     * @OA\RequestBody(@Model(type=UserDto::class))
     * @OA\Tag(name="registration")
     *
     */
    #[Route('/register', name: '.registration',methods: 'POST')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine,)
    {
        $email=$request->request->get('email');
        $password=$request->request->get('password');
        //dd($data);
        $user_exists=$doctrine->getRepository(User::class)->findBy(['email'=>$email]); //wróc do tego

        //dd($user_exists);
        if($user_exists){
            return $this->json([
                'error'=>'User with this email already exists ',
            ]);
        }
        else{
            $user=new User();
            $user->setEmail($email);
            $user->setPassword(
                $passwordHasher->hashPassword($user,$password)
            );

            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();


            return $this->json([

                    'user_id'=> $user->getId(),
                    'email'=>$user->getEmail(),

                ]
            );
        }

    }
    /**
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
     *
     * @Route("api/login_check", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=LoginResponse::class, ))
     *     )
     * )

     * @OA\RequestBody(@Model(type=UserDto::class))
     * @OA\Tag(name="registration")
     *
     */

//    #[Route('/login', name: '.login')]
//    public function login(Request $request ,ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher){
//        $email=$request->request->get('email');
//        $password=$request->request->get('password');
//        $user_exists=$doctrine->getRepository(User::class)->findBy(['email'=>$email]);
//        dd($user_exists);
//        //$pass=$passwordHasher->isPasswordValid($user_exists->getPassword());
//        if($passwordHasher->isPasswordValid($user_exists->getPassword())){
//        }
//    }
//    #[Route('/login_check', name: 'api_login_check')]
//    public function login_check(Request $request ,ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher){
//        $email=$request->request->get('email');
//        $password=$request->request->get('password');
//        $user_exists=$doctrine->getRepository(User::class)->findBy(['email'=>$email]);
//        dd($user_exists);
//        //$pass=$passwordHasher->isPasswordValid($user_exists->getPassword());
//        if($passwordHasher->isPasswordValid($user_exists->getPassword())){
//            return
//        }
//    }
}
