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
        
        $ordem = 'asc';
        $orderBy = 'id';
        $perpage = Request::input('perpage') ? Request::input('perpage') : 5;

        $ordenacao = Request::input('ordenacao');
        if (Request::input('ordenacao')) {
            $orderBy = $ordenacao['orderBy'];
            switch ($ordenacao['ordem']) {
                case -1:
                    $ordem = 'desc';
                    break;

                case 1:
                    $ordem = 'asc';
                    break;

                default:
                    $ordem = 'asc';
                    $orderBy = 'id';
                    break;
            }
        }
        Paginator::currentPageResolver(function (){
            return Request::input('pagina_escolhida');
        });
        
        $busca = Request::input('inputPesquisa');
        
        $query = Book::query();

        $query->when($busca, function ($query, $busca) {
            return $query->where('nome', 'like', "%$busca%");
        });

        $query->when($ordenacao, function($query, $ordenacao) use ($orderBy, $ordem) {
            return $query->orderBy($orderBy, $ordem);
        });

        return response()->json($query->paginate($perpage));
    }
}
