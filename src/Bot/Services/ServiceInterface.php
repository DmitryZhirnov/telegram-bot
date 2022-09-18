<?php

namespace App\Bot\Services;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

interface ServiceInterface
{
    public function handle();
    public function setRequest(ServerRequestInterface $request);
    public function setLogger(LoggerInterface $logger);
}