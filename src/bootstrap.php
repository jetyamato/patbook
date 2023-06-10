<?php declare(strict_types = 1);

use SocialNews\FrontPage\Presentation\FrontPageController;
use SocialNews\Framework\Rendering\TwigTemplateRendererFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Tracy\Debugger;
use function FastRoute\simpleDispatcher;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

Debugger::enable(Debugger::DEVELOPMENT);

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

$request = Request::createFromGlobals();

$dispatcher = simpleDispatcher(
	function (RouteCollector $r)
	{
		$routes = include ROOT_DIR . '/src/routes.php';
		foreach ($routes as $route)
		{
			$r->addRoute(...$route);
		}
	}
);

$routeInfo = $dispatcher->dispatch(
	$request->getMethod(),
	$request->getPathInfo()
);

switch ($routeInfo[0])
{
	case Dispatcher::NOT_FOUND:
		$response = new Response(
			'Not Found',
			404
		);
		break;
	case Dispatcher::METHOD_NOT_ALLOWED:
		$response = new Response(
			'Method Not Allowed',
			405
		);
		break;
	case Dispatcher::FOUND:
		[$controllerName, $method] = explode('#', $routeInfo[1]);
		$vars = $routeInfo[2];

		$injector = include('dependencies.php');
		$controller = $injector->make($controllerName);
		$response = $controller->$method($request, $vars);
		break;
}

if (!$response instanceof Response)
{
	throw new Exception('Controller methods must return a Response object');
}

$response->prepare($request);
$response->send();
