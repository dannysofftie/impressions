<?php

namespace Libraries;

/**
 * Provides a top level utility for making outgoing http requests,
 * get, post, patch, put and delete
 */
class Request
{
    /**
     * Curl resource
     *
     * @var [resource]
     */
    private static $curl;

    /**
     * Curl response
     *
     * @var [string]
     */
    private static $response;

    /**
     * Error message returned by curl
     *
     * @var [string]
     */
    private static $error;

    /**
     * Error number returned by curl
     *
     * @var [int]
     */
    private static $errorNo;

    /**
     * HTTP status code from external resource response
     *
     * @var [int]
     */
    private static $httpStatusCode;

    /**
     * Initialize curl and set options appropriately
     *
     * @param [string] $url
     * @param [string] $method
     */
    public function __construct($url, $method)
    {
        self::$curl = curl_init();
        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(self::$curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt(self::$curl, CURLOPT_TIMEOUT, 20);
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYPEER, false);
    }

    /**
     * Handle curl errors that might occur when making requests to external resources
     *
     * @return void
     */
    private static function handleErrors()
    {
        self::$error = curl_error(self::$curl);
        self::$errorNo = curl_errno(self::$curl);
        self::$httpStatusCode = curl_getinfo(self::$curl, CURLINFO_HTTP_CODE);

        if (0 !== self::$errorNo) {
            throw new \RuntimeException(self::$error, self::$errorNo);
        }
    }

    /**
     * Make POST requests to external resources
     *
     * @param [string] $url external server url
     * @param [array] $data data to send to server
     * @return array
     */
    public static function post($url, $data, $headers = [])
    {
        new self($url, 'POST');

        // set post fields here before executing
        curl_setopt(self::$curl, CURLOPT_POSTFIELDS, JSON::stringify($data));

        if (count($headers)) {
            curl_setopt(self::$curl, CURLOPT_HTTPHEADER, $header);
        }

        self::$response = curl_exec(self::$curl);

        self::handleErrors();

        curl_close(self::$curl);

        return self::$response;
    }

    /**
     * Make GET requests to external resources
     *
     * @param [string] $url
     * @return array
     */
    public static function get($url)
    {
        new self($url, 'GET');

        self::$response =  curl_exec(self::$curl);
        
        self::handleErrors();

        curl_close(self::$curl);

        return self::$response;
    }

    /**
     * Make PUT requests to external resources
     *
     * @param [string] $url
     * @return array
     */
    public static function put($url, $data)
    {
        new self($url, 'PUT');

        curl_setopt(self::$curl, CURLOPT_POSTFIELDS, $data);

        self::$response = curl_exec(self::$curl);
        
        self::handleErrors();

        curl_close(self::$curl);

        return self::$response;
    }
}
