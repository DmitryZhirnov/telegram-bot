<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\User;
use Longman\TelegramBot\Request;
use Psr\Log\LoggerAwareTrait;

class InfoCommand extends AdminCommand
{
    use LoggerAwareTrait;

    protected $name = 'info';
    protected $usage = '/info';
    protected $version = '1.0.0';
    protected $description = 'Информация о канале.';

    /**
     * @inheritDoc
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $text = file_get_contents(__DIR__ . "/../../../data/html/{$this->name}.html");
        return Request::sendPhoto([
//            'chat_id'    => -1001553767868,
            'chat_id'    => -1001351585233,
            'photo'      => __DIR__ . '/../../../public/images/opsb.png',
            'caption'    => $text,
            'parse_mode' => "html",
        ]);
    }
}