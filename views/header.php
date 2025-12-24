<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kuchnia Karola</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="icon" type="image/x-icon" href="../images/logo.png" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  </head>
  <body>
    <header class="header_class">
      <a href="/home">
        <div class="logo">
          <img src="images/logo.png" alt="Logo" width="500" height="500" />
        </div>
      </a>

      <nav class="nav-bar">
        <ul class="nav-links">
          <li><a href="/recipes">Przepisy</a></li>
          <li><a href="/gallery">Galeria</a></li>
          <li><a href="/aboutme">O mnie</a></li>
          <?php 
            
          if(isset($_SESSION['user'])){
            echo '<li><a href=".'. '/logout' .'">'. 'Logout'.'</a></li>';
          } else{
            echo '<li><a href=".'. '/loginpage' .'">'. 'Login'.'</a></li>';
          }
            ?>
          
        </ul>
      </nav>

      <a class="button1" href="/form">Kontakt</a>
    </header>