$(function() {

      $.ajax({url:'listar_datos',type:  'post',success:  function (response) {
        $('#loading').show();
        $('#div-tabla').html(response);
        },complete: function(){

           $('#lista').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
                  },
                   dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]


            });
           $('#loading').hide();


          }

      });

$('#a-registro').hide();
$('#a-descarga').hide();
$('#a-login').hide();
$('#a-cerrar').show();



});