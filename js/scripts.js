$(function () {
    /*fonte https://www.todoespacoonline.com/w/2014/09/tablesorter-jquery/*/
    // Parser para configurar a data para o formato do Brasil
    $.tablesorter.addParser({
        id: 'datetime',
        is: function (s) {
            return false;
        },
        format: function (s, table) {
            s = s.replace(/\-/g, "/");
            s = s.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/, "$3/$2/$1");
            return $.tablesorter.formatFloat(new Date(s).getTime());
        },
        type: 'numeric'
    });

    $('.tablesorter.tabelaPacientes').tablesorter({
        // Envia os cabeçalhos 
        headers: {
            5: {
                // Desativa a ordenação para essa coluna 
                sorter: false
            },
            4: {
                // Desativa a ordenação para essa coluna 
                sorter: false
            }
        }
    });
    /*
     * 
     */
    $("#cpf").mask("999.999.999-99");
    
    $("a.excluir").click(function (event) {
        /**
         * aqui será utlilizado um ajaxSubmit para esta acao
         */
        return confirm('Deseja realmente excluir este registro?');
    });

    $("table td div[name='lieditar']").click(function (a, b) {

        location.href = '/ControlePacientes/cadastrarPessoa.php?acao=edit&ted=' + this.id;

    });
});