<?php

namespace App\Controllers;

use Longman\TelegramBot\Telegram;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class CronBaseController
{
    protected ContainerInterface $container;
    protected LoggerInterface $logger;
    protected Telegram $telegramBot;
    protected string $commandClass;

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
        try {
            $this->logger->debug($this->commandClass);
            $command = new $this->commandClass($this->telegramBot, null);
            $command->execute();
        } catch (\Throwable $e) {
            $this->logger->debug(__METHOD__, [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);
        }

        return $response;
    }

    /**
     * @param string $commandClass
     */
    public function setCommandClass(string $commandClass): void
    {
        $this->commandClass = $commandClass;
    }
}