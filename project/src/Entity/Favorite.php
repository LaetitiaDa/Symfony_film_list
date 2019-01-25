<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteRepository")
 */
class Favorite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filmID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filmTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilmID(): ?string
    {
        return $this->filmID;
    }

    public function setFilmID(string $filmID): self
    {
        $this->filmID = $filmID;

        return $this;
    }

    public function getFilmTitle(): ?string
    {
        return $this->filmTitle;
    }

    public function setFilmTitle(string $filmTitle): self
    {
        $this->filmTitle = $filmTitle;

        return $this;
    }

    public function getUserID(): ?string
    {
        return $this->userID;
    }

    public function setUserID(string $userID): self
    {
        $this->userID = $userID;

        return $this;
    }
}
