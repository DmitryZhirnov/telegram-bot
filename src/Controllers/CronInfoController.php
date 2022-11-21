<?php

namespace App\Controllers;

use App\Bot\ServiceManager;
use App\Bot\Services\SpamFilter;
use Longman\TelegramBot\Telegram;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class CronInfoController
{
    protected ContainerInterface $container;
    protected LoggerInterface $logger;
    protected Telegram $telegramBot;
    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $this->container->get(LoggerInterface::class);
        try {
            $this->telegramBot = $this->container->get(Telegram::class);
        } catch (\Throwable $e) {
            $this->logger->debug(__METHOD__, [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);
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

        return $response;
    }
}
