<?php

namespace AppBundle\Library\CryptoCompare;


use DateTimeImmutable;

class HistoryMinuteApiParameters
{
    /** @var  string */
    private $fromSymbol;

    /** @var  string */
    private $toSymbol = 'BTC';

    /** @var int */
    private $recordLimit = 2000;

    /** @var  DateTimeImmutable */
    private $toTimestamp;

    /** @var  string */
    private $coinSymbol;

    /**
     * @return string
     */
    public function getFromSymbol(): string
    {
        return $this->fromSymbol;
    }

    /**
     * @param string $fromSymbol
     * @return HistoryMinuteApiParameters
     */
    public function setFromSymbol(string $fromSymbol): HistoryMinuteApiParameters
    {
        $this->fromSymbol = $fromSymbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getToSymbol(): string
    {
        return $this->toSymbol;
    }

    /**
     * @param string $toSymbol
     * @return HistoryMinuteApiParameters
     */
    public function setToSymbol(string $toSymbol): HistoryMinuteApiParameters
    {
        $this->toSymbol = $toSymbol;
        return $this;
    }

    /**
     * @return int
     */
    public function getRecordLimit(): int
    {
        return $this->recordLimit;
    }

    /**
     * @param int $recordLimit
     * @return HistoryMinuteApiParameters
     */
    public function setRecordLimit(int $recordLimit): HistoryMinuteApiParameters
    {
        $this->recordLimit = $recordLimit;
        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getToTimestamp(): DateTimeImmutable
    {
        return $this->toTimestamp;
    }

    /**
     * @param DateTimeImmutable $toTimestamp
     * @return HistoryMinuteApiParameters
     */
    public function setToTimestamp(DateTimeImmutable $toTimestamp): HistoryMinuteApiParameters
    {
        $this->toTimestamp = $toTimestamp;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoinSymbol(): string
    {
        return $this->coinSymbol;
    }

    /**
     * @param string $coinSymbol
     * @return HistoryMinuteApiParameters
     */
    public function setCoinSymbol(string $coinSymbol): HistoryMinuteApiParameters
    {
        $this->coinSymbol = $coinSymbol;
        return $this;
    }


    public function toArray()
    {
        return [
            'fsym' => $this->getFromSymbol(),
            'tsym' => $this->getToSymbol(),
            'limit' => $this->getRecordLimit(),
            'toTs' => $this->getToTimestamp()->getTimestamp(),
        ];
    }
}