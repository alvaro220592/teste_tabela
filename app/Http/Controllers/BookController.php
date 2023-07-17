<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function getBooks(){
        $busca = Request::input('busca');
        
        $query = Book::query();

        $query->when($busca, function ($query, $busca) {
            return $query->where('nome', 'like', "%$busca%");
        });
        return response()->json($query->paginate(Request::input('per_page')));
    }

    public function bookPagination(){
        return view('bookPagination');
    }

    public function bookPaginationGetBooks(){
        // dd(Request::input('pagina_escolhida'));
        Paginator::currentPageResolver(function (){
            return Request::input('pagina_escolhida');
        });
        
        $busca = Request::input('inputPesquisa');
        
        $query = Book::query();

        $query->when($busca, function ($query, $busca) {
            return $query->where('nome', 'like', "%$busca%");
        });

        $ordenacao = Request::input('ordenacao');
        $query->when($ordenacao, function($query, $ordenacao){
            return $query->orderBy($ordenacao);
        });

        return response()->json($query->paginate(5));
    }
}
