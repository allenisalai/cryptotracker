<?php

namespace AppBundle\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * CoinHourSnapshot
 *
 * @ORM\Table(name="coin_hour_snapshot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoinHourSnapshotRepository")
 */
class CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setCoinSymbol(string $coinSymbol): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setTime(DateTimeImmutable $time): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setOpen(float $open): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setClose(float $close): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setHigh(float $high): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setLow(float $low): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setVolumeFrom(float $volumeFrom): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setVolumeTo(float $volumeTo): CoinHourSnapshot
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
     * @return CoinHourSnapshot
     */
    public function setExchange(string $exchange): CoinHourSnapshot
    {
        $this->exchange = $exchange;
        return $this;
    }

}

