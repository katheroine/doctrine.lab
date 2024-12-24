<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'autopromotions')]
class Autopromotion
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $bio = null;
    /**
     * @var Author
     */
    #[ORM\OneToOne(targetEntity: Author::class, inversedBy: 'autopromotion')]
    #[ORM\JoinColumn(name: "author_id", referencedColumnName: "id", nullable: false)]
    private Author $author;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $bio
     *
     * @return void
     */
    public function setBio(string $bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param Author $author
     *
     * @return void
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }
}
