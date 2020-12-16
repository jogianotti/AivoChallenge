<?php


namespace AivoChallenge\Tests\IO;

use AivoChallenge\Domain\Album;
use AivoChallenge\Domain\Cover;
use AivoChallenge\IO\SpotifyService;
use PHPUnit\Framework\TestCase;

class SpotifyServiceTest extends TestCase
{
    public function testItShouldGetApiTokenOnCreateService()
    {
        $spotifyService = new SpotifyService();

        $this->assertInstanceOf(SpotifyService::class, $spotifyService);
    }

    public function testItShouldGetArtistId()
    {
        $spotifyService = new SpotifyService();

        $artistId = $spotifyService->searchArtistId('Tote Vega');

        $this->assertEquals('1973x73eN9EV5RPMXWE64N', $artistId);
    }

    public function testItShouldGetArtistAlbums()
    {
        $spotifyService = new SpotifyService();

        $albums = $spotifyService->getAlbums('1973x73eN9EV5RPMXWE64N');

        $expectedAlbums = [
            new Album(
                "Canciones Que Se Acercan",
                "2020-04-01",
                8,
                new Cover(
                    640,
                    640,
                    "https://i.scdn.co/image/ab67616d0000b2739753db3af04aac959505ffa5"
                )
            )
        ];

        $this->assertEquals($expectedAlbums, $albums);
    }
}