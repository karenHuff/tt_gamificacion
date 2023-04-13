let objJson;
function addGrupo(){
	var nom_grupo = $('#nom_grupo').val();
	var descripcion = $('#descripcion').val();
	if(nom_grupo == "" || descripcion == ""){
		//alert("Los campos no pueden estar vacíos");
		Swal.fire({
			html: '<h3>Completa todos los campos</h3>'	  
		});
	}else{ 
	    $.ajax({
			url: 'actionAddNuevoGrupo.php',
			type: 'POST',
			data: {
				accion: "guardarGrupo",
				nom_grupo: nom_grupo,
				descripcion : descripcion
			},
			success: function(Resultado) {
				//alert(Resultado);
				objJson = JSON.parse(Resultado);
				Swal.fire({
					html: '<h3>'+objJson.mensaje+'</h3>'	  
				}).then(function(){
					window.location.href = "../tables/nom_clase.php?idGrupo="+objJson.id;
				});
			},
			error: function (data) {
				// body...
			}
		});
	}
	formGrupo.reset();
}

