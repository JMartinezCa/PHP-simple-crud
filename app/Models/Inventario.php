<?php 
require_once dirname(__FILE__, 3) . '/src/Connection.php';
class Inventario extends Connection{
    public function __construct(){
       parent::__construct();
    }

    /**
     * @return Array
     */
    public function getAll ():Array{
        $query = "SELECT id, product, price, quantity, category FROM inventario";

        $stmt = $this->DB()->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = null;
        $this->closeConnection();

        return $result;
    }

    public function getById($id):Array{
        $query = "SELECT id, product, price, quantity, category 
                  FROM inventario
                  WHERE id = :id";

        $stmt = $this->DB()->prepare($query);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = null;
        $this->closeConnection();

        return $result;
    }

    /**
     * @param Array $data
     * 
     * @return Bool
     */
    public function save(Array $data):Bool{
        $query = "INSERT INTO inventario (product, price, quantity, category)
                  VALUES (:producto, :precio, :cantidad, :categoria)";

        $stmt = $this->DB()->prepare($query);
        $result = $stmt->execute($data);
        $stmt = null;

        $this->closeConnection();

        return $result;
    }

    /**
     * @param Array $data
     * @param Int $id
     * 
     * @return Bool
     */
    public function update(Array $data):Bool{
        $query = "UPDATE `inventario` 
                  SET product = :producto, price = :precio, quantity = :cantidad, category = :categoria
                  WHERE id = :id";

        $stmt = $this->DB()->prepare($query);
        $result = $stmt->execute($data);
        $stmt = null;

        return $result;
    }

    /**
     * @param Int $id
     * 
     * @return Bool
     */
    public function destroy(Int $id):Bool{
        $query = "DELETE FROM `inventario` WHERE id = :id";

        $stmt = $this->DB()->prepare($query);
        $result = $stmt->execute([':id' => $id]);
        $stmt = null;

        return $result;
    }
}