<link rel="stylesheet" href="styles/galeria.css" />
<main>
    <h2>Zapisane Inspiracje</h2>


    <section class="gallery">
        <?php if (!empty($photos)): ?>
            <form action="/saveSelected" method="POST">
                <section>
                    <?php foreach ($photos as $photo): ?>
                        <?php if (isChecked($photo['filename'])): ?>
                            <div class="gallery-item">
                                <input type="checkbox" <?= isChecked($photo['filename']) ?  'checked' :  ''  ?> value="<?= htmlspecialchars($photo['filename']) ?>" name="<?= htmlspecialchars($photo['filename']) ?>">
                                <a href="images/input/<?= htmlspecialchars($photo['filename']) ?>" target="_blank">
                                    <img src="images/input/t_<?= htmlspecialchars($photo['filename']) ?>"
                                        alt="<?= htmlspecialchars($photo['title']) ?>" /> </a>

                                    <h3>Title: <?= htmlspecialchars($photo['title']) ?></h3>
                                    <h4>Author: <?= htmlspecialchars($photo['author']) ?></h4>
                                <label>Ilość: </label>
                                <input type="number" name="amounts[<?= htmlspecialchars($photo['filename']) ?>]" 
               value="<?= isset($_SESSION['SELECTED_AMOUNTS'][$photo['filename']]) ? $_SESSION['SELECTED_AMOUNTS'][$photo['filename']] : 1 ?>" 
               min="1">

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </section>
                <button class="saveSelected" type="Save" value="save" name="save">Save selected</button>
                <button class="button1" type="submit" name="action" value="clear_all"
                    
                    onclick="return confirm('Na pewno chcesz usunąć WSZYSTKIE zapisane zdjęcia?');">
                    Delete All
                </button>
            </form>
        <?php else: ?>
            <p>Brak zdjęć do wyświetlenia.</p>

        <?php endif; ?>

    </section>

    <?php if (isset($_SESSION['username'])): ?>
        <section>
            <a class="savedphotos" href="/gallery">Powrót</a>
        </section>
    <?php endif; ?>
    <section class="back_top_sec">
        <a class="back-to-top" href="#top">Powrót</a>
    </section>
</main>