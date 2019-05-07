<?php $this->load->view('includes/head') ?>
	<?php $this->load->view('includes/navbar') ?>

	<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(<?= base_url('assets/uploads/'.$republica->FotoCapa) ?>)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-center">
					<div class="row row-mt-15em">
						<div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
	          	<?php if ($republica->FotoPerfil != NULL) { ?>
								<img src="<?= base_url('assets/uploads/'.$republica->FotoPerfil) ?>" class="profile-image-header">
	          	<?php } else { ?>
								<img src="<?= base_url('assets/images/no-image-placeholder.png') ?>" class="profile-image-header">
	          	<?php } ?>
							<h1 class="cursive-font"><?= $republica->NomeRepublica ?></h1>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="gtco-section">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font primary-color">Sobre nós:</h2>
					<p class="text-justify wordwrap"><?= $republica->DescricaoRepublica ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-left gtco-heading">
					<p class="text-justify wordwrap"><b>Telefone:</b> <?= $republica->Telefone ?></p>
					<p class="text-justify wordwrap"><b>Endereço:</b> <?= $republica->Rua.", ".$republica->Numero." - ".$republica->Complemento." - ".$republica->Bairro." - ".$cidade." - ".$estado?></p>
				</div>
			</div>

			<!-- Fotos -->
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font primary-color">Fotos da República</h2>
				</div>

				<?php if (!empty($fotos)) { ?>
				<?php foreach($fotos as $foto) { ?>
					<div class="col-lg-4 col-md-4 col-sm-6">
						<a href="<?= base_url('assets/uploads/'.$foto->Foto) ?>" class="fh5co-card-item image-popup nomargin-image">
							<figure>
								<img src="<?= base_url('assets/uploads/'.$foto->Foto) ?>" alt="Image" class="img-responsive">
							</figure>
						</a>
					</div>
					<?php } ?>
				<?php } else { ?>
					<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
						<h4>A república não cadastrou fotos ainda</h4>
					</div>
				<?php } ?>
			</div><!-- /row -->

			<!-- Vagas -->
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font primary-color">Vagas na República</h2>
				</div>

				<?php if ($republica->IDRepublica == $this->session->republica_id) :?>
					<div class="col-md-12 text-right">
						<a href="<?= base_url('nova-vaga') ?>" class="btn btn-primary">Adicionar Vaga</a>
					</div>
				<?php endif ?>

				<?php if (!empty($vagas)) { ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="col-md-3">Vaga</th>
								<th class="col-md-3">Valor</th>
								<th class="col-md-3">Tipo</th>
								<th class="col-md-1"></th>
								<?php  if ($republica->IDRepublica == $this->session->republica_id) {?><th class="col-1"></th><?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach($vagas as $vaga) { ?>
								<tr>
									<td><?= $vaga->TituloVaga ?></td>
									<td>R$ <?= number_format($vaga->Preco, 2, ",", ".") ?></td>
									<td><?php 
										switch ($vaga->TipoVaga) {
											case 0:
												echo 'Individual';
												break;
											case 1:
												echo 'Compartilhada';
												break;
											case 2:
												echo 'Provisória';
												break;
											
											default:
												echo 'Erro';
												break;
										}
									?></td>
									<td class="text-right"><a href="<?= base_url('vaga/'.$vaga->IDVaga) ?>">Ver</a></td>
									<?php  if ($republica->IDRepublica == $this->session->republica_id) {?>
										<td class="text-right"><a href="<?= base_url('editar-vaga/'.$vaga->IDVaga) ?>">Editar</a></td>
									<?php } ?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
						<h4>No momento não há vagas nessa república</h4>
					</div>
				<?php } ?>

			</div><!-- /row -->
		</div>
	</div>

<?php $this->load->view('includes/footer') ?>