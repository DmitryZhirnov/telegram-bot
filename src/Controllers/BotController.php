<?php

namespace App\Controllers;

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
        try {
            $this->logger->info($request->getBody()->getContents());
        } catch (\Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }
        $this->logger->info('response = ' .$response->getBody()->getContents());
        return $response;
    }
}
