<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();


$objFuncoes->isLogado();

if (isset($_POST['btCadastrar'])) {
    $arrayResponse = $objUsuario->queryInsert($_POST);
    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';

    if ($arrayResponse['status'] == true) {

        header('location: /' . ROOT . '/listarUsuarios.php');
    }
}

if (isset($_POST['btAlterar'])) {
    //utilizar funcao default
    $arrayResponse = $objUsuario->queryUpdate($_POST);
    unset($usuario);
    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';
    if ($arrayResponse['status'] == true) {
        header('location: /' . ROOT . '/listarUsuarios.php');
    }
}

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'edit':
            $id = isset($_GET['ted']) ? $_GET['ted'] : "0";
            $arrayReturn = $objUsuario->querySeleciona($id);
            $usuario = $arrayReturn['arrayDados'];

            break;
    }
}

include 'header.php';
include 'menu.php';
?>

<div><h1 class=""><small><?php echo TITULO_USUARIO; ?></small></h1></div>

<div id="formulario">

    <form id="formCadastro" name="formCadastro" action="" method="post">
        <div class="container">
            <div class="">

                <label>Nome: </label><br>
                <input type="text" id="nome" name="nome" required="required" value="<?= isset($usuario['nome']) ? $usuario['nome'] : "" ?>"><br>

                <label>E-mail: </label><br>
                <input type="text" id="email" name="email" required="required" value="<?= isset($usuario['email']) ? $usuario['email'] : "" ?>"><br>

                <label>Tipo de Usuário: </label><br>
                <select name="tipoUsuario" id="tipoUsuario">
                    <?php
                    foreach ($objFuncoes->tipoUsuario(2) as $key => $value) {
                        $selected = isset($usuario['tipoUsuario']) && $usuario['tipoUsuario'] == $key ? "selected='true'" : false;
                        ?>
                        <option <?= $selected ?> value="<?= $key ?>"><?= $value ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="">

                <input type="submit" name="<?= (isset($_GET['acao']) == 'edit') ? ('btAlterar') : ('btCadastrar') ?>" value="<?= (isset($_GET['acao']) == 'edit') ? ('Alterar') : ('Cadastrar') ?>">
                <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

                <input type="hidden" id="idpessoa" name="func" value="<?= (isset($usuario['idpessoa'])) ? ($objFuncoes->base64($usuario['idpessoa'], 1)) : ('') ?>">
            </div>
        </div>
    </form>
</div>

<?php
include 'footer.php';
?>