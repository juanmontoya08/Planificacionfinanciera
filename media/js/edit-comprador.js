$('document').ready(function() {
	$('form[name=edit-comprador]').submit(function(evt) {
		evt.preventDefault();
		
		var compradorid = $(this).data('id');
		var name = $('input[name=ncomprador-name]').val();
		var desc = $('textarea[name=ncomprador-descrp]').val();
		
		if(name == '') {
			alert('Por favor, introduzca un nombre de comprador');
			return false;
		}
		
		$.post('edit-comprador.php', {
			'act':'1',
			'compradorid':compradorid,
			'name':name,
			'desc':desc
		}, function(data) {
			if(data == '1') {
				alert('comprador actualizado con éxito');
				location.href = 'comprador.php';
			}else{
				alert('Algo salió mal. Por favor, vuelva a intentarlo');
				return false;
			}
		});
	});
	
	$('textarea[name=ncomprador-descrp]').keyup(function(evt) {
		var count = $(this).val().length;
		var limit = 400;
		var val = $(this).val();
		var t = $(this);
		
		if(count > limit){
			t.val(val.substr(0,400));
			var dif = 0;
		}else
			var dif = limit-count;
		$('span.ncomprador-desc-left').html('Descripción de comprador ('+dif+' caracteres restantes):');
	});
});