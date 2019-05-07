<?php $this->load->view('includes/head') ?>
	<?php $this->load->view('includes/navbar') ?>

	<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(<?= base_url('assets/images/background-general-2.jpg') ?>)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-center">
					<div class="row row-mt-15em">
						<div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
	          	<?php if ($republica->FotoPerfil != NULL) { ?>
								<a href="<?= base_url('republica/'.$republica->IDRepublica) ?>"><img src="<?= base_url('assets/uploads/'.$republica->FotoPerfil) ?>" class="profile-image-header"></a>
	          	<?php } else { ?>
								<a href="<?= base_url('republica/'.$republica->IDRepublica) ?>"><img src="<?= base_url('assets/images/no-image-placeholder.png') ?>" class="profile-image-header"></a>
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
					<h2 class="cursive-font primary-color"><?= $vaga->TituloVaga ?></h2>
					<p class="text-left"><b>Preço: R$</b><?= number_format($vaga->Preco, 2, ",", ".") ?>/mês</p>
					<p class="text-left"><b>Tipo:</b> <?php
						switch ($vaga->TipoVaga) {
							case 0:
								echo "Individual";
							break;
							
							case 1:
								echo "Compartilhada";
							break;

							case 2:
								echo "Provisória";
							break;

							default:
								echo 'Erro';
								break;
						}
					?></p>
					<p class="text-left"><b>Publicada em:</b> <?php $data = date_create($vaga->SalvoEm); echo date_format($data,"d/m/Y"); ?></p>
					<p class="text-left"><b>Republica:</b> <a href="<?= base_url('republica/'.$republica->IDRepublica) ?>"><?= $republica->NomeRepublica ?></a></p>
					<p class="text-left text-justify wordwrap"><b>Sobre:</b> <?= $vaga->DescricaoVaga ?></p>

				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font primary-color">Fotos da Vaga</h2>
				</div>

				<?php if (empty($fotos)): ?>
					<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
						<h5>Não foram cadastradas fotos dessa vaga.</h5>
					</div>
				<?php endif ?>

				<?php foreach($fotos as $foto) : ?>
				<div class="col-lg-4 col-md-4 col-sm-6">
					<a href="<?= base_url('assets/uploads/'.$foto->Foto) ?>" class="fh5co-card-item image-popup nomargin-image">
						<figure>
							<img src="<?= base_url('assets/uploads/'.$foto->Foto) ?>" alt="Image" class="img-responsive">
						</figure>
					</a>
				</div>
				<?php endforeach ?>

			</div>
		</div>
	</div>

<?php $this->load->view('includes/footer') ?>