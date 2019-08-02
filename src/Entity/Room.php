<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="room")
 */
class Room
{
    public const STATUS_CHARGED    = 'charged';
    public const STATUS_NO_CHARGES = 'no_charges';
    public const STATUS_OCCUPIED   = 'occupied';
    public const STATUS_DENIED     = 'denied';
    public const STATUS_EXPIRED    = 'expired';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var Floor
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Floor", inversedBy="rooms")
     */
    private $floor;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_out_of_order", type="boolean", nullable=false)
     */
    private $isOutOfOrder = false;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="return_date", type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="out_of_order_description", type="text", nullable=true)
     */
    private $outOfOrderDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\RoomProduct", mappedBy="room")
     */
    private $roomProducts;

    public function __construct()
    {
        $this->roomProducts = new ArrayCollection();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber($number): void
    {
        $this->number = $number;
    }

    public function getFloor(): Floor
    {
        return $this->floor;
    }

    public function setFloor(Floor $floor): void
    {
        $this->floor = $floor;
    }

    public function getIsOutOfOrder(): bool
    {
        return $this->isOutOfOrder;
    }

    public function setIsOutOfOrder(bool $isOutOfOrder): void
    {
        $this->isOutOfOrder = $isOutOfOrder;
    }

    public function getReturnDate(): ?\DateTime
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTime $returnDate): void
    {
        $this->returnDate = $returnDate;
    }

    public function getOutOfOrderDescription(): ?string
    {
        return $this->outOfOrderDescription;
    }

    public function setOutOfOrderDescription(?string $outOfOrderDescription): void
    {
        $this->outOfOrderDescription = $outOfOrderDescription;
    }

    public function getRoomProducts(): Collection
    {
        return $this->roomProducts;
    }

    public function setRoomProducts(ArrayCollection $roomProducts): void
    {
        $this->roomProducts = $roomProducts;
    }
}
