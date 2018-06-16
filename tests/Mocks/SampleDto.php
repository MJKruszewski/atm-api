<?php

namespace Mocks;


final class SampleDto
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var bool
     */
    private $bool;

    /**
     * @var integer
     */
    private $number;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return bool
     */
    public function getBool(): bool
    {
        return $this->bool;
    }

    /**
     * @param bool $bool
     */
    public function setBool(bool $bool): void
    {
        $this->bool = $bool;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }


}