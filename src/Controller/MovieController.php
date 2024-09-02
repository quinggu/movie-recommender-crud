<?php

namespace App\Controller;

use App\Domain\Service\MovieRecommender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    public function __construct(private readonly MovieRecommender $movieRecommender)
    {
    }

    #[Route('/movies/random', name: 'random_movies', methods: ['GET'])]
    public function randomMovies(): JsonResponse
    {
        $recommendedMovies = $this->movieRecommender->getRandomMovies();

        return $this->json($recommendedMovies);
    }

    #[Route('/movies/w-even-length', name: 'movies_with_w_even_length', methods: ['GET'])]
    public function moviesWithWAndEvenLength(): JsonResponse
    {
        $recommendedMovies = $this->movieRecommender->getMoviesStartingWithWAndWithEvenLength();

        return $this->json($recommendedMovies);
    }

    #[Route('/movies/multiple-words', name: 'movies_multiple_words', methods: ['GET'])]
    public function moviesWithMultipleWords(): JsonResponse
    {
        $recommendedMovies = $this->movieRecommender->getMoviesWithMultipleWords();

        return $this->json($recommendedMovies);
    }
}
