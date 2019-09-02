<?php
namespace App\Transformers;

use App\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    public function transform(Book $book)
    {
        return [
            "id"=> $book->id,
            "name"=> $book->name,
            "isbn"=> $book->isbn,
            "created_at"=> $book->created_at->format('m/d/Y g:i A'),
            "updated_at"=> $book->updated_at->format('m/d/Y g:i A'),
            "deleted_at"=> $book->deleted_at? $book->deleted_at->format('m/d/Y g:i A') : '',
        ];
    }
}
