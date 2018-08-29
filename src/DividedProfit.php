<?php
namespace Irwing\Pagarme;

class DividedProfit
{
    private $objectPagarMe;
    private $objectRequest;
    private $objectSplitRules;

    private $totalProfit;
    private $dividedProfit;
    private $mariaProfit;
    private $fee;
    private $joaoProfit;
    private $cesarProfit;
    private $splitRuleMaria;
    private $splitRuleJoao;
    private $splitRuleCesar;


    public function divide()
    {
        define('MARIA_ID', 're_cjle1g36b01c2l16d8ta4bb2c');
        define('JOAO_ID', 're_cjle1h4k9012v0k6eq3ifn72y');
        define('CESAR_ID', 're_cjle1hode01crl16dh5jc2dfc');
        define('API', 'ak_test_qDURyncApVQmfq7MCbXrv0ZXjIL0sL');

        define('PRICE_OF_MARIA_PRODUCT', 12500);
        define('PRICE_OF_JOAO_PRODUCT', 10000);
        define('PRICE_OF_CESAR_PRODUCT', 15000);

        $this->objectRequest = new \Irwing\Pagarme\RequestData();
        $this->objectPagarMe = new \PagarMe\Sdk\PagarMe('ak_test_qDURyncApVQmfq7MCbXrv0ZXjIL0sL');
        $this->objectSplitRules = new \PagarMe\Sdk\SplitRule\SplitRuleCollection();

        $this->totalProfit = $this->objectRequest->getIndividualData()['cost'];

        $this->fee = 4200;
        $this->dividedProfit = $this->totalProfit - $this->fee;

        if (!array_search('joao', $this->objectRequest->getIndividualData()) &&
            !array_search('cesar', $this->objectRequest->getIndividualData())) {
            $this->mariaProfit = $this->totalProfit;

            $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->mariaProfit,
                $this->objectPagarMe->recipient()->get(MARIA_ID),
                true,
                true
            );

            $this->objectSplitRules[0] = $this->splitRuleMaria;
            return $this->objectSplitRules;
        }

        if (!array_search('maria', $this->objectRequest->getIndividualData()) &&
            !array_search('cesar', $this->objectRequest->getIndividualData())) {
            $this->mariaProfit = $this->dividedProfit * 0.15;
            $this->joaoProfit = $this->dividedProfit * 0.85;

            $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->mariaProfit + $this->fee,
                $this->objectPagarMe->recipient()->get(MARIA_ID),
                true,
                true
            );

