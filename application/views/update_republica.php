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
							<h1 class="cursive-font">Atualizar Perfil</h1>	
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
						<h3>Informações</h3>
						<form action="<?= base_url('republicas/update') ?>" method="post" name="form_cadastro" id="form_update_perfil" class="text-left" enctype="multipart/form-data">
							<!-- Id enviado por post -->
							<input type="hidden" name="republica_id" id="republica_id" value="<?= $republica->IDRepublica ?>">

							<div class="form-row">
								<div class="col-md-12">
									<label for="nome_republica">Nome da República<span style="color: red;">*</span></label>
									<input type="text" name="nome_republica" id="nome_republica" class="form-control" placeholder="Ex: MelhorRep!" maxlength="50" required value="<?= $republica->NomeRepublica ?>">
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-3">
									<label for="cep">CEP<span style="color: red;">*</span></label>
									<input type="text" name="cep" id="cep" class="form-control" placeholder="Ex: 00000-000" maxlength="9" required value="<?= $republica->CEP ?>">
								</div>

								<div class="col-md-3">
									<label for="estado">Estado<span style="color: red;">*</span></label>
									<select name="estado" id="estado" class="form-control" required onchange="buscaCidades(this.value)">
										<option value="">Selecione o estado...</option>
										<?php foreach($estados as $estado): ?>
											<option value="<?= $estado->IDEstado ?>" <?= ($republica->IDEstado == $estado->IDEstado) ? 'selected':'' ?>><?= $estado->UF ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<div class="col-md-3">
									<label for="bairro">Cidade<span style="color: red;">*</span></label>
									<select name="cidade" id="cidade" class="form-control" required>
										<option value="">Selecione a cidade...</option>
										<?php foreach($cidades as $cidade): ?>
											<option value="<?= $cidade->IDCidade ?>" <?= ($republica->IDCidade == $cidade->IDCidade) ? 'selected':'' ?>><?= $cidade->NomeCidade ?></option>
										<?php endforeach ?>
									</select>
								</div>
								
								<div class="col-md-3">
									<label for="bairro">Bairro</label>
									<input type="text" name="bairro" id="bairro" class="form-control" placeholder="Ex: Bairro da Facul" maxlength="100" value="<?= $republica->Bairro ?>">
								</div>
							</div>
							
							<div class="form-row">
								<div class="col-md-8 form-group">
									<label for="rua">Rua<span style="color: red;">*</span></label>
									<input type="text" name="rua" id="rua" class="form-control" placeholder="Ex: Av. Universitária" maxlength="200" required value="<?= $republica->Rua ?>">
								</div>

								<div class="col-md-2 form-group">
									<label for="numero">Numero</label>
									<input type="text" name="numero" id="numero" class="form-control" placeholder="10" maxlength="10" value="<?= $republica->Numero ?>">
								</div>

								<div class="col-md-2 form-group">
									<label for="complemento">Complemento</label>
									<input type="text" name="complemento" id="complemento" class="form-control" placeholder="50" maxlength="50" value="<?= $republica->Complemento ?>">
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6">
									<label for="telefone">Telefone<span style="color: red;">*</span></label>
									<input type="text" name="telefone" id="telefone" class="form-control" placeholder="Ex: (00) 00000-0000" maxlength="15" value="<?= $republica->Telefone ?>" required>
								</div>
								<div class="col-md-6">
									<label for="tipo">Tipo da República<span style="color: red;">*</span></label>
									<select name="tipo" id="tipo" class="form-control" required>
										<option value="">Selecione...</option>
										<option value="0" <?= $republica->TipoRepublica == 0 ? "selected":"" ?>>Feminina</option>
										<option value="1" <?= $republica->TipoRepublica == 1 ? "selected":"" ?>>Masculina</option>
										<option value="2" <?= $republica->TipoRepublica == 2 ? "selected":"" ?>>Mista</option>
									</select>
								</div>
							</div>

							<!-- Descricao -->
							<div class="form-row">
								<div class="col-md-12">
									<label for="descricao">Descrição</label>
									<textarea name="descricao" id="descricao"><?= $republica->DescricaoRepublica ?></textarea>
								</div>
							</div>

							<!-- Fotos de Perfil e Capa -->
							<div class="form-row">
								<div class="col-md-6 text-center" style="margin-top: 3vh">
									<p>Foto de perfil</p>
									<?php if (empty($republica->FotoPerfil)): ?>
										<label for="foto_perfil"><img src="<?= base_url('assets/images/no-image-placeholder.png') ?>" id="img_foto_perfil" class="img-clicavel img-responsive" width="256"></label>
									<?php else : ?>
										<label for="foto_perfil"><img src="<?= base_url('assets/uploads/'.$republica->FotoPerfil) ?>" id="img_foto_perfil" class="img-clicavel img-responsive" width="256"></label>
									<?php endif; ?>
									<input type="file" name="foto_perfil" id="foto_perfil" class="sr-only">
								</div>
								<div class="col-md-6 text-center" style="margin-top: 3vh">
									<p>Foto de capa</p>
									<?php if (empty($republica->FotoCapa)): ?>
										<label for="foto_capa"><img src="<?= base_url('assets/images/cover-photo-placeholder.png') ?>" id="img_foto_capa" class="img-clicavel img-responsive" width="256"></label>
									<?php else : ?>
										<label for="foto_capa"><img src="<?= base_url('assets/uploads/'.$republica->FotoCapa) ?>" id="img_foto_capa" class="img-clicavel img-responsive" width="256"></label>
									<?php endif; ?>
									<input type="file" name="foto_capa" id="foto_capa" class="sr-only">
								</div>
							</div>

							<!-- Fotos -->
							<div class="form-row">
								<div class="col-md-12" style="margin-top: 3vh">
									<label>Fotos</label>
								</div>
								<!-- "Array" de "objetos" fotos -->
								<?php for ($i = 0; $i < 6; $i++) :?>
									<!-- Label e tag -->
									<label for="input_<?= $i ?>" class="col-md-2 text-center">
										<?php if (!empty($fotos[$i])): ?>
											<img src="<?= base_url('assets/uploads/'.$fotos[$i]->Foto) ?>" class="img-clicavel" id="tag_<?= $i ?>" width="100" height="100">
										<?php else: ?>
											<img src="<?= base_url('assets/images/add-image-placeholder.png') ?>" class="img-clicavel" id="tag_<?= $i ?>" width="100" height="100">
										<?php endif; ?>
									</label>
									<!-- Nome do arquivo -->
									<input type="hidden" name="arquivo_<?= $i ?>" id="arquivo_<?= $i ?>" value="<?= empty($fotos[$i]->Foto) ? '':$fotos[$i]->Foto ?>">
									<!-- Input -->
									<input type="file" name="input_<?= $i ?>" id="input_<?= $i ?>" class="sr-only">
								<?php endfor; ?>

								<div class="col-md-12" style="margin-top: 3vh">
									<?php if (isset($erro)) : ?>
										<small class="text-danger">Erro no upload: São aceitos arquivos de até 2Mb com dimensões de no máximo 1920x1080 nos formatamos jpg, jpeg ou png.</small>
									<?php else : ?>
										<small>São aceitos arquivos de até 2Mb com dimensões de no máximo 1920x1920 nos formatamos jpg, jpeg ou png.</small>
									<?php endif; ?>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group text-center">
										<input type="submit" value="Salvar" class="btn btn-primary btn-cadastro">
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
<!-- Script Froala -->
<script src="<?php echo base_url('assets/froala-editor/js/froala_editor.pkgd.min.js') ?>"></script>
<script type="text/javascript">
// Editor de texto Froala
	$(function() {
		$("#descricao").froalaEditor({
			charCounterCount: true,
			charCounterMax: 1000,
			fileUpload: false,
			fullPage: false,	
			height: 200,
			placeholderText: "Fale um pouco sobre a república...",
			toolbarButtons: ['bold', 'italic', 'underline'],
			wordPasteKeepFormatting: false,
		});
	});
</script>