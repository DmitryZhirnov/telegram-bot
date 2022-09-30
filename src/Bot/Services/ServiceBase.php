<?php

namespace App\Bot\Services;

use Longman\TelegramBot\Entities\Message;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

abstract class ServiceBase implements ServiceInterface
{
    use LoggerAwareTrait;

    protected ServerRequestInterface $request;

    abstract public function handle();

    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function getMessage(): Message
    {
        $request = json_decode($this->request->getBody()->getContents(), true);
        return new Message($request['message']);
    }
}
