<link rel="stylesheet" href="styles/aboutme.css" /> 
 <main>
      <section class="about_me_section">
        <h2>Login</h2>
        <?php if (isset($status)): ?>
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
            <?= htmlspecialchars($status) ?>
        </div>
      <?php endif; ?>
        <section class="form">
        <form action="/signup" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email">
            <label for="username">Username</label>
            <input type="username" name="username">
            <label for="password">Password</label>
            <input type="password" name="password">
            <section class="submits buttons">
            
            <button type="signup" value="login" name="signup">Login</button>
            </section>
        </form>

        </section>
        
        <section class="form">
          <h2>Register</h2>
        <form action="/signup" method="POST" enctype="multipart/form-data">
            <label for="email">Email</label>
            <input type="email" name="email">
            <label for="username">Username</label>
            <input type="username" name="username">
            <label for="password">Password</label>
            <input type="password" name="password">
            <label for="rpassword">Confirm Password</label>
            <input type="password" name="rpassword">
            <label for="file">Dodaj Avatar</label>
            <input class="file" type="file" name="file">
            <section class="submits buttons">
            <button type="signup" value="register" name="signup">Register</button>
            
            </section>
        </form>

        </section>
      </section>
          
    </main>

    <script src="aboutme.js"></script>