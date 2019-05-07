<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("Localizacao_model", "cidade");
	}

	public function index() {
		$data['estados'] = $this->cidade->readStates();
		$this->load->model('Vaga_model', 'vaga');
		$data['ultimas_vagas'] = $this->vaga->readLastVagas(6);
		// Pega uma foto de cada vaga para ser a thumb
		foreach($data['ultimas_vagas'] as $vaga) {
			$vaga->Thumb = $this->vaga->buscaThumbVaga($vaga->IDVaga);
		}
		// Numero de vagas
		$data['qtde_vagas'] = $this->vaga->countVagas();
		// Numero de republias
		$this->load->model('Republica_model', 'republica');
		$data['qtde_reps'] = $this->republica->countRepublicas();

		$data['title'] = "VagaReps";
		$this->load->view('index', $data);
	}

	// Param: ID do estado
	// Return: Retorna as cidades como json para o ajax
	public function buscaCidades () {
		$estado_id = $this->input->post('estado_id');
		$cidades = $this->cidade->readCitiesByState($estado_id);
		echo json_encode($cidades);
	}
}