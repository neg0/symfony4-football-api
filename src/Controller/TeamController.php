<?php

namespace App\Controller;

use App\Form\TeamType;
use App\Service\Team\TeamReadService;
use App\Service\Team\TeamCreationService;
use App\Service\Team\TeamUpdateService;
use App\Shared\HttpCacheTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    use HttpCacheTrait;

    /**
     * @var TeamReadService
     */
    private $teamReadService;

    /**
     * @var TeamCreationService
     */
    private $teamCreationService;

    /**
     * @var TeamUpdateService
     */
    private $teamUpdateService;

    public function __construct(
        TeamReadService $teamReadService,
        TeamCreationService $teamCreationService,
        TeamUpdateService $teamUpdateService
    ) {
        $this->teamReadService = $teamReadService;
        $this->teamCreationService = $teamCreationService;
        $this->teamUpdateService = $teamUpdateService;
    }

    /**
     * @Route("/league/{leagueId}/team", name="team_create", methods={"PUT"})
     */
    public function create(Request $request, string $leagueId): JsonResponse
    {
        $form = $this->createForm(TeamType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $this->teamCreationService->saveByLeagueId($form->getData(), $leagueId);

            return $this->json(['message' => 'successfully created'], Response::HTTP_CREATED);
        }

        return $this->json(
            [ 'error' => "been unable to create a team in given league" ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @Route("/league/{id}/team", name="team_read", methods={"GET"})
     */
    public function read(Request $request, string $id): JsonResponse
    {
        $teams = $this->teamReadService->listByLeagueId($id);
        $response = $this->json([ 'teams' => $teams ], Response::HTTP_OK);
        $this->addCount($response, 'teams');

        return $this->cachedResponse($response, $request);
    }

    /**
     * @Route("/league/{leagueId}/team/{teamId}", name="team_update", methods={"PATCH"})
     */
    public function update(Request $request, string $leagueId, string $teamId): JsonResponse
    {
        $form = $this->createForm(TeamType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $isSaved = $this->teamUpdateService->updateWithLeagueId($form->getData(), $leagueId, $teamId);
            if ($isSaved) {
                return $this->json([ 'message' => 'successfully updated' ], Response::HTTP_ACCEPTED);
            }
        }

        return $this->json(
            [ 'error' => "been unable to update the specified team" ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
