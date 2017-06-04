<!DOCTYPE html>
<html>
<head>
<title>Qualé a linguagem?</title>
</head>
<body>
	<style type="text/css">
		
		body {
			text-align: center;
		}

	</style>

	<h1>Qualé a linguagem?</h1>
	<h5 id="texto1">Nosso programa não é tão inteligente assim... Então, mostre para ele alguns códigos.</h5>
	<h6 id="texto2">Ensine dizendo qual a linguagem que voce está falando</h6>

<div id="div_linguagem">
	<label for="linguagem_ensinar">Linguagem:</label>
	<input id="linguagem_ensinar" type="text" name="linguagem_ensinar">
</div>
	
<br>
<textarea id="codigo" style="width: 300px;height: 200px;"></textarea>
<br>
<button id="botaoensinar" onclick="ensinar();">Ensinar</button>
<button id="botaolercodigo" onclick="tudopronto();">Ele está pronto!</button>
<!-- <button id="botaolercodigo" onclick="lercodigo();">Enviar</button> -->
<br>
<p id="resultado"></p>

<script>

	var array_aprendizado = [];
	var pontuacao = [];

	function ensinar(){

		var dados = [];

		if($("#linguagem_ensinar").val() != '' && $("#codigo").val()){

			var linguagem_ensinar = $("#linguagem_ensinar").val().toLowerCase();

			var texto = $("#codigo").val();
			var texto_quebrado = texto.split(" ");

			console.log(linguagem_ensinar);
			console.log(texto_quebrado);

			if(array_aprendizado.length > 0) {
				$.each(array_aprendizado,function(index,value){

					if(value.linguagem == linguagem_ensinar){

						$.each(texto_quebrado,function(index2,value2){
							if(value.estrutura.indexOf(value2) == -1){
								dados.push(value2);
								value.estrutura.push(value2);
							}
						});
					}
				});

				if(dados.length == 0) {
					$.each(texto_quebrado,function(index3,value3){
						dados.push(value3);
					});
					array_aprendizado.push({linguagem:linguagem_ensinar,estrutura: dados});
					pontuacao.push({linguagem: linguagem_ensinar, pontos: 0});
				}

			}else{
				$.each(texto_quebrado,function(index4,value4){
					dados.push(value4);
				});
				array_aprendizado.push({linguagem:linguagem_ensinar,estrutura: dados});
				pontuacao.push({linguagem: linguagem_ensinar, pontos: 0});
			}

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
			$("#resultado").html(buscalinguagem($("#codigo").val()));

			$("#linguagem_ensinar").val('');
			$("#codigo").val('');
		},500);
	}

	function tudopronto(){
		$("#botaolercodigo").attr("onclick","lercodigo()");
		$("#botaolercodigo").html("Enviar"); 
		$("#codigo").val('');
		$("#botaoensinar").css({"display":"none"}); 
		$("#div_linguagem").css({"display":"none"});

		$("#texto1").html("Motores preparados!"); 
		$("#texto2").html("Manda brasa"); 
		
	}

</script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

</body>
</html>