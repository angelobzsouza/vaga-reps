// Definições gerais
var base_url = "http://localhost/republicas/";
$('#cep').mask('00000-000');
$('#telefone').mask('(00) 00000-0000');

// VALIDAÇÕES DO FORMULÁRIO DE CADASTRO
$("#form_cadastro").submit(function (e) {
  var erro = 0;
  limpaValidacaoFormCadastro();
  // Valida senha
  var senha = $("#senha");
  var senha2 = $("#senha2");
  if (temAspas($(senha).val()) || temAspas($(senha2).val())) {
    $('#label_senha').text("A senha não pode conter \"\'\"");
    $('#label_senha').addClass("text-danger");
    $(senha).val("");
    $(senha2).val(""); 
    $(senha).addClass("is-invalid");
    e.preventDefault();
    return false;
  }

  if ($(senha).val() != $(senha2).val()) {
    $('#label_senha').text("As senhas devem ser iguais");
    $('#label_senha').addClass("text-danger");
    $(senha).val("");
    $(senha2).val(""); 
    $(senha).addClass("is-invalid");
    e.preventDefault();
    return false;
  }

  // Valida usuário
  if (!isAlphaNum($('#user').val())) {
    $("#label_user").text("Usuário inválido");
    $("#label_user").addClass("text-danger");
    $("#user").addClass("is-invalid");
    $("#user").val("");
    e.preventDefault();
    return false;
  }

  // Verifica se o usuário não está em uso
  var request = $.ajax({
    url: base_url+"credenciais/existUser",
    method: 'post',
    async: false,
    data: {'user': $('#user').val()}
  });

  request.done(function (existe) {
    if (existe == 1) {
      $("#label_user").text("Este usuário já está em uso");
      $("#label_user").addClass("text-danger");
      $("#user").addClass("is-invalid");
      $("#user").val("");
      erro = 1;
    }
  });

  request.fail(function () {
    alert("Estamos com problemas, tente novamente mais");
    e.preventDefault();
    erro = 1;
  });
  if (erro == 1) {
    e.preventDefault();
    return false;
  }
});

// Para inserir a localização manualmente
function buscaCidades (estado_id) {
	var request = $.ajax({
		url: base_url+"welcome/buscaCidades",
		data: {'estado_id': estado_id},
		method: "POST",
		dataType: 'json',
		async: false
	});

	request.done(function (cidades) {
		var select  = document.getElementById('cidade');
		$(select).empty();
    // Cria o elemento vazio
    var option = document.createElement("option");
    option.text = "Cidade";
    $(option).attr("value", "");
    $(option).addClass('text-black');
    select.add(option);   
		cidades.forEach(function (cidade) {
			var option = document.createElement("option");
			option.text = cidade.NomeCidade;
			$(option).attr("value", cidade.IDCidade);
      $(option).addClass('text-black');
			select.add(option);
		});
	});

  request.fail(function () {
    alert("Estamos com problemas, tente novamente mais tarde!");
    e.preventDefault();
  })
}

//Carregar o endereço automaticamente quando preenche o CEP
$("#cep").blur(function() {

  //Nova variável "cep" somente com dígitos.
  var cep = $(this).val().replace(/\D/g, '');

  //Expressão regular para validar o CEP.
  var validacep = /^[0-9]{8}$/;

  //Valida o formato do CEP.
  if(validacep.test(cep)) {
    //Preenche os campos com "..." enquanto consulta webservice.
    $("#rua").val("...");
    $("#bairro").val("...");

  // Selects de estado e cidade
  var cidade = document.getElementById('cidade');
  var estado = document.getElementById('estado');

    //Consulta o webservice viacep.com.br/
    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
      if (!("erro" in dados)) {
        //Atualiza os campos com os valores da consulta.
        $("#rua").val(dados.logradouro);
        $("#bairro").val(dados.bairro);
        $("#estado").val( $('option:contains('+dados.uf+')').val());
        var estado_id = $("#estado").val();
        buscaCidades(estado_id);
        $("#cidade").val( $('option:contains('+dados.localidade+')').val());
      } //end if.
      else {
        //CEP pesquisado não foi encontrado.
        alert("CEP não encontrado.");
      }
    });
  } //end if.
  else {
    //cep é inválido.
    alert("Formato de CEP inválido.");
  }
});

function limpaValidacaoFormCadastro () {
  // Limpa usuário
  $("#label_user").text("Nome de Usuário");
  $("#label_user").removeClass("text-danger");
  $("#user").removeClass("is-invalid");

  // Limpa senha
  var senha = $("#senha");
  $('#label_senha').text("Senha");
  $('#label_senha').removeClass("text-danger");
  $(senha).removeClass("is-invalid");
}

// VALIDAÇÕES PARA O LOGIN
$("form#form_login").submit(function (e) {
  var erro = 0;
  limpaValidacaoFormLogin();

  if (!isAlphaNum($("#user").val())) {
    $("#user").addClass('is-invalid');
    $("#user").attr('placeholder', "Nome de Usuário Inválido");
    $("#user").val('');
    e.preventDefault();
    return 0;
  }
});

function limpaValidacaoFormLogin () {
  $("#user").removeClass('is-invalid');
  $("#user").attr('placeholder', "Nome de Usuário");
  $("#senha").removeClass('is-invalid');
  $("#senha").attr('placeholder', "Senha");
}

// VISUALIZAÇÃO DE IMAGENS ANTES DO UPLOAD
// Show the selected image on input change
$("#input_0").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#tag_0').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#input_1").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#tag_1').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#input_2").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#tag_2').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#input_3").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#tag_3').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#input_4").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#tag_4').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#input_5").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#tag_5').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#foto_perfil").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#img_foto_perfil').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

$("#foto_capa").on('change', function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#img_foto_capa').attr("src", e.target.result).fadeIn();
    }
    reader.readAsDataURL(this.files[0]);
  }
});

// EXTRAS
function isAlphaNum(text){
  var alphaExp = /^[a-zA-Z-0-9]+$/;
  if(text.match(alphaExp)){
    return true;
  }else{
    return false;
  }
}

function temAspas (text) {
  if (text.indexOf('\'') > -1) {
    return true;
  }
  else {
    return false;
  }
}