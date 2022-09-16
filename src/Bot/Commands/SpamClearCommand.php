<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class SpamClearCommand extends UserCommand
{

    public function execute(): ServerResponse
    {
        return $this->replyToChat(__CLASS__);
    }
}