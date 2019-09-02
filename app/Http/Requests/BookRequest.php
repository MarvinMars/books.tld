<?php

namespace App\Http\Requests;

use App\Book;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Uppercase;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if($this->method() == 'PUT'||$this->method() == 'PATCH'){
            $rules = 'required|isbn|unique:books,isbn,'.$this->book->id;
        }else{
            $rules = 'required|isbn|unique:books';
        }
        return [
            'name' => ['required','max:100','min:3', new Uppercase],
            'isbn' => $rules,
        ];
    }
}
