<?php
include "menu.php";
$idfornecedor = isset($_GET["idfornecedor"]) ? $_GET["idfornecedor"]:null;
$op = isset($_GET["op"])? $_GET["op"]:null;
try{
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $bd = "bdrevisao";
    $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha);

  if($op=="del"){
    $sql = "delete from tblfornecedores where idfornecedor= :idfornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":idfornecedor",$idfornecedor);
    $stmt->execute();
    header("Location:fornecedores.php");
  }
  if($idfornecedor){
    $sql = "Select *  from tblfornecedores where idfornecedor= :idfornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":idfornecedor",$idfornecedor);
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_OBJ);

  }



  if($_POST){
    if($_POST["idfornecedor"]){
      $sql = "UPDATE tblfornecedores set fornecedor=:fornecedor, telefone=:telefone,cnpj=:cnpj WHERE idfornecedor=:idfornecedor";
      $stmt = $con->prepare($sql);
      $stmt->bindValue(":fornecedor", $_POST["fornecedor"]);
      $stmt->bindValue(":telefone", $_POST["telefone"]);
      $stmt->bindValue(":cnpj", $_POST["cnpj"]);
      $stmt->bindValue(":idfornecedor", $_POST["idfornecedor"]);
      $stmt->execute();
    } else {
      $sql = "INSERT INTO tblfornecedores(fornecedor,telefone,cnpj) values(:fornecedor,:telefone,:cnpj)";
      $stmt = $con->prepare($sql);
      $stmt->bindValue(":fornecedor",$_POST["fornecedor"]);
      $stmt->bindValue(":telefone",$_POST["telefone"]);
      $stmt->bindValue(":cnpj",$_POST["cnpj"]);

      $stmt->execute();



    }
    header("Location:fornecedores.php");
  }




} catch(PDOException $e){
  echo $e->getMessage();
}

?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Sistema</title>
  </head>
  <body>
    <h1>Cadastro de Fornecedor</h1>    
    <hr>
    <div class="container">
        <form method="post">
            Fornecedor      <input type="text" name="fornecedor" value="<?php echo isset($fornecedor) ? $fornecedor->fornecedor:null ?>">
            Telefone <input type="text" name="telefone"   value="<?php echo isset($fornecedor) ? $fornecedor->telefone:null ?>">
            CNPJ        <input type="text" name="cnpj"   value="<?php echo isset($fornecedor) ? $fornecedor->cnpj:null ?>">
            <input type="hidden" name="idfornecedor"           value="<?php echo isset($fornecedor) ? $fornecedor->idfornecedor:null ?>">>
            <input type="submit" value="Cadastrar" class="btn btn-warning">

        </form>
    </div>

  <?php 

    include "rodape.php";
    ?>