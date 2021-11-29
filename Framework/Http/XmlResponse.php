<?php

namespace Bespoke\Http;

class XmlResponse extends Response
{
    protected function getContentType(): string
    {
        return 'text/xml';
    }

    public function formatResponseData(): string
    {
        return $this->responseData;
    }
}
