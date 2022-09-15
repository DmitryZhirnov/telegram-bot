<?php

namespace App\Controllers;

use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class BotController
{
    protected ContainerInterface $container;
    protected LoggerInterface $logger;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        try {
            $this->logger = $this->container->get(LoggerInterface::class);
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
        $token = '5697838884:AAHGcz-ajOtBL-txCiac-WGgHdTct-S1I4k';
        try {
            $bot = new \Longman\TelegramBot\Telegram($token, "DmitryZhirnov");
            $requestObj = json_decode($request->getBody()->getContents());
            $message = Request::editMessageText([
                'message_id' => $requestObj->message->message_id,
                'text' => 'new text',
                'chat_id' => $requestObj->message->from->chat->id,
            ]);
            $this->logger->debug(var_export($message, true));
            $bot->handle();

        } catch (\Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }
        $this->logger->info('response = ' .$response->getBody()->getContents());
        return $response;
    }
}