            $this->splitRuleJoao = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->joaoProfit,
                $this->objectPagarMe->recipient()->get(JOAO_ID),
                true,
                true
            );

            $this->objectSplitRules[0] = $this->splitRuleMaria;
            $this->objectSplitRules[1] = $this->splitRuleJoao;

            return $this->objectSplitRules;
        }

        if (!array_search('maria', $this->objectRequest->getIndividualData()) &&
            !array_search('joao', $this->objectRequest->getIndividualData())) {
            $this->mariaProfit = $this->dividedProfit * 0.15;
            $this->cesarProfit = $this->dividedProfit * 0.85;

            $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->mariaProfit + $this->fee,
                $this->objectPagarMe->recipient()->get(MARIA_ID),
                true,
                true
            );

            $this->splitRuleCesar = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->cesarProfit,
                $this->objectPagarMe->recipient()->get(CESAR_ID),
                true,
                true
            );

            $this->objectSplitRules[0] = $this->splitRuleMaria;
            $this->objectSplitRules[1] = $this->splitRuleCesar;

            return $this->objectSplitRules;
        }

        if (!array_search('maria', $this->objectRequest->getIndividualData())) {
            $this->mariaProfit = PRICE_OF_CESAR_PRODUCT * 0.15;
            $this->mariaProfit = PRICE_OF_JOAO_PRODUCT * 0.15 + $this->mariaProfit;
            $this->cesarProfit = PRICE_OF_CESAR_PRODUCT * 0.85;
            $this->joaoProfit = PRICE_OF_JOAO_PRODUCT * 0.85;

            $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->mariaProfit + $this->fee,
                $this->objectPagarMe->recipient()->get(MARIA_ID),
                true,
                true
            );

            $this->splitRuleCesar = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->cesarProfit,
                $this->objectPagarMe->recipient()->get(CESAR_ID),
                true,
                true
            );

            $this->splitRuleJoao = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->joaoProfit,
                $this->objectPagarMe->recipient()->get(JOAO_ID),
                true,
                true
            );

            $this->objectSplitRules[0] = $this->splitRuleMaria;
            $this->objectSplitRules[1] = $this->splitRuleCesar;
            $this->objectSplitRules[2] = $this->splitRuleJoao;

            return $this->objectSplitRules;
        }

        if (!array_search('joao', $this->objectRequest->getIndividualData())) {
            $this->mariaProfit = PRICE_OF_CESAR_PRODUCT * 0.15;
            $this->cesarProfit = PRICE_OF_CESAR_PRODUCT * 0.85;

            $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->mariaProfit + $this->fee + PRICE_OF_MARIA_PRODUCT,
                $this->objectPagarMe->recipient()->get(MARIA_ID),
                true,
                true
            );

            $this->splitRuleCesar = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->cesarProfit,
                $this->objectPagarMe->recipient()->get(CESAR_ID),
                true,
                true
            );

            $this->objectSplitRules[0] = $this->splitRuleMaria;
            $this->objectSplitRules[1] = $this->splitRuleCesar;

            return $this->objectSplitRules;
        }

        if (!array_search('cesar', $this->objectRequest->getIndividualData())) {
            $this->mariaProfit = PRICE_OF_JOAO_PRODUCT * 0.15;
            $this->joaoProfit = PRICE_OF_JOAO_PRODUCT * 0.85;

            $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->mariaProfit + $this->fee + PRICE_OF_MARIA_PRODUCT,
                $this->objectPagarMe->recipient()->get(MARIA_ID),
                true,
                true
            );

            $this->splitRuleJoao = $this->objectPagarMe->splitRule()->monetaryRule(
                $this->joaoProfit,
                $this->objectPagarMe->recipient()->get(JOAO_ID),
                true,
                true
            );

            $this->objectSplitRules[0] = $this->splitRuleMaria;
            $this->objectSplitRules[1] = $this->splitRuleJoao;

            return $this->objectSplitRules;
        }

        $this->mariaProfit = PRICE_OF_CESAR_PRODUCT * 0.15;
        $this->mariaProfit = PRICE_OF_JOAO_PRODUCT * 0.15 + $this->mariaProfit;
        $this->cesarProfit = PRICE_OF_CESAR_PRODUCT * 0.85;
        $this->joaoProfit = PRICE_OF_JOAO_PRODUCT * 0.85;

        $this->splitRuleMaria = $this->objectPagarMe->splitRule()->monetaryRule(
            $this->mariaProfit + $this->fee + PRICE_OF_MARIA_PRODUCT,
            $this->objectPagarMe->recipient()->get(MARIA_ID),
            true,
            true
        );

        $this->splitRuleCesar = $this->objectPagarMe->splitRule()->monetaryRule(
            $this->cesarProfit,
            $this->objectPagarMe->recipient()->get(CESAR_ID),
            true,
            true
        );

        $this->splitRuleJoao = $this->objectPagarMe->splitRule()->monetaryRule(
            $this->joaoProfit,
            $this->objectPagarMe->recipient()->get(JOAO_ID),
            true,
            true
        );

        $this->objectSplitRules[0] = $this->splitRuleMaria;
        $this->objectSplitRules[1] = $this->splitRuleCesar;
        $this->objectSplitRules[2] = $this->splitRuleJoao;

        return $this->objectSplitRules;
    }
}
