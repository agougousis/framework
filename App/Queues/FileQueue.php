<?php

namespace App\Queues;

use App\Contracts\MessageQueue;
use App\Entities\MessageUnit;

class FileQueue implements MessageQueue
{
    /**
     * The directory where the message files are kept
     *
     * @var string
     */
    private $queueDirectory;

    /**
     * A number that indicates the ID of the message at the head of the queue.
     * If the queue is empty, this should be null.
     *
     * @var string
     */
    private $queueHead;

    /**
     * A number that indicates the ID of the message at the tail of the queue.
     * If the queue is empty, this should be null.
     *
     * @var string
     */
    private $queueTail;

    /**
     * The filename where the queue head and tail pointers are written.
     *  If the file does not exist, then the queue is empty.
     *
     * @var string
     */
    private $pointersFilePath;

    public function __construct(string $queueDirectory)
    {
        $this->queueDirectory   = $queueDirectory;
        $this->pointersFilePath = $this->queueDirectory . 'pointers.txt';

        if (file_exists($this->pointersFilePath)) {
            $pointers = file_get_contents($this->pointersFilePath);

            list($this->queueHead, $this->queueTail) = explode(':', $pointers);
        }
    }
    public function isEmpty()
    {
        if (empty($this->queueTail)) {
            return true;
        }
    }

    public function push(MessageUnit $messageUnit)
    {
        $this->updatePointersForPush();

        $this->saveMessageUnitToFile($messageUnit);

        $this->saveNewPointers();
    }

    public function pop() : MessageUnit
    {
        if (empty($this->queueTail)) {
            throw new \Exception('You cannot pop item from an empty queue!');
        }

        $messageUnit = $this->readMessageUnitFromFile();

        $this->updatePointersForPop();

        $this->saveNewPointers();

        return $messageUnit;
    }

    private function updatePointersForPush()
    {
        if (empty($this->queueHead)) {
            $this->queueHead = 1;
            $this->queueTail = 1;
        } else {
            $this->queueTail++;
        }
    }

    private function updatePointersForPop()
    {
        $this->queueHead++;

        if ($this->queueTail < $this->queueHead) {
            $this->queueHead = null;
            $this->queueTail = null;
        }
    }

    private function saveMessageUnitToFile(MessageUnit $messageUnit)
    {
        $newMessageFilename = 'message'.$this->queueTail.'.msg';
        $newMessageFilePath = $this->queueDirectory.$newMessageFilename;

        $serializedMessage = serialize($messageUnit);

        $savingResult = file_put_contents($newMessageFilePath, $serializedMessage);

        if ($savingResult === false) {
            throw new \Exception('Saving new message at '.$newMessageFilename.' failed! ');
        }
    }

    private function readMessageUnitFromFile() : MessageUnit
    {
        $messageFilename = 'message'.$this->queueHead.'.msg';
        $messageFilePath = $this->queueDirectory.$messageFilename;

        $serializedMessage = file_get_contents($messageFilePath);

        $messageUnit = unserialize($serializedMessage);

        unlink($messageFilePath);

        return $messageUnit;
    }

    private function saveNewPointers()
    {
        if (empty($this->queueHead)) {
            unlink($this->pointersFilePath);
        } else {
            $newPointers = $this->queueHead.':'.$this->queueTail;

            $savingResult = file_put_contents($this->pointersFilePath, $newPointers);

            if ($savingResult === false) {
                throw new \Exception('Saving new pointers failed! ');
            }
        }
    }
}
