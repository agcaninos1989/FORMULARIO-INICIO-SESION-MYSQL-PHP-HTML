<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$host = "localhost";
$usuario = "root"; // Usuario predeterminado en XAMPP
$contraseña = "";  // La contraseña predeterminada es vacía
$base_datos = "camilo_pruebas"; // El nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $usuario, $contraseña, $base_datos);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir los datos del formulario y verificar si existen
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $nombre_completo = $_POST['nombre'] . " " . $_POST['apellido']; // Concatenar nombre y apellido
    $nombre_usuario = $_POST['usuario'];
    $clave = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios_prueba (nombre_completo, nombre_usuario, clave) VALUES ('$nombre_completo', '$nombre_usuario', '$clave')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Por favor complete todos los campos del formulario.<br>";
}

// Recuperar todos los registros de la base de datos
$sql = "SELECT id, nombre_completo, nombre_usuario FROM usuarios_prueba";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<h2>Usuarios Registrados</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Nombre Completo</th><th>Nombre de Usuario</th></tr>";
    
    // Mostrar cada registro en una fila de la tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nombre_completo"] . "</td>";
        echo "<td>" . $row["nombre_usuario"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay usuarios registrados.";
}

// Cerrar la conexión
$conn->close();
?>
