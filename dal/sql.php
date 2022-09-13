<?php

class Sql
{
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DBNAME = "mydb";//ALTERAR PARA dblab

    private $conn;

    
	public function __construct()
	{
		try{
			$this->conn = new \PDO(
				"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, 
				Sql::USERNAME,
				Sql::PASSWORD
			);

			$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

			$this->conn->exec("set names utf8");

		} catch (Exception $e){
			//echo "Erro conectando ao MySql " . $e->getMessage();
			exit("Erro conectando ao MySql " . $e->getMessage()); //FAZER UM TRATAMENTO ADEQUADO PARA O LADO DO CLIENTE
            //exit(json_encode(array("status" => "Erro Conectando ao Banco de Dados",
                                   //"Mensagem" => $e.getMessage())));
		}
	}
    
	private function setParams($statement, $parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);

		}

	}

    private function bindParam($statement, $key, $value)
	{
		$statement->bindParam($key, $value);

	}

	public function query($rawQuery, $params = array())
	{
		try {

			//var_dump($rawQuery);

			$stmt = $this->conn->prepare($rawQuery);

			$this->setParams($stmt, $params);

			$stmt->execute();

			return $this->conn->lastInsertId();

			//$arr = $stmt->errorInfo();
			//print_r($arr);
		} catch (PDOException $e){
			//echo "Erro executando Query " . $e->getMessage();
			//exit("Erro executando Query " . $e->getMessage());
            throw new MyDatabaseException("Erro executando Select " . $e->getMessage());

		}

	}

	public function select($rawQuery, $params = array()):array
	{
		try{

			$stmt = $this->conn->prepare($rawQuery);

			$this->setParams($stmt, $params);

			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (PDOException $e){
			throw new MyDatabaseException("Erro executando Select " . $e->getMessage());
		}
	}

}