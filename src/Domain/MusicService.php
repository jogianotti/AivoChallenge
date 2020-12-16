<?php

namespace AivoChallenge\Domain;

interface MusicService
{
    public function searchArtistId(string $artistName): ?string;

    public function getAlbums(string $artistId): array;
}