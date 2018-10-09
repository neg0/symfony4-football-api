<?php

namespace App\Repository;

use App\Entity\League;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LeagueRepository extends ServiceEntityRepository
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RegistryInterface $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, League::class);

        $this->logger = $logger;
    }

    public function findOneById(string $id): ?League
    {
        $league = $this->find($id);
        if ($league instanceof League) {
            return $league;
        }

        return null;
    }

    public function removeById(string $id): bool
    {
        try {
            $league = $this->getEntityManager()->getReference(League::class, $id);
            $this->getEntityManager()->remove($league);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Throwable $throwable) {
            $this->logger->log('error', 'could not remove by id', $throwable->getTrace());
            return false;
        }
    }


}
