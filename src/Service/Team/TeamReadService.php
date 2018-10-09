<?php

namespace App\Service\Team;

use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;

class TeamListService
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
        return $this->teamRepository->findByLeagueId($id);
    }
}
