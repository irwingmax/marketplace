<?php
namespace Irwing\Pagarme;

class Transaction
{
    private $objectRequest;
    private $objectPagarMe;
    private $objectDivideProfit;
    private $amountToCapture;
    private $splitrules;
    private $metadata;
    private $transaction;

    public function finalizeCapture()
    {
        $this->objectRequest = new \Irwing\Pagarme\RequestData();
        $this->objectPagarMe = new \PagarMe\Sdk\PagarMe('ak_test_qDURyncApVQmfq7MCbXrv0ZXjIL0sL');
        $this->objectDivideProfit = new \Irwing\Pagarme\DividedProfit();

        $this->splitrules = $this->objectDivideProfit->divide();
        $this->amountToCapture = $this->objectRequest->getIndividualData()['cost'];
        $this->transaction = $this->objectPagarMe->transaction()->
                        get($this->objectRequest->getIndividualData()['token']);
        $this->metadata = [];

        return $this->objectPagarMe->transaction()->capture(
            $this->transaction,
            $this->amountToCapture,
            $this->metadata,
            $this->splitrules
        );
    }
}
