<?php


namespace AivoChallenge;


class AlbumsSearcher
{
    private MusicService $musicService;

    public function __construct(MusicService $musicService)
    {
        $this->musicService = $musicService;
    }

    public function __invoke(string $artist)
    {
        $artistId = $this->musicService->searchArtistId($artist);
        $albums = $this->musicService->getAlbums($artistId);

        return $albums;
    }
}