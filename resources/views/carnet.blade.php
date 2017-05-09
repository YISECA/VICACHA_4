<!DOCTYPE html>
<html>
<head>

<style type="text/css">
	.fondo{
position: absolute;
height: 653px;
width: 500px;
}
.nombre {
    position: absolute;
    top: 271px;
    text-align: center;
    width: 500px;
}
.cedula {
    position: absolute;
    top: 336px;
    text-align: center;
    width: 500px;
}
.codigo {
    position: absolute;
    top: 409px;
    text-align: center;
    width: 500px;
}
.imagen {
    position: absolute;
    top: 40px;
    text-align: center;
    width: 133px;
    height: 165px;
    left: 352px;
}
</style>
</head>
	<body>
	<img class="fondo" src="http://www.idrd.gov.co/SIM/images/carnet.png">
	 <div class="nombre">   {{$nombres.' '.$apellidos}} </div>
	 <div class="cedula">   {{$cedula}} </div>
	 <div class="codigo">    {{$codigo}} </div>
     <img class="imagen" src="{{ asset('public/uploads/'.$imagen) }}"> 

	</body>
</html>

