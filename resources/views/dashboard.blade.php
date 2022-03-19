@extends('layout')
@section('title','Dashboard')
@section('header')
@livewire('header')
@endsection
@section('css')
<style>
    * {
margin: 0;
padding: 0;
border: 0;
box-sizing: border-box;
-webkit-font-smoothing: antialiased;
}

@-webkit-keyframes radar {
0% {
transform: rotateY(0deg);
}
100% {
transform: rotateY(360deg);
}
}

@keyframes radar {
0% {
transform: rotateY(0deg);
}
100% {
transform: rotateY(360deg);
}
}
@-webkit-keyframes barco {
0% {
transform: rotate(-2deg) translateX(2px);
}
50% {
transform: rotate(1deg) translateX(-10px);
}
100% {
transform: rotate(-2deg) translateX(2px);
}
}
@keyframes barco {
0% {
transform: rotate(-2deg) translateX(2px);
}
50% {
transform: rotate(1deg) translateX(-10px);
}
100% {
transform: rotate(-2deg) translateX(2px);
}
}
@-webkit-keyframes contenedores {
0% {
transform: translateX(-7px);
}
50% {
transform: translateX(1px);
}
100% {
transform: translateX(-7px);
}
}
@keyframes contenedores {
0% {
transform: translateX(-7px);
}
50% {
transform: translateX(1px);
}
100% {
transform: translateX(-7px);
}
}
@-webkit-keyframes ola {
0% {
right: 0%;
}
100% {
right: 100%;
}
}
@keyframes ola {
0% {
right: 0%;
}
100% {
right: 100%;
}
}
@-webkit-keyframes olita {
0% {
bottom: 0;
}
100% {
bottom: -29px;
}
}
@keyframes olita {
0% {
bottom: 0;
}
100% {
bottom: -29px;
}
}
.wrap {
display: flex;
align-items: center;
justify-content: center;
width: 100%;
height: 100vh;
}

