<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Gesdinet\JWTRefreshTokenBundle\Doctrine\RefreshTokenRepositoryInterface;

/**
 * @extends EntityRepository<JwtRefreshToken>
 * @implements RefreshTokenRepositoryInterface<JwtRefreshToken>
 */
class RefreshTokenRepository extends EntityRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @param \DateTimeInterface|null $datetime
     *
     * @return JwtRefreshToken[]
     */
    public function findInvalid($datetime = null)
    {
        $datetime = (null === $datetime) ? new \DateTime() : $datetime;

        return $this->createQueryBuilder('u')
            ->where('u.valid < :datetime')
            ->setParameter(':datetime', $datetime)
            ->getQuery()
            ->getResult();
    }
}