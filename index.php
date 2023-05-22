<?php

//incluir o arquivo da classe e o arquivo de conexao
require_once ('classes/crud.php');
require_once ('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);

//solicitacoes do usuario
if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read':
            $rows = $crud->read();
            break;
        case 'update':
          if(isset($_POST['id'])){
            $crud->update($_POST);
          }
          $rows = $crud->read();
            break;
        case 'delete':
            $crud->delete($_GET['id']);
            break;
        default:
            $rows = $crud->read();
            break;
    }
}else{
    $rows = $crud->read();
}


?>



<!DOCTYPE html>
<html>
<head>
    <title>Formulário de Banda</title>
    <style>
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=number], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        table {
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #333;
        }

        th, td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
        }

        th {
        background-color: #f2f2f2;
        font-weight: bold;
        }

        tr:nth-child(even) {
        background-color: #f9f9f9;
        }

        a {
        display: inline-block;
        padding: 4px 8px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        }

        a:hover {
        background-color: #0069d9;
        }

        a.delete {
        background-color: #dc3545;
        }

        a.delete:hover {
        background-color: #c82333;
        }
    </style>
</head>
<body>

        <?php
            if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
                $id = $_GET['id'];
                $result = $crud->readOne($id);

                if(!$result){
                    echo"Registro não encontrado.";
                    exit();
                }
                $nome_banda = $result['nome_banda'];
                $genero = $result['genero'];
                $gravadora = $result['gravadora'];
                $num_discos = $result['num_discos'];
                $qtda_albuns = $result['qtda_albuns'];
         
         ?>
    
    
    <form method="POST" action="?action=update">
        <input type="hidden" nome="id" value="<?php echo $id ?>">
        <label for="nome_banda">Nome da Banda:</label>
        <input type="text" id="nome_banda" name="nome_banda" value="<?php echo $nome_banda ?>">

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" value="<?php echo $genero ?>">

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora" value="<?php echo $gravadora ?>">

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" value="<?php echo $num_discos ?>">

        <label for="quantidade_albums">Quantidade de Álbuns:</label>
        <input type="number" id="quantidade_albums" name="qtda_albuns"value="<?php echo $qtda_albuns ?>">

        <input type="submit" value="Atualizar" name="enviar">
    </form>

    <?php
            }else{

            

         ?>


<form method="POST" action="?action=create">
        <label for="nome_banda">Nome da Banda:</label>
        <input type="text" id="nome_banda" name="nome_banda" required>

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" required>

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora" required>

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" required>

         <label for="quantidade_albums">Quantidade de Álbuns:</label>
        <input type="number" id="quantidade_albums" name="qtda_albuns" required>

        <input type="submit" value="Cadastrar" name="enviar">
    </form>
    <?php
            }
    ?>

    <table>
        <tr>
            <th>Id</th>
            <th>Nome da Banda</th>
            <th>Genero</th>
            <th>Gravadora</th>
            <th>Numero de discos</th>
            <th>Quantidade de Albuns</th>
            <th>Ações</th>
        </tr>
        <?php
    if (isset($rows)) {
        foreach($rows as $row){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nome_banda']."</td>";
            echo "<td>".$row['genero']."</td>";
            echo "<td>".$row['gravadora']."</td>";
            echo "<td>".$row['num_discos']."</td>";
            echo "<td>".$row['qtda_albuns']."</td>";
            echo "<td>";
            echo "<a href='?action=update&id='".$row['id']."'>Editar</a>";
            echo "<a href='?action=delete&id=".$row['id']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' class='delete'>Excluir</a>";
            echo "</td>";
            echo "</tr>";

        }
    }else{
        echo "Não há registros a serem exibidos.";
    }
        ?>
    </table>
   

</body>
</html>