<?php
require_once '../vendor/autoload.php';

use PhpPmd\Console;

$db_host = Console::prompt('database host', ['default' => 'localhost']);

Console::stdout($db_host . PHP_EOL);
