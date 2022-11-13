<?php

namespace App\Controller;

use App\Entity\User;
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

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'registration')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, MailerInterface $mailer)
    {
        $form=$this->createFormBuilder()
            ->add('email')

            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'required'=>true,
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'Repeat Password']

            ])
            ->add('register', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-success float-right'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data=$form->getData();
            $user=new User();
            $user->setEmail($data['email']);
            $user->setPassword(
                $passwordHasher->hashPassword($user,$data['password'])
            );

            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $email = (new Email())
                ->from('symfony@example.com')
                ->to('agnieszkatumm@gmail.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Registration Successfull!')
                ->text('Thank you for registering! Have fun!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
