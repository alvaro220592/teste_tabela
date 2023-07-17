@extends('layouts.main')

@section('content')
    <style>
        th, td {
            border: 2px solid black;
        }
    </style>

    <a href="{{route('bookPagination')}}">Book pagination</a>
    <input type="hidden" value="{{route('getBooks')}}" id="url_getBooks">
    <input type="hidden" id="per_page" value="5">
    Buscar <input type="text" id="busca" onkeyup="getBooks(event)">
    <br><br>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Ano</th>
                <th>Páginas</th>
                <th>Criado em</th>
            </tr>
        </thead>
        <tbody>
            {{-- JS --}}
        </tbody>
    </table>
    <br>
    <button type="button" onclick="getBooks(event)" id="ver_mais">Ver mais</button>
@endsection 

@section('scripts')
    <script>
        async function getBooks(event){
            let url = document.getElementById('url_getBooks').value
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            let busca = document.getElementById('busca').value
            let per_page = document.getElementById('per_page').value

            let ver_mais
            if (event){
                if (event.target.id == 'ver_mais') {
                    ver_mais = true
                }
            }
                        
            const req = await fetch(url, {
                method: 'post',
                headers: {
                    'content-type': 'application/json',
                    'x-csrf-token': token
                },
                body: JSON.stringify({
                    busca: busca,
                    per_page: ver_mais ? parseInt(per_page) + 5 : per_page
                })
            })
            const res = await req.json()

            let tbody = document.querySelector('tbody')
            tbody.innerHTML = ''
            res.data.forEach(livro => {
                tbody.innerHTML += `
                    <tr>
                        <td>${livro.id}</td>
                        <td>${livro.nome}</td>
                        <td>${livro.ano}</td>
                        <td>${livro.paginas}</td>
                        <td>${livro.created_at}</td>
                    </tr>
                `
            })

            if (ver_mais) {
                document.getElementById('per_page').value = res.per_page
            }
        }

        getBooks(event)
    </script>
@endsection