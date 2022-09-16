<?php

namespace App\Bot;

use App\Application\Settings\Settings;
use App\Bot\Services\ServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class ServiceManager
{
    /**
     * @var array<string>
     */
    protected array $services = [];
    protected Settings $settings;
    protected LoggerInterface $logger;

    public function __construct(Settings $settings, LoggerInterface $logger)
    {
        $this->settings = $settings;
        $this->logger = $logger;
    }

    public function execute(ServerRequestInterface $request): void
    {
        foreach ($this->services as $service) {
            if (class_exists($service)) {
                $serviceObj = new $service();
                if ($serviceObj instanceof ServiceInterface) {
                    $serviceObj->setRequest($request);
                    $serviceObj->setLogger($this->logger);
                    $serviceObj->handle();
                }
            }
        }
    }

    public function addService(string $serviceClass)
    {
        $this->services[] = $serviceClass;
    }

    public function addServices(array $services)
    {
        $this->services = array_merge($this->services, $services);
    }
}