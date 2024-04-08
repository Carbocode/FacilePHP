<?php

namespace FacilePHP\Config;

abstract class Constants
{
    #region Config Constants
    //General Info
    public const APP_NAME    = 'AppName';
    public const APP_VERSION = 'v1.0';

    // Domains
    public const DOMAIN = 'example.com';

    public const BACKEND_DOMAIN = 'example.com';
    public const DEV_DOMAIN     = 'dev.' . self::BACKEND_DOMAIN;
    public const TEST_DOMAIN    = 'test.' . self::BACKEND_DOMAIN;

    // Mail
    public const NOREPLY_MAIL = 'noreply@' . self::DOMAIN;
    public const NOREPLY_NAME = 'NoReply - ' . self::APP_NAME;

    public const REPLY_MAIL = 'support@' . self::DOMAIN;
    public const REPLY_NAME = 'Support - ' . self::APP_NAME;

    public const INFO_MAIL = 'info@' . self::DOMAIN;
    public const INFO_NAME = 'Info - ' . self::APP_NAME;

    #endregion

    #region HTTP Methods
    public const OPTIONS = 'OPTIONS';
    public const GET     = 'GET';
    public const POST    = 'POST';
    public const PUT     = 'PUT';
    public const DELETE  = 'DELETE';
    #endregion

    #region HTTP Status Codes
    // Informational responses
    public const CONTINUE            = 100;
    public const SWITCHING_PROTOCOLS = 101;

    // Successful responses
    public const OK                            = 200;
    public const CREATED                       = 201;
    public const ACCEPTED                      = 202;
    public const NON_AUTHORITATIVE_INFORMATION = 203;
    public const NO_CONTENT                    = 204;
    public const RESET_CONTENT                 = 205;
    public const PARTIAL_CONTENT               = 206;

    // Redirection messages
    public const MULTIPLE_CHOISES   = 300;
    public const MOVED_PERMANENTLY  = 301;
    public const FOUND              = 302;
    public const SEE_OTHER          = 303;
    public const NOT_MODIFIED       = 304;
    public const TEMPORARY_REDIRECT = 307;
    public const PERMANENT_REDIRECT = 308;

    // Client error responses
    public const BAD_REQUEST                     = 400;
    public const UNAUTHORIZED                    = 401;
    public const PAYMENT_REQUIRED                = 402;
    public const FORBIDDEN                       = 403;
    public const NOT_FOUND                       = 404;
    public const METHOD_NOT_ALLOWED              = 405;
    public const NOT_ACCEPTABLE                  = 406;
    public const PROXY_AUTHENTICATION_REQUIRED   = 407;
    public const REQUEST_TIMEOUT                 = 408;
    public const CONFLICT                        = 409;
    public const GONE                            = 410;
    public const LENGTH_REQUIRED                 = 411;
    public const PRECONDITION_FAILED             = 412;
    public const REQEST_ENTITY_TOO_LARGE         = 413;
    public const REQUEST_URI_TOO_LONG            = 414;
    public const UNSUPPORTED_MEDIA_TYPE          = 415;
    public const REQUEST_RANGE_NOT_SATISFIABLE   = 416;
    public const EXPECTATION_FAILED              = 417;
    public const IM_A_TEAPOT                     = 418;
    public const MISDIRECTED_REQUEST             = 421;
    public const TOO_EARLY                       = 425;
    public const UPGRADE_REQUIRED                = 426;
    public const PRECONDITION_REQUIRED           = 426;
    public const TOO_MANY_REQUESTS               = 429;
    public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    public const UNAVAILABLE_FOR_LEGAL_REASONS   = 451;

    // Server error responses
    public const INTERNAL_SERVER_ERROR      = 500;
    public const NOT_IMPLEMENTED            = 501;
    public const BAD_GATEWAY                = 502;
    public const SERVICE_UNAVAILABLE        = 503;
    public const GATEWAY_TIMEOUT            = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    #endregion
}
