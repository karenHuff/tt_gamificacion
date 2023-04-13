var idEliminar 		=0;
var idActualizar 	=0;

var id;
var tabla;
var pregunta;
var respuesta;
var inc_uno;
var inc_dos;
var inc_tres;
var puntaje;

function crearActividad(idHistoria, idTipo){
	let id_historia = document.getElementById('idHistoria').value;
	let id_tipo = document.getElementById('idTipo').value;
	let id_grupo = document.getElementById('idGrupo').value;

	//alert("tipo: " +idTipo + "historia:" + idHistoria);

	$.ajax({
		url: 'actionAddActividad.php',
		type: 'POST',
		data: {
			accion: "guardar",
			idHistoria: idHistoria,
			idTipo: idTipo
		},
		success: function(Resultado) {
			//alert(Resultado);
			var resJSON = JSON.parse(Resultado);
			//alert(resJSON);
		},
		error: function (data) {
			// body...
		}
	});
}

function guardarText()
{	
	let id_historia = document.getElementById('idHistoria').value;
	let id_grupo = document.getElementById('idGrupo').value;

	let idActividad = $('#idActv').val();
	var nom_act = $('#nom_act').val();
	let contenido = $('#descr').val();
	//alert("hola: "+ nom_act + " "+ contenido); 
	if(nom_act == "" || contenido == ""){
		Swal.fire({
			html: '<h3>Completa todos los campos</h3>'	  
		}); 
	}else{
		$.ajax({
			url: 'actionAddJeopardy.php',
			type: 'POST',
			data: {
				accion : "guardar",
				idActv : idActividad, 
				nom_act : nom_act,
				contenido : contenido
			},
			success: function(Resultado) {
				// body...
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				Swal.fire({
					html: '<h3>'+resJSON.mensaje+'</h3>'	  
				}).then(function(){
					window.location.replace("../tables/nom_clase.php?idGrupo="+id_grupo);
				});
				//alert(resJSON.mensaje);
							
				//window.location.replace("../tables/nom_clase.php?idGrupo="+id_grupo);

			},
			error: function (data) {
				// body...
			}
		});
	}
   
}

function guardarCategoria(){
	let idActv = $('#idActv').val();
	let id_grupo = $('#idGrupo').val();
	let id_historia = $('#idHistoria').val();
	let id_tipo = document.getElementById('idTipo').value;
	var categoria = $('#categoria').val();
	if(categoria == ""){
		//alert("La categoria no puede quedar vacía");
		Swal.fire('<h3>La categoria no puede quedar vacía</h3>');
	}else{	
		$.ajax({
			url: 'actionAddCategoria.php',
			type: 'POST',
			data: {
				accion : "guardarCat", 
				categoria : categoria,
				idActv : idActv
			},
			success: function(Resultado){
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				
				if (resJSON.num_categoria>=3){
					$('#btn1').attr('disabled', true);
				}
				Swal.fire({
					html: '<h3>'+resJSON.mensaje+'</h3>'	  
				}).then(function(){
					window.location.replace("../tables/jeopardy.php?idGrupo="+id_grupo+"&idHistoria="+id_historia+"&tipo="+id_tipo+"&idActividad="+idActv);
				});
				//alert(resJSON.mensaje);
				//window.location.replace("../tables/jeopardy.php?idGrupo="+id_grupo+"&idHistoria="+id_historia+"&tipo="+id_tipo+"&idActividad="+idActv);
				
			}, 
			error: function(data){

			}
		});
	cleax.reset();
	}
}

function addJeopardy(){
	let idActv = $('#idActv').val();
	var categoria = $('#categoria1').val();
	var pregunta = $('#pregunta1').val();
	var incorrecta_1 = $('#incorrecta1').val();
	var respuesta = $('#respuesta').val();
	var incorrecta_2 = $('#incorrecta2').val();
	var incorrecta_3 = $('#incorrecta3').val();
	//falta agregar la categoria
	var puntaje = $('#puntaje').val();
	//var tabla = $('#tableJeopardy').DataTable();
	var tabla = $('#datatable').DataTable();
	
	
	if(pregunta == "" || categoria == ""  || respuesta == "" || incorrecta_1 == "" || incorrecta_2 == "" || incorrecta_3 == "" ||  puntaje == ""){
		//alert("Por favor completa todos los campos");
		Swal.fire('<h3>Completa todos los campos</h3>');
	}else if(isNaN(puntaje)){
		//alert("En el campo puntaje no se permiten letras, sólo números");
		Swal.fire('<h3>El campo puntaje solo permite números NO letras</h3>');
	}else{
		$.ajax({
			url: 'actionAddPreguntasJ.php',
			type: 'POST',
			data: {idActv:idActv, pregunta1: pregunta, respuesta: respuesta, incorrecta1: incorrecta_1, incorrecta2: incorrecta_2,
			 incorrecta3: incorrecta_3, categoria: categoria, puntaje: puntaje, accion: 'guardarPregunta'
			},
			success: function(Resultado){
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if (resJSON.estado==1) {
					id=resJSON.id;
					//alert(id);
					var botonActualizar = '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('+id+')"><i class="fa fa-edit"></i></button></td>';
					var botonEliminar = '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('+id+')"><i class="fa fa-trash"></i></button></td>';
					tabla.row.add([
						pregunta,
						categoria,
						respuesta,
						incorrecta_1,
						incorrecta_2,
						incorrecta_3,
						puntaje,
						botonActualizar,
						botonEliminar
						]).draw().node().id="row_"+id;
				}
				//alert(resJSON.mensaje);
				Swal.fire('<h3>'+resJSON.mensaje+'</h3>');
				
			}, 
			error: function(data){

			}
		});
	}
	preguntasId.reset();
}

