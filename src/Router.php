<?php

use FacilePHP\config\Constants;

/**
 * The Router class is responsible for handling the routing of HTTP requests.
 * It parses the request URI and method, matches them against a set of defined routes,
 * and initiates the corresponding endpoint or API action. The class also handles
 * CORS by responding to OPTIONS requests and supports dynamic URL parameters.
 */
final class Router
{
    /** Array holding the defined routing paths */
    private readonly array $routes;
    /** The URI being requested */
    private readonly string $requestUri;
    /** Components of the URI path */
    private readonly array $uriPaths;
    /** The HTTP method of the request */
    private readonly string $requestMethod;

    /** Stores dynamic parameters extracted from the URL */
    private readonly array $urlParams;

    /**
     * Constructs a Router instance with provided routing definitions.
     *
     * @param array $routes The routing definitions.
     * @param string $version The API version, defaulting to 'v1.0'.
     */
    public function __construct($routes, $version = 'v1.0')
    {
        $this->routes = [$version => $routes];

        $this->requestUri = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $this->uriPaths    = explode('/', trim($this->requestUri, '/'));

        $endpoint = $this->getApi();

        if (!array_key_exists(Constants::OPTIONS, $endpoint)) {
            throw new Exception('Percorso risorsa incompleto', Constants::NOT_FOUND);
        }

        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($this->requestMethod == Constants::OPTIONS) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: ' . implode(', ', $endpoint[Constants::OPTIONS]));
            die();
        }

        if (in_array($this->requestMethod, $endpoint[Constants::OPTIONS])) {
            $endpoint = $endpoint[$this->requestMethod];
        } else {
            throw new Exception('Metodo di accesso errato, Usato: ' . $this->requestMethod . ' Consentito: ' . implode(', ', $endpoint[Constants::OPTIONS]), Constants::BAD_REQUEST);
        }
        $api = new $endpoint(...$this->urlParams);
        $api->handle();
    }

    /**
     * Retrieves the API endpoint corresponding to the request URI.
     *
     * @return array The endpoint definition.
     */
    private function getApi(): array
    {
        $routes = $this->routes;

        foreach ($this->uriPaths as $segment) {

            if (array_key_exists($segment, $routes)) {
                $routes = $routes[$segment];
            } else {
                foreach (array_keys($routes) as $key) {
                    if (preg_match('/^{(.+)}$/', $key, $matches)) {
                        $paramName                   = $matches[1];
                        $this->urlParams[$paramName] = $segment;

                        $routes = $routes[$key];

                        break;
                    }
                }
            }
        }

        return $routes;
    }
}
