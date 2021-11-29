<?php

namespace Bespoke\Http;

class JsonResponse extends Response
{
    protected function getContentType(): string
    {
        return 'application/json';
    }

    public function formatResponseData(): string
    {
        return json_encode($this->responseData);
    }
}
