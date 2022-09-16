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
        $message = $this->getMessage();            // Get Message object
        $chat_id = $message->getChat()->getId();   // Get the current Chat ID
        $data = [                                  // Set up the new message data
                                                   'chat_id' => $chat_id,
                                                   // Set Chat ID to send the message to
                                                   'text'    => 'This is just a Test...',
                                                   // Set message to send
        ];
        return Request::sendMessage($data);        // Send message!
    }
}