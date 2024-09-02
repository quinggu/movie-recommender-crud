<?php

namespace App\Domain\Specification;

use App\Domain\Model\Entity\Movie;

class StartsWithW
{
    public function isSatisfiedBy(Movie $movie): bool
    {
        return str_starts_with($movie->getTitle(), 'W');
    }
}
