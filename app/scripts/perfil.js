
function  CarregaDadosMeu() {
    
    var dados = $.getJSON('/labmarcas/api/perfis' , dados);
    alert ('FEITO');
    return dados;

}


function carregaDados(){
    $.getJSON('/labmarcas/api/perfis.php' , function(dados) { 
        for (var i = 0; i < dados.length; i++) {
            var tr = $('<tr/>');
            $(tr).append("<td>" + dados[i].idperfil + "</td>");
            $(tr).append("<td>" + dados[i].descricao + "</td>");
            $(tr).append("<td><input type='button' value='Editar' onclick='carregaPerfilv2(" + dados[i].id_perfil + ");'><input type='button' value='Excluir' onclick='delete(" + dados[i].id_perfil + ");'></td>");
            $('.tbConsulta').append(tr);
        }
    });
}

function carregaPerfilv2(id) {
    window.location.href = '/labmarcas/app/edita_perfil/';

    const URL = "/labmarcas/api/perfil/" + id;

    async function getDataFromApi(URL) {
        const response = await fetch(URL);
        var data = await response.json();
        console.log(data.descricao);
    }

    getDataFromApi(URL);
}


function carregaPerfil(id){
    //window.location.href = '/vendas/app/edita_perfil/';

    $.getJSON('/labmarcas/api/perfil/' + id , function(dados) { 
        for (var i = 0; i < dados.length; i++) {
            $("#txtId").val(dados.id_perfil);
            $("#txtDescricao").val(dados.descricao);
        }
    });
}


function save(){    
    request = $.ajax({
            type : "POST",  //type of method
            url  : "/labmarcas/api/perfis/",  //your page
            data : { id : 0,
                     descricao : document.getElementById("txtDescricao").value }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        window.location.href = '/labmarcas/app/lista_perfis/';
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
}

function update(id){    
    request = $.ajax({
            type : "UPDATE",  //type of method
            url  : "/labmarcas/api/perfis/",  //your page
            data : { id : id,
                     descricao : document.getElementById("txtDescricao").value }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        window.location.href = '/labmarcas/app/lista_perfis/';
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
}

function update(id){    
    request = $.ajax({
            type : "DELETE",  //type of method
            url  : "/labmarcas/api/perfis/",  //your page
            data : { id : id }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        window.location.href = '/labmarcas/app/lista_perfis/';
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
}