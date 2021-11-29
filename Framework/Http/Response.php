<?php

namespace Bespoke\Http;

abstract class Response
{
    protected $statusCode = 200;

    protected $contentType;

    protected $responseData;

    public function __construct($statusCode, $responseData)
    {
        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
        $this->contentType = $this->getContentType();
    }

    public function send()
    {
        http_response_code($this->statusCode);

        header('Content-type:'.$this->contentType.';charset=utf-8');

        echo $this->formatResponseData();
    }

    abstract protected function formatResponseData(): string;

    abstract protected function getContentType(): string;
}
