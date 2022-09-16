<?php

namespace App\Controllers;

use App\Application\Settings\SettingsInterface;
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
            /** @var SettingsInterface $settings */
            $settings = $container->get(SettingsInterface::class);
            $telegramBot = new Telegram('5697838884:AAHGcz-ajOtBL-txCiac-WGgHdTct-S1I4k', 'DZhirnovBot');
            if (!empty($settings)) {
                $telegramBot->enableMySql($settings['db'], $telegramBot->getBotUsername() . '_');
            }
            $telegramBot->addCommandsPath(__DIR__ . '/../src/Bot/Commands');
            $this->telegramBot = $telegramBot;
        } catch (\Throwable $e) {
            $this->logger->debug(__METHOD__, [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace ' => $e->getTraceAsString()
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
