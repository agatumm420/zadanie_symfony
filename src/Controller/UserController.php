<?php

namespace App\Controller;


use App\Entity\User;
use App\Exception\ApiException;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Security\Hasher\CustomHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\UserDto;
use App\ResponseRegistration;
use App\LoginResponse;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Symfony\Component\Security\Core\User\UserInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;


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
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
    {

        $email=$request->request->get('email');
        $password=$request->request->get('password');
        $repeated=$request->request->get('repeated');
        $name=$request->request->get('name');
        $surname=$request->request->get('surname');
        //dd($data);
        $user_exists=$doctrine->getRepository(User::class)->findBy(['email'=>$email]); //wróc do tego

        //dd($user_exists);
        if($user_exists){
            throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'User with such email already exists');
        }
        else{
            if($password==$repeated && preg_match('/[a-z]/', $password) && preg_match('/[A-Z]/', $password)){

                $factory=$this->get_factory();
                $ActualPasswordHasher = $factory->getPasswordHasher('common');
                //$hash = $ActualPasswordHasher->hash($plainPassword);
                $user=new User();
                $user->setEmail($email);
                $user->setPassword(
                    $ActualPasswordHasher->hash($password)
                );
                $user->setName($name);
                $user->setSurname($surname);

                $em=$doctrine->getManager();
                $em->persist($user);
                $em->flush();


                return $this->json([

                        'user_id'=> $user->getId(),
                        'email'=>$user->getEmail(),

                    ]
                );
            }
            else{
                throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'Provided passwords must match and contain one capital letter and one lower caps letter');
            }
        }

    }



    /**
     * Returns a token when provided email and password.
     *
     * If the email doesn't exist or password is wrong error message will be returned.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=LoginResponse::class ))
     *     )
     * )

     * @OA\RequestBody(@Model(type=UserDto::class))
     * @OA\Tag(name="auth")
     *
     */
    #[Route('/login_token', name: '.login_token',methods: 'POST')]
  public function get_jwt(Request $request,  UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, JWTTokenManagerInterface $JWTManager,RefreshTokenGeneratorInterface $refreshTokenGenerator, RefreshTokenManagerInterface $refreshTokenManager ){
        $email=$request->request->get('email');
        $password=$request->request->get('password');
        $user=$doctrine->getRepository(User::class)->findBy(['email'=>$email]);

        if($user) {
            $factory = $this->get_factory();
            $ActualPasswordHasher = $factory->getPasswordHasher('common');
            //$ActualPasswordHasher->verify($hashedPassword,$plainPassword )
            // dd($ActualPasswordHasher->verify($user[0]->getPassword(),$password ) );
            if ($ActualPasswordHasher->verify($user[0]->getPassword(), $password)) {
                $refreshToken = $refreshTokenGenerator->createForUserWithTtl($user[0], 3600);

                $refreshTokenManager->save($refreshToken);

                return new JsonResponse(['token' => $JWTManager->create($user[0]), 'refresh_token'=>$refreshToken->getRefreshToken()]);

            }
            else{

                return new JsonResponse(['error'=>'Incorrect password']);
            }
        }
        else{
            return new JsonResponse(['error'=>"There is no user with provided email"]);
        }
  }
 public function get_factory(){
     $factory = new PasswordHasherFactory([
         'common' => ['algorithm' => 'bcrypt'],
         'memory-hard' => ['algorithm' => 'sodium'],
     ]);
     return $factory;
 }

}
