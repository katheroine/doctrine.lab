<?php

declare(strict_types=1);

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
    private string $content;
    /**
     * @var Source|null
     */
    #[ORM\ManyToOne(targetEntity: Source::class, inversedBy: 'quotes')]
    private ?Source $source = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param Source $source
     *
     * @return void
     */
    public function setSource(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @return Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }
}
