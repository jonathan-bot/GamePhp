<?php
//estos valores los recibo por POST
if(!isset($RegistrosAMostrar))
{
	$RegistrosAMostrar=15;
}

if(isset($_POST["RegistrosAEmpezar"]) && $_POST["RegistrosAEmpezar"] && $_POST["pag"])
{
	$RegistrosAEmpezar=$_POST["RegistrosAEmpezar"];
	$PagAct=$_POST['pag'];
}
else if(isset($_POST['pag']))
{
  $RegistrosAEmpezar=($_POST['pag']-1)*$RegistrosAMostrar;
  $PagAct=$_POST['pag'];
  //caso contrario los iniciamos
}
else
{
  $RegistrosAEmpezar=0;
  $PagAct=1; 
}
?>