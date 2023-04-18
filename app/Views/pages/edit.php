<?php  
session_start();

require_once '../../Controllers/InventarioController.php';
$inventario = new InventarioController();

if($_SERVER["REQUEST_METHOD"] == 'POST') $inventario->update();
?>

<!DOCTYPE html>
<html lang="es">
<?php require_once '../partials/head.php';?>
<body>
    <?php require_once '../partials/navegation.php';?>

    <div class="container pt-4">
        <div class="d-flex justify-content-end mb-3">
            <a href="../../../" class="btn btn-warning">Volver</a>
        </div>      
        <div class="message">
            <?php
                if(isset($_GET['result']) && $_GET['result'] == 1){
                    echo'<p class="success">Articulo registrado</p>';
                } 
                elseif(isset($_GET['result']) && $_GET['result'] == 0){
                    echo '<p class="fail">No fue pusible guardar el articulo</p>';
                } 

                if(isset($_SESSION['error'])){
                    $errors = $_SESSION['error'];

                    echo '<ul class="fail">';

                    foreach($errors as $error => $fields){
                        foreach($fields as $field => $value){
                            echo "<li>{$value}</li>";
                        }
                    }

                    echo '</ul>';
                }
            ?>
        </div>

        <form action="edit.php" method="post">
            <?php 
                require_once '../../Controllers/InventarioController.php';
                $inventarioController = new InventarioController;
                $id = $_GET['id'];
                $producto = $inventarioController->edit($id);
            ?>
            <input type="hidden" name="id" value="<?php echo $producto[0]['id'] ?>">
            <div class="form-group mb-4">
                <label for="product" class="form-label">Producto</label>
                <input type="text" name="product" id="product" class="form-control" value="<?php echo $producto[0]['product']?>">
            </div>
            <div class="form-group mb-4">
                <label for="price" class="form-label">Precio</label>
                <input type="number" min="0" name="price" id="price" class="form-control" value="<?php echo $producto[0]['price']?>">
            </div>
            <div class="form-group mb-4">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" min="0" name="quantity" id="quantity" class="form-control" value="<?php echo $producto[0]['quantity']?>">
            </div>
            <div class="form-group mb-4">
                <label for="category" class="form-label">Categoria</label>
                <input type="text" name="category" id="category" class="form-control" value="<?php echo $producto[0]['category']?>">
            </div>
            <input type="submit" name="save" value="Guardar" class="btn btn-primary">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>