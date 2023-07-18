class SearchBook {
    
    static #url_getBooks = document.getElementById('bookPaginationGetBooks').value
    static csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    static #campoPesquisa
    static #paginaAntiga
    static #pagina_escolhida = 1
    static #ordenacao = {}
    static #perpage

    static getUrlGetBooks(){
        return SearchBook.#url_getBooks
    }

    static setPesquisa(valor){
        SearchBook.#campoPesquisa = valor
    }

    static getCampoPesquisa(){
        return SearchBook.#campoPesquisa
    }

    static setPaginaEscolhida(pagina_escolhida){
        SearchBook.#pagina_escolhida = pagina_escolhida
    }

    static getPaginaEscolhida(){
        return SearchBook.#pagina_escolhida
    }

    static setPaginaAntiga(pag_antiga){
        SearchBook.#paginaAntiga = pag_antiga
    }

    static getPaginaAntiga(){
        return SearchBook.#paginaAntiga
    }

    static setOrdenacao(order_by, ordem){
        SearchBook.#ordenacao = {
            orderBy: order_by,
            ordem: ordem
        }
    }

    static getOrdenacao(){
        return SearchBook.#ordenacao
    }

    static setPerpage(perpage){
        SearchBook.#perpage = perpage
    }

    static getPerpage(){
        return SearchBook.#perpage
    }

    static async buscar(){
        configurarPaginacao()
        const requisicao = await fetch(SearchBook.getUrlGetBooks(), {
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'x-csrf-token': SearchBook.csrf_token
            },
            body: JSON.stringify({
                inputPesquisa: SearchBook.getCampoPesquisa(),
                pagina_escolhida: SearchBook.getPaginaEscolhida(),
                ordenacao: SearchBook.getOrdenacao(),
                perpage: SearchBook.getPerpage()
            })
        })

        const resposta = await requisicao.json()
        
        SearchBook.montarTabela(resposta.data)

        SearchBook.paginacao(resposta, resposta.links)

        SearchBook.setPaginaAntiga(resposta.current_page)
    }

    // montando as linhas da tabela
    static montarTabela(dados){
        let tbody = document.querySelector('tbody')
        tbody.innerHTML = ''
        dados.forEach(dado => {
            tbody.innerHTML += `
                <tr>
                    <td>${dado.id}</td>
                    <td>${dado.nome}</td>
                    <td>${dado.ano}</td>
                    <td>${dado.paginas}</td>
                    <td>${dado.created_at}</td>
                </tr>
            `
        })
    }

    // montando o bloco de paginação
    static paginacao(objeto, links){
        document.querySelector('.paginacao').innerHTML = ''
        
        links.forEach(link => {
            let id = ''
            if (link.label.search('Previous') != -1) {
                link.label = '<'
                id = 'previous'
            
            } else if (link.label.search('Next') != -1) {
                link.label = '>'
                id = 'next'            
            }

            document.querySelector('.paginacao').innerHTML += `
                <span class="pag_links" data-numeropagina="${link.label}" id="${id}" onclick="mudarPagina(this)">${link.label}</span>
            `

            // Se tiver na 1ª pagina, o botao de anterior nao aparece
            if (SearchBook.getPaginaEscolhida() == links[1].label) {
                let previous = document.getElementById('previous')
                if (previous) {
                    previous.style.display = 'none'
                }
            } 
            
            // Se tiver na ultima pagina, o botao de proximo nao aparece
            if (SearchBook.getPaginaEscolhida() == links[links.length - 2].label) {
                let next = document.getElementById('next')
                if (next) {
                    document.getElementById('next').style.display = 'none'
                }
            }
        })

        document.querySelectorAll('.pag_links').forEach(link => {
            if (link.dataset.numeropagina == objeto.current_page) {
                link.classList.add('pag_links_active')
            }
        })
    }
}

function inputPesquisa(elemento){
    SearchBook.setPesquisa(elemento.value)
    SearchBook.setPaginaEscolhida(1)
    SearchBook.buscar()
}

function mudarPagina(elemento){
    if (elemento.dataset.numeropagina == '...') {
        return
    }
    SearchBook.setPaginaEscolhida(elemento.dataset.numeropagina)
    SearchBook.buscar()
}

// Se a pessoa clicar em 'anterior' ou próximo
function configurarPaginacao(){
    if (SearchBook.getPaginaEscolhida() == '<') {
        SearchBook.setPaginaEscolhida(parseInt(SearchBook.getPaginaAntiga()) - 1)

    } else if (SearchBook.getPaginaEscolhida() == '>') {
        SearchBook.setPaginaEscolhida(parseInt(SearchBook.getPaginaAntiga()) + 1) 
    }
}

function ordenacao(elemento){
    // Resetando para 0 todos os datasets de ordem dos outros th
    document.querySelectorAll('th').forEach(th => {
        if (th.dataset.orderby != elemento.dataset.orderby) {
            th.dataset.order = 0            
            th.querySelector('i[data-dir=baixo]').classList.add('d-none')
            th.querySelector('i[data-dir=cima]').classList.add('d-none')
        }
    })
    
    if (elemento.dataset.order == 0) {
        elemento.dataset.order = 1
        elemento.querySelector('i[data-dir=baixo]').classList.add('d-none')
        elemento.querySelector('i[data-dir=cima]').classList.remove('d-none')        

    } else if (elemento.dataset.order == 1) {
        elemento.dataset.order = -1
        elemento.querySelector('i[data-dir=baixo]').classList.remove('d-none')
        elemento.querySelector('i[data-dir=cima]').classList.add('d-none')

    } else if (elemento.dataset.order == -1) {
        elemento.dataset.order = 0
        elemento.querySelector('i[data-dir=baixo]').classList.add('d-none')
        elemento.querySelector('i[data-dir=cima]').classList.add('d-none')
    }

    SearchBook.setOrdenacao(elemento.dataset.orderby, elemento.dataset.order)
    SearchBook.buscar()
}

function perpage_change(elemento){
    SearchBook.setPerpage(elemento.value)
    SearchBook.buscar()
}

SearchBook.buscar()
