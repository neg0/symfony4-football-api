<?php

namespace App\Service\Team;

use App\Entity\League;
use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;

class TeamCreationService
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        TeamRepository $teamRepository,
        LeagueRepository $leagueRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->teamRepository = $teamRepository;
        $this->leagueRepository = $leagueRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function saveByLeagueId(Team $team, string $leagueId): bool
    {
        $league = $this->leagueRepository->find($leagueId);
        $team->setLeague($league);

        return $this->teamRepository->save($team);
    }
}
