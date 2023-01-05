<?php declare(strict_types = 1);

namespace Patbook;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tracy\Debugger;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

Debugger::enable();

$request = Request::createFromGlobals();

$content = 'Hello ' . $request->get('name', 'visitor');

$response = new Response($content);
$response->prepare($request);
$response->send();
