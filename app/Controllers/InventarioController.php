<?php 
require_once dirname(__FILE__, 2) . '/Models/Inventario.php';

class InventarioController{
    public function __construct(){
       
    }

    /**
     * @return Void
     */
    public function show():Array{
        $inventario = new Inventario();
        $result = $inventario->getAll();

        return $result;
    }

    /**
     * @return Void
     */
    public function store():Void{
        $product = htmlspecialchars($_POST['product'], ENT_QUOTES);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
        $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
        $category = htmlspecialchars($_POST['category'], ENT_QUOTES); 

        $data = [
            'producto' => $product, 
            'precio' => $price, 
            'cantidad' => $quantity, 
            'categoria' => $category
        ];

        $validate = $this->validateData($data);
        
        if(!empty($validate)){
            $_SESSION['error'] = $validate;
            header("Location:../pages/create.php");
            exit();
        }
        
        $inventario = new Inventario();
        $result = $inventario->save($data);

        header("Location:../../../index.php?result=".$result);
    }

    public function edit($id){
        $inventario = new Inventario();
        $result = $inventario->getById($id);

        return $result;
    }

    public function update(){
        $product = htmlspecialchars($_POST['product'], ENT_QUOTES);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
        $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $category = htmlspecialchars($_POST['category'], ENT_QUOTES); 

        $data = [
            'producto' => $product, 
            'precio' => $price, 
            'cantidad' => $quantity, 
            'categoria' => $category,
            'id' => $id
        ];

        if(!empty($validate)){
            $_SESSION['error'] = $validate;
            header("Location:../pages/edit.php");
            exit();
        }
        
        $inventario = new Inventario();
        $result = $inventario->update($data);

        header("Location:../../../index.php?result=".$result);
    }

    public function delete(){
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

        $inventario = new Inventario();
        $result = $inventario->destroy($id);

        header("Location:./");
    }

    /**
     * @param Array $fields
     * 
     * @return Array
     */
    private function validateData(Array $fields):Array{
        $errors = [];

        foreach($fields as $field => $value){
            if(!$value)
            $errors[$field][] = "El campo {$field} es obligario";

            if($value && ($field == 'product' || $field == 'category') && !is_string($value))
            $errors[$field][] = "El campo {$field} solo recibe texto";

            if($value && ($field == 'price' || $field == 'quantity') && !is_int($value))
            $errors[$field][] = "El campo {$field} solo recibe números";
        }

        return $errors;
    }
}