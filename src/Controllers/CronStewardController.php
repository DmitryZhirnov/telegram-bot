<?php

namespace App\Controllers;

use App\Bot\Commands\StewardCommand;
use Psr\Container\ContainerInterface;

class CronStewardController extends CronBaseController
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->setCommandClass(StewardCommand::class);
    }
}