<?php
  // Load Config
  require_once 'config/config.php';
  require_once 'helpers/redirect.php';
  require_once 'helpers/session_helpers.php';
  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });
  
