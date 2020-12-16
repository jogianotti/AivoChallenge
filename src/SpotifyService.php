<?php


namespace AivoChallenge;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class SpotifyService implements MusicService
{
    private const TOKEN_ENDPOINT = "https://accounts.spotify.com/api/token";
    private const API_BASE_URI = "https://api.spotify.com/v1";
    private const SEARCH_ENDPOINT = "/search?q={query}&type={type}";
    private const ALBUMS_ENDPOINT = "/artists/{id}/albums";

    private const CLIENT_ID = "7a1982c983b945c2b0ebfc6fc15393f6";
    private const CLIENT_SECRET = "5dc6f4153bf342f08242f89980c7ee87";

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

    public function searchArtistId(string $artistName): string
    {
        // TODO: Implement searchArtistId() method.
    }

    public function getAlbums(string $artistId): array
    {
        // TODO: Implement getAlbums() method.
    }
}