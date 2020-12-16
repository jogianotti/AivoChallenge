<?php


namespace AivoChallenge\Domain;


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

        if (!$artistId) {
            return [];
        }

        return $this->musicService->getAlbums($artistId);
    }
}