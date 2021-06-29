<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Services\BookServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsObject;
use function PHPUnit\Framework\assertNull;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private $books;
    public function setUp(): void
    {
        parent::setUp();
        $this->books = Book::factory()->count(10)->create();
        // $this->app->factory(Book::class, 10);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_page_is_rendered_properly()
    {
        // make a request to the index page;
        // ensure the response is 200;
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    public function test_save_a_book_to_the_database()
    {
        $response = $this->postJson('/api/books', [
            'name' => 'Some New Book',
            'isbn' => '123-8712638076',
            'authors' => ['Ohidoa Oluwatobi Samuel'],
            'country' => 'Nigeria',
            'number_of_pages' => 153,
            'publisher' => 'Algorithms',
            'release_date' => now()
        ]);
        $response->assertStatus(201);
        $response->assertJson(['status' => 'true', 'data' => ['name' => 'Some New Book', 'isbn' => '123-8712638076']]);
    }

    public function test_fetching_book_from_external_api()
    {
        //ensure that it fetches books from the api
        $bookService = new BookServices();
        $response = $bookService->findBookByName('A Game of thrones');

        $this->assertIsObject($response);
        assertIsArray($response->first());
        $this->assertArrayHasKey('name', $response->first());
        $this->assertEquals('A Game of Thrones', $response->first()['name']);
    }

    public function test_fetching_books_from_api()
    {
        //ensure that it fetches books from the api
        $response = $this->getJson('api/books');
        $this->assertIsObject($response);
        $response->assertStatus(200);
        $response->assertSee(['data', 'status', 'message']);
        $this->assertIsArray($response['data']);
        $this->assertArrayHasKey("name", $response['data'][0]);
        $this->assertArrayHasKey("isbn", $response['data'][0]);
    }

    public function test_update_book()
    {
        $response = $this->patchJson("api/books/{$this->books[0]->id}", [
            "name" => "New Name"
        ]);
        $response->assertJson(['status' => 'true', 'message' => 'Book updated']);
        $response->assertJson(['data' => ['name' => 'New Name']]);
    }

    public function test_delete_book()
    {
        //
        $response = $this->delete("api/books/{$this->books[0]->id}");
        $response->assertStatus(200);
        $response->assertJson(['status' => 'true', 'message' => 'Book deleted']);
        $book = Book::find(2);
        assertNull($book);
    }

    public function test_delete_with_post_method()
    {
        $response = $this->post("api/books/{$this->books[0]->id}/delete");
        $response->assertStatus(200);
        $response->assertJson(['status' => 'true', 'message' => 'Book deleted']);
        $book = Book::find(2);
        assertNull($book);
    }

    public function test_listing_all_books()
    {
        //ensure that it fetches books from the api
        $book = $this->getJson("api/books/{$this->books[0]->id}")['data'];
        $response = $this->getJson('api/books');
        $this->assertContains($book, $response['data']);
        $response->assertSee($book['name']);
        $response->assertStatus(200);
    }
}
