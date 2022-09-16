<?php

namespace App\Bot\Services;

use Longman\TelegramBot\DB;
use Longman\TelegramBot\Request;
use Psr\Http\Message\ServerRequestInterface;

class SpamFilter implements ServiceInterface
{

    protected ServerRequestInterface $request;

    public function handle()
    {
        $request = json_decode($this->request->getBody()->getContents(), false);
        $text = $request->message->text;
        if (str_contains('мудак', $text)) {
            Request::deleteMessage(
                [
                    'message_id' => $request->message->id,
                    'chat_id'    => $request->message->chat->id,
                ]
            );
        }
    }

    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }
}