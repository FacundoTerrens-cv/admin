<?php
if(!isset($_SESSION['user'])){
    header('location: login.php');
  }
  require_once('conection.php');
$categoria = $_POST['categoria'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO contenido_paginas (tipo_contenido, tipo_servicio, titulo, descripcion) VALUES ('categoria', '$categoria', '$titulo', '$descripcion')";
mysqli_query($conn, $sql);
header("location: categorias.php");
?>