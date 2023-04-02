<?php declare(strict_types = 1);

namespace SocialNews\FrontPage\Presentation;

use SocialNews\Framework\Rendering\TemplateRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FrontPageController
{
	private $templateRenderer;

	public function __construct(TemplateRenderer $templateRenderer)
	{
		$this->templateRenderer = $templateRenderer;
	}

	public function show(): Response
	{
    $submissions = [
      ['url' => 'https://google.com', 'title' => 'Google'],
      ['url' => 'https://bing.com', 'title' => 'Bing']
    ];
    $content = $this->templateRenderer->render('FrontPage.html.twig', [
      'submissions' => $submissions
    ]);
		return new Response($content);
	}
}
