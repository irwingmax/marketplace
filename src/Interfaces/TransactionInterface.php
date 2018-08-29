<?php
namespace Irwing\Pagarme\Interfaces;

interface TransactionInterface
{
    public abstract function finalizeCapture();
}