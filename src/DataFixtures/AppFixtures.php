<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\Floor;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Room;
use App\Entity\RoomProduct;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $bulding = new Building();
        $bulding->setName('Test building 1');

        $floor1 = new Floor();
        $floor1->setNumber(1);
        $floor1->setBuilding($bulding);

        $floor2 = new Floor();
        $floor2->setNumber(2);
        $floor2->setBuilding($bulding);

        $floor3 = new Floor();
        $floor3->setNumber(3);
        $floor3->setBuilding($bulding);

        // rooms first floor

        $room11 = new Room();
        $room11->setNumber(101);
        $room11->setFloor($floor1);

        $room12 = new Room();
        $room12->setNumber(102);
        $room12->setFloor($floor1);

        $room13 = new Room();
        $room13->setNumber(103);
        $room13->setFloor($floor1);

        // rooms second floor

        $room21 = new Room();
        $room21->setNumber(201);
        $room21->setFloor($floor2);

        $room22 = new Room();
        $room22->setNumber(202);
        $room22->setFloor($floor2);

        // rooms third floor

        $room31 = new Room();
        $room31->setNumber(301);
        $room31->setFloor($floor3);

        $category1 = new ProductCategory();
        $category1->setName('Living room');

        $category2 = new ProductCategory();
        $category2->setName('Kitchen');

        $category3 = new ProductCategory();
        $category3->setName('Bathroom');

        $product1 = new Product();
        $product1->setName('Towel');
        $product1->setCategory($category3);
        $product1->setCost(10000);
        $product1->setStockNumber(100);

        $product2 = new Product();
        $product2->setName('Tissue paper');
        $product2->setCategory($category2);
        $product2->setCost(20000);
        $product2->setStockNumber(250);

        $product3 = new Product();
        $product3->setName('Dummy1');
        $product3->setCategory($category1);
        $product3->setCost(40000);
        $product3->setStockNumber(280);

        $product4 = new Product();
        $product4->setName('Another dummy');
        $product4->setCategory($category1);
        $product4->setCost(30000);
        $product4->setStockNumber(150);

        $roomProduct1 = new RoomProduct();
        $roomProduct1->setProduct($product1);
        $roomProduct1->setRoom($room12);
        $roomProduct1->setItemsNumber(5);

        $roomProduct2 = new RoomProduct();
        $roomProduct2->setProduct($product2);
        $roomProduct2->setRoom($room12);
        $roomProduct2->setItemsNumber(3);

        $roomProduct3 = new RoomProduct();
        $roomProduct3->setProduct($product3);
        $roomProduct3->setRoom($room12);
        $roomProduct3->setItemsNumber(2);

        $roomProduct4 = new RoomProduct();
        $roomProduct4->setProduct($product4);
        $roomProduct4->setRoom($room12);
        $roomProduct4->setItemsNumber(7);

        $user = new User();
        $user->setUsername('sori');
        $user->setEmail('sorit@eoneinc.net');
        $user->setPassword('$2y$12$pIUNGP4DDMTVVYij6wCQruVZ69LlHgnBgwGffXwYOnFvNJ74jvmWm');
        $user->setEnabled(true);

        $manager->persist($bulding);

        $manager->persist($floor1);
        $manager->persist($floor2);
        $manager->persist($floor3);

        $manager->persist($room11);
        $manager->persist($room12);
        $manager->persist($room13);
        $manager->persist($room21);
        $manager->persist($room22);
        $manager->persist($room31);

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);

        $manager->persist($product1);
        $manager->persist($product2);
        $manager->persist($product3);
        $manager->persist($product4);

        $manager->persist($roomProduct1);
        $manager->persist($roomProduct2);
        $manager->persist($roomProduct3);
        $manager->persist($roomProduct4);

        $manager->persist($user);

        $manager->flush();
    }
}
