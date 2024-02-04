<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Auth;

use App\Shared\Application\Bus\Command\CommandBus;
use App\UI\Http\Response\OpenApi;
use App\User\Application\Command\SignIn\LoginCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class LoginAction
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request): OpenApi
    {
        $this->commandBus->handle(
            new LoginCommand(
                (string)$request->request->get('email'),
                (string)$request->request->get('password'),
            ),
        );

        return OpenApi::empty(Response::HTTP_OK);
    }
}
