jQuery(document).ready(function($) {


	$('#fecha_nacimiento').datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: "-100:+0"});

	$('#fecha_ultimo_contrato').datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: "-100:+0"});

	$('#fecha_penultimo_contrato').datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: "-100:+0"});

	$('#fecha_fin_penultimo_contrato').datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: "-100:+0"});

	$('#fecha_antepenultimo_contrato').datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: "-100:+0"});

	$('#fecha_fin_antepenultimo_contrato').datepicker({dateFormat: 'yy-mm-dd'});

	for(var i=2;i<=2;i++){$('#page'+i).hide();}

	$('body').delegate('#adelante','click',function(){var id= $(this).data('id');$("#page"+id).hide();$("#page"+(id+1)).show();$('#form_gen')});	
 	$('body').delegate('#atras','click',function(){var id= $(this).data('id');$("#page"+id).hide();$("#page"+(id-1)).show();});

/*
    $.ajax({url:'listar_pais',type:  'post',success:  function (response) {$('#id_pais').html(response); }});
    $.ajax({url:'listar_ciudad',type:  'post',success:  function (response) {$('#id_ciudad').html(response); }});
    $.ajax({url:'listar_localidad',type:  'post',success:  function (response) {$('#id_localidad').html(response); }});
    $.ajax({url:'listar_departamento',type:  'post',success:  function (response) {$('#id_departamento').html(response); }});
*/
	

});