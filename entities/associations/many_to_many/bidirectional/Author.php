<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var PersonalDetails
     */
    #[ORM\OneToOne(targetEntity: PersonalDetails::class)]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    private ?PersonalDetails $personalDetails;
    /**
     * @var Collection<int, Source>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, mappedBy: 'authors')]
    private Collection $sources;

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
    public function getPersonalDetails(): PersonalDetails
    {
        return $this->personalDetails;
    }

    /**
     * @return Collection
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }
}
