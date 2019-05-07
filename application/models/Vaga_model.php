<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaga_model extends CI_Model {
	// Return: is_object's array with all table rows
	public function readAll () {
		// Faz a busca
		$this->db->get('Vaga')->result();
	}

	// Return: the last 6 vagas inseted in db
	public function readLastVagas ($qtde = NULL) {
		// Faz a busca
		return $this->db->limit($qtde)->order_by("IDVaga", "DESC")->get('Vaga')->result();
	}

	// Return: int total of vagas
	public function countVagas () {
		// Conta as vagas
		return $this->db->count_all('Vaga');
	}

	// Busca as vagas da pagina 
	public function readVagasByPage ($offset = NULL) {
		$this->db->limit(30, $offset)->order_by("IDVaga", "ASC");
		return $this->db->get('Vaga')->result();
	}

	// Param: Republica ID
	// Return: An object
	public function read ($vaga_id = NULL) {
		// Busca Vaga
		return $this->db->where('IDVaga', $vaga_id)->get('Vaga')->row();
	}

	// Param: Vaga ID
	// Return: Array with all phtos name
	public function buscaFotos ($vaga_id = NULL) {
		// Busca fotos
		return $this->db->where('IDVaga', $vaga_id)->get('FotoVaga')->result();
	}

	// Param: Vaga ID
	// Return: string Thumbnail
	public function buscaThumbVaga ($vaga_id = NULL) {
		// Busca
		$thumb = $this->db->select("Foto")->where("IDVaga", $vaga_id)->get('FotoVaga')->row();
		if ($thumb) {
			return $thumb->Foto;
		}
		else {
			return NULL;
		}
	}

	// Param: Vaga e fotos
	// Return: Bool with answer
	public function create ($vaga = NULL, $fotos = NULL) {
		// Titulo vaga: 0 individual, 1 compartilhada, 2 provisoria
		$query = "INSERT INTO Vaga (IDRepublica, Preco, DescricaoVaga, TipoVaga, SalvoEm, TituloVaga)
							VALUES (?, ?, ?, ?, NOW(), ?)";
		$ok = $this->db->query($query, array($this->session->republica_id, $vaga['valor'], $vaga['descricao'], $vaga['tipo'], $vaga['titulo']));
		$vaga_id = $this->db->insert_id();
		foreach ($fotos as $foto) {
			$query = 'INSERT INTO FotoVaga VALUES (default, ?, ?)';
			$ok = $this->db->query($query, array($vaga_id, $foto));
		}
		return $ok;
	}

	// Param: Vaga e os nomes dos arquivos das fotos
	// Return Bool with answer
	public function update ($vaga = NULL, $fotos = NULL) {
		$query = "UPDATE Vaga 
							SET Preco = ?,
									DescricaoVaga = ?,
									TipoVaga = ?,
									SalvoEm = NOW(),
									TituloVaga = ?
							WHERE IDVaga = ?";
		if (!$this->db->query($query, array($vaga['valor'], $vaga['descricao'], $vaga['tipo'], $vaga['titulo'], $vaga['vaga_id']))) {
			return false;
		}
		if (!empty($fotos)) {
			foreach($fotos as $foto) {
				// Se for edição, busca o id da foto para atualizar o nome
				if ($this->db->where('Foto', $foto)->count_all_results('FotoVaga') > 0) {
					$foto_id = $this->db->select('IDFoto')->where("Foto", $foto)->get('FotoVaga')->row()->IDFoto;
					$query = "UPDATE FotoVaga
										SET Foto = ?
										WHERE IDFoto = ?";
					//Tenta fazer o update, retorna falso caso de errado 
					if(!$this->db->query($query, array($foto, $foto_id))) {
						return false;
					}
				}
				// Se for adicionar uma nova foto, é só adicionar
				else {
					$query = "INSERT INTO FotoVaga (IDVaga, Foto)
										VALUES (?, ?)";
					if(!$this->db->query($query, array($vaga['vaga_id'], $foto))) {
						return false;
					}
				}
			}
		}
		return true;
	}

	// Param: Id da vaga
	// Return: Bool
	public function limpaFotos ($vaga_id = NULL) {
		$fotos = $this->db->where("IDVaga", $vaga_id)->get('FotoVaga')->result();
		// Percorre todas as fotos cadastradas e exclui, retornando falso caso alguma de errado
		foreach($fotos as $foto) {
			if(!unlink(FCPATH.'assets/uploads/'.$foto->Foto)) {
				return false;
			}
		}
		// Csao tudo tenha funcionado, retorna true
		return true;
	}

	// Param: ID da vaga
	// Return: Bool
	public function delete ($vaga_id = NULL) {
		// Deleta a vaga
		return $this->db->where('IDVaga', $vaga_id)->delete('Vaga');
	}

	// Param: Filters array
	// Return: int "Vagas" number
	public function contaVagasComFiltros ($filtros = NULL) {
		$query = "SELECT count(IDVaga) AS qtde_vagas FROM Vaga JOIN Republica ON Republica.IDRepublica = Vaga.IDRepublica";

		//Se tiver algum filtro, adiciona clausula WHERE 
		foreach($filtros as $filtro => $valor) {
			if($valor != NULL && $valor != "") {
				$query .= " WHERE ";
				break;
			}
		}
		// Adiciona cada um dos filtros exceto preco
		foreach($filtros as $filtro => $valor) {
			if($valor != "" && $filtro != "Preco") {
				$query .=  $filtro." = ".$valor." AND ";
			}
		}
		// Como a condição de filtro de preço é diferente, ela é adicionada a parte
		if ($filtros['Preco'] != "") {
			$query .=  "Preco <= ".$filtros['Preco']." AND ";
		}
		// Se tiver algum filtro, remove o "AND" que é adicionado a mais no fim da String
		foreach($filtros as $filtro => $valor) {
			if($valor != NULL && $valor != "") {
				$query =  substr($query, 0, -5);
				break;
			}
		}	
		return $this->db->query($query)->row()->qtde_vagas;
	}

	// Busca as vagas da pagina 
	public function readVagasByPageFilter ($offset = NULL, $filtros = NULL) {
		$query = "SELECT * FROM Vaga JOIN Republica ON Republica.IDRepublica = Vaga.IDRepublica";

		//Se tiver algum filtro, adiciona clausula WHERE 
		foreach($filtros as $filtro => $valor) {
			if($valor != "" && $valor != "") {
				$query .= " WHERE ";
				break;
			}
		}
		// Adiciona cada um dos filtros exceto preco
		foreach($filtros as $filtro => $valor) {
			if($valor != "" && $filtro != "Preco") {
				$query .=  $filtro." = ".$valor." AND ";
			}
		}
		// Como a condição de filtro de preço é diferente, ela é adicionada a parte
		if ($filtros['Preco'] != "") {
			$query .=  "Preco <= ".$filtros['Preco']." AND ";
		}
		// Se tiver algum filtro, remove o "AND" que é adicionado a mais no fim da String
		foreach($filtros as $filtro => $valor) {
			if($valor != NULL && $valor != "") {
				$query =  substr($query, 0, -5);
				break;
			}
		}
		$query .= " LIMIT 30";
		if(!empty($offset)) {
		 $query .= " OFFSET ".$offset;
		}
		return $this->db->query($query)->result();
	}
}
?>