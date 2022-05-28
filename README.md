# Console

Console based on [Clio](https://github.com/nramenta/clio).

Console is a lightweight utility and helper classes for CLI applications.

It provides colored output, prompts, confirmation inputs, selections, background.

## Installation

```
composer require php-pmd/console
```

PHP 5.4 is required. This library is developed on and is meant to be used on
POSIX systems with the posix, pcntl, and sockets extensions loaded.

The Console class provides helpers for interactive command line input/output.

### Console::stdin($raw = false)

Waits for user input. If `$raw` is set to `true`, returns the input without
right trimming for `PHP_EOL`.

### Console::input($prompt = null, $raw = false)

Asks the user for input which ends when the user types a `PHP_EOL` character.
You can optionally provide a prompt string. If `$raw` is set to `true`, returns
the input without right trimming for `PHP_EOL`. 

### Console::stdout($text, $raw = false)

Prints `$text` to STDOUT. The text can contain text color and style specifiers.
This method detects whether the text is to be sent out to TTY or to a file
through the use of shell redirection and acts accordingly, in the case of the
latter, by stripping the text of all color and style specifiers.

If the second parameter is set to true, then it will print `$text` as is with
all text color and style specifiers intact regardless of whether it's printing
to TTY or to a file.

```php
<?php
use PhpPmd\Console;
Console::stdout('Hello, World!');
```

### Console::output($text, $raw = false)

The same as `Console::stdout` except it automatically appends a `PHP_EOL`.

### Console::stderr($text, $raw = false)

Behaves like `Console::stdout` except it's for STDERR.

### Console::error($text, $raw = false)

The same as `Console::stderr` except it automatically appends a `PHP_EOL`.

### Console::prompt($text, $options)

This function prompts the user for input. Several options are available:

- `required`: True if input is necessary, false otherwise.
- `default`: If the user does not provide an input, this is the default value.
- `pattern`: Regular expression pattern to match.
- `validator`: Callable to validate input. Must return `true` or `false`.
- `error`: Default error message.

If an input error occurs, the prompt will repeat and will keep asking the user
for input until it satisfies all the requirements in the `$options` array. Note
that if you supply a `default` option, `required` is not enforced.

```php
<?php
use PhpPmd\Console;
$db_host = Console::prompt('database host', ['default' => 'localhost']);
```

If you provide your own validator callable, you can pass a custom error message
to the second parameter:

```php
<?php
use PhpPmd\Console;
$file = Console::prompt('File', [
    'required' => true,
    'validator' => function($input, &$error = null) {
        if (is_readable($input)) {
            return true;
        } else {
            $error = 'Path given is not a readable file';
            return false;
        }
    }
]);
```

Note that for this to work, the second parameter must be declared a reference.

### Console::confirm($text)

Asks the user for a simple y/n answer. The answer can be `'y'`, `'n'`, `'Y'`, or
`'N'`. Returns either `true` or `false`.

```php
<?php
use PhpPmd\Console;
$sure = Console::confirm('are you sure?');
```

### Console::select($text, $options)

Asks the user to choose from a selection of options. The `$options` array is a
key-value pairs of input and explanation. The `'?'` input option is appended
automatically and it serves as the help option showing all other options along
with their respective explanations.

```php
<?php
use PhpPmd\Console;
$opt = Console::select('apply this patch?',
    ['y' => 'yes', 'n' => 'no', 'a' => 'all']
);
```

### Console::work(callable $callable)

Forks another process to run `$callable` in the background while showing status
updates to the standard output. By default the status update is a simple spinner
which will stop once the `$callable` returns. By providing `$callable` with a
`$socket` parameter, the status update is whatever is sent from the background
process to the foreground process using the `socket_write()` function:

```php
<?php
use PhpPmd\Console;
Console::stdout('Working ... ');
Console::work(function($socket) { // $socket is optional, defaults to a spinner
    $n = 100;
    for ($i = 1; $i <= $n; $i++) {
        // do whatever it is you need to do
        socket_write($socket, "[$i/$n]\n");
        sleep(1); // sleep is good for you
    }
});
Console::stdout("%g[DONE]%n\n");
```

Messages sent to the foreground process needs to end with a `"\n"` character.

### Text color and style specifiers

You can use text color and style specifiers in the format of `%x` where `x` is
the specifier:

```php
<?php
use PhpPmd\Console;
Console::output('this is %rcolored%n and %Bstyled%n');
```

The `%n` specifier normalizes the color and style of the text to that of the
shell's defaults. This specifier is taken from PEAR's Console_Color package.
To print a percentage symbol, simply put two `%` characters. The following is
the full set of specifiers:

```
            text      text            background
------------------------------------------------
%k %K %0    black     dark grey       black
%r %R %1    red       bold red        red
%g %G %2    green     bold green      green
%y %Y %3    yellow    bold yellow     yellow
%b %B %4    blue      bold blue       blue
%m %M %5    magenta   bold magenta    magenta
%p %P       magenta (think: purple)
%c %C %6    cyan      bold cyan       cyan
%w %W %7    white     bold white      white

%F     Blinking, Flashing
%U     Underline
%8     Reverse
%_,%9  Bold

%n     Resets the color
%%     A single %
```

You can use these specifiers with methods that takes a string and outputs it.