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
            $token = getenv('TELEGRAM_BOT_TOKEN');
            $telegramBot = new Telegram($token, 'DZhirnovBot');
            $dbCredentials = [
                'host'     => getenv('DB_HOST'),
                'port'     => getenv('DB_PORT'), // optional
                'user'     => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'database' => getenv('db_name'),
            ];
            $telegramBot->enableMySql($dbCredentials, $telegramBot->getBotUsername() . '_');
            $telegramBot->addCommandsPath(__DIR__ . '/../src/Bot/Commands');
            return $telegramBot;
        }
    ]);
};
