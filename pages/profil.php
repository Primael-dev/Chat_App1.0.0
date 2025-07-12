<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Realtime Chat App</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<div>
  <nav class="site-nav">
    <button class="sidebar-toggle">
      <span class="material-symbols-rounded">menu</span>
    </button>
  </nav>
  <div class="container">
    <aside class="sidebar collapsed">
      <div style="display:flex;
        justify-content:center;
        align-items:center;" class="sidebar-header">
        <h1 >ChatApp</h1>
      </div>
      <div class="sidebar-content">
        <form action="#" class="search-form">
          <span class="material-symbols-rounded">search</span>
          <input type="search" placeholder="Search..." required />
        </form>
        <ul class="menu-list">
          <li class="menu-item">
            <a href="menu.php?page=accueil" class="menu-link active">
              <span class="material-symbols-rounded">home</span>
              <span class="menu-label">Accueil</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="menu.php?page=profil" class="menu-link">
              <span class="material-symbols-rounded">person</span>
              <span class="menu-label">Profil</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="menu.php?page=message" class="menu-link">
              <span class="material-symbols-rounded">mail</span>
              <span class="menu-label">Message</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="menu.php?page=notification" class="menu-link">
              <span class="material-symbols-rounded">notifications</span>
              <span class="menu-label">Notification</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="menu.php?page=parametres" class="menu-link">
              <span class="material-symbols-rounded">settings</span>
              <span class="menu-label">Paramètres</span>
            </a>
          </li>
        </ul>
      </div>
      </aside>
    <div class="main-content">
      <h1 class="page-title">Welcome on ChatApp</h1>
      <div>
      <p class="card">Welcome to your dashboard! Use the menu to navigate, toggle the sidebar, or switch between light and dark themes to personalize your experience.</p>
      </div>
    </div>
  </div>
  <script src="javascript/header.js" defer></script>
</div>
