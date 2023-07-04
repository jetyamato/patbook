<?php declare(strict_types = 1);

namespace SocialNews\User\Infrastructure;

use Doctrine\DBAL\Connection;
use SocialNews\User\Domain\User;
use SocialNews\User\Domain\UserRepository;

final class DbalUserRepository implements UserRepository
{
  private $connection;

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  public function add(User $user): void
  {
    $qb = $this->connection->createQueryBuilder();

    $qb->insert('users');
    $qb->values([
      'id' => $qb->createNamedParameter($user->getId()->toString()),
      'nickname' => $qb->createNamedParameter($user->getNickname()),
      'password_hash' => $qb->createNamedParameter($user->getPasswordHash()),
      'creation_date' => $qb->createNamedParameter(
          $user->getCreationDate(),
          'datetime'
      )
    ]);

    $qb->execute();
  }
}
