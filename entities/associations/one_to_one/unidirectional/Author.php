<?php

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
     * @var PersonalDetails
     */
    #[ORM\OneToOne(targetEntity: PersonalDetails::class)]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    private PersonalDetails $personalDetails;
    /**
     * @var AuthorAutopresentation
     */
    #[ORM\OneToOne(targetEntity: AuthorAutopresentation::class, mappedBy: 'author')]
    private ?AuthorAutopresentation $autopresentation = null;

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
    public function getPenname()
    {
        return $this->penname;
    }

    /**
     * @param PersonalDetails $personalDetails
     *
     * @return void
     */
    public function setPersonalDetails(PersonalDetails $personalDetails)
    {
        $this->personalDetails = $personalDetails;
    }

    /**
     * @return PersonalDetails
     */
    public function getPersonalDetails()
    {
        return $this->personalDetails;
    }

    /**
     * @return AuthorAutopresentation
     */
    public function getAutopresentation()
    {
        return $this->autopresentation;
    }
}
