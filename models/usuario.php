<?php
include_once("../dal/sql.php");


class Usuario
{
	public $id;
	public $nome;
	public $email;
	public $senha;
	public $status;



	public function __construct($id = 0)
	{
		if ($id != 0) {
			$result = $this->get("idusuario = $id");
			if (count($result) > 0) {
				$this->id = $result[0]["idusuario"];
				$this->descricao = $result[0]["nome"];
				$this->email = $result[0]["email"];
				$this->senha = $result[0]["senha"];
				$this->status = $result[0]["status"];
			}
		} else {
			$this->id = 0;
		}
	}

	public function save()
	{
		$sql = new Sql;
		$id = 0;

		try {
			if ($this->id == 0) {
				$id = $sql->query(
					"INSERT INTO usuario (
					nome,
					email,
					senha
				) VALUES (
					:nome
					:email
					:senha
				)",
					array(
						':nome' => $this->nome,
						':email' => $this->email,
						':senha' => $this->senha
					)
				);

				$this->id = $id;
			} else {
				$sql->query(
					"UPDATE usuario SET 
					nome = :nome,
					email = :email,
					senha = :senha,

				WHERE idusuario = :ID",
					array(
						':ID' => $this->id,
						':nome' => $this->nome,
						':email' => $this->email,
						':senha' => $this->senha
					)
				);
				$id = $this->id;
			}

			return $id;
		} catch (Exception $ex) {
			throw new Exception($ex);
		}
	}

	public static function delete($id)
	{
		$sql = new Sql;

		$sql->query("UPDATE usuario SET status=2 
            WHERE idusuario = :ID", array(
			':ID' => $id
		));
	}

	public static function list()
	{
		return (new self)->get();
	}

	public static function getbyId($id)
	{
		return (new self)->get("idusuario = $id");
	}

	private function get($criteria = null)
	{
		$sql = new Sql;

		$query = "SELECT idusuario, 
            nome,email,senha, status
		FROM usuario WHERE status!=2";

		if (!is_null($criteria)) {
			$query .= " and " . $criteria;
		}

		$query .= " ORDER BY nome";

		return $sql->select($query);
	}
}
