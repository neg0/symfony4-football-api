<?php

namespace App\Controller;

use App\Service\League\LeagueRemovalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends AbstractController
{
    /**
     * @var LeagueRemovalService
     */
    private $leagueRemovalService;

    public function __construct(LeagueRemovalService $leagueRemovalService)
    {
        $this->leagueRemovalService = $leagueRemovalService;
    }

    /**
     * @Route("/league/{id}", name="league_delete", methods={"DELETE"})
     */
    public function delete(string $id): JsonResponse
    {
        $isRemoved = $this->leagueRemovalService->removeById($id);
        if ($isRemoved) {
            return $this->json(['message' => "successfully deleted"], Response::HTTP_ACCEPTED);
        }

        return $this->json(['error' => "specified league does not exist"], Response::HTTP_NOT_FOUND);
    }
}
