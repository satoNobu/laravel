<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\ColorBook;

class TestController extends Controller
{
    //
    public function show()
    {


        // ■ insert
        // $book = new Book;
        // $book->name = "abcde";
        // $book->save();
        
        
        
        // ■ update
        // $book = Book::where('name', 'EEEE')->first();
        // \Log::info($book->name);
        // $book->name = 'DDD';
        // $book->save();

        // ■ update（複数更新）
        $updateCount = Book::where('name', 'DDD')
            ->update(['name' => 'a']);
        \Log::info("更新件数".$updateCount."件");
        $books = Book::all();
        $colorBook = ColorBook::all();
        // dd($colorBook, $books);
        return view('test', ['books' => $books]);
    }
}
