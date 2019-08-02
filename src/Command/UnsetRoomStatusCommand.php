<?php

namespace App\Command;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnsetRoomStatusCommand extends Command
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('app:room:unset-status');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Room[] $rooms */
        $rooms = $this->em->getRepository(Room::class)->findAll();
        foreach ($rooms as $room) {
            $room->setStatus(null);
        }

        $this->em->flush();
    }
}
