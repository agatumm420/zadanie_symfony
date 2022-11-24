<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Model\AbstractRefreshToken;

/**
 * @ORM\Entity
 * @ORM\Table("refresh_tokens")
 */
class RefreshToken extends AbstractRefreshToken
{
    protected $id;
    public function getId()
    {
        return $this->id;
    }

}
