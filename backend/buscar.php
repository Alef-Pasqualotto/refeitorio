<?php
include_once('conecta.php');
$dados = $_POST;
$banco = new Banco;
$conn = $banco->conectar();

$consulta = "SELECT * FROM";
$ingredientes = [];

// 1 = ingrediente
// 2 = item
// 3 = usuario
// 4 = cardapio

switch ($_POST['tabela']) {
    case 1: //selecionar por tipo ex:1 ,2 ,3  
        $query = $conn->prepare(' SELECT ingrediente.nome, ingrediente.calorias, item.descricao, cardapio.dt, cardapio.tipo, usuario.nome, usuario.crn 
        from cardapio_item INNER JOIN cardapio ON cardapio_item.cardapio_id = cardapio.cardapio_id 
        INNER JOIN item on cardapio_item.item_id = item.item_id INNER JOIN ingrediente_item on item.item_id = ingrediente_item.item_id 
        INNER JOIN ingrediente on ingrediente_item.ingrediente_id = ingrediente.ingrediente_id INNER JOIN usuario on cardapio.nutricionista_id = usuario.usuario_id 
        WHERE cardapio.tipo = :tipo GROUP BY item.descricao  ;');        
        $query->execute([
            ':tipo' => $dados['tipo']
        ]);
        echo '<pre>'; 
        var_dump($query->fetch(PDO::FETCH_ASSOC));
        break;
        case 2: //selecionar por data ex:0000-00-00
            $query = $conn->prepare('SELECT ingrediente.nome, ingrediente.calorias, item.descricao, cardapio.dt, cardapio.tipo, usuario.nome, usuario.crn 
            from cardapio_item INNER JOIN cardapio ON cardapio_item.cardapio_id = cardapio.cardapio_id 
            INNER JOIN item on cardapio_item.item_id = item.item_id INNER JOIN ingrediente_item on item.item_id = ingrediente_item.item_id 
            INNER JOIN ingrediente on ingrediente_item.ingrediente_id = ingrediente.ingrediente_id INNER JOIN usuario on cardapio.nutricionista_id = usuario.usuario_id 
            WHERE cardapio.dt = :dt GROUP BY item.descricao  ;');        
            echo '<pre>';
            $query->execute([
                ':dt' => $dados['dt']                          
            ]); 
            var_dump($query->fetch());
            break;
        case 3: //selecionar por nome ex: Cebola 
            $query = $conn->prepare(' SELECT ingrediente.nome, ingrediente.calorias, item.descricao, cardapio.dt, cardapio.tipo, usuario.nome, usuario.crn from cardapio_item 
            INNER JOIN cardapio ON cardapio_item.cardapio_id = cardapio.cardapio_id  
            INNER JOIN item on cardapio_item.item_id = item.item_id 
            INNER JOIN ingrediente_item on item.item_id = ingrediente_item.item_id 
            INNER JOIN ingrediente on ingrediente_item.ingrediente_id = ingrediente.ingrediente_id
            INNER JOIN usuario on cardapio.nutricionista_id = usuario.usuario_id
            WHERE ingrediente.nome % :nome ;');        
            $query->execute([
                ':nome' => $dados['nome']
            ]);
            break;
    }
?>
