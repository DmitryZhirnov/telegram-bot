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
        Telegram::class        => function (ContainerInterface $container) {
            $logger = $container->get(LoggerInterface::class);
            try {
                $token = $_ENV['TELEGRAM_BOT_TOKEN'];
                $telegramBot = new Telegram($token, 'DZhirnovBot');
                /** @var LoggerInterface $logger */
                $dbCredentials = [
                    'host'     => $_ENV['DB_HOST'],
                    'port'     => $_ENV['DB_PORT'],
                    // optional
                    'user'     => $_ENV['DB_USER'],
                    'password' => $_ENV['DB_PASSWORD'],
                    'database' => $_ENV['DB_NAME'],
                ];
                $telegramBot->enableMySql($dbCredentials, $telegramBot->getBotUsername() . '_');
                $telegramBot->enableAdmin(718724807);
                $telegramBot->addCommandsPath(__DIR__ . '/../src/Bot/Commands');
                return $telegramBot;
            } catch (Throwable $throwable) {
                $logger->debug($throwable->getMessage().$throwable->getLine());
            }
            return null;
        },
    ]);
};
