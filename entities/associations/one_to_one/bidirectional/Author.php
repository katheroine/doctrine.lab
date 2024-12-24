<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

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
     * @var Autopromotion
     */
    #[ORM\OneToOne(targetEntity: Autopromotion::class, mappedBy: 'author')]
    private ?Autopromotion $autopromotion = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $penname
     *
     * @return void
     */
    public function setPenname(string $penname)
    {
        $this->penname = $penname;
    }

    /**
     * @return string
     */
    public function getPenname(): string
    {
        return $this->penname;
    }

    /**
     * @return Autopromotion
     */
    public function getAutopromotion(): Autopromotion
    {
        return $this->autopromotion;
    }
}
