<!DOCTYPE html>







<html lang="ES">

  <head>

      <meta charset="utf-8">

      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <meta name="description" content="">

      <meta name="author" content="">

      <meta name="viewport" content="width=device-width, initial-scale=1">

      <meta http-equiv="X-UA-Compatible" content="IE=edge" />



      @section('style')

          <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

          <link rel="stylesheet" href="{{ asset('public/Css/jquery-ui.css') }}" media="screen">    

          <link rel="stylesheet" href="{{ asset('public/Css/bootstrap.min.css') }}" media="screen">    

          <link rel="stylesheet" href="{{ asset('public/Css/sticky-footer.css') }}" media="screen"> 

          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">   

      @show



      @section('script')

           <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>



          <script src="{{ asset('public/Js/jquery-ui.js') }}"></script>

          <script src="{{ asset('public/Js/bootstrap.min.js') }}"></script>

          <script src="{{ asset('public/Js/main.js') }}"></script>

          <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

          <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

          <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>

          <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

          <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>

          <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>

          <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>

          <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">

          

    

        



            @show



      <title>CAMINATAS ECOLÓGICAS</title>

  </head>



  <body>

      

       <!-- Menu Módulo -->

       <div class="navbar navbar-default navbar-fixed-top">

        <div class="container">

          <div class="navbar-header">

            <a href="#" class="navbar-brand">SIM</a>

            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">

              <span class="icon-bar"></span>

              <span class="icon-bar"></span>

              <span class="icon-bar"></span>

            </button>

          </div>

          <div class="navbar-collapse collapse" id="navbar-main">

            <ul class="nav navbar-nav">

               <li><a href="cerrar" id="a-registro">Inicio</a></li>

              <li><a href="registro" id="a-registro">Registrarse</a></li>

              <!--<li><a href="descarga" id="a-descarga">Descargar Carnet</a></li>-->

              <!--<li><a href="login" id="a-login" >Iniciar sesion</a></li>-->

            </ul>



           



            <ul class="nav navbar-nav navbar-right">

              <li><a href="http://www.idrd.gov.co/sitio/idrd/" target="_blank">I.D.R.D</a></li>

              <li><a href="cerrar" id="a-cerrar">Cerrar Sesión</a></li>

            </ul>



          </div>

        </div>

      </div>

      <!-- FIN Menu Módulo -->

        

      <!-- Contenedor información módulo -->

      </br></br>

      <div class="container">

          <div class="page-header" id="banner">

            <div class="row">

              <div class="col-lg-8 col-md-7 col-sm-6">

                <h1>IDRD</h1>

                <center<p class="lead"><h1>CAMINATAS ECOLÓGICAS</h1></p>

              </div>

              <div class="col-lg-4 col-md-5 col-sm-6">

                 <div align="right"> 

                    <img src="public/Img/IDRD.JPG" width="50%" heigth="40%"/>

                 </div>                    

              </div>

            </div>

          </div>        

      </div>

      <!-- FIN Contenedor información módulo -->

      <div id="loading">

      <img id="loading-image" src="http://3.bp.blogspot.com/-JeGYJyA7z2k/VNUMuthhjDI/AAAAAAAAATk/LnNLV4OGz-A/s1600/iconoCargando-1-.gif" alt="Loading..." /></div>



      <!-- Contenedor panel principal -->

      <div class="container">

          @yield('content')

      </div>        

      <!-- FIN Contenedor panel principal -->

  </body>



</html>











