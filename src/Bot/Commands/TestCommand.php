<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\TelegramLog;
use Psr\Log\LoggerAwareTrait;

class TestCommand extends \Longman\TelegramBot\Commands\UserCommand
{
    use LoggerAwareTrait;

    protected $name = 'test';
    protected $usage = '/test';
    protected $version = '1.0.0';
    protected $description = 'A command for test';

    /**
     * @inheritDoc
     */
    public function execute(): ServerResponse
    {
        $this->getMessage();
        return $this->replyToChat('text');
    }
}