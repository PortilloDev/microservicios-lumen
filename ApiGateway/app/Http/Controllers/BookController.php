<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Services\BookService;
use App\Services\AuthorService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;
    public $bookService;

    public $authorService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index()
    {
      return  $this->successResponse( $this->bookService->obtainBooks());
    }

    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->author_id);
        return  $this->successResponse($this->bookService->createBooks($request->all()), Response::HTTP_CREATED);
    }

    public function show($book)
    {
        return  $this->successResponse($this->bookService->obtainBook($book));

    }

    public function update(Request $request, $book)
    {
        return  $this->successResponse( $this->bookService->editBook($request->all(), $book));
    }

    public function destroy($book)
    {
        return  $this->successResponse( $this->bookService->destroyBook($book));

    }
}
