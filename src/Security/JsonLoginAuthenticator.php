<?php
namespace App\Security;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use DateTimeImmutable;
use Lcobucci\Clock\FrozenClock;

use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint;

class JsonLoginAuthenticator extends AbstractAuthenticator
{
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->request->has('token');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->request->get('refresh_token'); // czy zrobić tu login czy co
        if (null === $apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No token provided');
        }
        $TokenKey = InMemory::base64Encoded(
            '3e6cf8bf3859b04b2110deaf07c0c34f'
        );  //put in env
        $token = (new JwtFacade())->parse(
            $apiToken,
            new Constraint\SignedWith(new Sha256(), $TokenKey),
            new Constraint\StrictValidAt(
                new FrozenClock(new DateTimeImmutable('2022-07-24 20:55:10+00:00'))
            )
        );
//        $token->hasBeenIssuedBy()
        if(!$token->isExpired() && $token->hasBeenIssuedBy('https://127.0.0.1')){
            $this->onAuthenticationSuccess();
        }



       return new SelfValidatingPassport(new UserBadge($apiToken));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        $key = InMemory::base64Encoded(
            'hiG8DlOKvtih6AxlZn5XKImZ06yu8I3mkOzaJrEuW8yAv8Jnkw330uMt8AEqQ5LB'// later
        );
        //dd('heere');
        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            static fn (
                Builder $builder,
                DateTimeImmutable $issuedAt
            ): Builder => $builder
                ->issuedBy('https://127.0.0.1')
                ->permittedFor('https://127.0.0.1:8000/api')
                ->expiresAt($issuedAt->modify('+10 minutes'))
        );
        $refresh_key = InMemory::base64Encoded(
            '3e6cf8bf3859b04b2110deaf07c0c34f'
        );
        $refresh_token = (new JwtFacade())->issue(
            new Sha256(),
            $refresh_key,
            static fn (
                Builder $builder,
                DateTimeImmutable $issuedAt
            ): Builder => $builder
                ->issuedBy('https://127.0.0.1')
                ->permittedFor('https://127.0.0.1:8000/api')
                ->expiresAt($issuedAt->modify('+10 minutes'))
        );
        //dd($token);
//                dd($this->json([
//                    'token'=>$token->toString(),
//                ]));

//        return $this->json([
//            'token'=>$token->toString(),
//            'refresh_token'=>$refresh_token->toString()
//        ]);
        return new JsonResponse([
            'token'=>$token->toString(),
            'refresh_token'=>$refresh_token->toString()
        ], Response::HTTP_OK);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
    public function get_factory(){
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
        return $factory;
    }
}