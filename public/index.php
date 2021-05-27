<html lang='pt-br'>
<head>
    <title>Buscador de Endereço</title>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</head>
<body class='bg-light'>
    <div class='container-fluid'>
        <div class='container'>
            <div class='row h-100'>
                <div class='col my-auto'>
                    <form>
                        <div class='rounded-lg border shadow p-4'>
                            <h1 class='display-3 text-center py-5'>
                                Buscador de Endereço
                            </h1>
                            <hr>
                            <div class='row'>
                                <div class='form-group col'>
                                    <label for='i_cep'>CEP</label>
                                    <div class='input-group'>
                                        <input type='text' class='form-control' id='i_cep' name='i_cep' value='01001000' placeholder='Digite um CEP'>
                                        <div class='input-group-append'>
                                            <button class='btn btn-block btn-primary' type='button' onclick='fazerPesquisa(this)'>Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-lg-8'>
                                    <div class='form-group'>
                                        <label for='i_logradouro'>Logradouro</label>
                                        <input class='form-control' type='text' id='i_logradouro' name='logradouro' readonly>
                                    </div>
                                </div>
                                <div class=' col-lg-4'>
                                    <div class='form-group'>
                                        <label for='i_complemento'>Complemento</label>
                                        <input class='form-control' type='text' id='i_complemento' name='complemento' readonly>
                                    </div>
                                </div>
                                <div class='col-lg-4'>
                                    <div class='form-group'>
                                        <label for='i_bairro'>Bairro</label>
                                        <input class='form-control' type='text' id='i_bairro' name='bairro' readonly>
                                    </div>
                                </div>
                                <div class='col-lg-4'>
                                    <div class='form-group'>
                                        <label for='i_localidade'>Localidade</label>
                                        <input class='form-control' type='text' id='i_localidade' name='localidade' readonly>
                                    </div>
                                </div>
                                <div class=' col-lg-4'>
                                    <div class='form-group'>
                                        <label for='i_uf'>UF</label>
                                        <input class='form-control' type='text' id='i_uf' name='uf' readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function preencherCampos(props) {
            document.getElementById('i_logradouro')
                .value = props['logradouro'];
            document.getElementById('i_complemento')
                .value = props['complemento'];
            document.getElementById('i_bairro')
                .value = props['bairro'];
            document.getElementById('i_localidade')
                .value = props['localidade'];
            document.getElementById('i_uf')
                .value = props['uf'];
        }
        function limparCampos()
        {
            document.getElementById('i_logradouro')
                .value = '';
            document.getElementById('i_complemento')
                .value = '';
            document.getElementById('i_bairro')
                .value = '';
            document.getElementById('i_localidade')
                .value = '';
            document.getElementById('i_uf')
                .value = '';
        }
        function extrairPropsDeXML(xml) {
            var data = {};
            var nodes = xml.documentElement.children;
            for (i = 0; i < nodes.length; i++) {
                var c = nodes[i];
                if(c.nodeType === 1) { // Element
                    data[c.nodeName] =  c.firstChild ? c.firstChild.nodeValue : '';
                }
            }
            return data;
        }
        function mostrarModalAviso($mensagem)
        {
            //TODO: Modal de aviso
            alert($mensagem);
        }
        function fazerPesquisa(e) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 1) { // open()
                    e.disabled = true;
                    limparCampos();
                }
                if (this.readyState == 4) { // Done
                    e.disabled = false;
                    console.log('Resposta da consulta: \n' + this.responseText);
                    switch (this.status) {
                        case 200: // Ok
                            var props = extrairPropsDeXML(this.responseXML);
                            if(props.erro === undefined){
                                preencherCampos(props);
                            }else{
                                mostrarModalAviso('Ish... Este CEP não existe');
                            }
                            break;
                        case 400: // Bad Request
                            mostrarModalAviso('Ish... Este CEP não está digitado corretamente');
                            break;
                        case 500: // Internal Error
                            mostrarModalAviso('Ish... Ocorreu um erro interno');
                            break;
                        default:
                            mostrarModalAviso('Ish... Ocorreu outra coisa com código ' + this.status);
                            break;
                    }
                }
            };

            var elCampoCep = document.getElementById('i_cep');

            if(elCampoCep.value === ''){
                mostrarModalAviso('Você precisa informar um CEP válido para prosseguir com a busca');
            }else{
                xhr.open('GET', 'api/buscar.php?cep=' + elCampoCep.value, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>
