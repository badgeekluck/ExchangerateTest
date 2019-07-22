<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 */
class ExchangeRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $currencyUnit;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyUnit(): ?string
    {
        return $this->currencyUnit;
    }

    public function setCurrencyUnit(string $currencyUnit): self
    {
        $this->currencyUnit = $currencyUnit;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
