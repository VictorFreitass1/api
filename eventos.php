<?php 
    // Api - Aplicação para recursos de app mobile
    include_once('conn.php');

    // Variável que recebe o conteúdo da requisição do APP decodificando-a (json)
    $postjson = json_decode(file_get_contents('php://input',true),true);

if ($postjson['requisicao']=='add') {
    $query = $pdo->prepare("insert into eventos set nome= :nome, data=:data, capacidade=:capacidade, ativo=:ativo, usuarios_id=:usuarios_id");
    $query->bindValue(":nome", $postjson['nome']);
    $query->bindValue(":data", $postjson['data']);
    $query->bindValue(":capacidade", $postjson['capacidade']);
    $query->bindValue(":ativo", $postjson['ativo']);
    $query->bindValue(":usuarios_id", $postjson['usuarios_id']);
    $query->execute();
    $id = $pdo->lastInsertId();

    if ($query) {
        $result = json_encode(array('success'=>true,'id'=>$id));
    }else{
        $result = json_encode(array('success'=>false,'msg'=>'Falha ao inserir o evento'));
    }
    echo $result;
}// Final requisição add

if ($postjson['requisicao']=='desativar'){
    $query = $pdo->prepare("update eventos set ativo=0");
    $query->bindValue(":ativo", $postjson ['ativo']);
    $query->execute();
    if ($query) {
        $result = json_encode(array('success'=>true,'id'=>$id));
    }else{
        $result = json_encode(array('success'=>false,'msg'=>'Falha ao desativar o evento'));
    }
    echo $result;
}

else if ($postjson['requisicao']=='listar') {
    if($postjson['nome']==''){
        $query = $pdo->query("SELECT * FROM eventos order BY id desc limit " .$postjson['start']. "," .$postjson['limit']);
    }else{
        $busca = '%'.$postjson['nome'].'%';
        $query = $pdo->query("SELECT * FROM eventos WHERE nome LIKE '$busca' or capacidade LIKE '$busca' order BY id desc limit " .$postjson['start']. "," .$postjson ['limit']);
    }
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    for($i=0;$i < count($res);$i++){
        $dados [] = array(
            'id'                =>$res[$i]['id'],
            'nome'              =>$res[$i]['nome'],
            'data'              =>$res[$i]['data'],
            'capacidade'        =>$res[$i]['capacidade'],
            'ativo'             =>$res[$i]['ativo'],
            'usuarios_id'       =>$res[$i]['usuarios_id']
        );
    } 
    if(count($res)>0){
        $result = json_encode(array('success'=>true, 'result'=>$res));
    }
    else{
        $result = json_encode(array('success'=>false, 'result'=>'Eita Cláudia....'));
    }
    echo ($result);
}   // Fim do listar
else if($postjson['requisicao']=='editar'){
    $query= $pdo->prepare("update usuarios SET nome=:nome, data=:data, capacidade=:capacidade, ativo, usuarios_id=:usuarios_id WHERE id=:id");
    $query->bindValue(":nome",$postjson['nome']);
    $query->bindValue(":data",$postjson['data']);
    $query->bindValue(":capacidade",$postjson['capacidade']);
    $query->bindValue(":ativo",$postjson['ativo']);
    $query->bindValue(":usuarios_id",$postjson['usuarios_id']);
    $query->bindValue(":id",$postjson['id']);
    $query->execute();
    if ($query){
        $result = json_encode(array('success'=>true, 'msg' =>'Deu tudo certo com a alteração!'));
    } else {
        $result = json_encode(array('success'=>false,'msg' =>'Dados incorretos! Falha ao atualizar o evento!'));
    }
    echo $result;
} // Final da requisição editar
else if ($postjson['requisicao']=='excluir'){
    //$query = $pdo->query("Delete from eventos where id = $postjson[id]");
    $query = $pdo->query("update eventos set ativo = 0 where id $postjson[id]");
if ($query){
    $result = json_encode(array('success'=>true, 'msg' =>'Evento excluído com sucesso!'));
} else {
    $result = json_encode(array('success'=>false,'msg' =>'Falha ao excluir o evento!'));
}
echo $result;
} // Final do excluir
else if ($postjson['requisicao']=='ativar'){
    $query = $pdo->query("UPDATE eventos set ativo = 1 where id = $postjson[id]");
if ($query){
    $result = json_encode(array('success'=>true, 'msg' =>'Evento ativado com sucesso!'));
} else {
    $result = json_encode(array('success'=>false,'msg' =>'Falha ao ativar o evento!'));
}
echo $result;
}
?>