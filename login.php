<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

if (isset($_POST['login'])) {
    
    if ($objUsuario->login($_POST) == true) {
       
        header('location: /' . ROOT . '/listarPessoas.php');
    } else {
        if (isset($_SESSION['logado']) && $_SESSION['logado']==false) {
            echo '<script type="text/javascript">alert("'.$_SESSION['login_erro'].'");</script>';
        } else {
            echo '<script type="text/javascript">alert("Ops! Algo deu errado!");</script>';
        }
    }
}
include 'header.php';

?>

<body>
        <div id="login">
            <form name="formLogin" id="formLogin" action="" method="post">
                <div class="container">
                    <div class="wrap login">
                        <div><h1 class=""><small><?php echo TITULO; ?></small></h1></div>

                        <label>Usuário: </label>
                        <input type="text" name="usuario" id="usuario" required="required" value="" ><br>

                        <label>Senha: </label>
                        <input type="password" name="senha" required="required"><br>

                        <input type="submit" name="login" value="Logar">
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
