<?php
session_start();
// Destruye cualquier sesión del usuario
session_destroy();
header('Location: ../view/login.php?desconexion=1');



?>