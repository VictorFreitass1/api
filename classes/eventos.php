<?php 

class Eventos{
private $id;
private $nome;          
private $data;           
private $capacidade;
private $usuarios_id;      
private $ativo;
// Declarando métodos de acesso (Getters e Setters)
public function getId(){return $this->id;}
public function getNome(){return $this->nome;}
public function getData(){return $this->data;}
public function getCapacidade(){return $this->capacidade;}
public function getUsuariosId(){return $this->usuarios_id;}
public function getAtivo(){return $this->ativo;}


public function setId($value){$this->id = $value;}
public function setNome($value){$this->nome = $value;}
public function setData($value){$this->data = $value;}
public function setCapacidade($value){$this->capacidade = $value;}
public function setUsuariosId($value){$this->usuarios_id = $value;}
public function setAtivo($value){$this->ativo;}

public function loadById($_id){
    $sql = new Sql ();
    $result = $sql->select("SELECT * FROM usuarios WHERE id = :id", array (':id'=>$_id));
    if(count($results)>0){
        $this->setData($results[0]);
    }
}
public function setData($dados){
    $this->setId($dados['id']);
    $this->setNome($dados['nome']);
    $this->setData($dados['data']);
    $this->setCapacidade($dados['capacidade']);
    $this->setUsuariosId($dados['usuarios_id']);
    $this->setAtivo($dados['ativo']);
}
public static function getList(){
    $sql = new Sql();
    return $sql->select("SELECT * FROM eventos ORDER BY nome");
}
public function insert(){
    $sql = new Sql();
    $sql = $sql->select("CALL sp_event_insert(:nome, :data, :usuarios_id)",
    array(
        ":nome"=>$this->getNome(),
        ":data"=>$this->getData(),
        ":usuarios_id"=>$this->usuarios_id()
    ));
    if (count($res)>0){
        $this->setData($res[0]);
    }
}

}
?>