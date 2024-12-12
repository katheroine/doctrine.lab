<?php

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
    private ?string $author = null;
    #[ORM\Column(type: 'string')]
    private string $title;
    #[ORM\Column(type: 'string')]
    private string $description;
    /**
     * @var Collection<int, Quote>
     */
    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'source')]
    private Collection $quotes;
    #[ORM\Column(type: 'datetime')]
    private ?DateTime $originalPublicationDate;
}
