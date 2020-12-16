<?php


namespace AivoChallenge\Domain;


class Album
{
    private string $name;
    private string $released;
    private int $tracks;
    private Cover $cover;

    public function __construct(string $name, string $released, int $tracks, Cover $cover)
    {
        $this->name = $name;
        $this->released = $released;
        $this->tracks = $tracks;
        $this->cover = $cover;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function released(): string
    {
        return $this->released;
    }

    public function tracks(): int
    {
        return $this->tracks;
    }

    public function cover(): Cover
    {
        return $this->cover;
    }
}