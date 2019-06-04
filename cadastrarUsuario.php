<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

$objFuncoes->isLogado();

if (!isset($_SESSION['logado'])) {
    header('location: /' . ROOT . '/listarPessoas.php');
}

if (isset($_POST['btCadastrar'])) {
    if ($objUsuario->queryInsert($_POST) == 'ok') {

        header('location: /' . ROOT . '/listarUsuario.php');
    } else {
        echo '<script type="text/javascript">alert("Erro em cadastrar");</script>';
    }
}

if (isset($_POST['btAlterar'])) {
    //utilizar funcao default
    if ($objUsuario->queryUpdate($_POST) == 'ok') {
        header('location: ?acao=edit&func=' . $objFuncoes->base64($_POST['func'], 1));
    } else {
        echo '<script type="text/javascript">alert("Erro em alterar");</script>';
    }
}

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'edit': $sala = $objUsuario->querySeleciona($_GET['func']);
            break;
    }
}
include 'header.php';
include 'menu.php';
?>



<div><h1 class=""><small>Cadastrar usuário</small></h1></div>

<div id="formulario">
    <form name="formCad" action="" method="post">
        <label>Nome: </label><br>
        <input type="text" id="nome" name="nome" required="required" value="<?= $objFuncoes->tratarCaracter((isset($sala['nome'])) ? ($sala['nome']) : (''), 2) ?>"><br>

        <label>RG: </label><br>
        <input type="text" id="rg" name="rg" required="required" value="<?= isset($sala['rg']) ? ($sala['rg']) : ('') ?>"><br>

        <label>CPF: </label><br>
        <input type="text" name="cpf" id="cpf" class="mask" required="required" value="<?= isset($sala['cpf']) ? ($sala['cpf']) : ('') ?>"><br>

        <label>E-mail: </label><br>
        <input type="mail" name="email" id="email" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?= $objFuncoes->tratarCaracter((isset($sala['email'])) ? ($sala['email']) : (''), 2) ?>"><br>

        <label>Tipo de usuário: </label><br>
        <select name="tipoUsuario" id="tipoUsuario">
            <?php foreach ($objFuncoes->tipoUsuario(2) as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>

        <label>Endereço: </label><br>
        <input type="text" name="endereco" required="required" value="<?= $objFuncoes->tratarCaracter((isset($sala['endereco'])) ? ($sala['endereco']) : (''), 2) ?>"><br>

        <?php if (isset($_GET['acao']) <> 'edit') { ?>
            <label>Senha: </label><br>
            <input type="password" name="senha" required="required"><br>
        <?php } ?>
        <br>
        <input type="submit" name="<?= (isset($_GET['acao']) == 'edit') ? ('btAlterar') : ('btCadastrar') ?>" value="<?= (isset($_GET['acao']) == 'edit') ? ('Alterar') : ('Cadastrar') ?>">

        <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

        <input type="hidden" name="func" value="<?= (isset($sala['idUsuario'])) ? ($objFuncoes->base64($sala['idUsuario'], 1)) : ('') ?>">
    </form>
</div>

<?php include 'footer.php'; ?>