<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTimeImmutable;

/**
 * HypeSource
 *
 * @ORM\Table(name="hype_source")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HypeSourceRepository")
 */
class HypeSource
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="posting_date", type="datetime_immutable")
     */
    private $postingDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return HypeSource
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return HypeSource
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return HypeSource
     */
    public function setSource(string $source): HypeSource
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Set postingDate
     *
     * @param DateTimeImmutable $postingDate
     *
     * @return HypeSource
     */
    public function setPostingDate(DateTimeImmutable $postingDate)
    {
        $this->postingDate = $postingDate;

        return $this;
    }

    /**
     * Get postingDate
     *
     * @return DateTimeImmutable
     */
    public function getPostingDate() : DateTimeImmutable
    {
        return $this->postingDate;
    }
}

