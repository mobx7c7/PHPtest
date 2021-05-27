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
        <div class='modal fade' id='modalMensagem' tabindex='-1' role='dialog' aria-labelledby='modalMensagemLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'></h5>
                        <button type='button' class='btn btn-primary close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>OK</button>
                    </div>
                </div>
            </div>
        </div>
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
                                        <input type='text' class='form-control' id='i_cep' name='i_cep' placeholder='Digite um CEP' onkeypress='aplicarMascaraCEP(this)' maxlength='9'>
                                        <div class='input-group-append'>
                                            <button class='btn btn-block btn-primary' type='button' id='btn_buscar' onclick='fazerPesquisa(this)'>Buscar</button>
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
        function aplicarMascara(e, formato) {
            var i = e.value.length;
            var saida = formato.substring(1, 0);
            var texto = formato.substring(i)
            if (texto.substring(0, 1) != saida)
                e.value += texto.substring(0, 1);
        }
        function aplicarMascaraCEP(e)
        {
            aplicarMascara(e, '#####-###');
        }
        function usarStringOuNenhum(str)
        {
            return str ? str : '(nenhum)';
        }
        function carregarPropsNosCampos(props) {
            document.getElementById('i_logradouro')
                .value = props['logradouro'];
            document.getElementById('i_complemento')
                .value = usarStringOuNenhum(props['complemento']);
            document.getElementById('i_bairro')
                .value = props['bairro'];
            document.getElementById('i_localidade')
                .value = props['localidade'];
            document.getElementById('i_uf')
                .value = props['uf'];
        }
        function limparCampos(text = '')
        {
            document.getElementById('i_logradouro')
                .value = text;
            document.getElementById('i_complemento')
                .value = text;
            document.getElementById('i_bairro')
                .value = text;
            document.getElementById('i_localidade')
                .value = text;
            document.getElementById('i_uf')
                .value = text;
        }
        function desabilitarEntradas(valor)
        {
            document.getElementById('btn_buscar')
                .disabled = valor;
            document.getElementById('i_cep')
                .readOnly = valor;
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
        function mostrarModal(titulo, mensagem, onHiddenCb)
        {
            var modal = $('#modalMensagem');
            modal.on('hidden.bs.modal', onHiddenCb);
            modal.find('.modal-title').text(titulo);
            modal.find('.modal-body').text(mensagem);
            modal.modal('show');
            modal.modal({backdrop: 'static', keyboard: false});
        }
        function mostrarModalErro(mensagem, onHiddenCb)
        {
            mostrarModal('Erro', mensagem, onHiddenCb);
        }
        function mostrarModalAviso(mensagem, onHiddenCb)
        {
            mostrarModal('Aviso', mensagem, onHiddenCb);
        }
        function fazerPesquisa(e) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 1) { // open()
                    limparCampos();
                    desabilitarEntradas(true);
                }
                if (this.readyState == 4) { // Done
                    desabilitarEntradas(false);
                    console.log('Resposta da consulta: \n' + this.responseText);
                    switch (this.status) {
                        case 200: // Ok
                            var props = extrairPropsDeXML(this.responseXML);
                            if(props.erro === undefined){
                                carregarPropsNosCampos(props);
                            }else{
                                mostrarModalErro('Este CEP não existe');
                            }
                            break;
                        case 400: // Bad Request
                            mostrarModalErro('Este CEP não está digitado corretamente');
                            break;
                        case 500: // Internal Error
                            mostrarModalErro('Ocorreu um erro interno');
                            break;
                        default:
                            mostrarModalErro('Ocorreu outra coisa com código ' + this.status);
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
