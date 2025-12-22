<link rel="stylesheet" href="styles/form.css" />
<main>



      <section class="form_box">
        <section class="flex-element">
          <h2>Skontaktuj się ze mną</h2>
          <form action="action=upload" method="POST" id="form_section">
            <label for="name">Twoje imię</label>
            <input type="text" id="name" name="name"/>

            <label for="email">Twój email</label>
            <input type="email" id="email" name="email" />

            <label for="phone">Numer telefonu</label>
            <input type="tel" id="phone" name="phone" />

            <label for="message">Twoja wiadomość</label>
            <textarea
              id="message"
              name="message"
              cols="30"
              rows="10"
            ></textarea>

            <label for="preferences">Preferencje kontaktu</label>
            <select name="preferences" id="preferences">
              <option value="email">Email</option>
              <option value="phone">Telefon</option>
            </select>

            <div>
              <input type="checkbox" id="consent" name="consent" />
              <label for="consent">
                Tak, chcę otrzymywać powiadomienia na adres email / numer
                telefonu
              </label>
            </div>

            <div>
              <input type="radio" name="gender" id="mezczyzna" value="M" />
              <label for="mezczyzna">Mężczyzna</label>
            </div>

            <div>
              <input type="radio" name="gender" id="kobieta" value="K" />
              <label for="kobieta">Kobieta</label>
            </div>

            <button type="submit">Wyślij</button>
            <input class="reset_button" type="reset" value="Wyczyść" />
          </form>
        </section>
      </section>
      <section class="back_top_sec">
        <a class="back-to-top" href="#top">Powrót</a>
      </section>
    </main>

    <script src="form.js"></script>