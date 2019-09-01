<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetailsFeatureTest extends TestCase
{
    /**
     * A feature test for Api /api/details
     * @dataProvider provideIndex
     * @return void
     */
    public function testIndex($data)
    {
        $response = $this->json('GET', '/api/details', $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'request' => [
                        'sourceId',
                    ],
                    "timestamp"
                ],
                'data' => [
                    [
                        "number",
                        "date",
                        "name",
                        "link",
                        "details"
                    ]
                ]
            ]);
    }

    public function provideIndex()
    {
        return [
            [["sourceId" => "space","year" => 2013,"limit" => 2]],
            [["sourceId" => "space","year" => 2017,"limit" => 3]],
            [["sourceId" => "comics","comicId" => 67]],
            [["sourceId" => "comics","comicId" => 64]],            
        ];
    }
}
