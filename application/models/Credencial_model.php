<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credencial_model extends CI_Model {
	// Param: string $user
	// Return: Bool if user exist in db or not
	public function existUser ($user = NULL) {
		if ($this->db->where("Usuario", $user)->count_all_results('Republica') > 0) {
			return 1;
		}
		else {
			return 0;
		}
	}

	// Param: User and password
	// Return: 1 - Ok/2 - User dosn't exist/3 - Wrong password
	public function login ($user = NULL, $password = NULL) {
		if (!$this->db->where("Usuario", $user)->count_all_results('Republica') > 0) {
			return 2;
		}
		else if (!$this->db->where("Usuario", $user)->where("Senha", $password)->count_all_results('Republica') > 0) {
			return 3;
		}
		else {
			$user = $this->db->where("Usuario", $user)->where("Senha", $password)->get('Republica')->row();
			// Star session
			$this->session->login = true;
			$this->session->user = $user->Usuario;
			$this->session->foto_perfil = $user->FotoPerfil;
			$this->session->foto_capa = $user->FotoCapa;
			$this->session->republica_id = $user->IDRepublica;

			return 1;
		}
	}
}
?>