function crearRetos() {
	// body...
	let idActv=$('#idActv').val();
	var puntaje=$('#puntaje').val();
	var premio=$('#heard').val();
	var fecha=$('#entrega').val();
	var alumnos=$('#alumnos').val();
	var valores=Array.prototype.slice.call(document.querySelectorAll('#alumnos'),0).map(function(v,i,a){
		return v.value;
	});
//alert(premio);
	if (puntaje == "" || premio =="" || fecha=="" || alumnos=="") {
		//alert("Debe llenar todos los campos");
		Swal.fire('<h3>Completa todos los campos</h3>');
	}else if(isNaN(puntaje)){
		//alert("El campo puntaje solo permite números NO letras");
		Swal.fire('<h3>El campo puntaje solo permite números NO letras</h3>');
	}else{
		$.ajax({
			url: 'actionCrearRetos.php',
			type: 'POST',
			data: {puntaje:puntaje,
				premio:premio,
				entrega:fecha,
				alumnos:alumnos,
				idActv:idActv,
				accion:'crear'},
			success: function(Resultado) {
				// body...
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if(resJSON.estado==1){
					//alert(resJSON.mensaje);
					Swal.fire({
						html: '<h3>'+resJSON.mensaje+'</h3>'	  
					}).then(function(){
						window.location.replace("../tables/index.php");
					});
					
				}else{
					//alert("Esta activiada ya fue creada");
					Swal.fire({
						html: '<h3>Esta actividad ya fue creada</h3>'	  
					}).then(function(){
						window.location.replace("../tables/index.php");
					});
					//window.location.replace("index.php");
				}
			},
			error: function(data) {
				alert("Ocurrió un error");
			}
		});
	}
}