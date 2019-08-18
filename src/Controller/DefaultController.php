<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\Floor;
use App\Entity\Product;
use App\Entity\Room;
use App\Entity\RoomProduct;
use App\Form\Type\RoomOutOfOrderType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(Request $request): Response
    {
        $activeFloorId = $request->query->get('activeFloor');
        $activeRoomId  = $request->query->get('activeRoom');

        /** @var EntityManagerInterface $em */
        $em = $this->get('doctrine')->getManager();

        if ($activeFloorId === null) {
            $activeFloorId = $em->getRepository(Floor::class)
                ->createQueryBuilder('f')
                ->orderBy('f.id')
                ->setMaxResults(1)
                ->getQuery()
                ->getResult()[0]->getId()
            ;
        }

        if ($activeRoomId === null) {
            $activeRoomId = $em->getRepository(Room::class)
                ->createQueryBuilder('r')
                ->select('r')
                ->andWhere('r.floor = :activeFloorId')
                ->setParameter('activeFloorId', $activeFloorId)
                ->orderBy('r.id')
                ->setMaxResults(1)
                ->getQuery()
                ->getResult()[0]->getId()
            ;

        }

        $building    = $em->getRepository(Building::class)->findOneBy([]);
        $activeFloor = $em->getRepository(Floor::class)->find($activeFloorId);
        $activeRoom  = $em->getRepository(Room::class)->find($activeRoomId);

        $form = $this->createForm(RoomOutOfOrderType::class, $activeRoom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $activeRoom = $form->getData();
            $em->persist($activeRoom);
            $em->flush();

            $message = $activeRoom->isOutOfOrder() ? 'The room is out of order now' : 'The room is in order now';
            $this->addFlash('success', $message);


            return $this->redirectToRoute('main_page', $request->query->all());
        }

        $products = $this->createProductsArray($em, $activeRoom);

        return $this->render('index.html.twig', [
            'building' => $building,
            'activeFloor' => $activeFloor,
            'activeRoom' => $activeRoom,
            'outOfOrderForm' => $form->createView(),
            'products' => $products,
            'replenishments' => $this->getReplenishments($products),
        ]);
    }

    /**
     * @Route("/update-room-status/room/{room}/status/{status}", name="update_room_status")
     */
    public function updateStatus(Request $request, Room $room, string $status): RedirectResponse
    {
        $previousUrl = $request->headers->get('referer');

        $room->setStatus($status);
        /** @var EntityManagerInterface $em */
        $em = $this->get('doctrine')->getManager();
        $em->flush();

        $this->addFlash('success', sprintf('The room status changed to "%s"', $status));

        return $this->redirect($previousUrl);
    }

    /**
     * @Route("/add-replenishments", name="add_replenishments")
     */
    public function addReplenishments(Request $request): RedirectResponse
    {
        $previousUrl = $request->headers->get('referer');
        /** @var EntityManagerInterface $em */
        $em = $this->get('doctrine')->getManager();
        $data = $request->request->all();

        foreach ($data as $key => $replenishmentNumber) {
            if (!$replenishmentNumber) {
                continue;
            }

            $roomProductId = str_replace('room_product_', '', $key);

            /** @var RoomProduct $roomProduct */
            $roomProduct = $em->getRepository(RoomProduct::class)->find($roomProductId);
            $roomProduct->setReplenishmentNumber($roomProduct->getReplenishmentNumber() + $replenishmentNumber);
        }

        $em->flush();

        $this->addFlash('success', 'The replenishments were added');

        return new RedirectResponse($previousUrl);
    }

    private function createProductsArray(EntityManager $em, Room $room): array
    {
        /** @var RoomProduct[] $roomProducts */
        $roomProducts = $em->getRepository(RoomProduct::class)
            ->createQueryBuilder('rp')
            ->select('rp')
            ->innerJoin(Product::class, 'p')
            ->where('rp.room = :roomId')
            ->setParameter('roomId', $room->getId())
            ->getQuery()
            ->getResult()
        ;

        $sortedByProductCategory = [];

        foreach ($roomProducts as $roomProduct) {

            $product = $roomProduct->getProduct();

            if (!array_key_exists($product->getCategory()->getName(), $sortedByProductCategory)) {
                $sortedByProductCategory[$product->getCategory()->getName()] = [];
            }

            $sortedByProductCategory[$product->getCategory()->getName()][] = [$product, $roomProduct];
        }

        return $sortedByProductCategory;
    }

    private function getReplenishments(array $products)
    {
        $replenishments = [];

        foreach ($products as $productData) {
            foreach ($productData as $data) {
                /** @var Product $roomProduct */
                $product     = $data[0];
                /** @var RoomProduct $roomProduct */
                $roomProduct = $data[1];

                for ($i = 0; $i < $roomProduct->getReplenishmentNumber(); $i++) {
                    $replenishments[] = $product->getName();
                }
            }
        }

        return $replenishments;
    }
}
