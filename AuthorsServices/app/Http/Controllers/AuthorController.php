<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $authors = Author::all();

        return $this->succesResponse($authors);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255',
            'country' => 'required|max:255',
        ];


        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->succesResponse($author, Response::HTTP_CREATED);
    }

    public function show($author)
    {
        $author = Author::find($author);
        return $this->succesResponse($author);

    }

    public function update(Request $request, $author)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255',
            'country' => 'max:255',
        ];


        $this->validate($request, $rules);

        $author = Author::find($author);
        $author->fill($request->all());

        if($author->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->succesResponse($author);
    }

    public function destroy($author)
    {
        $author = Author::find($author);

        if($author === null){
            return $this->errorResponse('Id not found', Response::HTTP_NOT_FOUND);
        }

        $author->delete();

        return $this->succesResponse($author);
    }
}
