@extends('layouts.main')

@section('content')
    <style>
        th {
            cursor: pointer;
        }

        .paginacao {
            
        }

        .pag_links {
            border: solid 1px black;
            padding: 3px 8px;
            border-radius: 3px;
            cursor: pointer;
        }

        .pag_links_active {
            background-color: #55557f;
            color: white;
        }
    </style>

    <div class="row my-3">
        <div class="col-md-3 col-lg-3">
            <a class="text-danger" href="{{route('bookPagination')}}">Book pagination</a>
        </div>
    </div>

    <input type="hidden" value="{{route('bookPaginationGetBooks')}}" id="bookPaginationGetBooks">
    <input type="hidden" id="per_page" value="5">
    <input type="hidden" id="pagina_atual" value="1">

    <div class="row my-2">
        <div class="col-md-1">
            Buscar 
        </div>
        <div class="col-md-3 mx-5">
            <input class="campo_busca pastel_claro" type="text" id="busca" onkeyup="inputPesquisa(this)">
        </div>

        <div class="col-md-3">
            mostrar
            <select onchange="perpage_change(this)" class="campo_busca pastel_claro">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
    </div>

    <br><br>
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th onclick="ordenacao(this)" data-order="0" data-orderby="id">
                    <div class="d-flex flex-row">
                        #
                        <span class="d-flex flex-row">
                            <i class="d-none bi bi-caret-up-fill" data-dir="cima"></i>
                            <i class="d-none bi bi-caret-down-fill" data-dir="baixo"></i>
                        </span>
                    </div>
                </th>
                <th onclick="ordenacao(this)" data-order="0" data-orderby="nome">
                    <div class="d-flex flex-row">
                        Nome
                        <span class="d-flex flex-row">
                            <i class="d-none bi bi-caret-up-fill" data-dir="cima"></i>
                            <i class="d-none bi bi-caret-down-fill" data-dir="baixo"></i>
                        </span>
                    </div>
                </th>
                <th onclick="ordenacao(this)" data-order="0" data-orderby="ano">
                    <div class="d-flex flex-row">
                        Ano
                        <span class="d-flex flex-row">
                            <i class="d-none bi bi-caret-up-fill" data-dir="cima"></i>
                            <i class="d-none bi bi-caret-down-fill" data-dir="baixo"></i>
                        </span>
                    </div>
                </th>
                <th onclick="ordenacao(this)" data-order="0" data-orderby="paginas">
                    <div class="d-flex flex-row">
                        Páginas
                        <span class="d-flex flex-row">
                            <i class="d-none bi bi-caret-up-fill" data-dir="cima"></i>
                            <i class="d-none bi bi-caret-down-fill" data-dir="baixo"></i>
                        </span>
                    </div>
                </th>
                <th onclick="ordenacao(this)" data-order="0" data-orderby="created_at">
                    <div class="d-flex flex-row">
                        Criado em
                        <span class="d-flex flex-row">
                            <i class="d-none bi bi-caret-up-fill" data-dir="cima"></i>
                            <i class="d-none bi bi-caret-down-fill" data-dir="baixo"></i>
                        </span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            {{-- JS --}}
        </tbody>
    </table>
    <br>

    <div class="paginacao my-2">
        {{-- JS --}}
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