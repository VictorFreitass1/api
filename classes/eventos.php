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
    $results = $sql->select("SELECT * FROM eventos WHERE id = :id", array (':id'=>$_id));
    if(count($results)>0){
        $this->setData($results[0]);
    }
}
public function setDate($dados){
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
public static function search($_nome){
    $sql = new Sql();
    return $sql->select("SELECT * FROM eventos WHERE nome LIKE :nome",
        array(":nome"=>"%".$_nome."%"));
}
public function insert(){
    $sql = new Sql();
    $res = $sql->select("CALL sp_event_insert(:nome, :data, :capacidade, :usuarios_id)",
    array(
        ":nome"=>$this->getNome(),
        ":data"=>$this->getData(),
        ":capacidade"=>$this->getCapacidade(),
        ":usuarios_id"=>$this->getUsuariosId()
    ));
    if(count($res)>0){
        $this->setId($res[0]['id']);
    }
}
public function update() : bool{
    $sql = new Sql();
    $res = $sql->query("UPDATE eventos SET nome= :nome, data= :data, capacidade = :capacidade,
    usuarios_id = :usuarios_id WHERE id = :id",
    array(
        ":nome"=>$this->getNome(),
        ":id"=>$this->getId(),
        ":data"==$this->getData(),
        ":capacidade"=>$this->getCapacidade(),
        ":usuarios_id"=>$this->getUsuariosId()
    ));
    if($res){
        return true; 
    }else{
        return false;
    }
}
public function delete($_id){
    $sql = new Sql();
    $res = $sql->querySql("UPDATE eventos set avito = 0 WHERE id = :id",array(":id"=>$_id));
    return $res;
}
public function ativar(){
    $sql = new Sql();
    $sql->querySql("UPDATE eventos set ativo = 1 WHERE id = :id",array(":id"=>$this->getId()));
}
}
?>