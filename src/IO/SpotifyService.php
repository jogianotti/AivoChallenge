<?php


namespace AivoChallenge\IO;

use AivoChallenge\Domain\Album;
use AivoChallenge\Domain\Cover;
use AivoChallenge\Domain\FailedAccessTokenRequestException;
use AivoChallenge\Domain\FailedGetAlbumsException;
use AivoChallenge\Domain\FailedSearchException;
use AivoChallenge\Domain\MusicService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class SpotifyService implements MusicService
{
    private const TOKEN_ENDPOINT = "https://accounts.spotify.com/api/token";
    private const API_BASE_URI = "https://api.spotify.com/v1";
    private const SEARCH_ENDPOINT = "/search?q={query}&type=artist";
    private const ALBUMS_ENDPOINT = "/artists/{id}/albums";

    private const CLIENT_ID = "7a1982c983b945c2b0ebfc6fc15393f6";
    private const CLIENT_SECRET = "5dc6f4153bf342f08242f89980c7ee87";

    private string $accessToken;

    public function __construct()
    {
        $response = $this->requestAccessToken();

        $this->accessToken = $response->access_token;
    }

    private function requestAccessToken(): object
    {
        $client = new Client();
        $request = new Request(
            'POST',
            self::TOKEN_ENDPOINT,
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . base64_encode(self::CLIENT_ID . ':' . self::CLIENT_SECRET)
            ],
            'grant_type=client_credentials'
        );
        $response = $client->send($request, ['timeout' => 5]);

        if ($response->getStatusCode() !== 200) {
            throw new FailedAccessTokenRequestException();
        }

        return json_decode($response->getBody()->getContents());
    }

    public function searchArtistId(string $artistName): ?string
    {
        $client = new Client();
        $request = new Request(
            'GET',
            self::API_BASE_URI . str_replace('{query}', urlencode($artistName), self::SEARCH_ENDPOINT),
            [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        );

        $response = $client->send($request, ['timeout' => 5]);

        if ($response->getStatusCode() !== 200) {
            throw new FailedSearchException();
        }

        $result = json_decode($response->getBody()->getContents());

        return $result->artists->items[0] ? $result->artists->items[0]->id : null;
    }

    public function getAlbums(string $artistId): array
    {
        $client = new Client();
        $request = new Request(
            'GET',
            self::API_BASE_URI . str_replace('{id}', $artistId, self::ALBUMS_ENDPOINT),
            [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        );

        $response = $client->send($request, ['timeout' => 5]);

        if ($response->getStatusCode() !== 200) {
            throw new FailedGetAlbumsException();
        }

        $result = json_decode($response->getBody()->getContents());

        $albums = [];
        foreach ($result->items as $album) {
            $albums[] = new Album(
                $album->name,
                $album->release_date,
                $album->total_tracks,
                new Cover(
                    $album->images[0]->width,
                    $album->images[0]->height,
                    $album->images[0]->url
                )
            );
        }

        return $albums;
    }
}