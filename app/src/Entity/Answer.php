<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 * @ORM\Table(name="answer")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="2",
     *     max="255",
     * )
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Question")
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=180)
     *
     *
     * @Assert\Email(
     *     strict=false,
     *     message="invalid"
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     *
     * @Assert\Type(type="integer")
     */
    private $favourite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFavourite(): ?int
    {
        return $this->favourite;
    }

    public function setFavourite(int $favourite): self
    {
        $this->favourite = $favourite;

        return $this;
    }
}
