<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Republica_model extends CI_Model {
	// Return: is_object's array with all table rows
	public function readAll () {

	}

	// Param: Republica ID
	// Return: An object
	public function read ($republica_id = NULL) {
		// Busca Republica
		return $this->db->where('IDRepublica', $republica_id)->get('Republica')->row();
	}

	// Return: int numero de republicas
	public function countRepublicas () {
		// Conta as vagas
		return $this->db->count_all('Republica');
	}

	// Param: Republica
	// Return: Object id
	public function create ($republica = NULL) {
		$this->db->insert('Republica', $republica);
		return $this->db->insert_id();
	}

	// Param: Repubilca e um array com os nomes dos arquivos das fotos da republica
	// Return Bool with answer
	public function update ($republica = NULL, $fotos = NULL) {
		$ta_ok = true;
		// Só altera o nome das fotos no banco caso elas tenham sido alteradas
		if ($republica['foto_perfil'] != "") {
			$query = "UPDATE Republica SET FotoPerfil = ? WHERE IDRepublica = ?";
			$ta_ok = $this->db->query($query, array($republica['foto_perfil'], $republica['IDRepublica']));
		}
		if (!$ta_ok) {
			return false;
		}
		if ($republica['foto_capa'] != "") {
			$query = "UPDATE Republica SET FotoCapa = ? WHERE IDRepublica = ?";
			$ta_ok = $this->db->query($query, array($republica['foto_capa'], $republica['IDRepublica']));
		}
		if (!$ta_ok) {
			return false;
		}
		$query = "UPDATE Republica
							SET NomeRepublica = ?,
									DescricaoRepublica = ?,
									CEP = ?,
									Bairro = ?,
									Rua = ?,
									Numero = ?,
									Complemento = ?,
									IDEstado = ?,
									IDCidade = ?,
									Telefone = ?,
									TipoRepublica = ?
							WHERE IDRepublica = ?";

		$ta_ok = $this->db->query($query, array(
			$republica['NomeRepublica'],
			$republica['descricao'],
			$republica['CEP'],
			$republica['Bairro'],
			$republica['Rua'],
			$republica['Numero'],
			$republica['Complemento'],
			$republica['IDEstado'],
			$republica['IDCidade'],
			$republica['telefone'],
			$republica['tipo'],
			$republica['IDRepublica'],
		));
		if (!$ta_ok) {
			return false;
		}
		if (!empty($fotos)) {
			foreach($fotos as $foto) {
				// Se for edição, busca o id da foto para atualizar o nome
				if ($this->db->where('Foto', $foto)->count_all_results('FotoRepublica') > 0) {
					$foto_id = $this->db->select('IDFoto')->where("Foto", $foto)->get('FotoRepublica')->row()->IDFoto;
					$query = "UPDATE FotoRepublica
										SET Foto = ?
										WHERE IDFoto = ?";
					$ta_ok = $this->db->query($query, array($foto, $foto_id));
				}
				else {
					$query = "INSERT INTO FotoRepublica (IDRepublica, Foto)
										VALUES (?, ?)";
					$ta_ok = $this->db->query($query, array($republica['IDRepublica'], $foto));
				}
			}
		}

		return $ta_ok;
	}

	// Param: ID da republica
	// Return: Array de objetos com as fotos da republica
	public function buscaFotosDaRepublica ($republica_id = NULL) {
		// Busca Fotos
		return $this->db->where('IDRepublica', $republica_id)->order_by('IDFoto', 'DESC')->get('FotoRepublica')->result();
	}

	// Param: ID da republica
	// Return: Array de objetos com as vagas da republica
	public function buscaVagasDaRepublica ($republica_id = NULL) {
		// Busca Fotos
		return $this->db->where('IDRepublica', $republica_id)->get('Vaga')->result();
	}
}
?>