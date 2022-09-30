<?php 
// Api - Aplicação para recursos de app mobile
require('config.php');

// variável que recebe o conteúdo da requisição do APP decodificando-a (json)
$postjson = json_decode(file_get_contents('php://input', true),true);

if($postjson['requisicao']=='add'){
    $user = new Usuario($postjson['nome'],
                $postjson['data'],
                $postjson['capacidade'],
                $postjson['usuarios_id']);
    
    $user->insert();
    if($user->getId()>0){
        $result = json_encode(array('success'=>true,'id'=>$user->getId()));
    }else{
        $result = json_encode(array('success'=>false,'msg'=>'Falha ao inserir o Evento', ''=>$id ));
    }
    echo $result;
}// final requisição add 
else if($postjson['requisicao']=='listar'){
    $user = new Eventos();
    if($postjson['nome']==''){
       $res = Eventos::getList();  
    }else{
        $res = $user->search($postjson['nome']); 
    }
    for($i=0;$i < count($res); $i++){
        $dados[][] = array(
            'id'=>$res[$i]['id'],
            'nome'=>$res[$i]['nome'],
            'data'=>$res[$i]['data'],
            'capacidade'=>$res[$i]['capacidade'],
            'usuarios_id'=>$res[$i]['usuarios_id'],
            'ativo'=>$res[$i]['ativo'],
        );
    }
    if(count($res)>0){
        $result = json_encode(array('success'=>true,'result'=>$dados));
    }
    else{
        $result = json_encode(array('success'=>false,'result'=>'Eita Cláudia....'));
    }
    echo ($result);
}// fim do listar
else if($postjson['requisicao']=='editar'){
    $user = new Eventos();
    $user->setNome($postjson['nome']);
    $user->setId($postjson['id']);
    $user->setData($postjson['data']);
    $user->setCapacidade($postjson['capacidade']);
    $user->setUsuariosId($postjson['usuarios_id']);
    if ($user->update()){
        $result = json_encode(array('success'=>true, 'msg'=>"Deu tudo certo com alteração!"));
    }else{
        $result = json_encode(array('success'=>false,'msg'=>"Dados incorretos! Falha ao atualizar o Evento! (WRH014587)"));
    }
    echo $result;
} 
else if($postjson['requisicao']=='excluir'){
    $user = new Eventos();
    //$user->setId();
    $res = $user->delete($postjson['id']);
    if ($res){
        $result = json_encode(array('success'=>true, 'msg'=>"Evento excluído com sucesso!"));
    }else{
        $result = json_encode(array('success'=>false,'msg'=>"Falha ao excluir o Evento!"));
    }
    echo $result;
}//final do excluir
else if($postjson['requisicao']=='ativar'){
    $user = new Eventos();
    $user->setId($postjson['id']);
    $res = $user->ativar();
    if ($res){
        $result = json_encode(array('success'=>true, 'msg'=>"Evento Ativado com sucesso!"));
    }else{
        $result = json_encode(array('success'=>false,'msg'=>"Falha ao ativar o Evento!"));
    }
    echo $result;
}//final do ativar
?>