<?php

namespace AppBundle\Library\CryptoCompare;


use AppBundle\Entity\Coin;

class CoinListApi
{
    const API_ENDPOINT = 'https://www.cryptocompare.com/api/data/coinlist/';

    public function getUrl()
    {
        return self::API_ENDPOINT;
    }


    public function getCoinRecords(string $apiResult)
    {
        $results = json_decode($apiResult, true);
        $default = [
            'ImageUrl' => ''
        ];
        $coinList = [];
        foreach ($results['Data'] as $record) {

            $record = array_merge($default, $record);
            if ($record['TotalCoinSupply'] == 'N/A') {
                $record['TotalCoinSupply'] = 0;
            }


            $c = new Coin();
            $c->setCoinSymbol($record['Name'])
                ->setName($record['CoinName'])
                ->setFullName($record['FullName'])
                ->setImageUrl($record['ImageUrl'])
                ->setUrl($record['Url'])
                ->setAlgorithm($record['Algorithm'])
                ->setProofType($record['ProofType']);
            //->setTotalCoinSupply($record['TotalCoinSupply']);

            $coinList[] = $c;
        }

        return $coinList;
    }
}