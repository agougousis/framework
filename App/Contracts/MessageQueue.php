<?php

namespace App\Contracts;

use App\Entities\MessageUnit;

interface MessageQueue {
    public function push(MessageUnit $messageUnit);
}
