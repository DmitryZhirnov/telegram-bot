<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class TestCommand extends \Longman\TelegramBot\Commands\Command
{
    protected $name = 'test';

    /**
     * @inheritDoc
     */
    public function execute(): ServerResponse
    {
        $data = [];
        $data['text'] = $this->getMessage()->getText() . ' with test';
        return Request::sendMessage($data);
    }
}