<?php
// src/Security/Hasher/CustomVerySecureHasher.php
namespace App\Security;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\CheckPasswordLengthTrait;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class CustomHasher implements PasswordHasherInterface
{
use CheckPasswordLengthTrait;

public function hash(string $plainPassword): string
{
if ($this->isPasswordTooLong($plainPassword)) {



throw new InvalidPasswordException();
}

    $factory = new PasswordHasherFactory([
        'common' => ['algorithm' => 'bcrypt'],
        'memory-hard' => ['algorithm' => 'sodium'],
    ]);
    $passwordHasher = $factory->getPasswordHasher('common');
    $hash = $passwordHasher->hash($plainPassword);

return $hash;
}

public function verify(string $hashedPassword, string $plainPassword): bool
{
if ('' === $plainPassword || $this->isPasswordTooLong($plainPassword)) {
return false;
}

    $factory = new PasswordHasherFactory([
        'common' => ['algorithm' => 'bcrypt'],
        'memory-hard' => ['algorithm' => 'sodium'],
    ]);
    $passwordHasher = $factory->getPasswordHasher('common');

    $result = $passwordHasher->verify($hashedPassword,$plainPassword );

return $result;
}
public function needsRehash(string $hashedPassword): bool
    {
        // TODO: Implement needsRehash() method.
        return 0;
    }

}