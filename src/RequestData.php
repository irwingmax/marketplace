<?php
namespace Irwing\Pagarme;

class RequestData implements \Irwing\Pagarme\Interfaces\RequestDataInterface
{
    private $allData;
    private $individualData;

    public function getIndividualData()
    {
        $this->allData = explode(',', $_REQUEST['t']);
        $this->individualData = array(
            "cost" => $this->allData[0],
            "token" => $this->allData[1],
        );

        for ($indexer = 1; $indexer < count($this->allData) - 1; $indexer++) {
            $this->individualData["fornecedor" . $indexer] = $this->allData[$indexer+1];
        }

        return $this->individualData;
    }
}
