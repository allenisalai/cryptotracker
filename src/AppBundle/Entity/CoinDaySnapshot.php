<?php

namespace AppBundle\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * CoinDaySnapshot
 *
 * @ORM\Table(name="coin_day_snapshot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoinDaySnapshotRepository")
 */
class CoinDaySnapshot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="coin_symbol", type="string", length=20)
     */
    private $coinSymbol;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="time", type="datetime_immutable")
     */
    private $time;

    /**
     * @var float
     *
     * @ORM\Column(name="open", type="float")
     */
    private $open;

    /**
     * @var float
     *
     * @ORM\Column(name="close", type="float")
     */
    private $close;

    /**
     * @var float
     *
     * @ORM\Column(name="high", type="float")
     */
    private $high;

    /**
     * @var float
     *
     * @ORM\Column(name="low", type="float")
     */
    private $low;

    /**
     * @var float
     *
     * @ORM\Column(name="volume_from", type="float")
     */
    private $volumeFrom;

    /**
     * @var float
     *
     * @ORM\Column(name="volume_to", type="float")
     */
    private $volumeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="exchange", type="string", length=20)
     */
    private $exchange;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     *
     * @return CoinDaySnapshot
     */
    public function setCoinSymbol(string $coinSymbol): CoinDaySnapshot
    {
        $this->coinSymbol = $coinSymbol;
        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTime(): DateTimeImmutable
    {
        return $this->time;
    }

    /**
     * @param DateTimeImmutable $time
     *
     * @return CoinDaySnapshot
     */
    public function setTime(DateTimeImmutable $time): CoinDaySnapshot
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return float
     */
    public function getOpen(): float
    {
        return $this->open;
    }

    /**
     * @param float $open
     *
     * @return CoinDaySnapshot
     */
    public function setOpen(float $open): CoinDaySnapshot
    {
        $this->open = $open;
        return $this;
    }

    /**
     * @return float
     */
    public function getClose(): float
    {
        return $this->close;
    }

    /**
     * @param float $close
     *
     * @return CoinDaySnapshot
     */
    public function setClose(float $close): CoinDaySnapshot
    {
        $this->close = $close;
        return $this;
    }

    /**
     * @return float
     */
    public function getHigh(): float
    {
        return $this->high;
    }

    /**
     * @param float $high
     *
     * @return CoinDaySnapshot
     */
    public function setHigh(float $high): CoinDaySnapshot
    {
        $this->high = $high;
        return $this;
    }

    /**
     * @return float
     */
    public function getLow(): float
    {
        return $this->low;
    }

    /**
     * @param float $low
     *
     * @return CoinDaySnapshot
     */
    public function setLow(float $low): CoinDaySnapshot
    {
        $this->low = $low;
        return $this;
    }

    /**
     * @return float
     */
    public function getVolumeFrom(): float
    {
        return $this->volumeFrom;
    }

    /**
     * @param float $volumeFrom
     *
     * @return CoinDaySnapshot
     */
    public function setVolumeFrom(float $volumeFrom): CoinDaySnapshot
    {
        $this->volumeFrom = $volumeFrom;
        return $this;
    }

    /**
     * @return float
     */
    public function getVolumeTo(): float
    {
        return $this->volumeTo;
    }

    /**
     * @param float $volumeTo
     *
     * @return CoinDaySnapshot
     */
    public function setVolumeTo(float $volumeTo): CoinDaySnapshot
    {
        $this->volumeTo = $volumeTo;
        return $this;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @param string $exchange
     * @return CoinDaySnapshot
     */
    public function setExchange(string $exchange): CoinDaySnapshot
    {
        $this->exchange = $exchange;
        return $this;
    }

}

