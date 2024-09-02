<?php

namespace App\Domain\Specification;

use App\Domain\Model\Entity\Movie;

class HasMultipleWords
{
    public function isSatisfiedBy(Movie $movie): bool
    {
        return str_word_count($movie->getTitle()) > 1;
    }
}
