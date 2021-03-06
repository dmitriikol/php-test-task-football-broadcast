<?php

namespace App\Entity;

class Team
{
    private string $name;
    private string $country;
    private string $logo;
    /**
     * @var Player[]
     */
    private array $players;
    private string $coach;
    private int $goals;
    private array $positions = [
        'Защитник' => 0,
        'Вратарь' => 0,
        'Нападающий' => 0,
        'Полузащитник' => 0
    ];

    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
    }

    public function updatePosition(): void
    {
        foreach ($this->getPlayers() as $player) {
            switch ($player->getPosition()) {
                case 'В':
                    $this->positions['Вратарь'] += $player->getPlayTime(); 
                    break;
                case 'З':
                    $this->positions['Защитник'] += $player->getPlayTime(); 
                    break;
                case 'П':
                    $this->positions['Полузащитник'] += $player->getPlayTime(); 
                    break;
                case 'Н':
                    $this->positions['Нападающий'] += $player->getPlayTime(); 
                    break;
            }
        }
    }

    public function getPositions(): array 
    {
        $this->updatePosition();
        return $this->positions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }


    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }
}