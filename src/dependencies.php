<?php declare(strict_types = 1);

use Auryn\Injector;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Framework\Rendering\TwigTemplateRendererFactory;

$injector = new Injector();

$injector->delegate(
	TemplateRenderer::class,
	function () use ($injector): TemplateRenderer
	{
		$factory = $injector->make(TwigTemplateRendererFactory::class);
		return $factory->create();
	}
);

return $injector;
