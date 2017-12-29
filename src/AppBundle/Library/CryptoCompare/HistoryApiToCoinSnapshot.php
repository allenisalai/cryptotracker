<?php

namespace AppBundle\Library\CryptoCompare;


use AppBundle\Entity\CoinDaySnapshot;
use AppBundle\Entity\CoinHourSnapshot;
use AppBundle\Entity\CoinMinuteSnapshot;

class HistoryApiToCoinSnapshot
{
    const TIME_UNIT_MINUTE = 'minute';
    const TIME_UNIT_HOUR   = 'hour';
    const TIME_UNIT_DAY    = 'day';

    const API_ENDPOINT_MINUTE = 'https://min-api.cryptocompare.com/data/histominute';
    const API_ENDPOINT_HOUR   = 'https://min-api.cryptocompare.com/data/histohour';
    const API_ENDPOINT_DAY    = 'https://min-api.cryptocompare.com/data/histoday';

    /**
     * @param HistoryApiParameters $parameters
     *
     * @return string
     */
    public function getMinuteSnapshots(HistoryApiParameters $parameters)
    {
        return $this->getUrl(self::API_ENDPOINT_MINUTE, $parameters);
    }


    /**
     * @param HistoryApiParameters $parameters
     *
     * @return string
     */
    public function getHourSnapshots(HistoryApiParameters $parameters)
    {
        return $this->getUrl(self::API_ENDPOINT_HOUR, $parameters);
    }

    /**
     * @param HistoryApiParameters $parameters
     *
     * @return string
     */
    public function getDaySnapshots(HistoryApiParameters $parameters)
    {
        return $this->getUrl(self::API_ENDPOINT_DAY, $parameters);
    }

    /**
     * @param string $apiResult
     * @param string $timeUnit
     *
     * @return array
     */
    public function getCoinSnapshotRecords(string $apiResult, string $timeUnit = self::TIME_UNIT_HOUR)
    {
        $results = json_decode($apiResult, true);

        $ret = [];
        foreach ($results['Data'] as $record) {
            $newCoinSnapshot = $this->getCoinSnapshotClassInstance($timeUnit);
            $time            = new \DateTimeImmutable(date('Y-m-d H:i:s', $record['time']), new \DateTimeZone('UTC'));
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

    /**
     * @param string               $apiEndpoint
     * @param HistoryApiParameters $parameters
     *
     * @return string
     */
    private function getUrl(string $apiEndpoint, HistoryApiParameters $parameters)
    {
        return $apiEndpoint . "?" . http_build_query($parameters->toArray());
    }

    /**
     * @param string $timeUnit
     *
     * @return CoinDaySnapshot|CoinHourSnapshot|CoinMinuteSnapshot
     */
    private function getCoinSnapshotClassInstance(string $timeUnit)
    {
        switch ($timeUnit) {
            case self::TIME_UNIT_MINUTE:
                return new CoinMinuteSnapshot();
            case self::TIME_UNIT_HOUR:
                return new CoinHourSnapshot();
            case self::TIME_UNIT_DAY:
                return new CoinDaySnapshot();
        }
    }
}
