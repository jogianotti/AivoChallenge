<?php

//ID        7a1982c983b945c2b0ebfc6fc15393f6
//SECRET    5dc6f4153bf342f08242f89980c7ee87

namespace AivoChallenge\Tests;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use AivoChallenge\AlbumsSearcher;
use AivoChallenge\SpotifyService;
use AivoChallenge\MusicService;

class GetAlbumsTest extends TestCase
{
    /** @var MockInterface | MusicService */
    private MockInterface $musicService;

    protected function setUp(): void
    {
        $this->musicService = Mockery::mock(SpotifyService::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testItShouldGetAllAlbumsForAnArtist(): void
    {
        $this->shouldSearchArtistId();
        $this->shouldRequestAlbums();

        $artist = $this->getArtist();
        $albums = $this->getAlbums();

        $albumsSearcher = new AlbumsSearcher($this->musicService);

        $result = $albumsSearcher($artist);

        $this->assertIsArray($result);
        $this->assertEquals($albums, $result);
    }

    private function shouldSearchArtistId(): void
    {
        $artisName = '';
        $artistId = '';

        $this->musicService
            ->shouldReceive('searchArtistId')
            ->with($artisName)
            ->once()
            ->andReturn($artistId);
    }

    private function shouldRequestAlbums(): void
    {
        $artistId = '';
        $albums = [];

        $this->musicService
            ->shouldReceive('getAlbums')
            ->with($artistId)
            ->once()
            ->andReturn($albums);
    }

    private function getArtist(): string
    {
        return '';
    }

    private function getAlbums(): array
    {
        return [];
    }
}