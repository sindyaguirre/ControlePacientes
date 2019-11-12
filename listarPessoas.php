<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Pessoa.class.php';

$objFuncoes = new Funcoes();
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
                header('location: /ControlePacientes/listarPessoas.php');
            }
            break;
    }
}

include 'header.php';
include 'menu.php';
?>

<div><h1 class=""><small><?php echo TITULO; ?></small></h1></div>

<div class="" style="">
    <?php
    if (!isset($pessoa)) { ?>
        <table id="tabelaPacientes" class="table tablesorter table-striped tabelaPacientes">
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
                            <!--td widht="25%"><?php // echo isset($rst['nome']) ? $objFuncoes->tratarCaracter($rst['nome'], 2) : "-"; ?></td-->
                            <td widht="25%"><?php echo isset($rst['nome']) ? $rst['nome'] : "-"; ?></td>
                            <td widht="10%"><?php echo isset($rst['dataNascimento']) ? $objFuncoes->convertData($rst['dataNascimento'], 1) : "-"; ?></td>
                            <td widht="25%"><?php echo isset($rst['cpf']) ? $objFuncoes->mascara($rst['cpf'], "###.###.###-##") : "-"; ?></td>
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
<?php
include 'footer.php';
?>