<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="floor")
 */
class Floor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="floors")
     */
    private $building;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="floor")
     */
    private $rooms;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getBuilding(): Building
    {
        return $this->building;
    }

    public function setBuilding(Building $building): void
    {
        $this->building = $building;
    }

    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function setRooms(ArrayCollection $rooms): void
    {
        $this->rooms = $rooms;
    }
}
