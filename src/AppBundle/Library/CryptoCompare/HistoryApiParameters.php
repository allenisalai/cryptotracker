<?php

namespace AppBundle\Library\CryptoCompare;


use DateTimeImmutable;

class HistoryApiParameters
{
    /** @var  string */
    private $fromSymbol;

    /** @var  string */
    private $toSymbol = 'USD';

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
     * @return HistoryApiParameters
     */
    public function setFromSymbol(string $fromSymbol): HistoryApiParameters
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
     * @return HistoryApiParameters
     */
    public function setToSymbol(string $toSymbol): HistoryApiParameters
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
     * @return HistoryApiParameters
     */
    public function setRecordLimit(int $recordLimit): HistoryApiParameters
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
     * @return HistoryApiParameters
     */
    public function setToTimestamp(DateTimeImmutable $toTimestamp): HistoryApiParameters
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
     * @return HistoryApiParameters
     */
    public function setCoinSymbol(string $coinSymbol): HistoryApiParameters
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
