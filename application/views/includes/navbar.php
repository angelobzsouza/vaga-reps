<nav class="gtco-nav" role="navigation">
	<div class="gtco-container">
		
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div id="gtco-logo"><a href="<?= base_url() ?>">VagaReps <em>.</em></a></div>
			</div>
			<div class="col-xs-8 text-right menu-1">
				<!-- Navbar deslogada -->
				<?php if(!$this->session->login) { ?>
					<ul>
						<li><a href="<?= base_url() ?>">Home</a></li>
						<li><a href="<?= base_url('vagas') ?>">Vagas</a></li>
						<li><a href="<?= base_url('entrar') ?>">Login</a></li>
						<li class="btn-cta"><a href="<?= base_url('cadastrar') ?>"><span>Anunciar</span></a></li>
					</ul>
				<!-- Navbar logada -->
				<?php } else { ?>
				<ul>
					<li>Eae! <span class="text-white"><?= $this->session->user ?>&nbsp</span></li>
					<li class="has-dropdown">
						<a href="<?= base_url('republica/'.$this->session->republica_id) ?>">
	          	<?php if ($this->session->foto_perfil != NULL) { ?>
	          		<img src="<?= base_url('assets/uploads/'.$this->session->foto_perfil) ?>" width="30" height="30" class="rounded-circle">
	          	<?php } else { ?>
	          		<img src="<?= base_url('assets/images/no-image-placeholder.png') ?>" width="30" height="30" class="rounded-circle">
	          	<?php } ?>
						</a>
						<ul class="dropdown">
							<li><a href="<?= base_url() ?>">Home</a></li>
							<li><a href="<?= base_url('vagas') ?>">Vagas</a></li>
							<li><a href="<?= base_url('republica/'.$this->session->republica_id) ?>">Página da Rep</a></li>
							<li><a href="<?= base_url('editar-perfil/'.$this->session->republica_id) ?>">Editar Perfil</a></li>
							<li><a href="<?= base_url('sair') ?>">Sair</a></li>
						</ul>
					</li>
				</ul>
				<?php } ?>
			</div>
		</div>
		
	</div>
</nav>