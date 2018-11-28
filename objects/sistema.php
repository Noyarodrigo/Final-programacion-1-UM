<?php
class sistema{

    private $connection;

    private $table_name = "sistema_transporte";

    public $sistema_id;
    public $nombre;
    public $pais_procedencia;
    public $created;
    public $updated; 

    public function __construct($connection){
        $this->connection = $connection;
    }

    function read(){

                $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 

                ORDER BY
                    created DESC";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    
}
