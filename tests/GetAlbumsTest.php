<?php

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

        $albumsSearcher = new AlbumsSearcher($this->musicService);

        $result = $albumsSearcher('Tote Vega');

        $this->assertIsArray($result);
    }

    private function shouldSearchArtistId(): void
    {
        $artisName = 'Tote Vega';
        $artistId = '1973x73eN9EV5RPMXWE64N';

        $this->musicService
            ->shouldReceive('searchArtistId')
            ->with($artisName)
            ->once()
            ->andReturn($artistId);
    }

    private function shouldRequestAlbums(): void
    {
        $artistId = '1973x73eN9EV5RPMXWE64N';
        $albums = [];

        $this->musicService
            ->shouldReceive('getAlbums')
            ->with($artistId)
            ->once()
            ->andReturn($albums);
    }
}