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

    private $headers;

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

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $headerName)
    {
        $lowerHeaderName = strtolower($headerName);

        return  $this->headers[$lowerHeaderName] ?? null;
    }

    protected function loadRequestInfo()
    {
        $this->detectHttpMethod();
        $this->detectPath();

        $this->headers = getallheaders();

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

        if ($this->isJson()) {
            $requestBody = json_decode($requestBody, true);

            // If fails to decode, notify through an exception.
            if (is_null($requestBody)) {
                throw new InvalidContentException('Invalid JSON body');
            }
        }

        return $requestBody;
    }

    protected function isJson(): bool
    {
        return (isset($this->headers['Content-Type']) && ($this->headers['Content-Type'] === 'application/json'));
    }
}
