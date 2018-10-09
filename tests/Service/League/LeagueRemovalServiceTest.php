<?php

namespace App\Tests;

use App\Repository\LeagueRepository;
use App\Service\League\LeagueRemovalService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class LeagueRemovalServiceTest extends TestCase
{
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
        $leagueId = $this->getUuid();
        $this->leagueRepository
            ->expects($this->once())
            ->method('removeById')
            ->with($leagueId)
            ->willReturn(true);

        $removed = $this->sut->removeById($leagueId);
        $this->assertTrue($removed);
    }

    private function getLeagueRepository(): MockObject
    {
        return $this->createMock(LeagueRepository::class);
    }

    private function getUuid(): string
    {
        try {
            return Uuid::uuid4();
        } catch (\Throwable $exception) {
            return uniqid();
        }
    }
}
