<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Republicas extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Republica_model', 'republica');
	}

	public function index() {
		redirect(base_url());
	}

	// Retorno: Tela de perfil da republica
	public function republica ($republica_id = NULL) {
		$this->load->model("Localizacao_model", "localizacao");
		// Busca Republica
		$data['republica'] = $this->republica->read($republica_id);
		$data['estado'] = $this->localizacao->getStateUf($data['republica']->IDEstado);
		$data['cidade'] = $this->localizacao->getCityName($data['republica']->IDCidade);
		$data['fotos'] = $this->republica->buscaFotosDaRepublica($republica_id);
		$data['vagas'] = $this->republica->buscaVagasDaRepublica($republica_id);
		$data['title'] = $data['republica']->NomeRepublica;
		// Chama view
		$this->load->view('republica', $data);
	}

	// CRUD
	// Retorno: Tela do cadastro de republicas
	public function createView () {
		// Busca os estados
		$this->load->model('Localizacao_model', 'estados');
		$data['estados'] = $this->estados->readStates();
		$data['title'] = "Cadastrar";
		$this->load->view('create_republica', $data);
	}

	// Parametros: Infos do cadastro por POST
	// Retorno: Vai para  a tela de perfil
	public function create () {
		// Validação
		$this->form_validation->set_rules('nome_republica', "Nome da Republica", "required|max_length[50]");
		$this->form_validation->set_rules('user', "Nome da Usuário", "required|max_length[20]|alpha_numeric|is_unique[Republica.Usuario]");
		$this->form_validation->set_rules('senha', "Senha", "required|max_length[50]|min_length[8]|matches[senha]");
		$this->form_validation->set_rules('senha2', "Confirmação de Senha", "required|max_length[50]|min_length[8]");
		$this->form_validation->set_rules('cep', "CEP", "required|max_length[9]");
		$this->form_validation->set_rules('tipo_republica', "Tipo de Republica", "required|numeric");
		$this->form_validation->set_rules('telefone', "Telefone", "required|max_length[15]");
		$this->form_validation->set_rules('estado', "Estado", "required");
		$this->form_validation->set_rules('cidade', "Cidade", "required");
		$this->form_validation->set_rules('bairro', 'Bairro', "max_length[100]");
		$this->form_validation->set_rules('rua', 'Rua', "max_length[200]|required");
		$this->form_validation->set_rules('numero', 'Numero', "max_length[10]");
		$this->form_validation->set_rules('complemento', 'Complemento', "max_length[50]");

		// Pega as variáveis
		$republica['NomeRepublica'] = $this->input->post('nome_republica');
		$republica['Usuario'] = $this->input->post('user');
		$republica['Senha'] = sha1($this->input->post('senha'));
		$republica['CEP'] = $this->input->post('cep');
		$republica['IDEstado'] = $this->input->post('estado');
		$republica['IDCidade'] = $this->input->post('cidade');
		$republica['Bairro'] = $this->input->post('bairro');
		$republica['Rua'] = $this->input->post('rua');
		$republica['Numero'] = $this->input->post('numero');
		$republica['Complemento'] = $this->input->post('complemento');
		$republica['Telefone'] = $this->input->post('telefone');
		$republica['TipoRepublica'] = $this->input->post('tipo_republica');

		// Se a validação der certo cadastra, se não, vai para a tela de erro
		if($this->form_validation->run('form_cadastro')) {
			$republica_id = $this->republica->create($republica);
			$this->load->model("Credencial_model", "credencial");
			$this->credencial->login($republica['Usuario'], $republica['Senha']);
		}
		else {
			$this->load->view('errors/VagaReps_errors/error_general');
			return;
		}
		redirect(base_url('republica/'.$republica_id));
	}

	// Parametros: Id do usuário por GET
	// Retorno: Tela de edição
	public function updateView ($republica_id = NULL, $erro = NULL) {
		if ($republica_id != $this->session->republica_id) {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
		// Busca Republica
		$data['republica'] = $this->republica->read($republica_id);
		$data['fotos'] = $this->republica->buscaFotosDaRepublica($republica_id);
		$this->load->model('Localizacao_model', 'estados');
		$data['estados'] = $this->estados->readStates();
		$data['cidades'] = $this->estados->readCitiesByState($data['republica']->IDEstado);
		$data['title'] = "Editar Perfil";
		if (!empty($erro)) $data['erro'] = true;

		$this->load->view('update_republica', $data);
	}

	// Parametros: Infos do usuário por POST
	// Retorno: Página de perfil
	public function update () {
		// Verifica se o usuário é dono do perfil de edição
		if ($this->input->post('republica_id') != $this->session->republica_id) {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}

		// Valida o forms
		// Validação
		$this->form_validation->set_rules('nome_republica', "Nome da Republica", "required|max_length[50]");
		$this->form_validation->set_rules('cep', "CEP", "required|max_length[9]");
		$this->form_validation->set_rules('estado', "Estado", "required");
		$this->form_validation->set_rules('cidade', "Cidade", "required");
		$this->form_validation->set_rules('bairro', 'Bairro', "max_length[100]");
		$this->form_validation->set_rules('rua', 'Rua', "max_length[200]|required");
		$this->form_validation->set_rules('numero', 'Numero', "max_length[10]");
		$this->form_validation->set_rules('complemento', 'Complemento', "max_length[50]");
		$this->form_validation->set_rules('telefone', 'Telefone', "required|max_length[15]");
		$this->form_validation->set_rules('tipo', 'Tipo', "numeric|required");
		$this->form_validation->set_rules('descricao', 'Descricao', "max_length[2000]");

		// Recebe as variáveis por post
		$republica['IDRepublica'] = $this->input->post('republica_id');
		$republica['NomeRepublica'] = $this->input->post('nome_republica');
		$republica['CEP'] = $this->input->post('cep');
		$republica['IDEstado'] = $this->input->post('estado');
		$republica['IDCidade'] = $this->input->post('cidade');
		$republica['Bairro'] = $this->input->post('bairro');
		$republica['Rua'] = $this->input->post('rua');
		$republica['Numero'] = $this->input->post('numero');
		$republica['Complemento'] = $this->input->post('complemento');
		$republica['telefone'] = $this->input->post('telefone');
		$republica['tipo'] = $this->input->post('tipo');
		$republica['descricao'] = $this->input->post('descricao');
		$republica['foto_perfil'] = "";
		$republica['foto_capa'] = "";

		// Se a validação der certo, começa a validação de imagem
		if($this->form_validation->run('form_update_perfil')) {
			// Verifica tamanho, formato e dimensões das imagens antes de fazer o upload
			for ($i = 0; $i < 6 && $_FILES['input_'.$i]['size'] != 0; $i++) {
				$input_name = "input_".$i;
				// Pegando as dimensões
				$image_info = getimagesize($_FILES[$input_name]["tmp_name"]);
				$width = $image_info[0];
				$height = $image_info[1];
				$size = $_FILES[$input_name]['size'];
				$format = substr($_FILES[$input_name]['type'], 6);
				if ($width > 1920 || $height > 1920 || $size > 2048000 || ($format != 'png' && $format != 'jpg' && $format != 'jpeg')) {
					// Caso de algum erro
					redirect(base_url('editar-perfil/'.$republica['IDRepublica']."/1"));
				}
			}


			$this->load->model("Image_model", "image");
			// Upload da foto de perfil
			if ($_FILES['foto_perfil']['size'] > 0 && $_FILES['foto_perfil']['size'] < 2048000) {
				$republica['foto_perfil'] = $this->image->uploadImage("Republica", "FotoPerfil", "foto_perfil", $this->session->republica_id);
				if (!$republica['foto_perfil']) {
					redirect(base_url('editar-perfil/'.$republica['IDRepublica']."/1"));
				}
			}
			// Upload da foto de capa
			if ($_FILES['foto_capa']['size'] > 0 && $_FILES['foto_perfil']['size'] < 2048000) {
				$republica['foto_capa'] = $this->image->uploadImage("Republica", "FotoCapa", 'foto_capa', $this->session->republica_id);
				if (!$republica['foto_capa']) {
					redirect(base_url('editar-perfil/'.$republica['IDRepublica']."/1"));	
				}
			}

			// Vetor para armazenar os nomes das fotos da rep
			$nomes_fotos = NULL;
			// Upload das fotos da rep
			for($i = 0; $i < 6; $i++) {
				$file_name = false;
				if ($_FILES['input_'.$i]['size'] > 0) {
					$file_name = $this->image->uploadImages("FotoRepublica", "Foto", $i, $this->input->post('arquivo_'.$i));
				}
				if ($file_name) {
					$nomes_fotos[$i] = $file_name;
				}
			}

			// Se todos os uploads deram certo, salva as infos no banco
			if($this->republica->update($republica, $nomes_fotos)) {
				if ($republica['foto_perfil'] != "") {
					$this->session->foto_perfil = $republica['foto_perfil'];
				}
				redirect(base_url('republica/'.$republica['IDRepublica']));
			}
			else {
				$this->load->view('errors/VagaReps_errors/error_general');
				return;
			}
		}
		else {
			$this->load->view('errors/VagaReps_errors/error_general');
			return;
		}
		// Chama a função da página de perfil
	}

	// Parametros: ID do usuário
	public function delete () {
		// Verifica se tem permissão
		// Deleta no banco
		// Chama a home (usuário) ou página de gerenciamento (adm)
	}
}