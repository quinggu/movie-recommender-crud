<?php

namespace App\Tests\Application\Controller;

use App\Domain\Service\MovieRecommender;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MovieControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MovieRecommender $movieRecommenderMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->movieRecommenderMock = $this->createMock(MovieRecommender::class);
        $this->client->getContainer()->set(MovieRecommender::class, $this->movieRecommenderMock);
    }

    public function testRandomMovies(): void
    {
        $this->movieRecommenderMock
            ->method('getRandomMovies')
            ->willReturn(['Movie 1', 'Movie 2', 'Movie 3']);

        $this->client->request('GET', '/movies/random');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertCount(3, $responseData);
        $this->assertContains('Movie 1', $responseData);
        $this->assertContains('Movie 2', $responseData);
        $this->assertContains('Movie 3', $responseData);
    }

    public function testMoviesWithWAndEvenLength(): void
    {
        $this->movieRecommenderMock
            ->method('getMoviesStartingWithWAndWithEvenLength')
            ->willReturn(['Wonder', 'Wicked']);

        $this->client->request('GET', '/movies/w-even-length');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertContains('Wonder', $responseData);
        $this->assertContains('Wicked', $responseData);
        $this->assertNotContains('Warrior', $responseData);
        $this->assertNotContains('W', $responseData);
    }

    public function testMoviesWithMultipleWords(): void
    {
        $this->movieRecommenderMock
            ->method('getMoviesWithMultipleWords')
            ->willReturn(['The Dark Knight', 'Inception']);

        $this->client->request('GET', '/movies/multiple-words');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertContains('The Dark Knight', $responseData);
        $this->assertContains('Inception', $responseData);
        $this->assertNotContains('Interstellar', $responseData);
    }
}