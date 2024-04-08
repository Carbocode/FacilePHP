<?php

namespace FacilePHP\Middleware;

use FacilePHP\Request;

interface IMiddleware
{
    function handle(Request $request);
}
