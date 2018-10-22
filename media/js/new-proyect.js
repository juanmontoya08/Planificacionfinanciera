$('document').ready(function() {
	$('form[name=new-proy]').submit(function(evt) {
		evt.preventDefault();
		
		var nombre = $('input[name=nproy-name]').val();
		var descripcion = $('textarea[name=nproy-descrp]').val();
		
		if(nombre == '') {
			alert('Por favor, introduzca un nombre del proyecto');
			return false;
		}
		
		$.post('new-proyect.php', {
			'act':'1',
			'nombre':nombre,
			'descripcion':descripcion
		}, function(data) {
			if(data == '1') {
				alert('proyecto creado correctamente');
				location.href = 'new-proyect.php';
			}else{
				alert('Algo salió mal. Por favor, vuelva a intentarlo');
				return false;
			}
		});
	});
	
	$('textarea[name=nproy-descrp]').keyup(function(evt) {
		var count = $(this).val().length;
		var limit = 400;
		var val = $(this).val();
		var t = $(this);
		
		if(count > limit){
			t.val(val.substr(0,400));
			var dif = 0;
		}else
			var dif = limit-count;
		$('span.nproy-desc-left').html('Descripción ('+dif+' caracteres restantes)');
	});
});