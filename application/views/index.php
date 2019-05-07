<?php $this->load->view('includes/head') ?>
	<?php $this->load->view('includes/navbar') ?>
	
	<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(<?= base_url('assets/images/background-general.jpeg') ?>)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					<div class="row row-mt-15em">
						<!-- Lado esquerdo do header -->
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">Econtre sua <a href="<?= base_url('vagas') ?>">Vaga</a></span>
							<h1 class="cursive-font">#MoreEmRep</h1>	
						</div><!-- Lado esquerdo do header -->
						<!-- Lado direito do header -->
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">		
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
											<h3 class="cursive-font">Procurar Vaga</h3>
											<form action="<?= base_url('filtra-vagas') ?>" method="post">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="tipo_vaga">Tipo de Vaga</label>
														<select name="tipo_vaga" id="tipo_vaga" class="form-control">
															<option value="" class="text-black">Tipo</option>
															<option value="0" class="text-black">Individual</option>
															<option value="1" class="text-black">Compartilhada</option>
															<option value="2" class="text-black">Provisória</option>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="estado">Estado</label>
														<select name="estado" id="estado" class="form-control" onchange="buscaCidades(this.value)">
															<option value="" class="text-black">Estado</option>
															<?php foreach($estados as $estado): ?>
																<option value="<?= $estado->IDEstado ?>" class="text-black"><?= $estado->UF ?></option>
															<?php endforeach ?>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="cidade">Cidade</label>
														<select name="cidade" id="cidade" class="form-control">
															<option value="" class="text-black">Cidade</option>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Procurar">
													</div>
												</div>
											</form>	
										</div>
									</div>
								</div>
							</div>
						</div><!-- /Lado direito do header -->
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<!-- Ultimas vagas -->
	<div class="gtco-section">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font primary-color">Últimas Vagas</h2>
					<p>Veja as últimas vagas anunciadas no site</p>
				</div>
			</div>
			<div class="row">

				<?php foreach($ultimas_vagas as $vaga) { ?>
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
				<?php } ?> 
				
			</div><!-- /row -->
		</div>
	</div>
	
	<!-- Nossos valores -->
	<div id="gtco-features">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
					<h2 class="cursive-font">Nossa Missão</h2>
					<p>Saiba um pouco mais sobre o que move o VagaReps e o que buscamos trazer para nossos clientes e para o mundo.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="ti-face-smile"></i>
						</span>
						<h3>Facilidade</h3>
						<p>Ajudar universitários a encontrar um lugar para morar que condiza com seu perfil e interesses.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="ti-infinite"></i>
						</span>
						<h3>Tradição</h3>
						<p>Ajudar republicas universitárias a encontrar novos moradores e manter suas tradições ao longo dos anos.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="ti-money"></i>
						</span>
						<h3>Sem Fins Lucrativos</h3>
						<p>Nosso projeto não tem fins lucrativos e estamos buscando apenas apoiar de alguma forma os universitários e repúblicas do Brasil.</p>
					</div>
				</div>
				

			</div>
		</div>
	</div>

	<!-- Frase motivacional -->
	<div class="gtco-cover gtco-cover-sm" style="background-image: url(<?= base_url('assets/images/background-general.jpeg') ?>)"  data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container text-center">
			<div class="display-t">
				<div class="display-tc">
					<h1>&ldquo; A amizade desenvolve a felicidade e reduz o sofrimento, duplicando a nossa alegria e dividindo a nossa dor!&rdquo;</h1>
					<p>&mdash; Joseph Addison</p>
				</div>	
			</div>
		</div>
	</div>

	<!-- Fatos Engraçados -->
	<div id="gtco-counter" class="gtco-section">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
					<h2 class="cursive-font primary-color">Números</h2>
					<p>Veja em números nossas realizações até o dia de hoje</p>
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="<?= $qtde_reps ?>" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Reps Cadastradas</span>

					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="<?= $qtde_vagas ?>" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Vagas Anunciadas</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="<?= $qtde_reps * 2 ?>" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Festas Realizadas</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="<?= $qtde_vagas * 5 ?>" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Amizades Construídas</span>

					</div>
				</div>
					
			</div>
		</div>
	</div>

<?php $this->load->view('includes/footer') ?>