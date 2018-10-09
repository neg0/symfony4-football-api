<?php
namespace App\Service\League;

use App\Repository\LeagueRepository;

class LeagueRemovalService
{
    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function removeById(string $leagueId): bool
    {
        return $this->leagueRepository->removeById($leagueId);
    }
}
