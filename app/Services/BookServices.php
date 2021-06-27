<?php


namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class BookServices
{

    public static function formatResponse($book)
    {

        return [
            'name' => $book['name'],
            'isbn' => $book['isbn'],
            'authors' => $book['authors'],
            'number_of_pages' => $book['numberOfPages'],
            'publisher' => $book['publisher'],
            'country' => $book['country'],
            'release_date' => Carbon::parse($book['released'])->format('M d, Y')
        ];
    }

    public function getBooks()
    {
        $response = Http::get($this->buildEndpoint('books'));
        return $response->json();
    }

    public function findBookByName($name)
    {
        $response = Http::get($this->buildEndpoint('books'), ['name' => $name]);
        if ($response->successful()) {
            return $response->collect()->map(function ($book) {
                return $this->formatResponse($book);
            });
        } else {
            return null;
        }
    }




    private function buildEndpoint($endpoint)
    {
        return env('BOOK_SERVICE_URL') . "/$endpoint";
    }
}
