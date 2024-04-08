<?php

namespace FacilePHP;

#[\Attribute]
class Documentation
{
    /**
     * @param string $apiName the path to call to execute the API
     * @param string $description - default: ''
     * @param string $method required HTTP Method 
     * @param DRequest $request request details
     * @param array<DResponse> $response
     */
    public function __construct(public string $apiName, public string $description = '', public string $method, public Request $request,  public array $response = [])
    {
    }
}

class DRequest
{
    /**
     * @param array<DParam> $header header parameters details
     * @param array<DParam> $query query parameters details
     * @param array<DArray|DObject> $body body parameters details
     */
    public function __construct(public array $header = [], public array $query = [], public array $body = [])
    {
    }
}

class DParam
{
    /**
     * @param string $name parameter name - default: ''
     * @param string $description - default: ''
     * @param string $type - string, integer, double, boolean
     * @param bool $required - default: false
     */
    public function __construct(public string $name = '', public string $type, public string $description = '', public bool $required = false)
    {
    }
}

class DArray
{
    /**
     * @param string $name parameter name - default: ''
     * @param DObject|array<DObject> $objects
     * @param bool $required - default: false
     */
    public function __construct(public string $name = '', public DObject|array $objects, public bool $required = false)
    {
    }
}

class DObject
{
    /**
     * @param string $name parameter name - default: ''
     * @param array<DParam|DObject|DArray> $params
     * @param bool $required - default: false
     */
    public function __construct(public string $name = '', public array $params, public bool $required = false)
    {
    }
}


class DResponse
{
    /**
     * @param string $name parameter name
     * @param string $description - default: ''
     * @param bool $required - default: false
     */
    public function __construct(public string $code, public string $message, public array $body = [])
    {
    }
}
