$('document').ready(function() {
	$('.wrapper-pad #selectors li').click(function(evt) {
		evt.preventDefault();		
		
		if($(this).hasClass('selected'))
			return false;
		
		var val = $(this).attr('value');
		
		$('.wrapper-pad #selectors li.selected').removeClass('selected');
		$(this).addClass('selected');
		
		$.post('home.php', {
			'act': 'reqinfo',
			'int': val
		}, function(data) {
			if(data.indexOf('|') == -1) {
				alert(data);
				return false;
			}
			
			data = data.split('|');
			$('#numeross').fadeOut(200, function() { $(this).html(data[0]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[1]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[2]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[3]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[4]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[5]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[6]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[7]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[8]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[9]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[10]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[11]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[12]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[13]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[14]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[15]).fadeIn(200); });
			$('#numeross').fadeOut(200, function() { $(this).html(data[16]).fadeIn(200); });


		});
	});
	$(function(){ 
   $('ul.menu li').click(function(e) 
   { 
  $( "#box" ).text( "Seleccionaste: "+this.id);
 if (this.id=="mas"){
 	$( "#box" ).text( "Seleccionaste: Todo")

      }
      document.getElementById("box1").value = this.id;
      if (this.id=="today"){
      	this.id=="hoy";
      }

   });
});
});