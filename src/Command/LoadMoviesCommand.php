<?php

namespace App\Command;

use App\Application\Service\MovieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-movies',
    description: 'Load sample movies into the database'
)]
class LoadMoviesCommand extends Command
{
    public function __construct(
        private readonly MovieService           $movieService,
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $movies = $this->getMovies();

        $batchSize = 20;
        $i = 0;

        foreach ($movies as $title) {
            $this->movieService->createMovie($title);

            if (($i % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
            $i++;
        }

        $this->entityManager->flush();

        $io->success('All movies have been loaded successfully.');

        return Command::SUCCESS;
    }

    protected function getMovies(): array
    {
        return [
            "Pulp Fiction",
            "Incepcja",
            "Skazani na Shawshank",
            "Dwunastu gniewnych ludzi",
            "Ojciec chrzestny",
            "Django",
            "Matrix",
            "Leon zawodowiec",
            "Siedem",
            "Nietykalni",
            "Władca Pierścieni: Powrót króla",
            "Fight Club",
            "Forrest Gump",
            "Chłopaki nie płaczą",
            "Gladiator",
            "Człowiek z blizną",
            "Pianista",
            "Doktor Strange",
            "Szeregowiec Ryan",
            "Lot nad kukułczym gniazdem",
            "Wielki Gatsby",
            "Avengers: Wojna bez granic",
            "Życie jest piękne",
            "Pożegnanie z Afryką",
            "Szczęki",
            "Milczenie owiec",
            "Dzień świra",
            "Blade Runner",
            "Labirynt",
            "Król Lew",
            "La La Land",
            "Whiplash",
            "Wyspa tajemnic",
            "Django",
            "American Beauty",
            "Szósty zmysł",
            "Gwiezdne wojny: Nowa nadzieja",
            "Mroczny Rycerz",
            "Władca Pierścieni: Drużyna Pierścienia",
            "Harry Potter i Kamień Filozoficzny",
            "Green Mile",
            "Iniemamocni",
            "Shrek",
            "Mad Max: Na drodze gniewu",
            "Terminator 2: Dzień sądu",
            "Piraci z Karaibów: Klątwa Czarnej Perły",
            "Truman Show",
            "Skazany na bluesa",
            "Infiltracja",
            "Gran Torino",
            "Spotlight",
            "Mroczna wieża",
            "Rocky",
            "Casino Royale",
            "Drive",
            "Piękny umysł",
            "Władca Pierścieni: Dwie wieże",
            "Zielona mila",
            "Requiem dla snu",
            "Forest Gump",
            "Requiem dla snu",
            "Milczenie owiec",
            "Czarnobyl",
            "Breaking Bad",
            "Nędznicy",
            "Seksmisja",
            "Pachnidło",
            "Nagi instynkt",
            "Zjawa",
            "Igrzyska śmierci",
            "Kiler",
            "Siedem dusz",
            "Dzień świra",
            "Upadek",
            "Lśnienie",
            "Pan życia i śmierci",
            "Gladiator",
            "Granica",
            "Hobbit: Niezwykła podróż",
            "Pachnidło: Historia mordercy",
            "Wielki Gatsby",
            "Titanic",
            "Sin City",
            "Przeminęło z wiatrem",
            "Królowa śniegu",
        ];
    }
}
