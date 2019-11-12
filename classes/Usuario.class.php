<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

class Usuario {

    private $con;
    private $objFuncoes;
    private $idusuario;
    private $nome;
    private $usuario;
    private $email;
    private $tipoUsuario;
    private $senha;
    private $dataCadastro;

    public function __construct()
    {
        $this->con = new Conexao();
        $this->objFuncoes = new Funcoes();
    }

    /**
     * 
     * @param type $atributo
     * @param type $valor
     */
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    /**
     * 
     * @param type $atributo
     * @return type
     */
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    /**
     * 
     * @param type $dado
     * @return type
     */
    public function querySeleciona($dado){
        try {
            $this->idusuario = (int) $this->objFuncoes->base64($dado, 2);

            $select = $this->con->conectar()->prepare("SELECT * FROM `usuario` WHERE `idusuario` = ?");
            $result = $select->execute(array($this->idusuario));

            //verificando se a consulta foi feita com sucesso
            if (!$result)
            {
                $erro = $select->select->errorInfo();
                exit($erro[2]);
            }
            //buscando os dados na linha encontrada
            $arrayReturn = array(
                'status' => $status = $result,
                'arrayDados' => ( $status == true ? $select->fetch() : "")
            );
            return $arrayReturn;
        } catch (Exception $ex) {
            return "error " . $ex->getMessage();
        }
    }

    /**
     * 
     * @return type
     */
    public function querySelect()
    {
       try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `usuario`;");
            $select->execute();
            return $select->fetchAll();
        } catch (Exception $ex) {
            return 'erro ' . $ex->getMessage();
        }
    }

    /**
     * 
     * @param type $dados
     * @return string
     */
    public function queryInsert($dados)
    {
        try {
//            $this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->nome = $dados['nome'];
            $this->email = $dados['email'];
            $this->usuario = $dados['usuario'];
            $this->tipoUsuario = $dados['tipoUsuario'];
            $this->senha = md5($dados['senha']);
            $this->dataCadastro = $this->objFuncoes->dataAtual(2);

            $cad = $this->con->conectar()->prepare(
                    'INSERT INTO usuario (`nome`, `usuario`,`email`,`tipoUsuario`,`senha`,`dataCadastro`)'
                    . ' VALUE (:nome, :usuario, :email, :tipoUsuario, :senha, :dt);');
            $cad->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $cad->bindParam(":usuario", $this->usuario, PDO::PARAM_STR);
            $cad->bindParam(":email", $this->email, PDO::PARAM_STR);
            $cad->bindParam(":tipoUsuario", $this->tipoUsuario, PDO::PARAM_INT);
            $cad->bindParam(":senha", $this->senha, PDO::PARAM_STR);
            $cad->bindParam(":dt", $this->dataCadastro, PDO::PARAM_STR);

            if ($cad->execute())
            {
                return 'ok';
            }
            else
            {
                return 'erro';
            }
        } catch (Exception $ex) {
            return 'error ' . $ex->getMessage();
        }
    }

    public function queryUpdate($dados)
    {
        try {
            $this->idusuario = $dados['idusuario'];
            $this->nome = $dados['nome'];
//            $this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->usuario = $dados['usuario'];
            $this->email = $dados['email'];
            $this->tipoUsuario = $dados['tipoUsuario'];
            $cst = $this->con->conectar()->prepare("UPDATE `usuario` SET `nome` = :nome,`usuario` = :usuario, `tipoUsuario` = :tipoUsuario,`email` = :email WHERE `idusuario` = :idusu;");
            $cst->bindParam(":idusu", $this->idusuario, PDO::PARAM_INT);
            $cst->bindParam(":usuario", $this->usuario, PDO::PARAM_STR);
            $cst->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $cst->bindParam(":email", $this->email, PDO::PARAM_STR);
            $cst->bindParam(":tipoUsuario", $this->tipoUsuario, PDO::PARAM_INT);
            if ($cst->execute())
            {
                return 'ok';
            }
            else
            {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error ' . $ex->getMessage();
        }
    }

    public function queryDelete($dado)
    {

        try {
            $this->idusuario = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `usuario` WHERE `idusuario` = :idusu;");
            $cst->bindParam(":idusu", $this->idusuario, PDO::PARAM_INT);
            if ($cst->execute())
            {
                return 'ok';
            }
            else
            {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error' . $ex->getMessage();
        }
    }

    public function login($dados)
    {
        try {

            $this->usuario = $dados['usuario'];
            $this->senha = $dados['senha'];
            $select = $this->con->conectar()->prepare("SELECT * FROM `usuario` WHERE `usuario` = ? ");
            $result = $select->execute(array($this->usuario));

            // Verifica se a consulta foi realizada com sucesso
            if (!$result)
            {
                $erro = $select->errorInfo();
                exit($erro[2]);
            }

            // Busca os dados da linha encontrada
            $usuario = $select->fetch();

            if ($usuario['senha'] === $this->objFuncoes->encript_senha($this->senha))
            {
                $_SESSION['logado'] = true;
                $_SESSION['nomeUsuario'] = $usuario['nome'];
                $_SESSION['tipoUsuario'] = $usuario['tipoUsuario'];
                $_SESSION['idusuario'] = $usuario['idusuario'];
            }
            else
            {
                $_SESSION['logado'] = false;
                // Preenche o erro para o usuário
                $_SESSION['login_erro'] = 'Usuário ou senha inválidos';
            }
            return $_SESSION['logado'];
        } catch (Exception $ex) {

            $_SESSION['logado'] = false;
            $_SESSION['login_erro'] = $ex->getMessage();

            return "error " . $ex->getMessage();
        }
    }

}
