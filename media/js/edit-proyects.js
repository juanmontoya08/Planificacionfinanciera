$('document').ready(function() {
	$('form[name=edit-proyect]').submit(function(evt) {
		evt.preventDefault();
		
		var proyidd = $(this).data('id');
		var nombre = $('input[name=eproy-name]').val();
		var descripcion = $('textarea[name=eproy-descrip]').val();

		
		if(nombre == '') {
			alert('Por favor, introduzca un nombre de categoría');
			return false;
		}
		
		$.post('edit-proyect.php', {
			'act':'1',
			'proyidd':proyidd,
			'nombre':nombre,
			'descripcion':descripcion
		}, function(data) {
			if(data == '1') {
				alert('Proyecto actualizada con éxito');
				location.href = 'proyect.php';
			}else{
				alert('Algo salió mal. Por favor, vuelva a intentarlo');
				return false;
			}
		});
	});
	
	$('textarea[name=eproy-descrip]').keyup(function(evt) {
		var count = $(this).val().length;
		var limit = 400;
		var val = $(this).val();
		var t = $(this);
		
		if(count > limit){
			t.val(val.substr(0,400));
			var dif = 0;
		}else
			var dif = limit-count;
		$('span.eproy-desc-left').html('Descripción de categoria ('+dif+' caracteres restantes):');
	});
});