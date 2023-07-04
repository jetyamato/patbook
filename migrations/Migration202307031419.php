<?php declare(strict_types = 1);

namespace Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

final class Migration202307031419
{
  private $connection;

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  public function migrate(): void
  {
    $schema = new Schema();
    $this->createUsersTable($schema);

    $queries = $schema->toSql($this->connection->getDatabasePlatform());
    foreach ($queries as $query)
    {
      $this->connection->executeQuery($query);
    }
  }

  private function createUsersTable(Schema $schema): void
  {
    $table = $schema->createTable('users');
    $table->addColumn('id', 'guid');
    $table->addColumn('nickname', 'string');
    $table->addColumn('password_hash', 'string');
    $table->addColumn('creation_date', 'datetime');
    $table->addColumn('failed_login_attempts', 'integer', [
      'default' => 0
    ]);
    $table->addColumn('last_failed_login_attempt', 'datetime', [
      'notnull' => false
    ]);
  }
}
