<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SongRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\Regex;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Filter\CustomSearchFilter;
use Symfony\Component\Validator\Constraints\Choice;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 */
#[ApiResource()]
#[ApiFilter(OrderFilter::class, properties: ['title', 'artist', 'year', 'genre', 'duration'], arguments: ['orderParameterName' => 'orderBy'])]
#[ApiFilter(CustomSearchFilter::class)]
class Song
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=4)
     */
    #[Regex(pattern: "/^\d{4}$/", message: "Veuillez entrer une année valide")]
    private $year;


    const GENRES = [
      'Classical',
      'Dance',
      'Disco',
      'Folk',
      'Hip-Hop',
      'Jazz',
      'Latino',
      'Metal',
      'Pop',
      'Rock',
      'Synthpop'
    ];

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Choice(choices: Song::GENRES, message: "Veuillez choisir un genre valide")]
    private $genre;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

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

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
