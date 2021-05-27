<html lang='en'>
<head>
    <title>Buscador de CEP</title>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</head>

<body>
    <h1>Buscador de CEP</h1>
    <form>
        <label for="i_cep">CEP:</label><br>
        <input type="text" id="i_cep" name="i_cep" value='01001000'><br>
        <br>
        <label for='i_logradouro'>Logradouro:</label><br>
        <input type='text' id='i_logradouro' name='logradouro' readonly><br>
        <label for='i_complemento'>Complemento:</label><br>
        <input type='text' id='i_complemento' name='complemento' readonly><br>
        <label for='i_bairro'>Bairro:</label><br>
        <input type='text' id='i_bairro' name='bairro' readonly><br>
        <label for='i_localidade'>Localidade:</label><br>
        <input type='text' id='i_localidade' name='localidade' readonly><br>
        <label for='i_uf'>Uf:</label><br>
        <input type='text' id='i_uf' name='uf' readonly><br>
        <br>
        <input type="submit" value="Buscar" onclick="fazerPesquisa(this)">
    </form>
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
        function fazerPesquisa(e) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 1) { // open()
                    e.disabled = true;
                }
                if (this.readyState == 4) { // Done
                    e.disabled = false;
                    console.log('Resposta da consulta: \n' + this.responseText);
                    switch (this.status) {
                        case 200: // Ok
                            preencherCampos(extrairPropsDeXML(this.responseXML));
                            break;
                        case 400: // Bad Request
                            alert('Ish... este CEP não existe');
                            break;
                        case 500: // Internal Error
                            alert('Ish... ocorreu um erro interno');
                            break;
                        default:
                            alert('Ish... ocorreu outra coisa com código ' + this.status);
                            break;
                    }
                }
            };
            
            var elCampoCep = document.getElementById('i_cep');
            
            //Nota: Ocorre erro de CORS
            //xhr.open('GET', 'https://viacep.com.br/ws/'+elCampoCep.value+'/xml', true);

            xhr.open('GET', 'api/buscar.php?cep=' + elCampoCep.value, true);
            xhr.send();
        }
    </script>
</body>

</html>
</body>

</html>
