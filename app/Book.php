<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function scopeGetCollection($query, $request)
    {
        $query->when(!empty($request->get('title')), function ($query) use ($request) {
            return $query->where('title', 'LIKE', '%' . $request->get('title') . '%');
        })
            ->when(!empty($request->get('authors')), function ($query) use ($request) {
                return $query->whereHas('authors', function ($query) use ($request) {
                    $query->whereIn('id', explode(',', $request->get('authors')));
                });
            });
    }

    public function scopeSortBy($query, $request)
    {
        $query->when(!empty($request->get('sortColumn') && !empty($request->get('sortDirection'))), function ($query) use ($request) {
            if ($request->get('sortColumn') == 'avg_review') {
                return $query->whereHas('reviews', function ($query) use ($request) {
                    return $query->orderBy('avg(review)', $request->get('sortDirection'));
                });

            }
            return $query->orderBy($request->get('sortColumn'), $request->get('sortDirection'));
        });
    }
}
