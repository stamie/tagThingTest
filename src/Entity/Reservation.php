<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

/**
 * Reservation
 *
 * @ORM\Table(name="Reservation", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class Reservation
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
     * @var int|null
     *
     * @ORM\Column(name="base_price", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $basePrice = 0;

    /**
     * @var int|null
     *
     * @ORM\Column(name="final_price", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $finalPrice = 0;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasePrice(): ?int
    {
        return $this->basePrice;
    }

    private function setBasePrice(?int $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getFinalPrice(): ?int
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(?int $finalPrice): self
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function saveAs(EntityManager $entityManager): self
    {
        $entityManager->persist($this);
        $this->setBasePrice($this->product->getBasePrice());
        if ($this->getFinalPrice() <=0)
            $this->setFinalPrice($this->product->getBasePrice());
        
        $entityManager->flush();
        $this->product->updateFinalPricesSum($entityManager);
        
        return $this;
    }
    public function delete(EntityManager $entityManager): bool
    {
        $product = $this->product;
        $entityManager->remove($this);
        $entityManager->flush();

        $product->updateFinalPricesSum($entityManager);

        return true;
    }

}