.barco {
width: 400px;
height: 160px;
position: relative;
overflow: hidden;
-webkit-animation-name: barco;
      animation-name: barco;
-webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
-webkit-animation-duration: 5s;
      animation-duration: 5s;
}
.barco .puertita {
position: absolute;
bottom: 0px;
left: 7px;
width: 5px;
height: 10px;
background-color: #58575C;
border-radius: 5px;
}
.barco .base {
position: absolute;
bottom: 0;
width: 100%;
}
.barco .base .proa, .barco .base .popa, .barco .base .tronco {
background-color: #58575C;
}
.barco .base .anclacont {
position: absolute;
right: 32px;
bottom: 36px;
width: 8px;
height: 8px;
border-radius: 50%;
background-color: rgba(0, 0, 0, 0.2);
}
.barco .base .atras {
height: 58px;
width: 40px;
border-radius: 10px;
background-color: #58575C;
margin-left: 5px;
transform: skewX(13deg);
}
.barco .base .popa {
height: 58px;
width: 95px;
transform: skewX(37deg);
border-radius: 10px 18px 10px 18px;
position: absolute;
left: 30px;
top: 0;
}
.barco .base .tronco {
width: 347px;
height: 37px;
position: absolute;
left: 9px;
bottom: 0;
z-index: 10;
}
.barco .base .tronco .marca {
height: 14px;
width: 100%;
position: absolute;
bottom: 0;
left: 0%;
-webkit-perspective: 150px;
}
.barco .base .tronco .marca .per {
height: 100%;
background-color: rgba(255, 0, 0, 0.4);
transform: rotateX(7deg);
border-radius: 0 0 3px 3px;
}
.barco .base .proa {
height: 58px;
width: 91px;
transform: skewX(-47deg);
border-radius: 14px 10px 10px 18px;
position: absolute;
right: 26px;
top: 0;
}
.barco .puente {
width: 118px;
height: 124px;
position: absolute;
left: 12px;
top: 0;
}
.barco .puente .franja {
background-color: #58575C;
position: absolute;
bottom: 70px;
width: 35px;
height: 5px;
transform: skewX(-5deg);
left: 10px;
}
.barco .puente .camarote1 {
position: absolute;
bottom: 0;
left: 5px;
width: 36px;
height: 70px;
transform: skewX(-5deg);
background-color: white;
}
.barco .puente .camarote1:after {
content: " ";
position: absolute;
bottom: 0;
right: -2px;
background-color: #CCCDD1;
height: 100%;
width: 3px;
z-index: -1;
transform: skewX(3deg);
}
.barco .puente .camarote1 .antiskew {
transform: skewX(5deg);
display: flex;
justify-content: flex-end;
align-items: center;
flex-wrap: wrap;
padding: 7px 7px;
height: 45px;
}
.barco .puente .camarote1 .ventana {
width: 5px;
height: 5px;
border-radius: 1px;
background-color: #003F5F;
margin: 2px;
}
.barco .puente .chimeneal, .barco .puente .chimenear {
background-color: white;
}
.barco .puente .chimeneal .linea, .barco .puente .chimenear .linea {
height: 10px;
width: 100%;
margin-top: 4px;
background-color: red;
}
.barco .puente .chimeneal {
width: 14px;
height: 43px;
position: absolute;
top: 9px;
left: 16px;
transform: skewX(-6deg);
}
.barco .puente .chimenear {
width: 20px;
height: 43px;
position: absolute;
top: 9px;
left: 19px;
}
.barco .fantena {
position: absolute;
width: 2px;
height: 40px;
left: 87px;
top: 2px;
background-color: #3a3939;
border-radius: 3px;
}
.barco .santenea {
position: absolute;
width: 2px;
height: 20px;
left: 83px;
top: 19px;
background-color: #3a3939;
border-radius: 3px;
}
.barco .radar {
position: absolute;
height: 20px;
left: 50px;
top: 19px;
}
.barco .radar .cabeza {
width: 18px;
height: 7px;
background-color: white;
-webkit-animation-name: radar;
      animation-name: radar;
-webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
-webkit-animation-duration: 1s;
      animation-duration: 1s;
}
.barco .radar .soporte {
width: 4px;
height: 20px;
background-color: white;
margin-left: 7px;
margin-top: -8px;
border-radius: 1px;
}
.barco .control {
width: 62px;
height: 57px;
background-color: white;
position: absolute;
right: 13px;
top: 36px;
padding-top: 15px;
padding-bottom: 10px;
padding-left: 5px;
padding-right: 5px;
display: flex;
justify-content: flex-end;
flex-wrap: wrap;
border-bottom: solid 1px #CCCDD1;
}
.barco .control .tapa {
width: 100%;
position: absolute;
top: 0;
left: 2px;
background-color: white;
height: 13px;
transform: skewX(-8deg);
border-radius: 0 4px 0 0;
padding: 2px;
display: flex;
justify-content: space-around;
align-items: center;
}
.barco .control .tapa .top-ventana {
background-color: #003F5F;
height: 6px;
width: 28%;
transform: skewX(5deg);
}
.barco .control .mid-ventana {
width: 5px;
height: 5px;
border-radius: 1px;
background-color: #003F5F;
display: block;
margin: 2px;
}
.barco .control .mid-ventana:nth-of-type(7) {
margin-left: 10px;
}
.barco .control .puertita {
bottom: 2px;
}
.barco .bajo-camarotes {
background-color: white;
width: 69px;
height: 31px;
position: absolute;
bottom: 0;
right: 6px;
display: flex;
justify-content: flex-end;
padding: 5px 5px 14px 41px;
flex-wrap: wrap;
}
.barco .bajo-camarotes:after {
content: " ";
background-color: white;
position: absolute;
right: -2px;
top: 0;
width: 5px;
height: 100%;
transform: rotate(-7deg);
}
.barco .bajo-camarotes .ventanitas {
background-color: #003F5F;
width: 5px;
height: 3px;
border-radius: 2px;
margin: 1px;
}
.barco .bajo-camarotes .ventanitas:nth-of-type(4) {
margin-left: 4px;
}
.barco .contenedores {
width: 158px;
height: 80px;
position: absolute;
top: 80px;
right: 102px;
-webkit-animation-name: contenedores;
      animation-name: contenedores;
-webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
-webkit-animation-duration: 5s;
      animation-duration: 5s;
}
.barco .contenedores .contenedor {
width: 50px;
height: 16px;
background-color: #a4b8b9;
padding: 1px 2px;
display: flex;
float: left;
justify-content: space-around;
margin-bottom: 1px;
margin-right: 1px;
}
.barco .contenedores .contenedor:nth-of-type(2) {
background-color: #4f4a65;
}
.barco .contenedores .contenedor:nth-of-type(4) {
background-color: #b36730;
}
.barco .contenedores .cal {
background: black;
height: 100%;
width: 2px;
border-radius: 1px;
opacity: 0.07;
}

.elmar {
width: 100%;
height: 100%;
/* border-radius: 50%; */
display: flex;
align-items: center;
position: relative;
overflow: hidden;
justify-content: center;
background-color: #C0EBFF;
}
.elmar .agua {
background-color: #25b9ee;
width: 100%;
height: 42%;
position: absolute;
bottom: 0;
left: 0;
opacity: 0.8;
}
.elmar .agua .olacont {
width: 200%;
top: -18px;
position: relative;
-webkit-animation-name: ola;
      animation-name: ola;
-webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
-webkit-animation-duration: 30s;
      animation-duration: 30s;
-webkit-animation-timing-function: lineal;
      animation-timing-function: lineal;
}

