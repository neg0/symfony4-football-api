<?php

namespace App\Service\Team;

use App\Entity\League;
use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;

class TeamUpdateService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        TeamRepository $teamRepository,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->teamRepository = $teamRepository;
        $this->logger = $logger;
    }

    public function updateWithLeagueId(Team $team, string $leagueId, string $teamId = null): bool
    {
        try {
            /** @var League $league */
            $league = $this->entityManager->getReference(League::class, $leagueId);

            /** @var Team $teamEntity */
            $teamEntity = $this->entityManager->getReference(Team::class, $teamId ? $teamId : $team->getId());
            $teamEntity->setId($teamId ? $teamId : $team->getId());
            $teamEntity->setName($team->getName());
            $teamEntity->setStrip($team->getStrip());
            $teamEntity->setLeague($league);

            return $this->teamRepository->update($teamEntity);
        } catch (ORMException $exception) {
            $this->logger->log('error', 'could not find entity by id', $exception->getTrace());
        }

        return false;
    }
}
