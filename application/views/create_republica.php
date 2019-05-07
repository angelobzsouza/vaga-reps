<?php $this->load->view('includes/head') ?>	
	<?php $this->load->view('includes/navbar') ?>
	
	<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(<?= base_url('assets/images/nova-republica.jpg') ?>)">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-center">
					<div class="row row-mt-15em">
						<div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">#MOREEM<span class="text-orange">REP</span></span>
							<h1 class="cursive-font">Quer anunciar uma vaga?</h1>	
						</div>						
					</div>
				</div>
			</div>
		</div>
	</header>
	
	
	<div class="gtco-section">
		<div class="gtco-container">
			<div class="row text-center">
				<div class="col-md-12">
					<div class="col-md-12 animate-box">
						<h3>Cadastre sua república</h3>
						<div class="col-md-12 text-right">
							<small><a href="<?= base_url('entrar') ?>">Já possui cadastro? Faça o login!</a></small>
						</div>
						<form action="<?= base_url('republicas/create') ?>" method="post" name="form_cadastro" id="form_cadastro" class="text-left">

							<div class="form-row">
								<div class="col-md-12">
									<label for="nome_republica">Nome da República<span style="color: red;">*</span></label>
									<input type="text" name="nome_republica" id="nome_republica" class="form-control" placeholder="Ex: MelhorRep!" maxlength="50" required>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12">
									<label for="user" id="label_user">Nome de Usuário<span style="color: red;">*</span></label>
									<input type="text" name="user" id="user" class="form-control" placeholder="Ex: melhorrep123" maxlength="20" required>
									<small>Deve conter apenas elementos alfanuméricos</small>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6">
									<label for="senha" id="label_senha">Senha<span style="color: red;">*</span></label>
									<input type="password" name="senha" id="senha" class="form-control is-valid" placeholder="Senha" minlength="8" maxlength="50" required>
								</div>

								<div class="col-md-6">
									<label for="senha2">Confirmar Senha<span style="color: red;">*</span></label>
									<input type="password" name="senha2" id="senha2" class="form-control" placeholder="Confirmar Senha" minlength="8" maxlength="50" required>
								</div>

								<div class="col-md-12">
									<small>No mínimo 8 caracteres</small>
								</div>
							</div>

								<div class="form-row">
									<div class="col-md-6">
										<label for="tipo_republica">Tipo da República<span style="color: red;">*</span></label>
										<select name="tipo_republica" id="tipo_republica" class="form-control" required>
											<option value="">Selecione o tipo...</option>
											<option value="0" class="text-black">Feminina</option>
											<option value="1" class="text-black">Masculina</option>
											<option value="2" class="text-black">Mista</option>
										</select>	
									</div>

									<div class="col-md-6">
										<label for="telefone">Telefone<span style="color: red;">*</span></label>
										<input type="text" name="telefone" id="telefone" class="form-control" placeholder="Ex: (00) 00000-0000" maxlength="15" required>
									</div>
									
								</div>

							<div class="form-row">
								<div class="col-md-3">
									<label for="cep">CEP<span style="color: red;">*</span></label>
									<input type="text" name="cep" id="cep" class="form-control" placeholder="Ex: 00000-000" maxlength="9" required>
								</div>

								<div class="col-md-3">
									<label for="estado">Estado<span style="color: red;">*</span></label>
									<select name="estado" id="estado" class="form-control" required onchange="buscaCidades(this.value)">
										<option value="">Selecione o estado...</option>
										<?php foreach($estados as $estado): ?>
											<option value="<?= $estado->IDEstado ?>"><?= $estado->UF ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<div class="col-md-3">
									<label for="bairro">Cidade<span style="color: red;">*</span></label>
									<select name="cidade" id="cidade" class="form-control" required>
										<option value="">Selecione a cidade...</option>
									</select>
								</div>
								
								<div class="col-md-3">
									<label for="bairro">Bairro</label>
									<input type="text" name="bairro" id="bairro" class="form-control" placeholder="Ex: Bairro da Facul" maxlength="100">
								</div>
							</div>
							
							<div class="form-row">
								<div class="col-md-8 form-group">
									<label for="rua">Rua<span style="color: red;">*</span></label>
									<input type="text" name="rua" id="rua" class="form-control" placeholder="Ex: Av. Universitária" maxlength="200" required>
								</div>

								<div class="col-md-2 form-group">
									<label for="numero">Número</label>
									<input type="text" name="numero" id="numero" class="form-control" placeholder="Ex: 10" maxlength="10">
								</div>

								<div class="col-md-2 form-group">
									<label for="complemento">Complemento</label>
									<input type="text" name="complemento" id="complemento" class="form-control" placeholder="Ex: Apto 1" maxlength="50">
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group text-center">
										<input type="submit" value="Finalizar" class="btn btn-primary btn-cadastro">
									</div>
								</div>
							</div>

						</form>		
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->load->view('includes/footer') ?>