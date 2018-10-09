<?php

namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TeamLeagueFixtures extends Fixture
{
    private const PREMIER_LEAGUE = 'Premier League';
    private const LA_LIGA = 'La Liga';
    private const PREMIER_LEAGUE_TEAMS = [
        "Manchester City",
        "Manchester United",
        "Tottenham Hotspur",
        "Liverpool",
        "Chelsea",
        "Arsenal",
        "Burnley",
        "Everton	",
        "Leicester City",
        "Newcastle United",
        "Crystal Palace",
        "Bournemouth",
        "West Ham United",
        "Watford",
        "Brighton & Hove Albion",
        "Huddersfield Town",
        "Southampton",
        "Swansea City",
        "Stoke City",
        "West Bromwich Albion",
    ];
    private const LA_LIGA_TEAMS = [
        "Barcelona",
        "Real Madrid",
        "Alaves",
        "Sevilla",
        "Atlético",
        "Real Betis",
        "Espanyol",
        "Real Sociedad",
        "Celta Vigo",
        "Levante",
        "Eibar",
        "Valladolid",
        "Getafe",
        "Girona",
        "Villarreal",
        "Valencia",
        "A Bilbao",
        "Leganes",
        "Rayo Vallecano",
        "Huesca"
    ];

    public function load(ObjectManager $manager): void
    {
        $league = $this->createLeague(self::PREMIER_LEAGUE, $manager);
        $this->createTeams(self::PREMIER_LEAGUE_TEAMS, $league, $manager);

        $league = $this->createLeague(self::LA_LIGA, $manager);
        $this->createTeams(self::LA_LIGA_TEAMS, $league, $manager);
    }

    private function createLeague(string $name, ObjectManager $manager): League
    {
        $league = new League();
        $league->setName($name);
        $manager->persist($league);
        $manager->flush();

        return $league;
    }

    private function createTeams(array $teams, League $league, ObjectManager $manager): void
    {
        foreach ($teams as $teamName) {
            $team = new Team();
            $team->setName($teamName);
            $team->setLeague($league);
            $team->setStrip(\uniqid());

            $manager->persist($team);
        }

        $manager->flush();
    }
}
