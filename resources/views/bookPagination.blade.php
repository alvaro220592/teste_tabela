@extends('layouts.main')

@section('content')
    <style>
        th {
            cursor: pointer;
        }
        
        th, td {
            border: 2px solid black;
        }

        .paginacao {
            
        }

        .pag_links {
            background-color: turquoise;
            padding: 3px 8px;
            border-radius: 3px;
            cursor: pointer;
        }

        .pag_links_active {
            background-color: lightcoral;
            color: white;
        }
    </style>

    <a href="{{route('bookPagination')}}">Book pagination</a>
    <input type="hidden" value="{{route('bookPaginationGetBooks')}}" id="bookPaginationGetBooks">
    <input type="hidden" id="per_page" value="5">
    <input type="hidden" id="pagina_atual" value="1">

    Buscar <input type="text" id="busca" onkeyup="inputPesquisa(this)">

    <br><br>
    <table>
        <thead>
            <tr>
                <th onclick="ordenacao(this)" data-ordenacao="id">#</th>
                <th onclick="ordenacao(this)" data-ordenacao="nome">Nome</th>
                <th onclick="ordenacao(this)" data-ordenacao="ano">Ano</th>
                <th onclick="ordenacao(this)" data-ordenacao="paginas">Páginas</th>
                <th onclick="ordenacao(this)" data-ordenacao="created_at">Criado em</th>
            </tr>
        </thead>
        <tbody>
            {{-- JS --}}
        </tbody>
    </table>
    <br>

    <div class="paginacao">
        
    </div>
    
@endsection 

@section('scripts')
    <script src="{{ asset('js/SearchBook.js') }}"></script>
    <script>/*
        async function getBooks(event){
            let url = document.getElementById('bookPaginationGetBooks').value
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            let busca = document.getElementById('busca').value


            let pagina_escolhida = null
            if (event) {
                if (event.target.classList.contains('pag_links')) {
                    console.log(document.getElementById('pagina_atual').value -1)
                    if (event.target.dataset.numeropagina == '<') {
                        pagina_escolhida = parseInt(document.getElementById('pagina_atual').value) - 1
                    }
                    pagina_escolhida = event.target.dataset.numeropagina
                }
                else {
                    pagina_escolhida = document.getElementById('pagina_atual').value
                }
            }

            // Se tiver algo no campo de busca, passa para a página 1, pois é onde comcerteza virão resultados, podendo assim avançar a página se quiser
            if (busca != '') {
                pagina_escolhida = 1
            }

            const req = await fetch(url, {
                method: 'post',
                headers: {
                    'content-type': 'application/json',
                    'x-csrf-token': token
                },
                body: JSON.stringify({
                    busca: busca,
                    pagina_escolhida: pagina_escolhida
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
            document.getElementById('pagina_atual').value = res.current_page

            document.querySelector('.paginacao').innerHTML = ''
            res.links.forEach(link => {
                if (link.label.search('Previous') != -1) {
                    link.label = '<'
                } else if (link.label.search('Next') != -1) {
                    link.label = '>'
                }
                document.querySelector('.paginacao').innerHTML += `
                    <span class="pag_links" data-numeropagina="${link.label}" onclick="mudarPagina(this)">${link.label}</span>
                `
            })

            document.querySelectorAll('.pag_links').forEach(link => {
                if (link.dataset.numeropagina == res.current_page) {
                    link.classList.add('pag_links_active')
                }
            })
        }

        function mudarPagina(elemento){
            getBooks(event)
        }

        getBooks(event)*/
    </script>
@endsection