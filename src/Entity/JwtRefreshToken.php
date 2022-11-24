<?php
namespace App\Entity;

//use App\Repository\RefreshTokenRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshTokenRepository;
use Gesdinet\JWTRefreshTokenBundle\Model\AbstractRefreshToken;

#[
ORM\Entity(repositoryClass: RefreshTokenRepository::class),
ORM\Table(name: 'jwt_refresh_tokens')
]
class JwtRefreshToken extends AbstractRefreshToken
{
#[
ORM\Id,
ORM\GeneratedValue,
ORM\Column(type:"integer")
]
protected $id;

#[
ORM\Column(type: "string", length: 128, nullable: true)
]
protected $refreshToken;

#[
ORM\Column(type:"string", length: 255, nullable: true)
]
protected $username;

#[
ORM\Column(type:"datetime", nullable: true)
]
protected $valid;
}