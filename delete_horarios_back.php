<?php
include 'conection.php';
$id = $_GET['id'];
$consulta = "DELETE FROM `horarios_turnos` WHERE id = '$id'";
$sentencia = mysqli_query($conn,$consulta);
if($sentencia){
    header("Location:horarios.php"); 
}else{
    echo "<script>alert('Error')</script>";
}
?>