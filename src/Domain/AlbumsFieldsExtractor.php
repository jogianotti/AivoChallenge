<?php


namespace AivoChallenge\Domain;


class AlbumsFieldsExtractor
{
    public function __invoke(array $albums)
    {
        $albums_array = [];
        foreach ($albums as $album) {
            $albums_array[] = [
                'name' => $album->name(),
                'released' => $album->released(),
                'tracks' => $album->tracks(),
                'cover' => [
                    'width' => $album->cover()->width(),
                    'height' => $album->cover()->height(),
                    'url' => $album->cover()->url()
                ]
            ];
        }

        return $albums_array;
    }
}