<?php

namespace App\Bot\Services;

use App\Domain\SwearingWord\SwearingWord;
use Illuminate\Support\Str;
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
        $text = Str::lower($request->message->text);
        $this->logger->debug(__METHOD__, [json_encode($request->message, JSON_UNESCAPED_UNICODE)]);
        $swearingWords = SwearingWord::all();
        $swearingWordExists = false;
        foreach ($swearingWords as $swearingWord) {
            $swearingWordExists = Str::contains($swearingWord, $text);
            if ($swearingWordExists) {
                break;
            }
        }
        if ($swearingWordExists) {
            $this->logger->info(__METHOD__, ['Удаляю сообщение содержащее матершину']);
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
