<?php


namespace Jman\Core;


class AppRequest
{

    const GET = "GET";
    const POST = "POST";

    private $params, $files, $host, $method, $url, $cookies, $scheme;

    public function __construct()
    {
        $this->host = $_SERVER['HTTP_HOST'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REDIRECT_URL'];
        $this->scheme = $_SERVER['REQUEST_SCHEME'];
        $this->params = new RequestFilter($_REQUEST);
        $this->cookies = new RequestFilter($_COOKIE);
        $this->files = new RequestFilter($_FILES);
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getURL()
    {
        return $this->url;
    }

    public function isGET(): bool
    {
        return $this->method == self::GET;
    }

    public function isPOST(): bool
    {
        return $this->method == self::POST;
    }

    public function getParams(): RequestFilter
    {
        return $this->params;
    }

    public function getFiles(): RequestFilter
    {
        return $this->files;
    }

    /**
     * Returns the csrf token from the request. A token will be
     * present, if it is injected into the form.
     * @return mixed
     * @throws Exceptions\KeyNotFoundException
     */
    public function getCSRFToken()
    {
        return $this->params->get(AppSession::CSRF_TOKEN);
    }

}