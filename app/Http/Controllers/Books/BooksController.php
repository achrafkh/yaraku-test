<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Repositories\Interfaces\BooksRepositoryInterface;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $books;

    public function __construct(BooksRepositoryInterface $books)
    {
        $this->books = $books;
    }

    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->eloquent($this->books->query())->toJson();
        }

        return view('books.index');
    }

    /**
     * Store a newly created book in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BookRequest $request)
    {
        $book = $this->books->create($request->all());

        return response()->json($book, 201);
    }

    /**
     * Update the specified book in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(BookRequest $request, $id)
    {
        $book = $this->books->update($id, $request->all());

        return response()->json($book, 200);
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->books->delete($id);

        return response()->json(null, 204);
    }
}
