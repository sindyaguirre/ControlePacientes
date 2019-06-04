<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';
require_once 'classes/Pessoa.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();
$objPessoa = new Pessoa();


$objFuncoes->isLogado();

if (isset($_POST['btCadastrar'])) {
    $arrayResponse = $objPessoa->queryInsert($_POST);
    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';

    if ($arrayResponse['status'] == true) {

        header('location: /' . ROOT . '/home.php');
    }
}

if (isset($_POST['btAlterar'])) {
    //utilizar funcao default
    $arrayResponse = $objPessoa->queryUpdate($_POST);
    unset($pessoa);
    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';
    if ($arrayResponse['status'] == true) {
        header('location: ?acao=edit&ted=' . $objFuncoes->base64($_POST['idpessoa'], 1));
    }
}

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {

        case 'edit':
            $arrayReturn = $objPessoa->querySeleciona($_GET['ted']);
            $pessoa = $arrayReturn['arrayDados'];

            break;
        case 'delet':

            $arrayResponse = $objPessoa->queryDelete($_GET['ted']);

            if ($arrayResponse['status'] == true) {
                echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';
                header('location: /ControlePacientes/home.php');
            }
            break;
    }
}

include 'header.php';
include 'menu.php';
?>
<script>
    $(document).ready(function () {

        if ($("#idpessoa").val()) {
            $("#formCadastro").css("display", 'inline');
        }
        $("button#cadastar").click(function (event) {
            $("#formCadastro").css("display", 'inline');

            //$("#formCadastro").css("display", 'inline');
        });

        $("button#fecharCadastro").click(function (event) {
            $("#formCadastro").css("display", 'none');
        });

        $("a.excluir").click(function (event) {
            return confirm('Deseja realmente excluir este registro?');
        });

        $("table td div[name='lieditar']").click(function (a, b) {


            location.href = '/ControlePacientes/home.php?acao=edit&ted=' + this.id;

        });
    });
</script>

<div><h1 class=""><small><?php echo TITULO; ?></small></h1></div>
<p>
    <button type="button" class="btn btn-primary" name="cadastrar" id="cadastar">Novo paciente</button>
    <button type="button" class="btn btn-info" name="fecharCadastro" id="fecharCadastro">Fechar Formulário</button>
</p>

<div id="formulario">

    <form id="formCadastro" name="formCadastro" action="" method="post" style="display: none;">
        <div class="container">
            <div class="">

                <label>Nome: </label><br>
                <input type="text" id="nome" name="nome" required="required" value="<?= isset($pessoa['nome']) ? $objFuncoes->tratarCaracter($pessoa['nome'], 2) : "" ?>"><br>

                <label>CPF: </label><br>
                <input type="text" id="cpf" name="cpf" required="required" value="<?= isset($pessoa['cpf']) ? $pessoa['cpf'] : "" ?>"><br>

                <label>Data nascimento: </label><br>
                <input type="date" id="dataNascimento" name="dataNascimento" required="required" value="<?= isset($pessoa['dataNascimento']) ? $pessoa['dataNascimento']: "" ?>"><br>

                <label>Sexo: </label><br>
                <select name="sexo" id="idsexo">
                    <?php
                    foreach ($objFuncoes->listarSexo(2) as $key => $value) {
                        $selected = isset($pessoa['sexo']) && $pessoa['sexo'] == $key ? "selected='true'" : false;
                        ?>
                        <option <?= $selected ?> value="<?= $key ?>"><?= $value ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="">

                <input type="submit" name="<?= (isset($_GET['acao']) == 'edit') ? ('btAlterar') : ('btCadastrar') ?>" value="<?= (isset($_GET['acao']) == 'edit') ? ('Alterar') : ('Cadastrar') ?>">
                <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

                <input type="hidden" id="idpessoa" name="func" value="<?= (isset($pessoa['idpessoa'])) ? ($objFuncoes->base64($pessoa['idpessoa'], 1)) : ('') ?>">
            </div>
        </div>
    </form>
</div>

<div class="" style="">
    <?php
    if (!isset($pessoa)) { ?>
        <table id="tabelaReservas" class="table tablesorter table-striped tabelaPacientes">
            <thead>
                <tr>
                    <th scope="col">Cod</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
                    foreach ($objPessoa->querySelect() as $rst) {
                        ?>
                        <tr>
                            <td widht="20%" scope='row' ><?php echo isset($rst['idpessoa']) ? $rst['idpessoa'] : "-"; ?></td>
                            <td widht="25%"><?php echo isset($rst['nome']) ? $objFuncoes->tratarCaracter($rst['nome'], 2) : "-"; ?></td>
                            <td widht="10%"><?php echo isset($rst['dataNascimento']) ? $rst['dataNascimento'] : "-"; ?></td>
                            <td widht="25%"><?php echo isset($rst['cpf']) ? $rst['cpf'] : "-"; ?></td>
                            <td widht="20%">
                                <div class="liacoes">
                                    <div name="lieditar" id="<?= isset($rst['idpessoa']) ? $objFuncoes->base64($rst['idpessoa'], 1) : "" ?>" >
                                        <a class="editar" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a></div>
                                        <!--<a class="editar" href="?acao=edit&ted=" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a>-->
                                    <a class="excluir" href="?acao=delet&ted=<?= isset($rst['idpessoa']) ? $objFuncoes->base64($rst['idpessoa'], 1) : "" ?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
</div>
