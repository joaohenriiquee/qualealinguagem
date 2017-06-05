<!DOCTYPE html>
<html>
<head>
<title>Qualé a linguagem?</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="text-align: center;">
	<div class="row" style="background: url('./images/bg.jpg');">
		<div class="col s12">
			<h1 style="color:#fff;opacity:0.8;background-color: #000;">Qualé a linguagem?</h1>
			<h6 id="texto1" style="color: #fff;background-color: #0089ec;">Nosso programa não é tão inteligente assim... Então, mostre para ele alguns códigos.</h6>
			<h6 id="texto2" style="background-color: #fff;">Ensine dizendo qual a linguagem que voce está falando</h6>
		</div>
	</div>
	<div class="container">

		<div class="col s12">
			<div class="row">
				<div class="col s12">
					<h4 style="color:red;" id="resultado"></h4>
				</div>
			</div>
		    <div class="row">
		    	<div class="col s6">
		    		<label>Etapa I - Aprendizado</label>
					<div class="row card-panel hoverable">
						<div class="col s12">
					      <div class="row">
					        <div id="div_linguagem" class="input-field col s6">
					          <input id="linguagem_ensinar" type="text" class="validate">
					          <label for="linguagem_ensinar">Linguagem</label>
					        </div>
					      </div>
					    </div>
					    <div class="col s12">
					      <div class="row">
					        <div class="input-field col s12">
					          <textarea id="codigoaprendizado" class="materialize-textarea"></textarea>
					          <label for="codigoaprendizado">Código</label>
					        </div>
					      </div>
					    </div>
					    <div class="col s12">
					    	<button class="waves-effect waves-light btn red darken-2" id="botaoensinar" onclick="ensinar();">Ensinar</button>
							<button style="color: #000;" class="waves-effect waves-light btn yellow" id="botaotudopronto" onclick="tudopronto();">Tudo pronto!</button>
					    </div>
					</div>
				</div>

				<div class="col s6">
		    		<label>Etapa II - Decifrar</label>
					<div class="row card-panel hoverable">
					    <div class="col s12">
					      <div class="row">
					        <div class="input-field col s12">
					          <textarea id="codigo" class="materialize-textarea" disabled></textarea>
					          <label for="codigo">Código</label>
					        </div>
					      </div>
					    </div>
					    <div class="col s12">
					    	<button class="waves-effect waves-light btn green" id="botaodecifrar" onclick="lercodigo();" disabled>DECIFRAR</button>
					    	<button class="waves-effect waves-light btn black" id="botaoresetar" onclick="location.reload();" disabled>RESETAR</button>
					    </div>
					</div>
				</div>

			</div>

			<div class="row" style="text-align: left;">
				<label>Instruções</label>
				<div class="col s12">
					<label><strong>Primeira Etapa - Aprendizado:</strong> Informe uma linguagem e escreva o código de aprendizagem logo abaixo. Após isso aperte no botão 'ENSINAR'. Esse procedimento pode ser feito quantas vezes achar necessário. Quando achar necessário parar aperte no botão 'TUDO PRONTO!' e poderá nesse momento decifrar outros códigos.</label>
					<br>
					<label><strong>Segunda Etapa - Decifrar:</strong> Digite um código e aperte em decifrar. O código será cruzado com as informações do aprendizado e mostrará a linguagem na qual foi escrito. OBS: Só será possível decifrar linguagens utilizadas no aprendizado.</label>
				</div>
			</div>

		</div>

	</div>

<script>

	var array_aprendizado = [];
	var pontuacao = [];

	function ensinar(){

		var dados = [];

		if($("#linguagem_ensinar").val() != '' && $("#codigoaprendizado").val()){

			var linguagem_ensinar = $("#linguagem_ensinar").val().toLowerCase();

			var texto = $("#codigoaprendizado").val();
			var texto_quebrado = texto.split(" ");

			console.log(linguagem_ensinar);
			console.log(texto_quebrado);

			if(array_aprendizado.length > 0) {
				$.each(array_aprendizado,function(index,value){

					if(value.linguagem == linguagem_ensinar){

						$.each(texto_quebrado,function(index2,value2){
							if(value.estrutura.indexOf(value2) == -1){
								console.log(value2);
								dados.push(value2);
								value.estrutura.push(value2);
							}
						});
					}
				});

				if(dados.length == 0) {
					$.each(texto_quebrado,function(index3,value3){
						console.log(value3);
						dados.push(value3);
					});
					array_aprendizado.push({linguagem:linguagem_ensinar,estrutura: dados});
					pontuacao.push({linguagem: linguagem_ensinar, pontos: 0});
				}

			}else{
				$.each(texto_quebrado,function(index4,value4){
					console.log(value4);
					dados.push(value4);
				});
				array_aprendizado.push({linguagem:linguagem_ensinar,estrutura: dados});
				pontuacao.push({linguagem: linguagem_ensinar, pontos: 0});
			}

			alert("Ensinado com sucesso!");
			$("#linguagem_ensinar").val('');
			$("#codigoaprendizado").val('');

		}else{
			alert("Campos insuficientes!");
		}

		console.log(array_aprendizado);
	}

	function adicionarpontos(linguagem){
		$.each(pontuacao,function(index,value){
			if(value.linguagem == linguagem){
				value.pontos = value.pontos + 1;
			}
		});
	}

	function resetarpontos(){
		$.each(pontuacao,function(index,value){
			value.pontos = 0;
		});
	}

	function getvencedor(){
		var vencedor = '';
		$.each(pontuacao,function(index,value){
			if(value.pontos > vencedor.pontos || vencedor == '' && value.pontos > 0){
				vencedor = value;
			}
		});

		if(vencedor != ''){
			return vencedor;
		}else{
			return false;
		}
		
	}

	function buscalinguagem(codigo){
		resetarpontos();
		$.each(array_aprendizado,function(index,value){
			$.each(value.estrutura,function(index2,value2){
				if(codigo.indexOf(value2) > -1){
					adicionarpontos(value.linguagem);
				}
			});
		});

		console.log(pontuacao);
		if(getvencedor()){
			return getvencedor().linguagem;
		}else{
			return "Linguagem não identificada.";
		}
		
	}

	function lercodigo(){
		setTimeout(function(){
			$("#resultado").html("Linguagem utilizada foi "+buscalinguagem($("#codigo").val()));
			$("#codigo").val('');
		},500);
	}

	function tudopronto(){
		$( "#linguagem_ensinar" ).prop( "disabled", true );
		$( "#codigoaprendizado" ).prop( "disabled", true ); 
		$( "#botaoensinar" ).prop( "disabled", true );
		$( "#botaotudopronto" ).prop( "disabled", true );

		$( "#codigo" ).prop( "disabled", false );
		$( "#botaodecifrar" ).prop( "disabled", false ); 
		$( "#botaoresetar" ).prop( "disabled", false );

		$("#texto1").html("Motores preparados."); 
		$("#texto2").html("Manda brasa!"); 
		
	}

</script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

</body>
</html>