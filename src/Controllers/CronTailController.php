<?php

namespace App\Controllers;

use App\Bot\Commands\TailCommand;
use Psr\Container\ContainerInterface;

class CronTailController extends CronBaseController
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->setCommandClass(TailCommand::class);
    }
}