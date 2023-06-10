<?php declare(strict_types = 1);

use Auryn\Injector;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Framework\Rendering\TwigTemplateRendererFactory;
use SocialNews\Framework\Rendering\TemplateDirectory;
use SocialNews\FrontPage\Application\SubmissionsQuery;
use SocialNews\FrontPage\Infrastructure\MockSubmissionsQuery;

$injector = new Injector();

$injector->delegate(
	TemplateRenderer::class,
	function () use ($injector): TemplateRenderer
	{
		$factory = $injector->make(TwigTemplateRendererFactory::class);
		return $factory->create();
	}
);

$injector->alias(SubmissionsQuery::class, MockSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);

return $injector;
