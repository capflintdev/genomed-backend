<?php
require_once __DIR__ . '/vendor/autoload.php';

echo 'http host ' . $_SERVER['HTTP_HOST'];
echo '<br>';
echo 'SCRIPT_FILENAME ' . $_SERVER['SCRIPT_FILENAME'];
echo '<br>';
echo 'DOCUMENT_ROOT' . $_SERVER['DOCUMENT_ROOT'];
echo '<br>';
echo 'DOCUMENT_URI' . $_SERVER['DOCUMENT_URI'];
echo '<br>';
echo 'HTTP_HOST' . $_SERVER['HTTP_HOST'];
var_dump($_SERVER);