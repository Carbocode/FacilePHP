<?php

namespace FacilePHP;

use ExploreJson;
use FacilePHP\Config\Constants;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\InMemory;
use TokenJWT;

final class Request
{
    use ExploreJson;

    private readonly array $queryParams;
    private readonly array $bodyParams;
    private readonly array $serverParams;
    private readonly array $cookies;
    private readonly array $files;

    private function __construct()
    {
        $this->queryParams = $_GET;
        $this->serverParams = $_SERVER;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;

        $this->parseBody();
    }

    private function parseBody(): void
    {
        if ($this->isJson()) {
            $json = file_get_contents('php://input');
            $this->bodyParams = json_decode($json, true);
        } else {
            $this->bodyParams = $_POST;
        }
    }

    private function isJson(): bool
    {
        return strpos($this->header('Content-Type'), 'application/json') === 0;
    }

    public function method(): string
    {
        return $this->serverParams['REQUEST_METHOD'] ?? Constants::GET;
    }

    public function path(): string
    {
        return $this->serverParams['REQUEST_URI'] ?? '/';
    }

    public function header(string|int $key, string|int|null $default = null): string|int|null
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->serverParams[$key] ?? $default;
    }

    public function query(string|int $key, string|int|null $default = null): string|int|null
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function body(string|int $key, string|int|null $default = null): string|int|null
    {
        return $this->getParam($this->bodyParams, $key, $default);
    }

    public function cookie(string|int $key, string|int|null $default = null): string|int|null
    {
        return $this->cookies[$key] ?? $default;
    }

    public function file(string|int $key): mixed
    {
        return $this->files[$key] ?? null;
    }

    public function token(Signer $signer, string $privateKey, string $publicKey = '', bool $filePath = false): TokenJWT
    {

        if ($filePath) {
            $privateKey = InMemory::file($privateKey);
            if ($publicKey)
                $publicKey = InMemory::file($publicKey);
        } else {
            $privateKey = InMemory::plainText($privateKey);
            if ($publicKey)
                $privateKey = InMemory::plainText($publicKey);
        }

        if ($publicKey)
            $config = Configuration::forAsymmetricSigner($signer, $privateKey, $publicKey);
        else
            $config = Configuration::forSymmetricSigner($signer, $privateKey);

        $token = $config->parser()->parse($this->header('Authorization'));

        return new TokenJWT($token);
    }
}
