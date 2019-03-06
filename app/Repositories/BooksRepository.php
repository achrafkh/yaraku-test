<?php
namespace App\Repositories;

use App\Models\Book;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BooksRepositoryInterface;

class BooksRepository extends BaseRepository implements BooksRepositoryInterface
{
    protected $model;

    /**
     * BooksRepository constructor.
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function exportData(array $sort, $keyword = null, $cols = '*')
    {
        $sorting_cols = config('datasets.columns.books');

        $query = $this->model->orderBy($sorting_cols[$sort['column']], $sort['dir']);

        if (!is_null($keyword)) {
            $query = $this->model->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('author', 'LIKE', '%' . $keyword . '%');
            });
        }

        return $query->get($cols);
    }
}
