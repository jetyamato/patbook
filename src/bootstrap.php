<?php declare(strict_types = 1);

namespace Patbook;

use Tracy;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

Tracy\Debugger::enable();

echo 'Hello from the bootstrap file! :)';
