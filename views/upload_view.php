<link rel="stylesheet" href="styles/aboutme.css" /> 
 <main>
      <section class="about_me_section">
        <h2 class="thanks">Dziekujemy za wypełnienie formularza!</h2>
        <p>
          <?php
            $db = get_db();
            $contacts = $db->contacts->find();

            foreach($contacts as $contact){
              echo $contact['name'] . $contact['phone']. $contact['message'] . '<br/>';
            }

          ?>
          
        </p>
        
      </section>
    </main>

    <script src="aboutme.js"></script>