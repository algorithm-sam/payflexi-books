<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\BookInterface;

class BookController extends Controller
{
    private $_bookRepository;

    public function __construct(BookInterface $bookInterface)
    {
        $this->_bookRepository = $bookInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = $this->_bookRepository->allBooks();
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Request Object
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'isbn' => 'required|string',
            'authors' => 'required|array',
            'authors.*' => 'required|string|min:3',
            'country' => 'required|string',
            'number_of_pages' => 'required|integer',
            'publisher' => 'required|string',
            'release_date' => 'required|date'
        ]);

        $book = $this->_bookRepository->storeBook($request->only(['name', 'isbn', 'authors', 'country', 'number_of_pages', 'publisher', 'release_date']));
        return response()->json($book, 201);
    }


    public function searchBook(Request $request)
    {
        //Handle Invalid/Malformed Query Parameter
        if (!$request->query('name')) {
            return response()->json(['status' => false, "message" => "Invalid request"], 400);
        }

        $book = $this->_bookRepository->searchBook($request->query('name'));
        return response()->json($book, 200);
    }

    /**
     * Fetches the specified resource.
     *
     * @param  String  $bookName
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $book)
    {
        //
        $book = $this->_bookRepository->getBook($book);
        return response()->json($book, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $book)
    {
        //validate the request object;
        $response = $this->_bookRepository->update($book, $request->all());
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($book_id)
    {
        //
        $response = $this->_bookRepository->delete($book_id);
        return response()->json($response, 200);
    }
}
