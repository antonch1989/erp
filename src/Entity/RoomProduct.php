<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="room_product", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="room_product_unique", columns={"room_id", "product_id"})
 * })
 */
class RoomProduct
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
     * @var integer
     *
     * @ORM\Column(name="items_number", type="integer")
     */
    private $itemsNumber = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="replenishment_number", type="integer")
     */
    private $replenishmentNumber = 0;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="roomProducts")
     */
    private $product;

    /**
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="roomProducts")
     */
    private $room;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getItemsNumber(): int
    {
        return $this->itemsNumber;
    }

    public function setItemsNumber(int $itemsNumber): void
    {
        $this->itemsNumber = $itemsNumber;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    public function getReplenishmentNumber(): int
    {
        return $this->replenishmentNumber;
    }

    public function setReplenishmentNumber(int $replenishmentNumber): void
    {
        $this->replenishmentNumber = $replenishmentNumber;
    }
}
