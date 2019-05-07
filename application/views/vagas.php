<?php $this->load->view('includes/head') ?>
	<?php $this->load->view('includes/navbar') ?>
	<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(<?= base_url('assets/images/background-general-2.jpg') ?>)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-center">
					<div class="row row-mt-15em">
						<div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">#MOREEM<span class="text-orange">REP</span></span>
							<h1 class="cursive-font">Veja todas as nossas vagas!</h1>	
						</div>
						
					</div>
							
					
				</div>
			</div>
		</div>
	</header>

	<div class="gtco-section">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 text-center gtco-heading">
					<h2 class="cursive-font primary-color">Vagas</h2>
					<!-- Filtros -->
						<form action="<?= base_url('filtra-vagas') ?>" method="post" id="filter_form">
							<div class="form-row">
								<div class="form-group col-md-2">
										<label for="tipo_rap">Tipo de Rep</label>
										<select name="tipo_rep" id="tipo_rep" class="form-control">
											<option value="" class="text-black">Tipo</option>
											<option value="0" <?= $filtros['TipoRepublica'] === '0' ? 'selected':'' ?> class="text-black">Feminina</option>
											<option value="1" <?= $filtros['TipoRepublica'] === '1' ? 'selected':'' ?> class="text-black">Masculina</option>
											<option value="2" <?= $filtros['TipoRepublica'] === '2' ? 'selected':'' ?> class="text-black">Mista</option>
										</select>
								</div>
								<div class="form-group col-md-2">
										<label for="tipo_vaga">Tipo de Vaga</label>
										<select name="tipo_vaga" id="tipo_vaga" class="form-control">
											<option value="" class="text-black">Tipo</option>
											<option value="0" <?= $filtros['TipoVaga'] === '0' ? 'selected':'' ?> class="text-black">Individual</option>
											<option value="1" <?= $filtros['TipoVaga'] === '1' ? 'selected':'' ?> class="text-black">Compartilhada</option>
											<option value="2" <?= $filtros['TipoVaga'] === '2' ? 'selected':'' ?> class="text-black">Provisória</option>
										</select>
								</div>
								<div class="form-group col-md-2">
										<label for="estado">Estado</label>
										<select name="estado" id="estado" class="form-control" onchange="buscaCidades(this.value)">
											<option value="" class="text-black">Estado</option>
												<?php foreach($estados as $estado): ?>
													<option value="<?= $estado->IDEstado ?>" <?= $filtros['IDEstado'] == $estado->IDEstado ? 'selected':'' ?> class="text-black"><?= $estado->UF ?></option>
												<?php endforeach ?>
										</select>
								</div>
								<div class="form-group col-md-2">
										<label for="cidade">Cidade</label>
										<select name="cidade" id="cidade" class="form-control">
											<option value="" class="text-black">Cidade</option>
												<?php foreach($cidades as $cidade): ?>
													<option value="<?= $cidade->IDCidade ?>" <?= $filtros['IDCidade'] == $cidade->IDCidade ? 'selected':'' ?> class="text-black"><?= $cidade->NomeCidade ?></option>
												<?php endforeach ?>
										</select>
								</div>
								<div class="form-group col-md-2">
										<label for="valor">Valor Máximo R$</label>
										<input type="number" step="0.1" name="valor" id="valor" class="form-control" value="<?= $filtros['Preco'] ?>">
								</div>
								<div class="form-group col-md-2">
										<label for="layout">&nbsp</label>
										<input type="submit" name="submit" id="sumbit" class="btn btn-primary btn-block" value="Filtrar">
								</div>
							</div>
						</form>	
				</div>
			</div>
			<div class="row">

				<?php foreach($vagas as $vaga) : ?>
					<div class="col-lg-4 col-md-4 col-sm-6">
						<a href="<?= base_url('vaga/'.$vaga->IDVaga) ?>" class="fh5co-card-item">
							<figure>
								<div class="overlay"><i class="ti-eye"></i></div>
								<?php if (empty($vaga->Thumb)): ?>
									<img src="<?= base_url('assets/images/house-placeholder.png') ?>" alt="Image" class="img-responsive">
								<?php else: ?>
									<img src="<?= base_url('assets/uploads/'.$vaga->Thumb) ?>" alt="Image" class="img-responsive">
								<?php endif; ?>
							</figure>
							<div class="fh5co-text">
								<h2><?= $vaga->TituloVaga ?></h2>
								<p><?= substr($vaga->DescricaoVaga, 0, 70)."..." ?>
								</p>
								<p><span class="price cursive-font">R$<?= number_format($vaga->Preco, 2, ",", ".") ?>/mês</span></p>
							</div>
						</a>
					</div>
				<?php endforeach ?>

				<div class="col-md-12 text-center">
					<?= $this->pagination->create_links() ?>
				</div>

			</div><!-- /row -->
		</div>
	</div>
	
<?php $this->load->view('includes/footer') ?>