<?php declare(strict_types = 1);

namespace SocialNews\Framework\Rendering;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

final class TwigTemplateRendererFactory
{
  private $templateDirectory;

  public function __construct(TemplateDirectory $templateDirectory)
  {
    $this->templateDirectory = $templateDirectory;
  }

	public function create(): TwigTemplateRenderer
	{
    $templateDirectory = $this->templateDirectory->toString();
		$loader = new FilesystemLoader([$templateDirectory]);
		$twigEnvironment = new Environment($loader);
		return new TwigTemplateRenderer($twigEnvironment);
	}
}
