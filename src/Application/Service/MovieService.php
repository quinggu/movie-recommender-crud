<?php

namespace App\Application\Service;

use App\Domain\Model\Entity\Movie;
use App\Infrastructure\Repository\MovieRepository;

class MovieService
{
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function createMovie(string $title): void
    {
        $movie = new Movie($title);
        $em = $this->movieRepository->getEntityManager();
        $em->persist($movie);
        $em->flush();
    }

    public function deleteMovie(int $id): void
    {
        $movie = $this->movieRepository->find($id);
        if ($movie) {
            $em = $this->movieRepository->getEntityManager();
            $em->remove($movie);
            $em->flush();
        }
    }
}
