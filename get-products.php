#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Console\Application;
use Symfony\Component\HttpClient\HttpClient;
use TheIconicAPIDumper\APIWrapper;
use TheIconicAPIDumper\DumpCommand;

$HTTPClient = HttpClient::create();
$APIWrapper = new APIWrapper($HTTPClient);

$app = new Application('The Iconic Products Console Application', 'v1.0.0');
$app -> add(new DumpCommand($APIWrapper));
$app -> run();