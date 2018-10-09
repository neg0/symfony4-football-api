<?php

namespace App\Service\Team;

use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;

class TeamReadService
{
    /**
     * @var LeagueRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function listByLeagueId(string $id): array
    {
        $teams = $this->teamRepository->findByLeagueId($id);
        /** @var Team $team */
        foreach ($teams as $team) {
            $team->setLeague(null);
        }

        return $teams;
    }
}
