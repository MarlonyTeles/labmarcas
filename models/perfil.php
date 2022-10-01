<?php
include_once("../dal/sql.php");

class Perfil{
	public $id;
    public $descricao;

	public function __construct($id = 0){
		if ($id != 0) {
			$result = $this->get("idperfil = $id");
			if (count($result) > 0){
				$this->id = $result[0]["idperfil"];
                $this->descricao = $result[0]["descricao"];
            }
        } else {
			$this->id = 0;
		}
    }
	
	public function save(){
		$sql = new Sql;
		$id = 0;

		try{
			if ($this->id == 0){
				$id = $sql->query("INSERT INTO perfil (
					descricao
				) VALUES (
					:descricao
				)",
				array(
					':descricao' => $this->descricao
				));

				$this->id = $id;
			} else {
				$sql->query("UPDATE perfil SET 
					descricao = :descricao
				WHERE idperfil = :ID",
				array(
					':ID' => $this->id,
					':descricao' => $this->descricao
				));
				$id = $this->id;
			}

			return $id;

		} catch (Exception $ex){
			throw new Exception($ex);
		}
	}    

	public static function delete($id){
		$sql = new Sql;

		$sql->query("UPDATE perfil SET status=2 
            WHERE idperfil = :ID", array(
			':ID' => $id
		));
	}

	public static function list(){
		return (new self)->get();

	}

    public static function getbyId($id){        
		return (new self)->get("idperfil = $id");
		
	}
    
    private function get($criteria = null){
		$sql = new Sql;

		$query = "SELECT idperfil, 
            descricao, status
		FROM perfil WHERE status!=2";

		if (!is_null($criteria)){
			$query .= " and " . $criteria;
		}

		$query .= " ORDER BY descricao";

		return $sql->select($query);
	}
}

?>