<?php declare(strict_types = 1);

use Migrations\Migration202306101915;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

$injector = include(ROOT_DIR . '/src/dependencies.php');

$connection = $injector->make('Doctrine\DBAL\Connection');

$migration = new Migration202306101915($connection);
$migration->migrate();

echo 'Finished running migrations' . PHP_EOL;
