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

        header('location: /' . ROOT . '/listarPessoas.php');
    }
}

if (isset($_POST['btAlterar'])) {
    //utilizar funcao default
    $arrayResponse = $objPessoa->queryUpdate($_POST);
    unset($pessoa);
    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';
    if ($arrayResponse['status'] == true) {
        header('location: /' . ROOT . '/listarPessoas.php');
    }
}

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'edit':
            $id = isset($_GET['ted']) ? $_GET['ted'] : "0";
            $arrayReturn = $objPessoa->querySeleciona($id);
            $pessoa = $arrayReturn['arrayDados'];

            break;
    }
}

include 'header.php';
include 'menu.php';
?>

<div><h1 class=""><small><?php echo TITULO; ?></small></h1></div>

<div id="formulario">

    <form id="formCadastro" name="formCadastro" action="" method="post">
        <div class="container">
            <div class="">

                <label>Nome: </label><br>
                <input type="text" id="nome" name="nome" required="required" value="<?= isset($pessoa['nome']) ? $objFuncoes->tratarCaracter($pessoa['nome'], 2) : "" ?>"><br>

                <label>CPF: </label><br>
                <input type="text" id="cpf" name="cpf" required="required" value="<?= isset($pessoa['cpf']) ? $pessoa['cpf'] : "" ?>"><br>

                <label>Data nascimento: </label><br>
                <input type="date" id="dataNascimento" name="dataNascimento" required="required" value="<?= isset($pessoa['dataNascimento']) ? $pessoa['dataNascimento'] : "" ?>"><br>

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

<?php
include 'footer.php';
?>