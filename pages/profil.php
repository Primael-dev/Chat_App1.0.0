<!DOCTYPE html>
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
  <style>
    /* Importing Google Fonts - Poppins */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    
    :root {
      /* Light theme colors - Updated with chat palette */
      --color-text-primary: #333;
      --color-text-secondary: #666;
      --color-text-placeholder: #67676a;
      --color-bg-primary: #f7f7f7;
      --color-bg-secondary: #e6e6e6;
      --color-bg-sidebar: #ffffff;
      --color-border-hr: #e6e6e6;
      --color-hover-primary: #333;
      --color-hover-secondary: #f1f1f1;
      --color-shadow: rgba(0, 0, 0, 0.1);
      --color-status-online: #468669;
      --color-status-offline: #ccc;
      --color-error-text: #721c24;
      --color-error-bg: #f8d7da;
      --color-error-border: #f5c6cb;
      --color-accent: #4a90e2;
      --color-like: #e74c3c;
    }
    
    body.dark-theme {
      /* Dark theme colors - Adapted for consistency */
      --color-text-primary: #ffffff;
      --color-text-secondary: #ccc;
      --color-text-placeholder: #ccc;
      --color-bg-primary: #333;
      --color-bg-secondary: #444;
      --color-bg-sidebar: #2a2a2a;
      --color-border-hr: #555;
      --color-hover-secondary: #555;
      --color-shadow: rgba(0, 0, 0, 0.5);
    }
    
    body {
      background-color: var(--color-bg-primary);
      color: var(--color-text-primary);
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .main-content {
      background-color: var(--color-bg-primary);
      color: var(--color-text-primary);
      padding: 20px;
      min-height: 100vh;
    }
    
    .page-title {
      color: var(--color-text-primary);
      font-weight: 600;
      margin-bottom: 20px;
      font-size: 2em;
    }
    
    .card {
      background-color: var(--color-bg-sidebar);
      color: var(--color-text-primary);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px var(--color-shadow);
      margin-bottom: 20px;
      border: 1px solid var(--color-border-hr);
    }
    
    .wrapper {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .profile {
      background-color: var(--color-bg-sidebar);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px var(--color-shadow);
      border: 1px solid var(--color-border-hr);
    }
    
    .profile h2 {
      color: var(--color-text-primary);
      font-weight: 600;
      margin-bottom: 25px;
      font-size: 1.5em;
    }
    
    .profile h3 {
      color: var(--color-text-primary);
      font-weight: 500;
      margin: 30px 0 20px 0;
      font-size: 1.2em;
    }
    
    #postForm {
      margin-bottom: 30px;
    }
    
    #content {
      width: 100%;
      padding: 15px;
      border: 2px solid var(--color-border-hr);
      border-radius: 10px;
      background-color: var(--color-bg-primary);
      color: var(--color-text-primary);
      font-size: 14px;
      resize: vertical;
      min-height: 80px;
      transition: border-color 0.3s ease, background-color 0.3s ease;
    }
    
    #content:focus {
      outline: none;
      border-color: var(--color-status-online);
      background-color: var(--color-bg-sidebar);
    }
    
    #content::placeholder {
      color: var(--color-text-placeholder);
    }
    
    button[type="submit"] {
      background-color: var(--color-status-online);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      font-size: 14px;
      margin-top: 15px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    
    button[type="submit"]:hover {
      background-color: #3a6b54;
      transform: translateY(-2px);
    }
    
    button[type="submit"]:active {
      transform: translateY(0);
    }
    
    #postMessage {
      margin-top: 15px;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
      background-color: var(--color-bg-secondary);
      color: var(--color-text-primary);
      border: 1px solid var(--color-border-hr);
    }
    
    /* Styles pour les cartes de posts */
    .posts-container {
      display: grid;
      gap: 20px;
      margin-top: 20px;
    }
    
    .post-card {
      background: linear-gradient(135deg, var(--color-bg-sidebar) 0%, var(--color-bg-primary) 100%);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 8px 25px var(--color-shadow);
      border: 1px solid var(--color-border-hr);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px var(--color-shadow);
    }
    
    .post-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--color-status-online), var(--color-accent));
    }
    
    .post-header {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }
    
    .post-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 15px;
      border: 3px solid var(--color-status-online);
      box-shadow: 0 4px 10px var(--color-shadow);
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--color-status-online), var(--color-accent));
      color: white;
      font-weight: 600;
      font-size: 18px;
      text-transform: uppercase;
    }
    
    .post-user-info {
      flex: 1;
    }
    
    .post-user-name {
      font-weight: 600;
      color: var(--color-text-primary);
      font-size: 1.1em;
      margin-bottom: 2px;
    }
    
    .post-date {
      color: var(--color-text-secondary);
      font-size: 0.9em;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .post-content {
      color: var(--color-text-primary);
      line-height: 1.6;
      margin-bottom: 15px;
      font-size: 15px;
      padding: 10px;
      background-color: var(--color-bg-primary);
      border-radius: 8px;
      border-left: 4px solid var(--color-status-online);
    }
    
    .post-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 15px;
      border-top: 1px solid var(--color-border-hr);
    }
    
    .post-stats {
      display: flex;
      gap: 20px;
      align-items: center;
    }
    
    .stat-item {
      display: flex;
      align-items: center;
      gap: 5px;
      color: var(--color-text-secondary);
      font-size: 0.9em;
    }
    
    .like-button {
      background: none;
      border: none;
      color: var(--color-text-secondary);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      border-radius: 20px;
      transition: all 0.3s ease;
      font-size: 14px;
    }
    
    .like-button:hover {
      background-color: var(--color-hover-secondary);
      color: var(--color-like);
      transform: scale(1.05);
    }
    
    .like-button.liked {
      color: var(--color-like);
      background-color: rgba(231, 76, 60, 0.1);
    }
    
    .post-id {
      background-color: var(--color-bg-secondary);
      color: var(--color-text-secondary);
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.8em;
      font-weight: 500;
    }
    
    .empty-posts {
      text-align: center;
      padding: 40px;
      color: var(--color-text-secondary);
      font-style: italic;
    }
    
    .empty-posts i {
      font-size: 3em;
      margin-bottom: 15px;
      color: var(--color-text-placeholder);
    }
    
    /* Animation d'apparition des cartes */
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .post-card {
      animation: slideInUp 0.5s ease-out;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
      .main-content {
        padding: 15px;
      }
      
      .profile {
        padding: 20px;
      }
      
      .page-title {
        font-size: 1.3em;
      }
      
      .post-card {
        padding: 15px;
      }
      
      .post-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      
      .post-avatar {
        width: 40px;
        height: 40px;
        font-size: 16px;
      }
      
      .post-actions {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
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
        <h1>ChatApp</h1>
      </div>
      <div class="sidebar-content">
        <form action="#" class="search-form">
          <span class="material-symbols-rounded">search</span>
          <input type="search" placeholder="Search..." required />
        </form>
        <ul class="menu-list">
          <li class="menu-item">
            <a href="menu.php?page=accueil" class="menu-link">
              <span class="material-symbols-rounded">home</span>
              <span class="menu-label">Accueil</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="menu.php?page=profil" class="menu-link active">
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
      
      <div class="wrapper">
        <section class="profile">
          <h2>Mon profil</h2>
          <form id="postForm" method="POST">
            <textarea name="content" id="content" rows="3" placeholder="Exprime-toi..."></textarea>
            <button type="submit">Publier</button>
            <div id="postMessage"></div>
          </form>
          
          <h3>Mes posts</h3>
          <div class="posts-container" id="postsList">
            <!-- Les posts seront chargés ici -->
          </div>
        </section>
      </div>
    </div>
  </div>

  <script src="javascript/header.js" defer></script>
  <script>
    
    // Fonction pour toggle la sidebar
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
    }
    
    // Fonction pour formater la date
    function formatDate(dateString) {
      const date = new Date(dateString);
      const now = new Date();
      const diff = now - date;
      
      const minutes = Math.floor(diff / (1000 * 60));
      const hours = Math.floor(diff / (1000 * 60 * 60));
      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      
      if (minutes < 60) {
        return `il y a ${minutes} min`;
      } else if (hours < 24) {
        return `il y a ${hours}h`;
      } else {
        return `il y a ${days} jour${days > 1 ? 's' : ''}`;
      }
    }
    
    // Fonction pour créer une carte de post
    function createPostCard(post) {
      const timeAgo = formatDate(post.created_at);
      const initials = (post.user.fname.charAt(0) + post.user.lname.charAt(0)).toUpperCase();
      
      return `
        <div class="post-card">
          <div class="post-header">
            <div class="post-avatar">${initials}</div>
            <div class="post-user-info">
              <div class="post-user-name">${post.user.fname} ${post.user.lname}</div>
              <div class="post-date">
                <i class="far fa-clock"></i>
                ${timeAgo}
              </div>
            </div>
            <div class="post-id">#${post.id}</div>
          </div>
          
          <div class="post-content">
            ${post.content.replace(/\n/g, '<br>')}
          </div>
          
          <div class="post-actions">
            <div class="post-stats">
              <div class="stat-item">
                <i class="far fa-eye"></i>
                <span>12 vues</span>
              </div>
              <div class="stat-item">
                <i class="far fa-comment"></i>
                <span>3 commentaires</span>
              </div>
            </div>
            <button class="like-button" onclick="likePost(${post.id})">
              <i class="far fa-heart"></i>
              <span>J'aime</span>
            </button>
          </div>
        </div>
      `;
    }
    
    // Fonction pour afficher les posts
    function displayPosts(posts) {
      const postsContainer = document.getElementById('postsList');
      
      if (posts.length === 0) {
        postsContainer.innerHTML = `
          <div class="empty-posts">
            <i class="far fa-file-alt"></i>
            <p>Aucun post pour le moment.</p>
            <p>Créez votre premier post ci-dessus !</p>
          </div>
        `;
        return;
      }
      
      postsContainer.innerHTML = posts.map(post => createPostCard(post)).join('');
    }
    
    // Fonction pour liker un post
    function likePost(postId) {
      const button = event.target.closest('.like-button');
      
      // Appel AJAX pour liker le post
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../php/like_post.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          // Recharger les posts après le like
          loadPosts();
          
          // Animation visuelle temporaire
          button.classList.add('liked');
          setTimeout(() => {
              button.classList.remove('liked');
          }, 300);
      };
      xhr.onerror = function() {
          console.error('Erreur lors du like du post');
      };
      xhr.send('post_id=' + postId);
    }
    
    // Fonction pour charger les posts depuis le serveur
    function loadPosts() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '../php/get_posts.php', true);
      xhr.onload = function() {
          try {
              const posts = JSON.parse(xhr.responseText);
              displayPosts(posts);
          } catch (e) {
              console.error('Erreur lors du parsing JSON:', e);
              document.getElementById('postsList').innerHTML = '<div class="empty-posts"><i class="far fa-exclamation-triangle"></i><p>Erreur lors du chargement des posts</p></div>';
          }
      };
      xhr.onerror = function() {
          document.getElementById('postsList').innerHTML = '<div class="empty-posts"><i class="far fa-exclamation-triangle"></i><p>Erreur de connexion</p></div>';
      };
      xhr.send();
    }
    
    // Soumission du post
    document.getElementById('postForm').onsubmit = function(e) {
      e.preventDefault();
      var content = document.getElementById('content').value;
      
      if (!content.trim()) {
        document.getElementById('postMessage').innerHTML = '<div style="color: var(--color-error-text); background-color: var(--color-error-bg); padding: 10px; border-radius: 5px;">Veuillez saisir un contenu</div>';
        return;
      }
      
      // Appel AJAX pour créer le post
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../php/create_post.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
          document.getElementById('postMessage').innerHTML = '<div style="color: var(--color-status-online); background-color: rgba(70, 134, 105, 0.1); padding: 10px; border-radius: 5px;">' + xhr.responseText + '</div>';
          document.getElementById('content').value = '';
          loadPosts();
      };
      xhr.onerror = function() {
          document.getElementById('postMessage').innerHTML = '<div style="color: var(--color-error-text); background-color: var(--color-error-bg); padding: 10px; border-radius: 5px;">Erreur lors de la création du post</div>';
      };
      xhr.send('content=' + encodeURIComponent(content));
    };
    
    // Chargement initial
    loadPosts();
  </script>
</body>
</html>