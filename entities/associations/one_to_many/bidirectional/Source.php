<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'sources')]
class Source
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $title;
    /**
     * @var Collection<int, Quote>
     */
    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'source')]
    private Collection $quotes;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Collections
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }
}
