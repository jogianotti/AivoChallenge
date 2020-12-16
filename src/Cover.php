<?php


namespace AivoChallenge;


class Cover
{
    private int $width;
    private int $height;
    private string $url;

    public function __construct(int $width, int $height, string $url)
    {
        $this->width = $width;
        $this->height = $height;
        $this->url = $url;
    }

    public function width(): int
    {
        return $this->width;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function url(): string
    {
        return $this->url;
    }


}