<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private ?string $author = null;
    #[ORM\Column(type: 'string')]
    private ?string $source = null;
    #[ORM\Column(type: 'string')]
    private string $content;
}
