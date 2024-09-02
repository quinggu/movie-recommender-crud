<?php

namespace App\Domain\Specification;

use App\Domain\Model\Entity\Movie;

class HasEvenLength
{
    public function isSatisfiedBy(Movie $movie): bool
    {
        return strlen($movie->getTitle()) % 2 === 0;
    }
}
