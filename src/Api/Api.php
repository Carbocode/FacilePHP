<?php

namespace FacilePHP\Api;

use FacilePHP\Request;


interface Api
{

    /**
     * API Constructor
     *
     * @param Request $request all data from the request made by calling any Endpoint
     */
    function __construct(Request $request);

    function handle(Request $request);
}
