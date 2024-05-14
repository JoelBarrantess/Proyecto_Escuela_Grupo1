<?php
session_start();
// Destruye cualquier sesión del usuario
session_destroy();
// Redirecciona a login.php
header('Location: ../view/login.php?desconexion=1');



?>