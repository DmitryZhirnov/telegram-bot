<?php

namespace App\Controllers;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class BotController
{
    protected ContainerInterface $container;
    protected LoggerInterface $logger;
    protected Telegram $telegramBot;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        try {
            $this->logger = $this->container->get(LoggerInterface::class);
            $this->telegramBot = $this->container->get(Telegram::class);
            $this->logger->debug(__METHOD__, [var_export($this->telegramBot)]);exit;
        } catch (\Throwable $e) {
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        try {
            $requestObj = json_decode($request->getBody()->getContents());
            $this->logger->debug('bot:  ' . var_export($this->telegramBot));
            if ($requestObj->message->text == '12345') {
                Request::deleteMessage([
                    'message_id' => $requestObj->message->message_id,
                    'chat_id'    => $requestObj->message->chat->id,
                ]);
            }
            $this->logger->debug(var_export($requestObj->message, true));
            $this->telegramBot->handle();
        } catch (\Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }
        $this->logger->info('response = ' . $response->getBody()->getContents());
        return $response;
    }
}
