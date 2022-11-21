<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Psr\Log\LoggerAwareTrait;

class StewardCommand extends AdminCommand
{
    use LoggerAwareTrait;

    protected $name = 'steward';
    protected $usage = '/steward';
    protected $version = '1.0.0';
    protected $description = 'Еженедельное сообщение сбора по 100 рублей.';

    /**
     * @inheritDoc
     */
    public function execute(): ServerResponse
    {
        $text = file_get_contents(__DIR__ . "/../../../data/html/{$this->name}.html");
        return Request::sendPhoto([
//            'chat_id'    => -1001553767868, // мой чат
            'chat_id'    => -1001351585233, //опсб орел
            'caption'    => $text,
            'photo'      => __DIR__ . '/../../../public/images/steward.png',
            'parse_mode' => "html",
        ]);
    }
}
