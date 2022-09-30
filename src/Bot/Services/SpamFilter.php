<?php

namespace App\Bot\Services;

use App\Domain\SwearingWord\SwearingWord;
use Illuminate\Support\Str;
use Longman\TelegramBot\Request;
use Psr\Log\LoggerAwareTrait;

/**
 *
 */
class SpamFilter extends ServiceBase
{
    use LoggerAwareTrait;

    public function handle()
    {
        $this->logger->debug(__METHOD__);
        $message = $this->getMessage();

        $text = Str::lower($message->getText());
        if (empty($text)) {
            $text = Str::lower($message->getCaption());
        }
        if (empty($text)) {
            return;
        }
        $swearingWordExists = SwearingWord::query()->where('word', 'LIKE', "%{$text}")
            ->where('word', 'LIKE', "{$text}%");
        if ($swearingWordExists->exists()) {
            $this->logger->info(__METHOD__, ['Удаляю сообщение содержащее матершину']);
            Request::deleteMessage(
                [
                    'message_id' => $message->getMessageId(),
                    'chat_id'    => $message->getChat()->getId(),
                ]
            );
        }
    }
}
