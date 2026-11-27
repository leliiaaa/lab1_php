<?php

declare(strict_types=1);

namespace App\Tasks;

use InvalidArgumentException;

class Triangle
{
    public function __construct(
        public readonly float $a,
        public readonly float $b,
        public readonly float $c
    ) {
        if ($a <= 0 || $b <= 0 || $c <= 0 || ($a + $b <= $c) || ($a + $c <= $b) || ($b + $c <= $a)) {
            throw new InvalidArgumentException('Сторони не утворюють коректний трикутник.');
        }
    }

    public function getPerimeter(): float
    {
        return round($this->a + $this->b + $this->c, 2);
    }

    public function getArea(): float
    {
        $halfPerimeter = $this->getPerimeter() / 2;

        return round(
            sqrt($halfPerimeter * ($halfPerimeter - $this->a) * ($halfPerimeter - $this->b) * ($halfPerimeter - $this->c)),
            2
        );
    }
}
