<?php
session_start();

// Verifica si 'usuario' está definida en la sesión
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] != null) {
    header("Location:index.php");
} else {
    require_once 'paginaweb.html';
}
?>