<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Repositories\BooksRepository;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BooksRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test repositories All method
     *
     * @return void
     */
    public function testAllMethod()
    {
        $class = new BooksRepository(new Book);
        $db_count = DB::table('books')->count();
        $repo_count = $class->all()->count();

        if ($repo_count != $db_count) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * Test repositories Query method
     *
     * @return void
     */
    public function testQueryMethod()
    {
        $class = new BooksRepository(new Book);
        $random = (array) DB::table('books')->orderBy(DB::raw('RAND()'))->first();

        $result = $class->query()->where('title', $random['title'])->where('author', $random['author'])->first()->toarray();

        if ($result != $random) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * Test repositories Query method
     *
     * @return void
     */
    public function testCreateMethod()
    {
        $class = new BooksRepository(new Book);

        $record = factory(Book::class)->make();

        $savedRecord = $class->create($record->toarray());

        if (!($savedRecord instanceof Book)) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * Test repositories Query method
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $class = new BooksRepository(new Book);

        $str = str_random(5) . '-' . time();
        $str2 = str_random(5) . '-' . time();

        $record = (array) DB::table('books')->select('id', 'title', 'author')->orderBy(DB::raw('RAND()'))->first();

        $record['title'] = $str;
        $record['author'] = $str2;

        $updatedRecord = $class->update($record['id'], $record);

        $record = (array) DB::table('books')->select('id', 'title', 'author')->find($record['id']);

        if (ucfirst($str) != $record['title'] || ucfirst($str2) != $record['author'] || false == $updatedRecord) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * Test repositories Query method
     *
     * @return void
     */
    public function testDeleteMethod()
    {
        $class = new BooksRepository(new Book);

        $record = (array) DB::table('books')->orderBy(DB::raw('RAND()'))->first();

        $deleted = $class->delete($record['id']);

        $found = DB::table('books')->where('id', $record['id'])->whereNull('deleted_at')->exists();

        if (false == $deleted || $found) {
            $this->assertTrue(false);
        }
        $unexisting_id = DB::table('books')->orderBy('id', 'DESC')->first()->id + 10;
        $deleted = $class->delete($unexisting_id);

        if (0 != $deleted) {
            $this->assertTrue(false);
        }
        $this->assertTrue(true);
    }
}
