<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\TelegramLog;

class TestCommand extends \Longman\TelegramBot\Commands\Command
{
    protected $name = 'test';
    protected $usage = '/test';


    /**
     * @inheritDoc
     */
    public function execute(): ServerResponse
    {
        TelegramLog::debug(__METHOD__);
        $text = $this->getMessage()->getText() . ' with test';
        return $this->replyToChat($text);
    }
}