<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Longman\TelegramBot\Telegram;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Telegram::class => function (ContainerInterface $container) {
            $logger = $container->get(LoggerInterface::class);
            /** @var SettingsInterface $settings */
            $settings = $container->get(SettingsInterface::class);
            $token = $settings->get('botToken');
            $telegramBot = new Telegram($token, 'DZhirnovBot');
            /** @var LoggerInterface $logger */
            $telegramBot->enableMySql($settings['db'], $telegramBot->getBotUsername() . '_');
            $telegramBot->addCommandsPath(__DIR__ . '/../src/Bot/Commands');
            return $telegramBot;
        }
    ]);
};
