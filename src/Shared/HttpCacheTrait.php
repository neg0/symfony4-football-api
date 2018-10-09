<?php

namespace App\Shared;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait HttpCacheTrait
{
    private $expiryTime = '15 Seconds';

    protected function cachedResponse(JsonResponse $response, Request $request): JsonResponse
    {
        $response->setEtag(md5($response->getContent()));
        $response->setExpires(new \DateTime('+' . $this->expiryTime));
        $response->isNotModified($request);
        $response->setPublic();

        return $response;
    }

    protected function addCount(JsonResponse $response, string $key = null)
    {
        $contents = json_decode($response->getContent(), true);
        $contents['total'] = count($contents);

        if (null !== $key) {
            $contents['total'] = count($contents[$key]);
        }

        $response->setContent(json_encode($contents, true));
    }
}
