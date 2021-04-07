<?php
class Config{
  const DATE_FORMAT = "Y-m-d H:i:s";
  public static function DB_HOST(){
    return Config::get_env("DB_HOST", "localhost");
  }
  public static function DB_USERNAME(){
    return Config::get_env("DB_USERNAME", "root");
  }
  public static function DB_PASSWORD(){
    return Config::get_env("DB_PASSWORD", "");
  }
  public static function DB_SCHEME(){
    return Config::get_env("DB_SCHEME", "foodblog");
  }
  public static function DB_PORT(){
    return Config::get_env("DB_PORT", "3306");
  }

  const SMTP_HOST = "smtp.gmail.com";
  const SMTP_PORT = 587;
  const SMTP_ENCRYPT = "tls";
  const SMTP_USER = "admir.krilasevic@stu.ibu.edu.ba";
  const SMTP_PASSWORD = "";

  const JWT_SECRET = "nbf3095zn64";
  const JWT_TOKEN_TIME = 604800;

  public static function get_env($name, $default){
  return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
}
}

 ?>
