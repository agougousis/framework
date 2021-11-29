<?php

namespace Bespoke\Http;

use Bespoke\Exceptions\InvalidContentException;

class Request
{
    protected static $instance;

    /** @var string GET|POST|PUT|PATCH|DELETE */
    private $method;

    /** @var  string */
    private $path;

    private $body;

    protected function __construct() { }
    protected function __clone() { }
    private function __wakeup() { }

    public static function getInstance() {
        if (!isset(self::$instance)) {
             $request = new self;
             $request->loadRequestInfo();

            self::$instance = $request;
        }

        return self::$instance;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    protected function loadRequestInfo()
    {
        $this->detectHttpMethod();
        $this->detectPath();

        $this->body = (in_array($this->method, ['POST', 'PUT', 'PATCH'])) ? $this->readBody() : null;
    }

    protected function detectHttpMethod()
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        switch($method) {
            case 'GET':
                $this->method = 'GET';
                break;
            case 'POST':
                $this->method = 'POST';
                break;
            case 'PUT':
                $this->method = 'PUT';
                break;
            case 'PATCH':
                $this->method = 'PATCH';
                break;
            case 'DELETE':
                $this->method = 'DELETE';
                break;
            default:
                $this->method = 'GET';
        }
    }

    protected function detectPath()
    {
        $rawPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->path = rtrim($rawPath, '/');
    }

    protected function readBody()
    {
        $requestBody = file_get_contents('php://input');

        if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
            $requestBody = json_decode($requestBody, true);
        }

        if (is_null($requestBody)) {
            throw new InvalidContentException();
        }

        return $requestBody;
    }
}
