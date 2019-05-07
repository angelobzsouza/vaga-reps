<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credenciais extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Credencial_model', 'credencial');
	}

	public function index() {
		redirect(base_url(''));
	}

	//Return: A view de login
	public function loginView () {
		$this->load->view('login');
	}

	// Param: Usuário e senha
	// Return: Profile Page
	public function login () {
		$this->form_validation->set_rules("user", "Nome de Usuário", "required|max_length[20]|alpha_numeric");
		$this->form_validation->set_rules("senha", "Senha", "required|max_length[50]");
		// Se a validação der certo, loga
		if ($this->form_validation->run('form_login')) {
			$user = $this->input->post('user');
			$senha = sha1($this->input->post('senha'));
			// Param: Usuário e senha
			// Return: 1 - Logou/2 - Usuário não econtrado/3 - Senha Incorreta
			$resposta = $this->credencial->login($user, $senha);

			if ($resposta == 1) {
				redirect(base_url('republica/'.$this->session->republica_id));
			}
			else if ($resposta == 2) {
				$this->load->view('login', ['invalid_user' => true]);
			}
			else if ($resposta == 3) {
				$this->load->view('login', ['wrong_password' => true]);
			}
		}
		else {
			$this->load->view('errors/VagaReps_errors/error_general');
		}
	}

	// Return: Home page
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url());
	}
 
	// Param: Usuário por POST
	// Return: Da um echo para a requisão se o usuário está no banco ou não
	public function existUser () {
		$user = $this->input->post('user');
		// Verify if $user is alphanum before access the db
		if (ctype_alnum($user)) {
			echo $this->credencial->existUser($user);
		}
		else {
			exit;
		}
	}
}