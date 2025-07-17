<?php
include_once "../conexao.php";

class DatabaseHelper {
    //iniciando um construtor pois preciso definir uma conexão padrão
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn; //Aqui eu defino que a conexão pode ser utuizada por todos os métodos na classe.
    }

    //início do CRUD - facilitando a manipulação dos dados 

    public function insert($tabela, $dados) {
        $columns = implode(", ", array_keys($dados));
        $values = implode(", ", array_map(fn($v) => "'$v'", array_values($dados)));

        $sql = "INSERT INTO $tabela ($columns) VALUES ($values)";
        $sqlExec = $this->conn->prepare($sql);
        $sqlExec->bind_param(str_repeat('s', count($dados)), ...array_values($dados));
        return $sqlExec->execute();
    }
}

?>
<!-- 
class DatabaseHelper {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function inserir($tabela, $dados) {
        $colunas = implode(", ", array_keys($dados));
        $valores = implode(", ", array_map(fn($v) => "'$v'", array_values($dados)));

        $sql = "INSERT INTO $tabela ($colunas) VALUES ($valores)";
        return $this->conn->query($sql);
    }

    public function atualizar($tabela, $dados, $condicao) {
        $campos = implode(", ", array_map(fn($k, $v) => "$k = '$v'", array_keys($dados), array_values($dados)));
        $sql = "UPDATE $tabela SET $campos WHERE $condicao";

        return $this->conn->query($sql);
    }

    public function deletar($tabela, $condicao) {
        $sql = "DELETE FROM $tabela WHERE $condicao";
        return $this->conn->query($sql);
    }

    public function selecionar($tabela, $colunas = "*", $condicao = "1") {
        $sql = "SELECT $colunas FROM $tabela WHERE $condicao";
        return $this->conn->query($sql);
    }
}
 -->