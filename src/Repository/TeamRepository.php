<?php

namespace App\Repository;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TeamRepository extends ServiceEntityRepository
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RegistryInterface $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Team::class);

        $this->logger = $logger;
    }

    public function save(Team $team): bool
    {
        try {
            $this->getEntityManager()->persist($team);
            $this->getEntityManager()->flush($team);

            return true;
        } catch (\Throwable $exception) {
            $this->logger->log('error', 'could not save new ', $exception->getTrace());

            return false;
        }
    }

    public function update(Team $team): bool
    {
        try {
            $metadata = $this->getEntityManager()->getClassMetaData(Team::class);
            $metadata->setIdGenerator(new AssignedGenerator());
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $this->getEntityManager()->persist($team);
            $this->getEntityManager()->flush($team);

            return true;
        } catch (\Throwable $exception) {
            $this->logger->log('error', 'could not save new ', $exception->getTrace());

            return false;
        }
    }

    /**
     * @return League[]
     */
    public function findByLeagueId(string $id): array
    {
        return $this->findBy(['league' => $id]);
    }
}
