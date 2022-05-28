<?php
require_once '../vendor/autoload.php';

use PhpPmd\Console;

$opt = Console::select('apply this patch?',
    ['y' => 'yes', 'n' => 'no', 'a' => 'all']
);

Console::stdout($opt . PHP_EOL);