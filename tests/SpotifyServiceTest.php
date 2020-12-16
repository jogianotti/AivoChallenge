<?php


namespace AivoChallenge\Tests;

use AivoChallenge\SpotifyService;
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
}