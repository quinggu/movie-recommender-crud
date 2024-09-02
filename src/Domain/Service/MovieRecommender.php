<?php

namespace App\Domain\Service;

use App\Domain\Model\Entity\Movie;
use App\Domain\Specification\HasEvenLength;
use App\Domain\Specification\HasMultipleWords;
use App\Domain\Specification\StartsWithW;
use App\Infrastructure\Repository\MovieRepository;

class MovieRecommender
{
    private HasEvenLength $hasEvenLength;
    private StartsWithW $startsWithW;
    private HasMultipleWords $hasMultipleWords;

    public function __construct(private readonly MovieRepository $movieRepository)
    {
        $this->hasEvenLength = new HasEvenLength();
        $this->startsWithW = new StartsWithW();
        $this->hasMultipleWords = new HasMultipleWords();
    }

    public function getRandomMovies(int $limit = 3): array
    {
        $movies = $this->movieRepository->findAllMovies();
        shuffle($movies);

        return array_slice($movies, 0, $limit);
    }

    public function getMoviesStartingWithWAndWithEvenLength(): array
    {
        return array_filter($this->movieRepository->findAllMovies(), function (Movie $movie) {
            return $this->startsWithW->isSatisfiedBy($movie) && $this->hasEvenLength->isSatisfiedBy($movie);
        });
    }

    public function getMoviesWithMultipleWords(): array
    {
        return array_filter($this->movieRepository->findAllMovies(), function (Movie $movie) {
            return $this->hasMultipleWords->isSatisfiedBy($movie);
        });
    }
}
