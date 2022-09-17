<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use App\Http\Requests\PostBookRequest;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{
    public function getCollection(Request $request)
    {
        return BookResource::collection(Book::getCollection($request)->sortBy($request)->paginate());
    }

    public function post(PostBookRequest $request)
    {
        try {
            DB::beginTransaction();
            $book = Book::create([
                'isbn' => $request->isbn,
                'title' => $request->title,
                'description' => $request->description
            ]);
            if (count($request->authors) > 0) {
                $book->authors()->syncWithoutDetaching($request->authors);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
        return new BookResource($book);
    }

    public function postReview(Book $book, PostBookReviewRequest $request)
    {
        try {
            DB::beginTransaction();
            $review = BookReview::create([
                'book_id' => $book->id,
                'user_id' => $request->user()->id,
                'review' => $request->review,
                'comment' => $request->comment
            ]);
            $book->reviews()->save($review);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
        return new BookReviewResource($review);
    }
}
