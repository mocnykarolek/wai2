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
            <label for="title">Tytuł </label>
            <input type="text" name="title">
            <label for="author">Autor </label>
            <input type="text" name="author" value="<?= $_SESSION['username'] ?? '' ?>">
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
        <?php if (!empty($photos)): ?>
            <form action="/saveSelected" method="POST">
            <section>
            <?php foreach ($photos as $photo): ?>
                <div class="gallery-item">
                    <?php if (isset($_SESSION['username'])): ?>
                    <input type="checkbox" <?= isChecked($photo['filename']) ?  'checked' :  ''  ?>  value="<?= htmlspecialchars($photo['filename']) ?>" name="<?= htmlspecialchars($photo['filename']) ?>">
                    <?php endif; ?>
                    <a href="images/input/<?= htmlspecialchars($photo['filename']) ?>" target="_blank">
                        <img src="images/input/t_<?= htmlspecialchars($photo['filename']) ?>"
                            alt="<?= htmlspecialchars($photo['title']) ?>" />
                        <h3>Title: <?= htmlspecialchars($photo['title']) ?></h3>
                        <h4>Author: <?= htmlspecialchars($photo['author']) ?></h4> 

                    </a>

                </div>

            <?php endforeach; ?>
                
            </section>
            <?php if (isset($_SESSION['username'])): ?>
            <button class="saveSelected" type="Save" value="save" name="save">Save selected</button>
            <?php endif; ?>
            </form> 
        <?php else: ?>
            <p>Brak zdjęć do wyświetlenia.</p>
        
        <?php endif; ?>
        
    </section>

    <div class="pagination" style="text-align: center; margin-top: 20px;">
    
    <?php 
        
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if($currentPage < 1) $currentPage = 1;
    ?>

    <?php if ($currentPage > 1): ?>
        <a href="/gallery?page=<?= $currentPage - 1 ?>" class="button1">Poprzednia</a>
    <?php endif; ?>

    <span style="margin: 0 15px; font-weight: bold;">
        Strona <?= $currentPage ?> z <?= $totalPages ?>
    </span>

    <?php if ($currentPage < $totalPages): ?>
        <a href="/gallery?page=<?= $currentPage + 1 ?>" class="button1">Następna</a>
    <?php endif; ?>

    </div>

    <?php if (isset($_SESSION['username'])): ?>
    <section>
        <a class="savedphotos" href="/savedPhotos">Twoje Zapisane zdjecia</a>
    </section>
    <?php endif; ?>

    <section class="back_top_sec">
        <a class="back-to-top" href="#top">Powrót</a>
    </section>
</main>