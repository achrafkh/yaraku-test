<?php

namespace Tests\Feature;

use Tests\TestCase;

class DownloadTest extends TestCase
{
    /**
     * A basic test For Csv Download.
     *
     * @return void
     */
    public function testCsvDownload()
    {

        $requestData = [
            "order" => [
                [
                    "column" => "1",
                    "dir" => "desc",
                ],
            ],
            "search" => [
                "value" => "",
                "regex" => "false",
            ],
            "filename" => "tester",
            "selected_columns" => [
                "title",
                "author",
            ],
            "type" => "csv",
        ];

        $response = $this->json('GET', '/books/export/csv?' . http_build_query($requestData));
        $response->assertStatus(200)
            ->assertHeader('Content-Disposition', 'attachment; filename=' . $requestData['filename'] . '.csv');
    }

    /**
     * A basic test For Csv Download.
     *
     * @return void
     */
    public function testXmlDownload()
    {

        $requestData = [
            "order" => [
                [
                    "column" => "1",
                    "dir" => "desc",
                ],
            ],
            "search" => [
                "value" => "",
                "regex" => "false",
            ],
            "filename" => "tester",
            "selected_columns" => [
                "title",
                "author",
            ],
            "type" => "xml",
        ];
        $response = $this->json('GET', '/books/export/xml?' . http_build_query($requestData));
        $response->assertStatus(200)
            ->assertHeader('Content-Disposition', 'attachment; filename=' . $requestData['filename'] . '.xml');
    }
}
