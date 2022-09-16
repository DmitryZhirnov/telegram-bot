<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class SpamClearCommand extends UserCommand
{
    protected $name = 'clear';
    protected $usage = '';
    protected $version = '1.0.0';
    protected $description = 'A command for test';

    public function execute(): ServerResponse
    {
        return $this->replyToChat(__CLASS__);
    }
}