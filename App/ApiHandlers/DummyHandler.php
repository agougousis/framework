<?php

namespace App\ApiHandlers;

use App\Entities\DummyEntity;
use App\Entities\TimestampEntity;
use Bespoke\Http\Request;
use DOMDocument;
use Bespoke\Http\JsonResponse;
use Bespoke\Http\XmlResponse;

class DummyHandler
{
    private $creationTimestamp;

    public function __construct(TimestampEntity $timestamp)
    {
        $this->creationTimestamp = $timestamp;
    }

    public function json(DummyEntity $dummyEntity)
    {
        $responseData = [
            'param1' => 100,
            'param2' => 'John',
            'param3' => $dummyEntity->getDummyString()
        ];

        return new JsonResponse(200, $responseData);
    }

    public function xml()
    {
        $dom = new DOMDocument('1.0','UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement('student');
        $dom->appendChild($root);
        $result = $dom->createElement('result');
        $root->appendChild($result);
        $result->setAttribute('id', 1);
        $result->appendChild( $dom->createElement('name', 'Opal Kole') );
        $result->appendChild( $dom->createElement('sgpa', '8.1') );
        $result->appendChild( $dom->createElement('cgpa', '8.4') );
        $xml = $dom->saveXML();

        return new XmlResponse(200, $xml);
    }

    public function addUser()
    {
        return new JsonResponse(200, []);
    }

    public function request(Request $request)
    {
        throw new \Exception('hello');

        echo "<pre>";
        var_dump($request);
        die();
    }
}
