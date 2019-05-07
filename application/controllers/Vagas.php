<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vagas extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("Vaga_model", "vaga");
	}

	public function index($pagina = NULL) {
		// Limpa os filtros da sessão
		$filtros['TipoRepublica'] = $this->session->TipoRepublica = "-1";
		$filtros['TipoVaga'] = $this->session->TipoVaga = "-1";
		$filtros['IDEstado'] = $this->session->IDEstado = "";
		$filtros['IDCidade'] = $this->session->IDCidade = "";
		$filtros['Preco'] = $this->session->Preco = "";

 		$qtde_vagas = $this->vaga->countVagas();

 		$this->load->library('pagination');

 		$config['base_url'] = base_url('vagas/');
		$config['total_rows'] = $qtde_vagas;
		$config['per_page'] = 30;
		$config['first_link'] = "&nbsp&nbspInício";
		$config['last_link'] = "&nbsp&nbspÚltimo";
		$config['next_link'] = "&nbsp&nbspPróximo";
		$config['prev_link'] = "&nbsp&nbspAnterior";
		$config['cur_tag_open'] = "&nbsp<b>";
		$config['cur_tag_close'] = "&nbsp</b>";
		$config['num_tag_open'] = "&nbsp";
		$config['num_tag_close'] = "&nbsp";

		$this->pagination->initialize($config);
		
		// Busca info no banco de acordo com a paginação
		$data['vagas'] = $this->vaga->readVagasByPage($pagina);
		$this->load->model("Localizacao_model", "localizacao");
		$data['estados'] = $this->localizacao->readStates();
		$data['title'] = "Vagas";
		$data['filtros'] = $filtros;

		// Pega uma foto de cada vaga para ser a thumb
		foreach($data['vagas'] as $vaga) {
			$vaga->Thumb = $this->vaga->buscaThumbVaga($vaga->IDVaga);
		}

		// Chama a view
		$this->load->view('vagas', $data);
	}

	// Param: Indice da paginação por get e parametros de busca por post
	// Return: Pagina de vagas com as vagas encontradas
	public function filtraVagas ($pagina = NULL) {
		if($this->input->post('submit')) {
			$this->session->TipoRepublica = $this->input->post('tipo_rep');
			$this->session->TipoVaga = $this->input->post('tipo_vaga');
			$this->session->IDEstado = $this->input->post('estado');
			$this->session->IDCidade = $this->input->post('cidade');
			$this->session->Preco = $this->input->post('valor');
		}

		$filtros['TipoRepublica'] = $this->session->TipoRepublica;
		$filtros['TipoVaga'] = $this->session->TipoVaga;
		$filtros['IDEstado'] = $this->session->IDEstado;
		$filtros['IDCidade'] = $this->session->IDCidade;
		$filtros['Preco'] = $this->session->Preco;

		// Validação de formulário
		foreach($filtros as $filtro) {
			if ($filtro != "" && !is_numeric($filtro)) {
				$this->load->view('errors/VagaReps_errors/error_general');
				return false;
			}
 		}

 		$qtde_vagas = $this->vaga->contaVagasComFiltros($filtros);

 		$this->load->library('pagination');

 		$config['base_url'] = base_url('filtra-vagas/');
		$config['total_rows'] = $qtde_vagas;
		$config['per_page'] = 30;
		$config['first_link'] = "&nbsp&nbspInício";
		$config['last_link'] = "&nbsp&nbspÚltimo";
		$config['next_link'] = "&nbsp&nbspPróximo";
		$config['prev_link'] = "&nbsp&nbspAnterior";
		$config['cur_tag_open'] = "&nbsp<b>";
		$config['cur_tag_close'] = "&nbsp</b>";
		$config['num_tag_open'] = "&nbsp";
		$config['num_tag_close'] = "&nbsp";

		$this->pagination->initialize($config);
		
		// Busca info no banco de acordo com a paginação
		$data['vagas'] = $this->vaga->readVagasByPageFilter($pagina, $filtros);
		$data['filtros'] = $filtros;
		$this->load->model("Localizacao_model", "localizacao");
		$data['estados'] = $this->localizacao->readStates();
		if ($filtros['IDEstado'] != "") {
			$data['cidades'] = $this->localizacao->readCitiesByState($filtros['IDEstado']);
		}
		$data['title'] = "Vagas";

		// Pega uma foto de cada vaga para ser a thumb
		foreach($data['vagas'] as $vaga) {
			$vaga->Thumb = $this->vaga->buscaThumbVaga($vaga->IDVaga);
		}

		// Chama a view
		$this->load->view('vagas', $data);
	}

	// Retorno: View da vaga
	public function vaga ($vaga_id = NULL) {
		$this->load->model("Republica_model", "republica");

		$data['vaga'] = $this->vaga->read($vaga_id);
		$data['fotos'] = $this->vaga->buscaFotos($vaga_id);
		$data['republica'] = $this->republica->read($data['vaga']->IDRepublica);
		$data['title'] = "Vaga da ".$data['republica']->NomeRepublica;

		$this->load->view('vaga', $data);
	}

	// CRUD
	// Retorno: Tela do cadastro de vagas
	public function createView () {
		// Para cadastrar deve estar logado
		if (!$this->session->login) {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
		$this->load->view('create_vaga', ['title' => 'Nova Vaga']);
	}

	// Parametros: Infos do cadastro por POST
	// Retorno: Vai para  a tela de perfil
	public function create () {
		// Validação dos campos simples
		$this->form_validation->set_rules('titulo', "Titulo", "required|max_length[100]");
		$this->form_validation->set_rules('valor', "Valor", "required|numeric");
		$this->form_validation->set_rules('tipo', "Tipo", "required");
		$this->form_validation->set_rules('descricao', "Descricao", "required|max_length[400]|min_length[70]");

		$vaga['titulo'] = $this->input->post('titulo');
		$vaga['tipo'] = $this->input->post('tipo');
		$vaga['valor'] = $this->input->post('valor');
		$vaga['descricao'] = $this->input->post('descricao');

		// Se a validação der certo, vai para o upload de imagens
		if($this->form_validation->run('form_create_vaga')) {
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
					$this->load->view('create_vaga', ["erro" => true, "title" => "Nova Vaga"]);
					return;	
				}
			}

			$this->load->model("Image_model", "image");

			// Vetor para armazenar os nomes das fotos da rep
			$nomes_fotos = NULL;
			// Upload das fotos da rep
			for($i = 0; $i < 6; $i++) {
				$file_name = false;
				if ($_FILES['input_'.$i]['size'] > 0) {
					$file_name = $this->image->uploadImages("FotoVaga", "Foto", $i, $this->input->post('arquivo_'.$i));
				}
				if ($file_name) {
					$nomes_fotos[$i] = $file_name;
				}
			}

			// Se os uploads deram certo
			if (!$this->vaga->create($vaga, $nomes_fotos)) {
				$this->load->view('errors/VagaReps_errors/error_general');
				return;	
			}
		}
		else {
			echo "Fomr";
			// $this->load->view('errors/VagaReps_errors/error_general');
			return;
		}
		redirect(base_url('republica/'.$this->session->republica_id));
	}

	// Parametros: Id da vaga por GET
	// Retorno: Tela de edição
	public function updateView ($vaga_id = NULL) {
		// Verifica se o usuário é o dono da vaga
		$data['vaga'] = $this->vaga->read($vaga_id);
		if ($this->session->republica_id != $data['vaga']->IDRepublica) {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
		// Busca as infos da vaga
		$data['fotos'] = $this->vaga->buscaFotos($vaga_id);
		$data['title'] = "Editar Vaga";
		// Chama a tela com as infos
		$this->load->view('update_vaga', $data);
	}

	// Parametros: Infos da vaga por POST
	// Retorno: Página de perfil da rep
	public function update () {
		// Verifica se o usuário é o dono da vaga
		$data['vaga'] = $this->vaga->read($this->input->post('vaga_id'));
		if ($this->session->republica_id != $data['vaga']->IDRepublica) {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
		// Valida o formulário
		$this->form_validation->set_rules('titulo', "Titulo", "required|max_length[100]");
		$this->form_validation->set_rules('valor', "Valor", "required|numeric");
		$this->form_validation->set_rules('tipo', "Tipo", "required");
		$this->form_validation->set_rules('descricao', "Descricao", "required|max_length[400]|min_length[70]");

		// Obtem as informações
		$vaga['vaga_id'] = $this->input->post('vaga_id');
		$vaga['titulo'] = $this->input->post('titulo');
		$vaga['tipo'] = $this->input->post('tipo');
		$vaga['valor'] = $this->input->post('valor');
		$vaga['descricao'] = $this->input->post('descricao');

		// Se o formulário estiver correto
		if ($this->form_validation->run('form_update_vaga')) {
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

			// Upload das imagens, excluido os arquivos do banco caso estejam sendo substituidos
			$this->load->model("Image_model", "image");
			// Vetor para armazenar os nomes das fotos da rep
			$nomes_fotos = NULL;
			// Upload das fotos da vaga
			for($i = 0; $i < 6; $i++) {
				$file_name = false;
				if ($_FILES['input_'.$i]['size'] > 0) {
					$file_name = $this->image->uploadImages("FotoVaga", "Foto", $i, $this->input->post('arquivo_'.$i));
				}
				if ($file_name) {
					$nomes_fotos[$i] = $file_name;
				}
			}
			// Salva os dados no banco
			if ($this->vaga->update($vaga, $nomes_fotos)) {
				// Redireciona para a página de perfil da republica
				redirect(base_url('republica/'.$this->session->republica_id));
			}
			// Caso o armazenamento no banco tenha dado errado
			else {
				$this->load->view('errors/VagaReps_errors/error_general');
				return false;
			}
		}
		// Se a validação do formulário der errado
		else {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
	}

	// Parametros: ID da vaga por GET
	// Return: Bool para a requisição
	public function delete ($vaga_id = NULL) {
		// Busca a vaga para verificar a permissão da republica
		$vaga = $this->vaga->read($vaga_id);
		// Caso haja algum problema encerra o processo
		if ($this->session->republica_id != $vaga->IDRepublica) {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
		// Apaga os arquivos das fotos da vaga na pasta uploads
		$resposta = $this->vaga->limpaFotos($vaga_id);
		// Apaga a vaga (O banco apaga as fotos da vaga na tabela automaticamente por cascadae)
		$reposta = $this->vaga->delete($vaga_id);
		if ($resposta) {
			redirect(base_url('republica/'.$this->session->republica_id));
		}
		else {
			$this->load->view('errors/VagaReps_errors/error_general');
			return false;
		}
	}
}