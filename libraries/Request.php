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
    private $curl;

    /**
     * Curl response
     *
     * @var [string]
     */
    private $response;

    /**
     * Error message returned by curl
     *
     * @var [string]
     */
    private $error;

    /**
     * Error number returned by curl
     *
     * @var [int]
     */
    private $errorNo;

    /**
     * HTTP status code from external resource response
     *
     * @var [int]
     */
    private $httpStatusCode;

    /**
     * Initialize curl and set options appropriately
     *
     * @param [string] $url
     * @param [string] $method
     */
    public function __construct($url, $method)
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 20);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
    }

    /**
     * Handle curl errors that might occur when making requests to external resources
     *
     * @return void
     */
    private static function handleErrors()
    {
        $this->error = curl_error($this->curl);
        $this->errorNo = curl_errno($this->curl);
        $this->httpStatusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        if (0 !== $this->errorNo) {
            throw new RuntimeException($this->error, $this->errorNo);
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
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, JSON::stringify($data));

        if (count($headers)) {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
        }

        $this->response = curl_exec($this->curl);

        self::handleErrors();

        curl_close($this->curl);

        return $this->response;
    }

    /**
     * Make GET requests to external resources
     *
     * @param [string] $url
     * @return array
     */
    private static function get($url)
    {
        new self($url, 'GET');

        $this->response = curl_exec($this->curl);
        
        self::handleErrors();

        curl_close($this->curl);

        return $this->response;
    }

    /**
     * Make PUT requests to external resources
     *
     * @param [string] $url
     * @return array
     */
    private static function put($url, $data)
    {
        new self($url, 'PUT');

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

        $this->response = curl_exec($this->curl);
        
        self::handleErrors();

        curl_close($this->curl);

        return $this->response;
    }
}
