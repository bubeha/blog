<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony;

use App\User\Application\Auth\TokenExtractor;
use App\User\Application\Auth\TokenManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;

final readonly class TokenAuthenticator implements AuthenticatorInterface
{
    public function __construct(private TokenExtractor $extractor, private TokenManager $tokenManager)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $this->extractor->getToken($request) !== null;
    }

    public function authenticate(Request $request): Passport
    {
        /** @var string $token */
        $token = $this->extractor->getToken($request);
        $user = $this->tokenManager->decode($token);

        return new SelfValidatingPassport(
            new UserBadge(
                $user->getUserIdentifier(),
                // todo load user from database
                static fn(string $email): UserInterface => $user,
            ),
        );
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        $user = $passport->getUser();

        return new PostAuthenticationToken(
            $user,
            $firewallName,
            $user->getRoles(),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // todo replace exception
        throw $exception;
    }
}
