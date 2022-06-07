<?php
$oculto=$_GET["oculto"];

$size = $_FILES['file']['size'];
$path = $_FILES['file']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$nuevo_nombre=date('YmdHis').".".$ext;

$arreglo_permitido=array("jpg","png","gif","mp4","mp3");

if(in_array($ext,$arreglo_permitido))
{
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "../recursos/".$nuevo_nombre))
    {
        if($ext=="jpg" || $ext=="png" || $ext=="gif")
        {
            //IMAGEN
            ?>
            <img src="../recursos/<?php echo $nuevo_nombre;?>" width="100">
            <input type="hidden" name="<?php echo $oculto;?>" id="<?php echo $oculto;?>" value="<?php echo $nuevo_nombre;?>">
            <?php
        }
        else if($ext=="mp3")
        {
            //AUDIO
            ?>
            <audio src="../recursos/<?php echo $nuevo_nombre;?>" controls></audio>
            <input type="hidden" name="<?php echo $oculto;?>" id="<?php echo $oculto;?>" value="<?php echo $nuevo_nombre;?>">
            <?php
        }
        else if($ext=="mp4")
        {
            //VIDEO
            ?>
            <video src="../recursos/<?php echo $nuevo_nombre;?>" controls width="100"></video>
            <input type="hidden" name="<?php echo $oculto;?>" id="<?php echo $oculto;?>" value="<?php echo $nuevo_nombre;?>">
            <?php
        }
    }
}
else
{
    echo "ERROR: Extensi&oacute;n no permitida (<b> $path </b>)";
}
?>