<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class UniqueIdGenerator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateUniqueProjectId(): int
    {
        do {
            $id = random_int(100000, 999999); // Generate a 6-digit number
        } while ($this->isIdExists($id));

        return $id;
    }

    private function isIdExists(int $id): bool
    {
        return $this->entityManager->getRepository('App:Project')
                ->findOneBy(['id' => $id]) !== null;
    }
}