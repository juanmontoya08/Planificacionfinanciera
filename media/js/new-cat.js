$('document').ready(function() {
	$('form[name=new-cat]').submit(function(evt) {
		evt.preventDefault();
		
		var name = $('input[name=ncat-name]').val();
		var desc = $('textarea[name=ncat-descrp]').val();
		
		if(name == '') {
			alert('Por favor, introduzca un nombre de categoría');
			return false;
		}
		
		$.post('nueva_categoria.php', {
			'act':'1',
			'name':name,
			'desc':desc
		}, function(data) {
			if(data == '1') {
				alert('Categoría creada correctamente');
				location.href = 'nueva_categoria.php';
			}else{
				alert('Algo salió mal. Por favor, vuelva a intentarlo');
				console.log(name, desc)
				return false;
			}
		});
	});
	
	$('textarea[name=ncat-descrp]').keyup(function(evt) {
		var count = $(this).val().length;
		var limit = 400;
		var val = $(this).val();
		var t = $(this);
		
		if(count > limit){
			t.val(val.substr(0,400));
			var dif = 0;
		}else
			var dif = limit-count;
		$('span.ncat-desc-left').html('Descripción ('+dif+' caracteres restantes)');
	});
});