.olita {
fill: #25b9ee;
-webkit-animation-name: olita;
      animation-name: olita;
-webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
-webkit-animation-duration: 1s;
      animation-duration: 1s;
position: relative;
}
</style>
@endsection
@section('content')
<section class="wrap">
	<div class="elmar">
		<div class="cielo">
		</div>
		<div class="barco">
			<div class="puente">
				<div class="chimeneal">
					<div class="linea"></div>
				</div>
				<div class="chimenear">
					<div class="linea"></div>
				</div>
				<div class="franja"></div>
				<div class="camarote1">
					<div class="antiskew">
						<div class="ventana"></div>
						<div class="ventana"></div>
						<div class="ventana"></div>
						<div class="ventana"></div>
						<div class="ventana"></div>
						<div class="puertita"></div>
					</div>
				</div>
				<div class="radar">
					<div class="cabeza"></div>
					<div class="soporte"></div>	
				</div>
				<div class="fantena"></div>
				<div class="santenea"></div>
				<div class="control">
					<div class="tapa">
						<div class="top-ventana"></div>
						<div class="top-ventana"></div>
						<div class="top-ventana"></div>
					</div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="mid-ventana"></div>
					<div class="puertita"></div>
				</div>
				<div class="bajo-camarotes">
					<div class="ventanitas"></div>
					<div class="ventanitas"></div>
					<div class="ventanitas"></div>
					<div class="ventanitas"></div>
					<div class="ventanitas"></div>
					<div class="ventanitas"></div>
				</div>
			</div>
			<div class="base">
				<div class="atras"></div>
				<div class="popa"></div>
				<div class="tronco">
					<div class="marca">
						<div class="per"></div>
					</div>
				</div>
				<div class="proa"></div>
				<div class="anclacont"></div>
			</div>
			<div class="contenedores">
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
				<div class="contenedor">
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
					<div class="cal"></div>
				</div>
			</div>
		</div>
		<div class="agua">
			<svg version="1.1" class="olacont" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 13685.8 298.5" style="enable-background:new 0 0 13685.8 298.5;" xml:space="preserve">
				<path class="olita" d="M13641.6,241.3c-325.4-8.8-403.9-213.3-535-213.3c-85.9,0-159.3,27.7-292.7,127.3c-93.3,69.7-372.3,86-372.3,86
				h-44.1c-325.4-8.8-403.9-213.3-535-213.3c-85.9,0-159.3,27.7-292.7,127.3c-93.3,69.7-372.3,86-372.3,86h-44.1
				c-325.4-8.8-403.9-213.3-535-213.3c-85.9,0-159.3,27.7-292.7,127.3c-93.3,69.7-372.3,86-372.3,86h-44.1
				c-325.4-8.8-661.3-147-827.7-86c-109.4,40.1-372.3,86-372.3,86H8665C8339.6,232.6,8261.1,28,8130,28c-85.9,0-159.3,27.7-292.7,127.3
				c-93.3,69.7-372.3,86-372.3,86h-44.2c-301.4-8.1-708.8-174.7-827.7-86c-78.8,58.8-289.7,79.6-353.6,84.7c-0.6,0-1.2,0.1-1.7,0.1
				c-1.1,0.1-2.2,0.2-3.2,0.2c-1.5,0.1-3,0.2-4.3,0.3c-0.9,0.1-1.7,0.1-2.4,0.2c-4.5,0.3-7,0.5-7,0.5h-44.1
				C5851.3,232.6,5772.8,8,5641.7,8c-85.9,0-159.3,47.7-292.7,147.3c-93.3,69.7-372.3,86-372.3,86h-44.1
				c-325.4-8.8-694.3-185.6-827.7-86c-93.3,69.7-372.3,86-372.3,86h-44.1C3363,232.6,3284.4,28,3153.4,28
				c-85.9,0-159.3,27.7-292.7,127.3c-93.3,69.7-372.3,86-372.3,86h-44.1c-325.4-8.8-403.9-179.3-535-179.3
				c-85.9,0-159.3-6.3-292.7,93.3c-93.3,69.7-372.3,86-372.3,86H1200C874.7,232.6,796.1,28,665,28c-85.9,0-159.3,27.7-292.7,127.3
				C278.9,225,0,241.3,0,241.3v57.2h0h1244.2h0h1244.2h0h1244.2h0h1244.2h0h1244.2h0H7465h0h1244.2l0,0h1244.2l0,0h1244.2l0,0h1244.2
				l0,0h1244.2v-57.2H13641.6z"/>
			</svg>

		</div>

	</div>
</section>
@endsection