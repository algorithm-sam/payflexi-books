<?php


namespace App\Interfaces;


interface BookInterface
{
    public function getBooks();
    public function allBooks();
    public function getBook($book_id);
    public function storeBook($bookData);
    public function findByID($book_id);
    public function update($book_id, $bookUpdates);
    public function searchBook($bookName);
    public function delete($book_id);
}
