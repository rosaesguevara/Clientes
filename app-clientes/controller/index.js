var base_uri = '../api-clientes/api/';

$(document).ready(function() {	
	listarMunicipio();
	listarTipoDocumento();
	listarCliente();
	listarDocumento();
	listarDireccion();
});

function listarMunicipio(){
	$.ajax({
	    url: base_uri+'municipio/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#idMunicipio').empty();
	    if(response.status=="success"){
	    	$('#idMunicipio').append('<option value="">Seleccione una opción</option>');
	        $.each(response.object, function(index, value){
				$('#idMunicipio').append('<option value="' + value.idMunicipio + '">' + value.municipio + '</option>');
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function listarTipoDocumento(){
	$.ajax({
	    url: base_uri+'tipoDocumento/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#idTipoDocumento').empty();
	    if(response.status=="success"){
	    	$('#idTipoDocumento').append('<option value="">Seleccione una opción</option>');
	        $.each(response.object, function(index, value){
				$('#idTipoDocumento').append('<option value="' + value.idTipoDocumento + '">' + value.tipoDocumento + '</option>');
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function listarCliente(){
	$.ajax({
	    url: base_uri+'cliente/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#tbodyCliente').empty();
	    if(response.status=="success"){
		    var cont = 1;
		    var accion = '';
	        $.each(response.object, function(index, value){
	        	accion = '';
				$('#tbodyCliente').append('<tr><td>' + cont + '</td><td>' + value.nombres + value.apellidos + '</td><td>' + value.documentos + '</td><td>' + value.direcciones + '</td><td>' + accion + '</td></tr>');
				cont++;
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function listarDocumento(){
	$.ajax({
	    url: base_uri+'documento/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#tbodyDocumento').empty();
	    if(response.status=="success"){
		    var cont = 1;
		    var accion = '';
	        $.each(response.object, function(index, value){
	        	accion = '';
				$('#tbodyDocumento').append('<tr><td>' + cont + '</td><td>' + value.tipodocumento + '</td><td>' + value.numeroDocumento + '</td><td>' + accion + '</td></tr>');
				cont++;
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function listarDireccion(){
	$.ajax({
	    url: base_uri+'direccion/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#tbodyDireccion').empty();
	    if(response.status=="success"){
		    var cont = 1;
		    var accion = '';
	        $.each(response.object, function(index, value){
	        	accion = '';
				$('#tbodyDireccion').append('<tr><td>' + cont + '</td><td>' + value.direccion + '</td><td>' + value.municipio + ", " + value.departamento + '</td><td>' + accion + '</td></tr>');
				cont++;
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function eliminarCliente(idCliente){
	if (confirm('Esta seguro que desea eliminar este cliente?') == true) {
		$.ajax({
		    url: base_uri+'cliente/delete.php',
		    type: 'POST',
		    dataType: 'Json',
		    data: {
		    	idCliente: idCliente
		    }
		}).done(function(response){
		    if(response.status=="success"){
		    	alert('El cliente fue eliminado');
			    listarCliente();
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	}
}

function eliminarDocumento(idDocumento){
	if (confirm('Esta seguro que desea eliminar este documento?') == true) {
		$.ajax({
		    url: base_uri+'documento/delete.php',
		    type: 'POST',
		    dataType: 'Json',
		    data: {
		    	idDocumento: idDocumento
		    }
		}).done(function(response){
		    if(response.status=="success"){
		    	alert('El documento fue eliminado');
			    listarDocumento();
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	}
}

function eliminarDireccion(idDireccion){
	if (confirm('Esta seguro que desea eliminar esta direccion?') == true) {
		$.ajax({
		    url: base_uri+'direccion/delete.php',
		    type: 'POST',
		    dataType: 'Json',
		    data: {
		    	idDireccion: idDireccion
		    }
		}).done(function(response){
		    if(response.status=="success"){
		    	alert('La direccion fue eliminada');
			    listarDireccion();
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	}
}
