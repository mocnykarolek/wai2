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
                    <input type="checkbox" <?php isChecked($photo['filename']) ?>  value="<?= htmlspecialchars($photo['filename']) ?>" name="<?= htmlspecialchars($photo['filename']) ?>">
                    <a href="images/input/<?= htmlspecialchars($photo['filename']) ?>" target="_blank">
                        <img src="images/input/t_<?= htmlspecialchars($photo['filename']) ?>"
                            alt="<?= htmlspecialchars($photo['title']) ?>" />
                        <h3>Title: <?= htmlspecialchars($photo['title']) ?></h3>
                        <h4>Author: <?= htmlspecialchars($photo['author']) ?></h4> 

                    </a>

                </div>

            <?php endforeach; ?>
                
            </section>
            <button class="saveSelected" type="Save" value="save" name="save">Save selected</button>
            </form> 
        <?php else: ?>
            <p>Brak zdjęć do wyświetlenia.</p>
        
        <?php endif; ?>
        
    </section>
    <section>
        <a class="savedphotos" href="/SavedPhotos">Twoje Zapisane zdjecia</a>
    </section>

    <section class="back_top_sec">
        <a class="back-to-top" href="#top">Powrót</a>
    </section>
</main>