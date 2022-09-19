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
        $message = $this->getMessage();
        $text = "<b>жирный</b>, <strong>жирный</strong>\n\n";
        $text .= "<i>курсив</i>, <em>курсив</em>\n\n";
        $text .= "<u>подчеркнутый</u>, <ins> подчеркнутый </ins>\n\n";
        $text .= "<s>перечеркнутый</s>, <strike> перечеркнутый </strike>, <del> перечеркнутый </del>";
        $text .= "<a href='https://dzhirnov.ru' target='_blank'>home</a>";

        return Request::sendMessage(['chat_id'    => $message->getChat()->getId(),
                                     'message_id' => $message->getMessageId(),
                                     'text'       => $text,
                                     'parse_mode' => "html",
        ]);
    }
}