<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
//use Doctrine\ORM\EntityRepository;
use App\Entity\Reservation;

/**
 * Product
 *
 * @ORM\Table(name="Product")
 * @ORM\Entity
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="base_price", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $basePrice = 0;

    /**
     * @var int|null
     *
     * @ORM\Column(name="final_prices_sum", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $finalPricesSum = 0;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBasePrice(): ?int
    {
        return $this->basePrice;
    }

    public function setBasePrice(?int $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getFinalPricesSum(): ?int
    {
        return $this->finalPricesSum;
    }

    private function setFinalPricesSum(?int $finalPricesSum): self
    {
        $this->finalPricesSum = $finalPricesSum;

        return $this;
    }
    public function saveAs(EntityManager $entityManager): self
    {
        $entityManager->persist($this);
        $entityManager->flush();
        return $this;
    }

    public function updateFinalPricesSum(EntityManager $entityManager): self
    {
        $entityManager->persist($this);
        $integer = 0;
        $repository = $entityManager->getRepository(Reservation::class);
        $reservations = $repository->findAll();
        foreach ($reservations as $reservation)
        {
            $integer += $reservation->getFinalPrice();

        }
        $this->setFinalPricesSum($integer);
        
        $entityManager->flush();
        return $this;
    }


}
