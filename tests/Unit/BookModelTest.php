<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookModelTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test Model mutator for title attribute
     *
     * @return void
     */
    public function testTitleMutator()
    {
        $data = [
            'title' => strtolower($this->faker->sentence(rand(5, 10), $variableNbWords = true)),
            'author' => strtolower($this->faker->name),
        ];

        $record = Book::create($data);

        if (ucfirst($data['title']) != $record->title || ucfirst($data['author']) != $record->author) {
            $this->assertTrue(false);
        }
        $this->assertTrue(true);
    }

    /**
     * Test Model mutator for Author attribute
     *
     * @return void
     */
    public function testAuthorMutator()
    {
        $this->assertTrue(true);
    }
}
