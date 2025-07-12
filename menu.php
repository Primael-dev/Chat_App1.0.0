<?php
// menu.php

// Définit les pages autorisées
$allowed_pages = [
  'accueil' => 'users.php',
  'profil' => 'pages/profil.php',
  'message' => 'pages/message.php',
  'notification' => 'pages/notification.php',
  'parametres' => 'pages/parametres.php'
];

// Récupère le paramètre 'page' de l'URL, sinon valeur par défaut = 'accueil'
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Vérifie si la page est autorisée
if (array_key_exists($page, $allowed_pages)) {
  include($allowed_pages[$page]);
} else {
  // Page non trouvée
  echo "<h1>Erreur 404 - Page non trouvée</h1>";
}
?>
