<?php

namespace App\Bot\Services;

use Longman\TelegramBot\Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;

class SpamFilter implements ServiceInterface
{
    use LoggerAwareTrait;

    protected ServerRequestInterface $request;

    public function handle()
    {
        $request = json_decode($this->request->getBody()->getContents(), false);
        $text = $request->message->text;
        $this->logger->debug(__METHOD__, [var_export($request->message, true)]);
        if (str_contains('мудак', $text)) {
            Request::deleteMessage(
                [
                    'message_id' => $request->message->message_id,
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
