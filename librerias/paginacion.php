<?php
$PagAnt=$PagAct-1;
$PagSig=$PagAct+1;
$PagUlt=$NroRegistros/$RegistrosAMostrar;
//verificamos residuo para ver si llevará decimales
$Res=$NroRegistros%$RegistrosAMostrar;
// si hay residuo usamos funcion floor para que me
// devuelva la parte entera, SIN REDONDEAR, y le sumamos
// una unidad para obtener la ultima pagina

if(isset($_POST["permanente"])){$permanente=$_POST["permanente"];}else{$permanente='';}

if($Res>0)
{
	$PagUlt=floor($PagUlt)+1;
}

echo "<div class='marco_paginacion'>";

if($PagAnt!=0)
{
	echo " <span class='boton_paginar'><a onClick=\"paginar('".$pagina_local."','".$div."','1','".$busqueda."','".$permanente."')\" title='Primer registro'> &larr; </a></span> ";
}

if($PagAct>1)
{
	echo " <span class='boton_paginar'><a onClick=\"paginar('".$pagina_local."','".$div."','$PagAnt','".$busqueda."','".$permanente."')\" title='Anterior'> &laquo; </a></span> ";
}

if($PagAct!=1||$PagUlt!=1)
{
	echo " <span class='boton_paginar'><strong style='color:#990000'> ".$PagAct."</strong>/".$PagUlt."</strong> </span> ";
}

if($PagAct<$PagUlt)
{
	echo " <span class='boton_paginar'><a onClick=\"paginar('".$pagina_local."','".$div."','$PagSig','".$busqueda."','".$permanente."')\" title='Siguiente'> &raquo; </a></span> ";
}

if($PagAct!=$PagUlt)
{
	echo " <span class='boton_paginar'><a onClick=\"paginar('".$pagina_local."','".$div."','$PagUlt','".$busqueda."','".$permanente."')\" title='Ultimo registro'> &rarr; </a></span> ";
}

echo "</div>";
?>