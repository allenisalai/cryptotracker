<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coin
 *
 * @ORM\Table(name="coin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoinRepository")
 */
class Coin
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
     * @ORM\Column(name="coin_symbol", type="string", length=15, unique=true)
     */
    private $coinSymbol;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=100, nullable=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="algorithm", type="string", length=25, nullable=true)
     */
    private $algorithm;

    /**
     * @var string
     *
     * @ORM\Column(name="proof_type", type="string", length=25, nullable=true)
     */
    private $proofType;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="total_coin_supply", type="float", nullable=true)
     */
    private $totalCoinSupply;


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
     * @return Coin
     */
    public function setCoinSymbol(string $coinSymbol): Coin
    {
        $this->coinSymbol = $coinSymbol;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Coin
     */
    public function setName(string $name): Coin
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return Coin
     */
    public function setFullName(string $fullName): Coin
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Coin
     */
    public function setUrl(string $url): Coin
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * @param string $algorithm
     * @return Coin
     */
    public function setAlgorithm(string $algorithm): Coin
    {
        $this->algorithm = $algorithm;
        return $this;
    }

    /**
     * @return string
     */
    public function getProofType(): string
    {
        return $this->proofType;
    }

    /**
     * @param string $proofType
     * @return Coin
     */
    public function setProofType(string $proofType): Coin
    {
        $this->proofType = $proofType;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return Coin
     */
    public function setImageUrl(string $imageUrl): Coin
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalCoinSupply(): string
    {
        return $this->totalCoinSupply;
    }

    /**
     * @param string $totalCoinSupply
     * @return Coin
     */
    public function setTotalCoinSupply(string $totalCoinSupply): Coin
    {
        $this->totalCoinSupply = $totalCoinSupply;
        return $this;
    }
}

