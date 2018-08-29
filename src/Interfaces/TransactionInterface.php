<?php
namespace Irwing\Pagarme\Interfaces;

interface TransactionInterface
{
    abstract public function finalizeCapture();
}
