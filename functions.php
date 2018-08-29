<?php
require __DIR__.'/vendor/autoload.php';

$objectTransaction = new \Irwing\Pagarme\Transaction();
$objectTransaction->finalizeCapture();
