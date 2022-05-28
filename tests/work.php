<?php
require_once '../vendor/autoload.php';

use PhpPmd\Console;

Console::stdout("falsh Working ...\n");
Console::work(function ($socket) { // socket
    $n = 100;
    for ($i = $n; $i >= 0; $i-=10) {
        Console::flash($socket, "[$i/$n]");
        usleep(100000);
    }
});
Console::stdout("[ok]\n");

Console::stdout("Socket Working ...\n");
Console::work(function ($socket) { // socket
    $n = 10;
    for ($i = 0; $i <= $n; $i++) {
        if ($i == $n) Console::write($socket, "[$i/$n]");
        else Console::writeln($socket, "[$i/$n]");
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