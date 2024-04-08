<?php

use Lcobucci\JWT\Token\Plain;

final class TokenJWT
{
    use ExploreJson;

    private readonly Plain $token;
    private readonly array $bodyParams;
    private readonly array $headerParams;

    public function __construct(Plain $token)
    {
        $this->token = $token;
        $this->bodyParams = $token->claims()->all();
        $this->headerParams = $token->headers()->all();
    }

    public function body(string|int $key, string|int|null $default = null): string|int|null
    {
        return $this->getParam($this->bodyParams, $key, $default);
    }

    public function validateToken($token, $audience): bool
    {
        //TODO: validazione Token
        return false;
    }

    public function getClaims($token): array
    {
        return $token->claims()->all();
    }
}
