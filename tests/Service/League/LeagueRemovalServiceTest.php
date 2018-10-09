<?php

namespace App\Tests;

use App\Repository\LeagueRepository;
use App\Service\League\LeagueRemovalService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LeagueRemovalServiceTest extends TestCase
{
    private const MOCK_LEAGUE_ID = 1;

    /**
     * @var LeagueRemovalService
     */
    private $sut;

    /**
     * @var LeagueRepository | MockObject
     */
    private $leagueRepository;

    public function setUp(): void
    {
        $this->leagueRepository = $this->getLeagueRepository();

        $this->sut = new LeagueRemovalService($this->leagueRepository);
    }

    public function tearDown(): void
    {
        unset($this->sut, $this->leagueRepository);
    }

    public function testServiceShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(LeagueRemovalService::class, $this->sut);
    }

    public function testServiceShouldRemoveEntityById(): void
    {
        $this->leagueRepository
            ->expects($this->once())
            ->method('removeById')
            ->with(self::MOCK_LEAGUE_ID)
            ->willReturn(true);

        $removed = $this->sut->removeById(self::MOCK_LEAGUE_ID);
        $this->assertTrue($removed);
    }

    private function getLeagueRepository(): MockObject
    {
        return $this->createMock(LeagueRepository::class);
    }
}
