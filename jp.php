<?php

require 'vendor/autoload.php';

use JmesPath\Lexer;
use JmesPath\Parser;
use JmesPath\Interpreter;

$expression = $argv[1];
$data = json_decode(stream_get_contents(STDIN), true);

echo "Expression:\n-----------\n\n{$expression}\n\n";
echo "Data:\n-----\n\n" . json_encode($data, JSON_PRETTY_PRINT) . "\n\n";

$parser = new Parser(new Lexer());
$interpreter = new Interpreter(true);

$t = microtime(true);
$opcodes = $parser->compile($expression);
$parseTime = (microtime(true) - $t) * 1000;

$t = microtime(true);
$result = $interpreter->execute($opcodes, $data);
$interpretTime = (microtime(true) - $t) * 1000;

echo sprintf("Result:\n-------\n\n%s\n\n", json_encode($result, JSON_PRETTY_PRINT));
echo "Parse time:     {$parseTime} ms\n";
echo "Interpret time: {$interpretTime} ms\n";
echo "Total time:     " . ($parseTime + $interpretTime) . " ms\n";
