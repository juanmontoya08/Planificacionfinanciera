
function buscar(){
var opcion = document.getElementById('cant_comprada').value;
var opcion2 = document.getElementById('valor_planificado').value;
$("#valor_comprado").val(opcion*opcion2);
}

$('document').ready(function() {

	$('form[name=edit-plan]').submit(function(evt) {
		evt.preventDefault();
		
		var id = $('input[id=planid]').val();
		var descripcion = $('input[id=descripcion]').val();
		var cat = $('select[id=categoria]').val();
		var cant_planificada = $('input[id=cant_planificada]').val();
		var cant_comprada= $('input[id=cant_comprada]').val();
		var valor_planificado= $('input[id=valor_planificado]').val();
		var valor_comprado= $('input[id=valor_comprado]').val();
		var comprador= $('select[id=comprador]').val();

		$.post('editar_planificacion.php', {
			'act':'1',
			'planid':id,
			'descripcion':descripcion,
			'categoria':cat,
			'cant_planificada':cant_planificada,
			'cant_comprada':cant_comprada,
			'valor_planificado':valor_planificado,
			'valor_comprado':valor_comprado,
			'comprador':comprador
		},function(data) {
			if(data == '1') {
				alert('Se han realizado cambios con éxito');
				location.href = 'planificaciones.php';
			}else{
				alert('Algo salió mal. Por favor, inténtelo de nuevo2');
				console.log(id, descripcion, cat, cant_planificada, cant_comprada, valor_planificado, valor_comprado, comprador);
				return false;
			}
		});
	});
	
	
	$('input[name=plan-cant_planificada]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d*\.{0,1}\d{0,2}$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});

	$('input[name=plan-cant_comprada]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d*\.{0,1}\d{0,2}$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});

	$('input[name=plan-valor_planificado]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d*\.{0,1}\d{0,2}$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});
});