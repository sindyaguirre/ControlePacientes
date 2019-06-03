<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

class Pessoa {

    private $con;
    private $objFuncoes;
    private $idpessoa;
    private $nome;
    private $idtipoPessoa;
    private $dataNascimento;
    private $sexo;
    private $cpf;
    private $dataCadastro;

    /**
     * 
     */
    public function __construct() {
        $this->con = new Conexao();
        $this->objFuncoes = new Funcoes();
    }

    /**
     * 
     * @param type $atributo
     * @param type $valor
     */
    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    /**
     * 
     * @param type $atributo
     * @return type
     */
    public function __get($atributo) {
        return $this->$atributo;
    }

    /**
     * 
     * @param type $dado
     * @return type
     */
    public function querySeleciona($id) {
        try {
            $this->idpessoa = $this->objFuncoes->base64($id, 2);
            $select = $this->con->conectar()->prepare("SELECT * FROM `pessoa` WHERE `idpessoa` = ? ");
            
            $result = $select->execute(array($this->idpessoa));

            // Verifica se a consulta foi realizada com sucesso
            if (!$result) {
                $erro = $select->errorInfo();
                exit($erro[2]);
            }

            // Busca os dados da linha encontrada

            $arrayReturn = array(
                'status' => $status = $result,
                'arrayDados' => ($status == true ? $select->fetch() : ""));
            return $arrayReturn;
        } catch (Exception $ex) {
            return "error " . $ex->getMessage();
        }
    }

    /**
     * 
     * @return type
     */
    public function querySelect() {
        try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `pessoa`;");
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
    public function queryInsert($dados) {

        try {
            $this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->idtipoPessoa = 1; //paciente
            $this->dataNascimento = $dados['dataNascimento'];
            $this->sexo = $dados['sexo'];
            $this->cpf = $dados['cpf'];
            $this->dataCadastro = $this->objFuncoes->dataAtual(2);

            $obj = $this->con->conectar()->prepare(
                    'INSERT INTO pessoa (`nome`, `idtipoPessoa`, `dataNascimento`, `sexo`, `cpf`, `dataCadastro`)'
                    . ' VALUE (:nome, :idtipoPessoa, :dataNascimento, :sexo, :cpf, :dataCadastro);');
            $obj->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $obj->bindParam(":idtipoPessoa", $this->idtipoPessoa, PDO::PARAM_INT);
            $obj->bindParam(":dataNascimento", $this->dataNascimento, PDO::PARAM_STR);
            $obj->bindParam(":sexo", $this->sexo, PDO::PARAM_INT);
            $obj->bindParam(":cpf", $this->cpf, PDO::PARAM_STR);
            $obj->bindParam(":dataCadastro", $this->dataCadastro, PDO::PARAM_STR);

            if ($obj->execute()) {
                return array('status' => true, 'msg' => "Cadastrado com sucesso!");
            } else {
                return array('status' => false, 'msg' => "Algo deu errado!");
            }
        } catch (Exception $ex) {
            return array('status' => false, 'msg' => 'error ' . $ex->getMessage());
        }
    }

    public function queryUpdate($dados) {
        try {
            $this->idpessoa = $this->objFuncoes->base64($dados['func'], 2);
            $this->nome = $dados['nome'];
            $this->dataNascimento = $dados['dataNascimento'];
            $this->sexo = $dados['sexo'];
            $this->cpf = $dados['cpf'];
            $obj = $this->con->conectar()->prepare(
                    "UPDATE `pessoa` SET"
                    . " `nome` = :nome,"
                    . "`dataNascimento` = :dataNascimento "
                    . "`sexo` = :sexo"
                    . "`cpf` = :cpf"
                    . "WHERE `idpessoa` = :idpessoa;");
            $obj->bindParam(":idpessoa", $this->idpessoa, PDO::PARAM_INT);
            $obj->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $obj->bindParam(":dataNascimento", $this->dataNascimento, PDO::PARAM_STR);
            $obj->bindParam(":sexo", $this->sexo, PDO::PARAM_INT);
            $obj->bindParam(":cpf", $this->cpf, PDO::PARAM_INT);

            if ($obj->execute()) {
                return array('status' => true, 'msg' => "Alterado com sucesso!");
            } else {
                return array('status' => false, 'msg' => "Algo deu errado!");
            }
        } catch (Exception $ex) {
            return array('status' => false, 'msg' => 'error ' . $ex->getMessage());
        }
    }

    public function queryDelete($dado) {

        try {

            $this->idpessoa = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `pessoa` WHERE `idpessoa` = :idpess;");
            $cst->bindParam(":idpess", $this->idpessoa, PDO::PARAM_INT);

            if ($cst->execute()) {
                return array('status' => true, 'msg' => "Excluido com sucesso!");
            } else {
                return array('status' => false, 'msg' => "Algo deu errado!");
            }
        } catch (Exception $ex) {
            return array('status' => false, 'msg' => 'error ' . $ex->getMessage());
        }
    }

}
