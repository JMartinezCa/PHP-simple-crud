<?php  
session_start();

require_once './app/Controllers/InventarioController.php';
$inventario = new InventarioController();

if($_SERVER["REQUEST_METHOD"] == 'POST') $inventario->delete();
?>

<!DOCTYPE html>
<html lang="es">
<?php require_once 'app/Views/partials/head.php';?>
<body>
    <?php require_once 'app/Views/partials/navegation.php';?>

    <div class="container pt-4">
        <div class="d-flex justify-content-end mb-3">
            <a href="./app/Views/pages/create.php" class="btn btn-primary">Agregar nuevo elemento</a>
        </div>      

        <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Precio</td>
                        <td>Cantidad</td>
                        <td>Categoria</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require_once './app/Controllers/InventarioController.php';

                    $inventarioController = new InventarioController;
                    $inventario = $inventarioController->show();

                    foreach($inventario as $datos => $value){
                        echo "
                        <tr>
                            <td>{$value['id']}</td>
                            <td>{$value['product']}</td>
                            <td>{$value['price']}</td>
                            <td>{$value['quantity']}</td>                            
                            <td>{$value['category']}</td>                            
                            <td>
                                <a href='./app/Views/pages/edit.php?id={$value['id']}' class='btn btn-success'>Editar</a>
                                <form method='POST' action='index.php'>
                                    <input type='hidden' name='id' value='{$value['id']}'>
                                    <input type='submit' name='delete' value='Eliminar' class='btn btn-danger'>
                                </form>
                            </td>                            
                        </tr>
                    ";
                    }
                    ?>
                </tbody>
            </table>
        </div>        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>