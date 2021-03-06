function ventanaModal(ruta,titulo,cadena,tamanio,post)
{
    var titulo = titulo || 'Mensaje del Sistema';
    var cadena = cadena || '';
    var tamanio = tamanio || ' modal-lg ';
    var post = post || 'SI';
    
    //Limpiar el contenedor ventana
	var ventana='';
	$('#ventana').html('');
    
    ventana+='<div id="ventana_modal" class="modal fade" tabindex="-1" style="margin-top:30px;" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">';
      ventana+='<div class="modal-dialog '+tamanio+'" role="document">';
        ventana+='<div class="modal-content">';
          ventana+='<div class="modal-header">';
            ventana+='<h5 class="modal-title" id="gridModalLabel">'+titulo+'</h5>';
            ventana+='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
              ventana+='<span aria-hidden="true">&times;</span>';
            ventana+='</button>';
          ventana+='</div>';
         
          if(post=='SI')
          {
              ventana+='<div class="modal-body" id="contenido_ventana_modal"></div>';
          }
          else
          {
              ventana+='<div class="modal-body" id="contenido_ventana_modal">'+cadena+'</div>';
          }
          
        ventana+='</div>';
      ventana+='</div>';
    ventana+='</div>';
    
	$('#ventana').html(ventana);
    
	$('#ventana_modal').modal('show');
	
	if(post=='SI')
	{
    	$.post(ruta,cadena,function(respuesta)
    	{
    		$('#contenido_ventana_modal').html(respuesta);
    	});
	}
}

function salir()
{
    location.href="salir.php";	
}

function recargar()
{
    location.href="/";	
}

function error(mensaje)
{
    $('#alerta').html('<span class="fas fa-exclamation-triangle"></span> '+mensaje);
    $('#alerta').removeClass('alert-success');
    $('#alerta').addClass('alert-danger');

    $('#alerta').animate({'top':'1px'},700,function()
    {
        $('#alerta').animate({'top':'1px'},2500,function()
        {
            $('#alerta').animate({'top':'-100px'},700);
        });
    });  
}

function exito(mensaje)
{
    $('#alerta').html('<span class="fas fa-check-square"></span> '+mensaje);
    $('#alerta').removeClass('alert-danger');
    $('#alerta').addClass('alert-success');

    $('#alerta').animate({'top':'1px'},700,function()
    {
        $('#alerta').animate({'top':'1px'},1900,function()
        {
            $('#alerta').animate({'top':'-100px'},700);
        });
    });  
}

function crud(pagina,cadena,callback)
{
	$.post(pagina,cadena,function(data)
	{
		var buscar=/EXITO/;
		var resultado=buscar.test(data);
		var array_mensaje = new Array();
		
		 if(resultado)
		 {	
			 array_mensaje[0]=true;	
			 array_mensaje[1]=data;
			 callback(array_mensaje);						  
		 }
		 else
		 {
			 array_mensaje[0]=false;	
			 array_mensaje[1]=data;	
			 callback(array_mensaje);
		 }
	});
}

function buscar(pagina,capa,id,permanente)
{
	var permanente = permanente || '';
	var valor=$(id).val();
	
	if(permanente.length>0)
	{
		permanente='&'+permanente;
	}
	
	var cadena='busqueda='+valor+permanente;
	
	$.post(pagina,cadena,function(respuesta){
		$(capa).html(respuesta);
	});
}

function paginar(pagina,div,pag,busqueda,permanente)
{
	var permanente = permanente || '';
	var busqueda = busqueda || '';
	
	if(permanente.length>0)
	{
		permanente='&'+permanente;
	}	
	
	var cadena='pag='+pag+'&busqueda='+busqueda+permanente;
	  
	$.post(pagina,cadena,function(respuesta)
	{
		$(div).html(respuesta);
	});
}

function subirArchivos(input,div,oculto)
{
    var formData = new FormData();
    var files = $('#'+input)[0].files[0];

    formData.append('file',files);
    
    $.ajax({
        url: '../librerias/cargar_archivo.php?oculto='+oculto,
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta)
        {
            $('#'+div).html(respuesta)
        }
    });
}

//Evitar el ENTER automatico
function stopRKey(evt)
{
   var evt = (evt) ? evt : ((event) ? event : null);
   var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
   if ((evt.keyCode == 13) && (node.type=="text")){return false;}
}