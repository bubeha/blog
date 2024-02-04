<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\UI\Http\Response\OpenApi;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;

final readonly class CurrentUserAction
{
    public function __construct(private Security $token)
    {
    }

    public function __invoke(): OpenApi
    {
        return OpenApi::fromPayload(
            [
                'email' => $this->token->getUser()?->getUserIdentifier(),
            ],
            Response::HTTP_OK
        );
    }
}
