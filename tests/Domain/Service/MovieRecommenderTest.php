<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\Entity\Movie;
use App\Domain\Service\MovieRecommender;
use App\Infrastructure\Repository\MovieRepository;
use PHPUnit\Framework\TestCase;

class MovieRecommenderTest extends TestCase
{
    private MovieRepository $movieRepositoryMock;
    private MovieRecommender $movieRecommender;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieRepositoryMock = $this->createMock(MovieRepository::class);

        $this->movieRecommender = new MovieRecommender($this->movieRepositoryMock);
    }

    public function testGetRandomMovies(): void
    {
        $this->movieRepositoryMock
            ->method('findAllMovies')
            ->willReturn([
                new Movie('Movie 1'),
                new Movie('Movie 2'),
                new Movie('Movie 3'),
                new Movie('Movie 4'),
                new Movie('Movie 5')
            ]);

        $result = $this->movieRecommender->getRandomMovies();
        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        $this->assertCount(3, $result);

        $this->assertSame($resultTitles, array_unique($resultTitles));

        $expectedTitles = ['Movie 1', 'Movie 2', 'Movie 3', 'Movie 4', 'Movie 5'];
        foreach ($resultTitles as $resultTitle) {
            $this->assertContains($resultTitle, $expectedTitles, "Failed asserting that the result contains '$resultTitle'.");
        }
    }

    public function testGetMoviesStartingWithWAndWithEvenLength(): void
    {
        $this->movieRepositoryMock
            ->method('findAllMovies')
            ->willReturn([
                new Movie('Wonder'),
                new Movie('Warrior'),
                new Movie('Wicked'),
                new Movie('W'),
                new Movie('Wonder Woman')
            ]);

        $result = $this->movieRecommender->getMoviesStartingWithWAndWithEvenLength();

        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        $this->assertContains('Wonder', $resultTitles);
        $this->assertContains('Wicked', $resultTitles);
        $this->assertNotContains('Warrior', $resultTitles);
        $this->assertNotContains('W', $resultTitles);
    }

    public function testGetMoviesWithMultipleWords(): void
    {
        $this->movieRepositoryMock
            ->method('findAllMovies')
            ->willReturn([
                new Movie('The Dark Knight'),
                new Movie('Inception'),
                new Movie('Avatar')
            ]);

        $result = $this->movieRecommender->getMoviesWithMultipleWords();

        $resultTitles = array_map(fn(Movie $movie) => $movie->getTitle(), $result);

        $this->assertContains('The Dark Knight', $resultTitles);
        $this->assertNotContains('Inception', $resultTitles);
        $this->assertNotContains('Avatar', $resultTitles);
    }
}