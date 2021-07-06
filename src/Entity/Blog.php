<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $body;

    /**
     * @ORM\Column(type="json")
     */
    private $categories = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author_fname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author_lname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author_email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getAuthorFname(): ?string
    {
        return $this->author_fname;
    }

    public function setAuthorFname(string $author_fname): self
    {
        $this->author_fname = $author_fname;

        return $this;
    }

    public function getAuthorLname(): ?string
    {
        return $this->author_lname;
    }

    public function setAuthorLname(string $author_lname): self
    {
        $this->author_lname = $author_lname;

        return $this;
    }

    public function getAuthorEmail(): ?string
    {
        return $this->author_email;
    }

    public function setAuthorEmail(string $author_email): self
    {
        $this->author_email = $author_email;

        return $this;
    }
}
