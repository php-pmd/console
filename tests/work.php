<?php
require_once '../vendor/autoload.php';

use PhpPmd\Console;

Console::stdout("Socket Working ...\n");
Console::work(function ($socket) { // socket
    $n = 10;
    for ($i = 0; $i <= $n; $i++) {
        Console::write($socket, "[$i/$n]");
        usleep(100000);
    }
});
Console::stdout("[ok]\n");

Console::stdout("Loading Working ...\n");
Console::work(function () { // spinner
    $n = 10;
    for ($i = 0; $i <= $n; $i++) {
        usleep(100000);
    }
});
Console::stdout("[ok]\n");