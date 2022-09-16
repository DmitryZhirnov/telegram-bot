<?php

namespace App\Bot;

use App\Application\Settings\Settings;
use App\Bot\Services\ServiceInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServiceManager
{
    /**
     * @var array<string>
     */
    protected array $services = [];
    protected Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function execute(ServerRequestInterface $request): void
    {
        foreach ($this->services as $service) {
            if (class_exists($service)) {
                $serviceObj = new $service();
                if ($serviceObj instanceof ServiceInterface) {
                    $serviceObj->setRequest($request);
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