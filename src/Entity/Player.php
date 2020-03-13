<?php
namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private int $number;
    private string $name;
    private string $playStatus;
    private int $inMinute;
    private int $outMinute;
    private bool $goal;
    private int $yellowCard;
    private int $redCard;
    private string $position;

    public function __construct(int $number, string $name, string $position)
    {
        $this->number = $number;
        $this->name = $name;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->inMinute = 0;
        $this->outMinute = 0;
        $this->goal = false;
        $this->yellowCard = 0;
        $this->redCard = 0;
        $this->position = $position;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setGoal(): void
    {
        $this->goal = true;
    }

    public function getGoal(): bool
    {
        return $this->goal;
    }

    public function addYellowCard(): void
    {
        $this->yellowCard += 1;
    }

    public function getYellowCard(): int
     {
        return $this->yellowCard;
    }

    public function addRedCard(): void
    {
        $this->redCard += 1;
    }

    public function getRedCard(): int
     {
        return $this->redCard;
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if(!$this->outMinute) {
            return 0;
        }

        return $this->outMinute - $this->inMinute;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }
}