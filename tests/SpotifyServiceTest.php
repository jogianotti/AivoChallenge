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
}