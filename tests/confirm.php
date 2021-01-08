<?php
require_once '../vendor/autoload.php';

use PhpPmd\Console;

$sure = Console::confirm('are you sure?');

Console::stdout($sure . PHP_EOL);