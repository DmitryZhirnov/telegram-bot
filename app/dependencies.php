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
        LoggerInterface::class         => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Telegram::class                => function (ContainerInterface $container) {
            $logger = $container->get(LoggerInterface::class);
            $settings = $container->get(SettingsInterface::class);
            try {
                $token = $_ENV['TELEGRAM_BOT_TOKEN'];
                $telegramBot = new Telegram($token, 'DZhirnovBot');
                $dbCredentials = $settings->get('db');
                $telegramBot->enableMySql($dbCredentials);
                $telegramBot->enableAdmins([718724807, 507810493]);
                $telegramBot->addCommandsPath(__DIR__ . '/../src/Bot/Commands');
                return $telegramBot;
            } catch (Throwable $throwable) {
                $logger->debug($throwable->getMessage() . $throwable->getLine());
            }
            return null;
        },
        \App\Bot\ServiceManager::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $logger = $container->get(LoggerInterface::class);
            return new \App\Bot\ServiceManager($settings, $logger);
        },
        'db' => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $capsule = new Illuminate\Database\Capsule\Manager();
            $capsule->addConnection($settings->get('db'));
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            return $capsule;
        },
    ]);
};
