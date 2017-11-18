<?php

namespace AppBundle\Library\CryptoCompare;


use AppBundle\Entity\CoinSnapshot;

class HistoryMinuteApiToCoinSnapshot
{
    const API_ENDPOINT = 'https://min-api.cryptocompare.com/data/histominute';

    public function getUrl(HistoryMinuteApiParameters $parameters)
    {
        return self::API_ENDPOINT . "?" . http_build_query($parameters->toArray());
    }


    public function getCoinSnapshotRecords(string $apiResult)
    {
        $results = json_decode($apiResult, true);

        $ret = [];
        foreach ($results['Data'] as $record) {
            $newCoinSnapshot = new CoinSnapshot();
            $time = new \DateTimeImmutable(date('Y-m-d H:i:s', $record['time']), new \DateTimeZone('UTC'));
            $newCoinSnapshot
                ->setTime($time)
                ->setOpen($record['open'])
                ->setClose($record['close'])
                ->setHigh($record['high'])
                ->setLow($record['low'])
                ->setVolumeFrom($record['volumefrom'])
                ->setVolumeTo($record['volumeto']);

            $ret[] = $newCoinSnapshot;
        }

        usort($ret, function ($a, $b) {
            if ($a->getTime()->getTimestamp() < $b->getTime()->getTimestamp()) {
                return 1;
            } else {
                return -1;
            }
        });

        return $ret;
    }
}