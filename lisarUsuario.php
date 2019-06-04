<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

$objFuncoes->isLogado();

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'edit': $sala = $objUsuario->querySeleciona($_GET['func']);
            break;
        case 'delet':
            if ($objUsuario->queryDelete($_GET['func']) == 'ok') {
                headerheader('location: /' . ROOT . '/listarUsuario.php');
            } else {
                echo '<script type="text/javascript">alert("Erro em deletar");</script>';
            }
            break;
    }
}

include 'header.php';
include 'menu.php';
?>

    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($objUsuario->querySelect() as $rst) {
                    ?>
                    <tr>

                        <th scope="row"><?php echo $rst['idusuario']; ?></th>
                        <td><?php echo $objFuncoes->tratarCaracter($rst['nome'], 2); ?></td>
                        <td><?php echo $rst['email']; ?></td>
                        <td>
                            <div class="">
                                <a class="editar" href="?acao=edit&func=<?= $objFuncoes->base64($rst['idusuario'], 1) ?>" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a>
                                <a class="excluir" href="?acao=delet&func=<?= $objFuncoes->base64($rst['idusuario'], 1) ?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a>
                            </div>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
<?php include 'footer.php'; ?>