function IdentificaActualizar(id) {
	// body...
	idActualizar=id;
	leerJeopardy();
}

function updatePalabraJ(){
	let id_Activ = $('#idActv').val();
	var categoria = $('#categoria2').val();
	pregunta = $('#updatePregunta').val();
	inc_uno  = $('#updateInc1').val();
	respuesta  = $('#updateRes').val();
	inc_dos  = $('#updateInc2').val();
	inc_tres  = $('#updateInc3').val();
	puntaje  = $('#updatePuntaje').val();
	//Referencias
	var tabla = $('#datatable').DataTable();
	id= idActualizar;

	//alert(categoria);

	if(pregunta == "" || categoria == ""  || inc_uno == "" || respuesta == "" || inc_dos == "" || inc_tres == "" ||  puntaje == ""){
		//alert("Completa todos los campos"); 
		Swal.fire('<h3>Completa todos los campos</h3>');
	}else if(isNaN(puntaje)){
		//alert("El campo puntaje solo permite números NO letras");
		Swal.fire('<h3>El campo puntaje solo permite números NO letras</h3>');
	}else{
		$.ajax({
			url: 'actionUpdateJeopardy.php',
			type: 'POST',
			data: {
				categoria:categoria,
				pregunta:pregunta,
				respuesta:respuesta, 
				inc_uno:inc_uno, 
				inc_dos:inc_dos, 
				inc_tres:inc_tres,
				puntaje:puntaje,
				idActv : id,
				accion:'actualizar'},
			success: function(Resultado) {
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if (resJSON.estado==1) {
					//id=resJSON.id;
					//var botonActualizar = '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('+id+')"><i class="fa fa-edit"></i></button></td>';
					//var botonEliminar = '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('+id+')"><i class="fa fa-trash"></i></button></td>';
					var temp = tabla.row('#row_'+id).data();
					temp[0]=pregunta;
					temp[1]=categoria;
					temp[2]=respuesta;
					temp[3]=inc_uno;
					temp[4]=inc_dos;
					temp[5]=inc_tres;
					temp[6]=puntaje;

					tabla.row('#row_'+id).data(temp).draw();
					//window.location.redirect("../tables/quiz.php?idGrupo="+id_grupo+"&"+"idHistoria="+id_historia+"&"+"idActividad="+idActividad);
					//window.location.redirect("../tables/elegir_actividad.php?idGrupo="+id_grupo+"&"+"idHistoria="+id_historia);
				}
				//alert(resJSON.mensaje);
				Swal.fire('<h3>'+resJSON.mensaje+'</h3>');
			},
			error: function (data) {
				// body...
				alert("Ocurrió un error");
			}

		});
	}
	//preguntasId.reset();

}

function IdentificaEliminar(id) {
	// body...
	idEliminar=id;	
	mostrarPregunta();
}



function deletePreguntaJ() {
	// body...
	var tabla = $('#datatable').DataTable();
	id= idEliminar;
	$.ajax({
		url: "actionDeletePreguntaJ.php",
		type: "POST",
		data: {id:idEliminar,accion:'eliminar'},
		success: function(Resultado) {
			var res=JSON.parse(Resultado);
			if (res.estado==1) {
				tabla.row("#row_"+idEliminar).remove().draw();
			}
			//alert(res.mensaje);
		},
		error: function (data) {
			// body...
			alert("Ocurrió un error");
		}
	});
	cerrarse();
}

function leerJeopardy(){
	id=idActualizar;
	let idJeop = $('#idActv').val();
	//alert (idJeop);
	$.ajax({
		url: "actionReadJeopardy.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);

			pregunta = $('#updatePregunta').val(RJSON.pregunta);
			inc_uno  = $('#updateInc1').val(RJSON.resp_dos);
			respuesta  = $('#updateRes').val(RJSON.resp_uno);
			inc_dos  = $('#updateInc2').val(RJSON.resp_tres);
			inc_tres  = $('#updateInc3').val(RJSON.resp_cuatro);
			puntaje  = $('#updatePuntaje').val(RJSON.puntaje);
			
		},
	});
}

function mostrarPregunta() {
	// body...
	id=idEliminar;
	let idJeop = $('#idActv').val();
	//alert(idJeop);
	$.ajax({
		url: "actionReadJeopardy.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			document.getElementById("idPregunta").innerHTML = RJSON.pregunta;
			//pregunta = $('#idpregunta').val(RJSON.pregunta);
		}
	});
}

function cerrarse(){
    $("#modal-danger").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}