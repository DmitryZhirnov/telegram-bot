<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Domain\SwearingWord\SwearingWord;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world! Slim');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->post('/bot', \App\Controllers\BotController::class);

    $app->get('/bot/{word}', function (Request $request, Response $response) {
        $swearingWords = [
            'хуй',
            'пизда',
        ];
        $text = 'хуйq';
        foreach ($swearingWords as $swearingWord) {
            $swearingWordExists = Str::contains($text, $swearingWord);
            if ($swearingWordExists) {
                break;
            }
        }
        echo $swearingWordExists ? 'true' : 'false';
        return $response;
    });
};
