var base_uri = '../api-clientes/api/';

$(document).ready(function() {	
	listarMunicipio();
	listarTipoDocumento();
	listarCliente();

	$('#myModal').on('hidden.bs.modal', function (e) {
		listarCliente();
	});

	$("#guardarCliente").click(function(){
		$.ajax({
		    url: base_uri+'cliente/save.php',
		    type: 'POST',
		    dataType: 'Json',
		    data: $('#frmCliente').serialize()
		}).done(function(response){
		    if(response.status=="success"){
		    	alert('El cliente se ingreso con exito');
				$("#frmCliente input[name=idCliente]").val('');
	    		$("#frmCliente input[name=nombres]").val('');
	    		$("#frmCliente input[name=apellidos]").val('');
			    listarCliente();
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	});

	$("#guardarDocumento").click(function(){
		$.ajax({
		    url: base_uri+'documento/save.php',
		    type: 'POST',
		    dataType: 'Json',
		    data: $('#frmDocumento').serialize()
		}).done(function(response){
		    if(response.status=="success"){
		    	alert('El documento se ingreso con exito');
				$("#frmDocumento input[name=idDocumento]").val('');
	    		$("#frmDocumento input[name=numeroDocumento]").val('');
	    		listarTipoDocumento();
			    listarDocumento($("#frmDocumento input[name=idCliente]").val());
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	});

	$("#guardarDireccion").click(function(){
		$.ajax({
		    url: base_uri+'direccion/save.php',
		    type: 'POST',
		    dataType: 'Json',
		    data: $('#frmDireccion').serialize()
		}).done(function(response){
		    if(response.status=="success"){
		    	alert('El cliente se ingreso con exito');
				$("#frmDireccion input[name=idDireccion]").val('');
	    		$("#frmDireccion input[name=direccion]").val('');
	    		listarMunicipio();
				listarDireccion($("#frmDireccion input[name=idCliente]").val());
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	});
});

function listarMunicipio(idMunicipio){
	$.ajax({
	    url: base_uri+'municipio/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#idMunicipio').empty();
	    if(response.status=="success"){
	    	$('#idMunicipio').append('<option value="">Seleccione una opción</option>');
	        $.each(response.object, function(index, value){
				if (idMunicipio != undefined && idMunicipio != null) {
	        		if (idMunicipio == value.idMunicipio) {
	        			$('#idMunicipio').append('<option value="' + value.idMunicipio + '" selected="true">' + value.municipio + '</option>');
	        		}
	        	} else {
					$('#idMunicipio').append('<option value="' + value.idMunicipio + '">' + value.municipio + '</option>');
	        	}
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function listarTipoDocumento(idTipoDocumento){
	$.ajax({
	    url: base_uri+'tipoDocumento/list.php',
	    type: 'GET',
	    dataType: 'Json'
	}).done(function(response){
	    $('#idTipoDocumento').empty();
	    if(response.status=="success"){
	    	$('#idTipoDocumento').append('<option value="">Seleccione una opción</option>');
	        $.each(response.object, function(index, value){
	        	if (idTipoDocumento != undefined && idTipoDocumento != null) {
	        		if (idTipoDocumento == value.idTipoDocumento) {
	        			$('#idTipoDocumento').append('<option value="' + value.idTipoDocumento + '" selected="true">' + value.tipoDocumento + '</option>');
	        		}
	        	} else {
					$('#idTipoDocumento').append('<option value="' + value.idTipoDocumento + '">' + value.tipoDocumento + '</option>');
	        	}
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
	        	accion+= '<button type="button" class="btn btn-sm btn-primary" onclick="obtenerDetalle(' +  value.idCliente + ')">Detalle</button><br/>';
	        	accion+= '<button type="button" class="btn btn-sm btn-secondary" onclick="obtenerCliente(' +  value.idCliente + ')">Modificar</button><br/>';
	        	accion+= '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarCliente(' +  value.idCliente + ')">Eliminar</button>';
				$('#tbodyCliente').append('<tr><td>' + cont + '</td><td>' + value.nombres + " " + value.apellidos + '</td><td>' + value.documentos + '</td><td>' + value.direcciones + '</td><td>' + accion + '</td></tr>');
				cont++;
			});
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function listarDocumento(idCliente){
	$.ajax({
	    url: base_uri+'documento/list.php',
	    type: 'GET',
	    dataType: 'Json',
	    data:{
	    	idCliente: idCliente
	    }
	}).done(function(response){
	    $('#tbodyDocumento').empty();
	    if(response.status=="success"){
		    var cont = 1;
		    var accion = '';
	        $.each(response.object, function(index, value){
	        	accion = '';
	        	accion+= '<button type="button" class="btn btn-sm btn-secondary" onclick="obtenerDocumento(' +  value.idDocumento + ')">Modificar</button><br/>';
	        	accion+= '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarDocumento(' +  value.idCliente + ', ' +  value.idDocumento + ')">Eliminar</button>';
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

function listarDireccion(idCliente){
	$.ajax({
	    url: base_uri+'direccion/list.php',
	    type: 'GET',
	    dataType: 'Json',
	    data:{
	    	idCliente: idCliente
	    }
	}).done(function(response){
	    $('#tbodyDireccion').empty();
	    if(response.status=="success"){
		    var cont = 1;
		    var accion = '';
	        $.each(response.object, function(index, value){
	        	accion = '';
	        	accion+= '<button type="button" class="btn btn-sm btn-secondary" onclick="obtenerDireccion(' +  value.idDireccion + ')">Modificar</button><br/>';
	        	accion+= '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarDireccion(' +  value.idCliente + ', ' +  value.idDireccion + ')">Eliminar</button>';
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

function eliminarDocumento(idCliente, idDocumento){
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
			    listarDocumento(idCliente);
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	}
}

function eliminarDireccion(idCliente, idDireccion){
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
			    listarDireccion(idCliente);
		    }else{
		        alert(response.error);
		    }
		}).fail(function(){
		    alert('Ocurrió un error al realizar la petición');
		});
	}
}

function obtenerCliente(idCliente){
	$.ajax({
	    url: base_uri+'cliente/list.php',
	    type: 'GET',
	    dataType: 'Json',
	    data: {
	    	idCliente: idCliente
	    }
	}).done(function(response){
	    if(response.status=="success"){
	    	if (response.total>0) {
	    		var data = response.object[0];
	    		$("#frmCliente input[name=idCliente]").val(data.idCliente);
	    		$("#frmCliente input[name=nombres]").val(data.nombres);
	    		$("#frmCliente input[name=apellidos]").val(data.apellidos);
	    	}
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function obtenerDocumento(idDocumento){
	$.ajax({
	    url: base_uri+'documento/list.php',
	    type: 'GET',
	    dataType: 'Json',
	    data: {
	    	idDocumento: idDocumento
	    }
	}).done(function(response){
	    if(response.status=="success"){
	    	if (response.total>0) {
	    		var data = response.object[0];
	    		$("#frmDocumento input[name=idDocumento]").val(data.idDocumento);
	    		$("#frmDocumento input[name=numeroDocumento]").val(data.numeroDocumento);
	    		$("#frmDocumento input[name=idCliente]").val(data.idCliente);
	    		listarTipoDocumento(data.idTipoDocumento);
	    	}
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function obtenerDireccion(idDireccion){
	$.ajax({
	    url: base_uri+'direccion/list.php',
	    type: 'GET',
	    dataType: 'Json',
	    data: {
	    	idDireccion: idDireccion
	    }
	}).done(function(response){
	    if(response.status=="success"){
	    	if (response.total>0) {
	    		var data = response.object[0];
	    		$("#frmDireccion input[name=idDireccion]").val(data.idDireccion);
	    		$("#frmDireccion input[name=direccion]").val(data.direccion);
	    		$("#frmDireccion input[name=idCliente]").val(data.idCliente);
	    		listarMunicipio(data.idMunicipio);
	    	}
	    }else{
	        alert(response.error);
	    }
	}).fail(function(){
	    alert('Ocurrió un error al realizar la petición');
	});
}

function obtenerDetalle(idCliente){
	$("#frmDocumento input[name=idCliente]").val(idCliente);
	$("#frmDireccion input[name=idCliente]").val(idCliente);
	listarDocumento(idCliente);
	listarDireccion(idCliente);
	$('#myModal').modal('show');
}