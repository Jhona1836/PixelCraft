<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pixelcraft";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$search = '';
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
}

// Consulta para obtener los usuarios registrados
$sql = "SELECT id, usuario, correo, telefono, direccion, comentario FROM tabla_registro";
if ($search) {
    $sql .= " WHERE usuario LIKE '%$search%' OR correo LIKE '%$search%' OR telefono LIKE '%$search%' OR direccion LIKE '%$search%' OR comentario LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3B8541;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #45a049;
            padding: 20px;
            color: #fff;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            color: #ddd;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #3B8541;
        }
        .content {
            flex: 1;
            padding: 20px;
        
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        h2 {
            color: #f2f2f2;
            margin-bottom: 20px;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 8px;
            width: calc(100% - 120px);
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-form input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>PixelCraft</h2>
        <a href="#usuarios">Usuarios Registrados</a>
        <a href="#">Reportes</a>
        <a href="#">Configuración</a>
        <a href="..//Index/Home.html">regresar</a>
    </div>
    <div class="content">
        <h2 id="usuarios">Usuarios Registrados</h2>
        <form class="search-form" method="post" action="">
            <input type="text" name="search" placeholder="Buscar usuarios..." value="<?php echo $search; ?>">
            <input type="submit" value="Buscar">
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Comentario</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar datos de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>". $row["id"]. "</td>
                            <td>". $row["usuario"]. "</td>
                            <td>". $row["correo"]. "</td>
                            <td>". $row["telefono"]. "</td>
                            <td>". $row["direccion"]. "</td>
                            <td>". $row["comentario"]. "</td>                   
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay usuarios registrados</td></tr>";
            }
            $conn->close();
           ?>
        </table>
    </div>
</body>
</html>
