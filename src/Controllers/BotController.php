<?php

namespace App\Controllers;

use Longman\TelegramBot\Telegram;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BotController
{
    protected ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
            $bot->handle();

        } catch (\Throwable $throwable) {
            echo $throwable->getMessage();
        }
        return $response;
    }
}
