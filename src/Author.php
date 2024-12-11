<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $penname;
    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, mappedBy: 'authors')]
    private Collection $sources;
}
