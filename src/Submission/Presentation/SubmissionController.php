<?php declare(strict_types = 1);

namespace SocialNews\Submission\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;

final class SubmissionController
{
  private $templateRenderer;
  private $storedTokenValidator;
  private $session;

  public function __construct
  (
    TemplateRenderer $templateRenderer,
    StoredTokenValidator $storedTokenValidator,
    Session $session
  )
  {
    $this->templateRenderer = $templateRenderer;
    $this->storedTokenValidator = $storedTokenValidator;
    $this->session = $session;
  }

	public function show(): Response
	{
		$content = $this->templateRenderer->render('Submission.html.twig');
		return new Response($content);
	}

  public function submit(Request $request): Response
  {
    $response = new RedirectResponse('/submit');

    if (!$this->storedTokenValidator->validate
      (
        'submission',
        new Token((string)$request->get('token'))
      )
    )
    {
      $this->session->getFlashBag()->add('errors', 'Invalid token');
      return $response;
    }

    // save the submission...
    
    $this->session->getFlashBag()->add('success', 'Your URL was submitted successfully');
    return $response;
  }
}
