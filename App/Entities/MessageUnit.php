<?php

namespace App\Entities;

class MessageUnit
{
    const IEI = '00';
    const IEDL = '03';

    private $recipients;

    private $originator;

    private $message;

    private $udhHeader;

    public function __construct($recipients, $originator, string $message)
    {
        $this->recipients = $recipients;
        $this->originator = $originator;
        $this->message    = $message;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function getOriginator()
    {
        return $this->originator;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getUdhHeader()
    {
        return $this->udhHeader;
    }

    public function isConcatenated()
    {
        return isset($this->udhHeader);
    }

    public function addUdhHeader(int $numberOfChunks, int $chunkId, int $udhRefNumber)
    {
        $dataByte1 = dechex($udhRefNumber);
        $dataByte2 = dechex($numberOfChunks);
        $dataByte3 = dechex($chunkId);

        $this->udhHeader = self::IEI . self::IEDL . $dataByte1 . $dataByte2 . $dataByte3;
    }
}
