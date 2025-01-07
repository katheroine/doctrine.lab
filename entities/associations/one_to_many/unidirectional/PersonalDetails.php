<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', name: 'first_name')]
    private string $firstName;
    #[ORM\Column(type: 'string', name: 'last_name')]
    private string $lastName;
    /**
     * @var Collection<int, Email>
     */
    #[ORM\ManyToMany(targetEntity: Email::class)]
    #[ORM\JoinTable(name: 'personal_details_emails')]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'email_id', referencedColumnName: 'id', unique: true)]
    private Collection $emails;

    public function __construct()
    {
        $this->emails = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $firstName
     *
     * @return void
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     *
     * @return void
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param Email $email
     *
     * @return void
     */
    public function addEmail(Email $email)
    {
        $this->emails->add($email);
    }

    /**
     * @return ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }
}
