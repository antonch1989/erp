<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product")
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="cost", type="integer", nullable=false)
     */
    private $cost;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_number", type="integer", nullable=false)
     */
    private $stockNumber;

    /**
     * @var ProductCategory
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductCategory")
     */
    private $category;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\RoomProduct", mappedBy="product")
     */
    private $roomProducts;

    public function __construct()
    {
        $this->roomProducts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCost(): Money
    {
        return new Money($this->cost, new Currency('USD'));
    }

    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    public function getStockNumber(): int
    {
        return $this->stockNumber;
    }

    public function setStockNumber(int $stockNumber): void
    {
        $this->stockNumber = $stockNumber;
    }

    public function getCategory(): ProductCategory
    {
        return $this->category;
    }

    public function setCategory(ProductCategory $category): void
    {
        $this->category = $category;
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
