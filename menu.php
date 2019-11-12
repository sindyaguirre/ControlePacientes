<!--navbar-->
<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <!--.btn-navbar estaclasse é usada como alteranador para o contepudo colapsave-->
            <button class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="home.php"> | Home </a></li>
                    <?= $objFuncoes->permissao(2) ? '<li><a href="listarPessoas.php"> | Listar pessoas </a></li>' : "" ?>
                    <?= $objFuncoes->permissao(1) ? '<li> <a href="cadastrarPessoa.php"> | Novo paciente </a></li>' : "" ?>
                    <?= $objFuncoes->permissao(1) ? '<li><a href="cadastrarUsuario.php"> | Novo Usuario </a></li>' : "" ?>
                    <?= $objFuncoes->permissao(1) ? '<li><a href="listarUsuarios.php"> | Listar Usuários </a></li>' : "" ?>
                    <li><a href="logout.php"> | Logout | </a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
