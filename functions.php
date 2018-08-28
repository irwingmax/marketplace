<?php
// error_reporting(E_ALL);
// ini_set("display_errors","On");

require __DIR__.'/vendor/autoload.php';

$objectTransaction = new \Irwing\Pagarme\Transaction();
$objectTransaction->finalizeCapture();

if (!$objectTransaction->finalizeCapture()) {
    echo "Fail";
}
    echo "Success";
