<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'emails')]
class Email
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', name: 'local_part')]
    private $localPart;
    #[ORM\Column(type: 'string')]
    private $domain;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $email
     *
     * @return void
     */
    public function set(string $email)
    {
        list($this->localPart, $this->domain) = explode('@', $email);
    }

    /**
     * @return string
     */
    public function get()
    {
        return
            $this->localPart
            . '@'
            . $this->domain;
    }
}
