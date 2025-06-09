<?php
function getTokenFromCacheOrAPI($configPath, $cachePath)
{
    // Verificar si existe el archivo de caché
    if (file_exists($cachePath)) {
        $cache = json_decode(file_get_contents($cachePath), true);
        $now = time();

        // Verificar si el token aún no ha expirado (con margen de 60 segundos)
        if (isset($cache['token'], $cache['exp']) && $cache['exp'] > ($now + 60)) {
            return $cache['token']; // Token válido
        }
    }

    // Leer configuraciones desde el archivo JSON
    if (!file_exists($configPath)) {
        die("El archivo de configuración no existe.");
    }

    $config = json_decode(file_get_contents($configPath), true);

    if (!isset($config['client_id'], $config['client_secret'], $config['token_url'])) {
        die("Faltan datos en el archivo de configuración.");
    }

    // Preparar los datos para POST
    $postFields = http_build_query([
        'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret']
    ]);

    // Realizar la solicitud CURL
    $ch = curl_init($config['token_url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Error cURL: ' . curl_error($ch));
    }

    curl_close($ch);

    // La API responde con el token directamente como texto plano
    $token = trim($response); // Limpiar \r\n o espacios

    // Validar que es un JWT
    if (empty($token) || substr_count($token, '.') !== 2) {
        die("No se recibió un token válido. Respuesta: $response");
    }

    // Decodificar JWT para obtener la fecha de expiración
    $parts = explode('.', $token);
    $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

    if (!isset($payload['exp'])) {
        die("No se pudo leer la expiración del token.");
    }

    //$exp = $payload['exp'];
    $exp = time() + (8 * 60 * 60); // 8 horas en segundos
    //$exp = time() + (5 * 60); // 2 minutos

    // Guardar el token en cache
    file_put_contents($cachePath, json_encode([
        'token' => $token,
        'exp' => $exp
    ]));

    return $token;
}

// Uso
$configPath = __DIR__ . '/config/fwAuthorization.json';
$cachePath = __DIR__ . '/token_cache.json';

$token = getTokenFromCacheOrAPI($configPath, $cachePath);
echo $token;

?>