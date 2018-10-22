$('document').ready(function() {
	// $('form[name=new-plan]').submit(function(evt) {
	// 	evt.preventDefault();
	// 	// var archivo = $('input[type=file]').val().split('\\').pop();
	// 	var descripcion = $("#descripcion").val();
	// 	var categoria = $("#categoria").val();
	// 	var cant_planificada = $("#cant_planificada").val();
	// 	var cant_comprada = $("#cant_comprada").val();
	// 	var valor_planificado = $("#valor_planificado").val();
	// 	var valor_comprado = $("#valor_comprado").val();
	// 	var comprador = $("#comprador").val();

	// 	if(descripcion == '') {
	// 		alert('Por favor, introduzca el nombre del producto');
	// 		return false;
	// 	}
	// 	if(cant_comprada == '') {
	// 		alert('Ingresa la cantidad');
	// 		location.href='new-category.php';
	// 		return false;
	// 	}
	// 	if(cant_planificada == 0) {
	// 		alert('Ingresa la cantidad');
	// 		return false;
	// 	}

		
	// 	$.post('nueva_planificacion.php', {
	// 		'act':'1',
	// 		'descripcion':descripcion,
	// 		'categoria':categoria,
	// 		'cant_planificada':cant_planificada,
	// 		'cant_comprada':cant_comprada,
	// 		'valor_planificado':valor_planificado,
	// 		'valor_comprado':valor_comprado,
	// 		'comprador':comprador
	// 	}, function(data) {
	// 		if(data == '1') {
	// 			alert('Producto creado correctamente');
	// 			location.reload();
	// 		}else{
	// 			alert('Algo salió mal. Por favor, vuelva a intentarlo');

	// 		}
	// 	});
	// });
	
	
	$('input[name=cant_planificada]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d+$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});
		$('input[name=valor_planificado]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d+$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});
	
	$('input[name=cant_comprada]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d*\.{0,1}\d{0,2}$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});
});