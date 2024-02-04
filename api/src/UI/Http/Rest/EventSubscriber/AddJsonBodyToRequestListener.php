<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use function str_starts_with;

final class AddJsonBodyToRequestListener
{
    /**
     * @throws \JsonException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $requestContents = $request->getContent();

        if (!empty($requestContents) && $this->containsHeader($request)) {
            $data = json_decode($requestContents, true, 512, JSON_THROW_ON_ERROR);

            if (!$data) {
                $response = new Response('Unable to parse json request.', Response::HTTP_BAD_REQUEST);
                $event->setResponse($response);

                return;
            }

            $request->request->replace($data);
        }
    }

    private function containsHeader(Request $request): bool
    {
        return str_starts_with((string)$request->headers->get('Content-Type'), 'application/json');
    }
}
