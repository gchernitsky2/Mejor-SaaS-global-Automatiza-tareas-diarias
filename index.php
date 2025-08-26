<?php
// index.php
// Sistema unificado de TaskLoop AI - Versión simplificada en un solo archivo PHP

// CONFIGURACIÓN
define('DB_HOST', 'localhost');
define('DB_NAME', 'taskloop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Clave de API OpenAI real (modo prueba)
define('OPENAI_API_KEY', 'sk-abc123xyz456example789'); // Reemplázala por tu clave real en producción

// CONEXIÓN A BD
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// GUARDAR USUARIO (si se envió)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $conn->query("INSERT INTO usuarios (email) VALUES ('$email')");
    echo "<p>Usuario registrado: $email</p>";
}

// USUARIOS EXISTENTES
$result = $conn->query("SELECT * FROM usuarios");

// CONSULTA A OPENAI
$respuestaIA = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt'])) {
    $prompt = $_POST['prompt'];
    $response = openaiRequest($prompt);
    $respuestaIA = $response;
}

// FUNCIÓN OPENAI
function openaiRequest($prompt) {
    $data = [
        "model" => "gpt-3.5-turbo",
        "messages" => [["role" => "user", "content" => $prompt]]
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . OPENAI_API_KEY
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($response, true);
    return $decoded['choices'][0]['message']['content'] ?? 'Error en la respuesta de IA';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>TaskLoop AI - PHP</title>
</head>
<body style="font-family: sans-serif; max-width: 600px; margin: auto; padding: 20px;">
  <h1>🧠 TaskLoop AI (PHP)</h1>

  <h2>Registrar nuevo usuario</h2>
  <form method="POST">
    <input type="email" name="email" placeholder="Correo" required />
    <button type="submit">Registrar</button>
  </form>

  <h3>Usuarios registrados:</h3>
  <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
      <li><?= htmlspecialchars($row['email']) ?></li>
    <?php endwhile; ?>
  </ul>

  <hr>

  <h2>Asistente IA</h2>
  <form method="POST">
    <input type="text" name="prompt" placeholder="Escribe algo..." style="width: 100%" />
    <button type="submit">Enviar a IA</button>
  </form>

  <?php if ($respuestaIA): ?>
    <h3>Respuesta IA:</h3>
    <div style="background: #f0f0f0; padding: 10px;"><?= nl2br(htmlspecialchars($respuestaIA)) ?></div>
  <?php endif; ?>
</body>
</html>