<?php
// Snipe-IT Railway Startup Script

// Database configuration - Railway provides DATABASE_URL
if (getenv("DB_DATABASE") || (getenv("DB_HOST") && getenv("DB_USERNAME"))) {
  echo "Database Environment variables are manually set. Ignoring DATABASE_URL parser." . PHP_EOL;
} else if (getenv("DATABASE_URL")) {
  echo "Using Railway DATABASE_URL." . PHP_EOL;
  set_db_from_url(getenv('DATABASE_URL'));
} else if (getenv("MYSQL_URL")) {
  echo "Using Railway MYSQL_URL." . PHP_EOL;
  set_db_from_url(getenv("MYSQL_URL"));
} else if (getenv("POSTGRES_URL")) {
  echo "Using Railway POSTGRES_URL." . PHP_EOL;
  set_db_from_url(getenv("POSTGRES_URL"));
}

function set_db_from_url($uri) {
  $parsed = parse_url($uri);
  $host = $parsed['host'] ?? 'localhost';
  $port = $parsed['port'] ?? 3306;
  $user = $parsed['user'] ?? 'root';
  $pass = $parsed['pass'] ?? '';
  $database = isset($parsed['path']) ? ltrim($parsed['path'], '/') : '';
  
  // Detect database type from scheme
  $scheme = $parsed['scheme'] ?? 'mysql';
  
  if (strpos($scheme, 'postgres') !== false || strpos($scheme, 'postgresql') !== false) {
    file_put_contents('./.env', 'DB_CONNECTION=pgsql' . PHP_EOL, FILE_APPEND);
    $port = $port ?: 5432;
  } else {
    file_put_contents('./.env', 'DB_CONNECTION=mysql' . PHP_EOL, FILE_APPEND);
    $port = $port ?: 3306;
  }
  
  file_put_contents('./.env', 'DB_HOST=' . $host . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_PORT=' . $port . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_USERNAME=' . $user . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_PASSWORD=' . $pass . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_DATABASE=' . $database . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_PREFIX=null' . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_DUMP_PATH=null' . PHP_EOL, FILE_APPEND);
}

// Redis configuration - Railway provides REDIS_URL
if (getenv("REDIS_URL")) {
  echo "Setting up Railway Redis." . PHP_EOL;
  $url = getenv("REDIS_URL");
  $parsed = parse_url($url);
  file_put_contents('./.env', 'REDIS_HOST=' . ($parsed['host'] ?? 'localhost') . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'REDIS_PASSWORD=' . ($parsed['pass'] ?? '') . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'REDIS_PORT=' . ($parsed['port'] ?? 6379) . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'CACHE_DRIVER=redis' . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'SESSION_DRIVER=redis' . PHP_EOL, FILE_APPEND);
} else {
  file_put_contents('./.env', 'CACHE_DRIVER=file' . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'SESSION_DRIVER=file' . PHP_EOL, FILE_APPEND);
}

// Railway proxy setup
file_put_contents('./.env', 'APP_TRUSTED_PROXIES=*' . PHP_EOL, FILE_APPEND);

// Set up GD
file_put_contents('./.env', 'IMAGE_LIB=gd' . PHP_EOL, FILE_APPEND);

// Set local filesystem
file_put_contents('./.env', 'FILESYSTEM_DISK=local' . PHP_EOL, FILE_APPEND);
file_put_contents('./.env', 'PUBLIC_FILESYSTEM_DISK=local_public' . PHP_EOL, FILE_APPEND);

// Set APP_CIPHER
file_put_contents('./.env', 'APP_CIPHER=AES-256-CBC' . PHP_EOL, FILE_APPEND);

// Queue driver
file_put_contents('./.env', 'QUEUE_CONNECTION=sync' . PHP_EOL, FILE_APPEND);

// Set APP_URL if PORT is available (Railway provides PORT)
if (getenv("PORT") && getenv("RAILWAY_PUBLIC_DOMAIN")) {
  $app_url = 'https://' . getenv("RAILWAY_PUBLIC_DOMAIN");
  file_put_contents('./.env', 'APP_URL=' . $app_url . PHP_EOL, FILE_APPEND);
}

echo "Railway startup script completed." . PHP_EOL;
?>
