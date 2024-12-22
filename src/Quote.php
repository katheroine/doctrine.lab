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
    /**
     * @var Source|null
     */
    #[ORM\ManyToOne(targetEntity: Source::class, inversedBy: 'quotes')]
    private ?Source $source = null;
    #[ORM\Column(type: 'string')]
    private string $content;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $author
     *
     * @return void
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
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
    public function getSource()
    {
        return $this->source;
    }
}
