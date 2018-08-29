<?php
namespace Irwing\Pagarme;

class Transaction implements \Irwing\Pagarme\Interfaces\TransactionInterface
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
        $this->objectRequest = new RequestData();
        $this->objectPagarMe = new \PagarMe\Sdk\PagarMe('ak_test_qDURyncApVQmfq7MCbXrv0ZXjIL0sL');
        $this->objectDivideProfit = new DividedProfit();

        $this->splitrules = $this->objectDivideProfit->divide();
        $this->amountToCapture = $this->objectRequest->getIndividualData()['cost'];

        $this->transaction = $this->objectPagarMe->transaction()->get(
            $this->objectRequest->getIndividualData()['token']
        );

        $this->metadata = [];

        $this->transaction = $this->objectPagarMe->transaction()->capture(
            $this->transaction,
            $this->amountToCapture,
            $this->metadata,
            $this->splitrules
        );

        if ($this->transaction == null) {
            echo 'Transação não finalizada';
        }

            echo 'Trasação finalizada com sucesso';
    }
}
