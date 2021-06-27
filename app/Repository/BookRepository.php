<?php


namespace App\Repository;

use App\Models\Book;
use App\Services\BookServices;
use App\Interfaces\BookInterface;

class BookRepository implements BookInterface
{
    private $_bookService;
    public function __construct(BookServices $bookService)
    {
        $this->_bookService = $bookService;
    }
    public function getBooks()
    {
        $response = $this->_bookService->getBooks();
        return $response;
    }

    public function getBook($book_id)
    {
        $response = $this->findByID($book_id);
        return $this->formatResponse($response, "Book retreived");
    }

    public function storeBook($bookData)
    {
        $book = Book::create($bookData);
        return $this->formatResponse($book, "Book added");
    }


    public function formatResponse($response = null, $message = null, $status = true)
    {
        $responseBody = [
            'status' => $status,
            'message' => $message ?? 'Book searched',
        ];
        $response ? $responseBody['data'] = $response :  null;

        return $responseBody;
    }

    public function update($book_id, $bookUpdates)
    {
        $book = $this->findByID($book_id);
        $book->update($bookUpdates);
        return $this->formatResponse($book, "Book updated");
    }

    public function findByID($book_id)
    {
        return Book::findOrFail($book_id);
    }

    public function allBooks()
    {
        $books = Book::all();
        return $this->formatResponse($books, "Books retreived");
    }

    public function searchBook($bookName)
    {
        $book = $this->_bookService->findBookByName($bookName);
        if (!$book) {
            return $this->formatResponse(null, 'Invalid Request', false);
        } else return $this->formatResponse($book, count($book) ? 'External books searched' : 'Book searched');
    }

    public function delete($book_id)
    {
        $this->findByID($book_id)->delete();
        return $this->formatResponse(null, "Book deleted");
    }
}
