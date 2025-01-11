<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'addresses')]
class Address
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $street;
    #[ORM\Column(type: 'string')]
    private string $city;
    #[ORM\Column(type: 'string')]
    private string $state;
    #[ORM\Column(type: 'string')]
    private string $postalCode;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $street
     *
     * @return void
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $city
     *
     * @return void
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $state
     *
     * @return void
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $postalCode
     *
     * @return void
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }
}
