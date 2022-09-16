<?php

namespace App\Bot\Services;

use Psr\Http\Message\ServerRequestInterface;

interface ServiceInterface
{
    public function handle();
    public function setRequest(ServerRequestInterface $request);
}