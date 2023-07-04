<?php declare(strict_types = 1);

use Auryn\Injector;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use SocialNews\User\Domain\UserRepository;
use SocialNews\User\Infrastructure\DbalUserRepository;
use SocialNews\User\Application\NicknameTakenQuery;
use SocialNews\User\Infrastructure\DbalNicknameTakenQuery;
use SocialNews\Submission\Domain\SubmissionRepository;
use SocialNews\Submission\Infrastructure\DbalSubmissionRepository;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Framework\Rendering\TwigTemplateRendererFactory;
use SocialNews\Framework\Rendering\TemplateDirectory;
use SocialNews\FrontPage\Application\SubmissionsQuery;
use SocialNews\FrontPage\Infrastructure\DbalSubmissionsQuery;
use SocialNews\Framework\Dbal\ConnectionFactory;
use SocialNews\Framework\Dbal\DatabaseUrl;
use SocialNews\Framework\Csrf\TokenStorage;
use SocialNews\Framework\Csrf\SymfonySessionTokenStorage;

$injector = new Injector();

$injector->delegate(
	TemplateRenderer::class,
	function () use ($injector): TemplateRenderer
	{
		$factory = $injector->make(TwigTemplateRendererFactory::class);
		return $factory->create();
	}
);

$injector->alias(SubmissionsQuery::class, DbalSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);

$injector->define(
  DatabaseUrl::class, [':url' => 'pdo-mysql://'.$_ENV['DB_USER'].':'.$_ENV['DB_PASS'].'@127.0.0.1:3306/patbook?charset=utf8']
);

$injector->delegate(
  Connection::class,
  function () use ($injector): Connection
  {
    $factory = $injector->make(ConnectionFactory::class);
    return $factory->create();
  }
);

$injector->share(Connection::class);

$injector->alias(TokenStorage::class, SymfonySessionTokenStorage::class);

$injector->alias(SessionInterface::class, Session::class);

$injector->alias(SubmissionRepository::class, DbalSubmissionRepository::class);

$injector->alias(UserRepository::class, DbalUserRepository::class);

$injector->alias(NicknameTakenQuery::class, DbalNicknameTakenQuery::class);

return $injector;
