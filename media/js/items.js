$('document').ready(function() 
{	
	// Delete Item
	$('a[name=c5]').click(function(evt) {
		evt.preventDefault();
		var t = $(this);
		
		if(confirm('¿Está seguro de que desea eliminar este elemento?') == true) {
			var id = t.parent().parent().children('td').children('input[name=id]').val();
			var archivo =  t.parent().parent().children('td').children('input[id=archivo]').val();
			var element = t.parent().parent();
			var height = element.height();


			$.post('planificaciones.php', {
				'act':'2',
				'id':id,
				'archivo':archivo
			}, function(data) {
				if(data == '1')
					element.fadeOut(700);
				else
					element.fadeOut(700);
							$("body").overhang({
		type: "success",
		message: "Eliminado Correctamente",
		duration: 2
		});
			});
		}
	});
	
	$('a[name=c4]').click(function(evt) {
		evt.preventDefault();
		var t = $(this);
		
		if(confirm('¿Está seguro de que desea enviar este elemento a terminados?') == true) {
			var id = t.parent().parent().children('td').children('input[name=id]').val();
			var estado = t.parent().parent().children('td').children('input[name=estado]').val() ;
			var element = t.parent().parent();
			var height = element.height();
			
			if (estado == 1){
							$("body").overhang({
  			type: "error",
 			 message: "No se pudo realizar esta acción",
});
				return false
			}

$.ajax({
	type: "POST",
	data: "act=3&id="+id+"&estado="+estado,
	url: "impresiones.php",
	success: function(){
$("#estado"+id).html("<span class='label label-danger'> TERMINADO.</span>"),
		$("body").overhang({
		type: "success",
		message: "Actualizado Correctamente",
		duration: 2
		});
	}
});


			// $.post('items.php', {
			// 	'act':'3',
			// 	'id':id,
			// 	'estado':estado

			// }, function(data) {
			// 	if(data == '1')
			// 		element.fadeIn(700);
			// 	else
			// 		element.fadeIn(700);
			
			// 		alert('realizado correctamente');
			// });
		}
	});
	
	
	
	// Previous Page
	$('#pagination .prev').click(function() { go('prev', $(this).attr('name')); });
	
	// Next page
	$('#pagination .next').click(function() { go('next', $(this).attr('name')); });
	
	// Show per page
	$('select[name=show-per-page]').on('change', function() { go('show-per-page', this.value); });
	
	// Handler of pagination and show per page
	function go(act, val) {
		var search = urlGet()['search'];
		if(act == 'prev' || act == 'next') {
			var p = val;
			var pp = urlGet()['pp'];
			var url = 'page='+p;

			if(pp != undefined) url = url+'&pp='+pp;
		}else if(act == 'show-per-page') {
			var pp = val;
			var page = urlGet()['page'];
			var url = 'pp='+pp;
			
			if(page != undefined) url = url+'&page='+page;
		}
		
		if(search != undefined) url = url+'&search='+search;
		location.href = 'items.php?'+url;
	}
	
	
	
	
	/***************** Functions *******************/
	// Get url GET params
	function urlGet() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
	
	// Get width without scrollbar
	function getViewportWidth() {
		document.body.style.overflow = 'hidden';
		var viewportWidth = $(window).width();
		document.body.style.overflow = '';
		return viewportWidth;
	}
	
	// Map selected checkboxes
	function mapCheckboxes() {
		var mapped = $('input[name=chbox]:checked').map(function() {
			return $(this).val();
		});
		return mapped;s
	}
});