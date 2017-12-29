<?php

namespace AppBundle\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * CoinMinuteSnapshot
 *
 * @ORM\Table(name="coin_minute_snapshot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoinMinuteSnapshotRepository")
 */
class CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setCoinSymbol(string $coinSymbol): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setTime(DateTimeImmutable $time): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setOpen(float $open): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setClose(float $close): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setHigh(float $high): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setLow(float $low): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setVolumeFrom(float $volumeFrom): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setVolumeTo(float $volumeTo): CoinMinuteSnapshot
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
     * @return CoinMinuteSnapshot
     */
    public function setExchange(string $exchange): CoinMinuteSnapshot
    {
        $this->exchange = $exchange;
        return $this;
    }

}

