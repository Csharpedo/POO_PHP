<?php

include('conexao/conexao.php');

$db = new Database();

class Crud{
    private $conn;
    private $table_name = "bandas";

    public function __construct($db){
        $this->conn = $db;
    }

    //funcao para criar registros
    public function create($postValues){
        $nome_banda = $postValues['nome_banda'];
        $genero = $postValues['genero'];
        $gravadora = $postValues['gravadora'];
        $num_discos = $postValues['num_discos'];
        $qtda_albuns = $postValues['qtda_albuns'];

        $query = "INSERT INTO ".$this->table_name . "(nome_banda,genero,gravadora,num_discos,qtda_albuns) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$nome_banda);
        $stmt->bindParam(2,$genero);
        $stmt->bindParam(3,$gravadora);
        $stmt->bindParam(4,$num_discos);
        $stmt->bindParam(5,$qtda_albuns);
        
        if($stmt->execute()){
            return True;
        }else {
            return False;
        }
    }

    //funcao para ler registros 
    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
        }

    //funcao para atualizar os registros
    public function update($postValues){
        $id = $postValues['Id']
        $nome_banda = $postValues['nome_banda'];
        $genero = $postValues['genero'];
        $gravadora = $postValues['gravadora'];
        $num_discos = $postValues['num_discos'];
        $qtda_albuns = $postValues['qtda_albuns'];

        if(empty($id) || empty($nome_banda) || empty($genero) || empty($num_discos) || empty($gravadora) || (empty($num_discos) || (empty($qtda_albuns)){
            return false;
        }                                                                                                                                            


        $query = "UPDATE ". $this->table_name . "SET nome_banda = ?, genero = ?, gavadora = ?, num_discos = ?, qtda_albuns = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        $stmt->bindParam(2,$nome_banda);
        $stmt->bindParam(3,$genero);
        $stmt->bindParam(4,$gravadora);
        $stmt->bindParam(5,$num_discos);
        $stmt->bindParam(6,$qtda_albuns);

        if($stmt->execute()){
            return True;
        }else {
            return False;
        }
    }
    //funcao para pegar os registros do bando e colocar no formulario html
    public function readOne($id) {
        $query = "SELECT * FROM" . $this->table_name . "WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //funcao para deletar registros
    public function delete($id){
        $query = "DELETE FROM ". $this->table_name . " WHERe id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        if($stmt->execute()){
            return True;
        }else{
            return False;
        }
    }
}