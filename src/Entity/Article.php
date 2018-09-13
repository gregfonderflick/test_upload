<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min = 3,
     * minMessage = "Votre titre doit contenir au minimum {{ limit }} caractères",
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     * min = 10,
     * minMessage = "Votre contenu doit contenir au minimum {{ limit }} caractères",
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Heading", inversedBy="articles")
     */
    private $heading;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/*" })
     */
    private $image;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;


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

        if ($title) {
            $this->createdAt = new \DateTime();
        }


        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    public function getHeading(): ?Heading
    {
        return $this->heading;
    }

    public function setHeading(?Heading $heading): self
    {
        $this->heading = $heading;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.

        return $this->title;

    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
