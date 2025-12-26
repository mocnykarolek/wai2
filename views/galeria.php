<link rel="stylesheet" href="styles/galeria.css" />
<main>
        <h2>Galeria inspiracji</h2>
        <?php if (isset($status)): ?>
            <div class="status">
                <?= htmlspecialchars($status) ?>
            </div>
            
        
      <?php endif; ?>
        <section class="flexContainer">
        <form action="/addPhoto" method="POST" enctype="multipart/form-data">
            <label for="title">Tytuł  </label>
            <input type="text" name="title">

            <label for="file">Dodaj zdjecie</label>
            <input class="file" type="file" name="file">
            <div>
              <input type="radio" name="visibility" id="publicze" value="public" required />
              <label for="mezczyzna">public</label>
            </div>

            <div>
              <input type="radio" name="visibility" id="prywatne" value="private" required />
              <label for="kobieta">private</label>
            </div>
            <button class="inputButton" type="submit">Wyślij</button>
            
        </form>
        </section>

      <section class="gallery">
        
            <div class="gallery-item">
                <img src="images/galeria/1.jpeg" alt="Zdjęcie 1"   />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/2.jpeg" alt="Zdjęcie 2"   />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/3.jpeg" alt="Zdjęcie 3"  />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/4.jpeg" alt="Zdjęcie 4"  />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/5.jpeg" alt="Zdjęcie 5"  />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/6.jpeg" alt="Zdjęcie 6"  />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/0.jpeg" alt="Zdjęcie 0"  />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/7.jpeg" alt="Zdjęcie 7"  />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/8.jpeg" alt="Zdjęcie 8" />
            </div>
            <div class="gallery-item">
                <img src="images/galeria/9.jpeg" alt="Zdjęcie 9" />
            </div>
                <?php 
                    $db = get_db();
                    $photos = $db->photos->find();

                    $currentUser = $_SESSION['username'] ?? null;
                    if (!empty($photos)){
                    foreach($photos as $photo){
                        if($photo['visibility'] === 'public'){
                    echo '<div class="gallery-item">
                                <img src="images/input/' . 't_' . $photo['filename'] . '" alt="Zdjęcie 9" />
                            </div>
                ' ; 
                        } elseif($photo['visibility'] === 'private' && $photo['author'] === $currentUser){
                            echo '<div class="gallery-item">
                                <img src="images/input/' . 't_' . $photo['filename'] . '" alt="Zdjęcie 9" />
                            </div>
                ' ;
                        }

                    }
                }
                ?>
            
      </section>


      <section class="back_top_sec">
        <a class="back-to-top" href="#top">Powrót</a>
      </section>
    </main>