<?php

namespace App\Service\Team;

use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;

class TeamSaveService
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

    public function prepare(array $data, string $leagueId, string $teamId = null): array
    {
        if (false === isset($data['id'])) {
            $data['id'] = $teamId;
        }

        $data['league'] = $this->leagueRepository->find($leagueId);

        return $data;
    }

    public function update(Team $team, string $teamId = null): bool
    {
        try {
            /** @var Team $teamEntity */
            $teamEntity = $this->entityManager->getReference(Team::class, $teamId ? $teamId : $team->getId());
            $teamEntity->setId($team->getId());
            $teamEntity->setName($team->getName());
            $teamEntity->setStrip($team->getStrip());
            $teamEntity->setLeague($team->getLeague());

            return $this->teamRepository->update($teamEntity);
        } catch (ORMException $exception) {
            $this->logger->log('error', 'could not find entity by id', $exception->getTrace());
        }

        return false;
    }

    public function singleSave(Team $team): bool
    {
        return $this->teamRepository->save($team);
    }
}
