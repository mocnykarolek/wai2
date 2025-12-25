<link rel="stylesheet" href="styles/aboutme.css" /> 
 <main>
      <section class="about_me_section">
        <?php if (isset($status)): ?>
        
            <?= htmlspecialchars($status) ?>
        
      <?php endif; ?>
      </section>
    </main>

    <script src="aboutme.js"></script>