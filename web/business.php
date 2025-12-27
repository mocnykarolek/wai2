
<?php
function get_db()
{

    $mongo = new MongoDB\Client(
        "mongodb://127.0.0.1:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]
    );

    $db = $mongo->wai;

    return $db;
}

function save_contact($name, $email, $phone, $message, $contact, $consent, $sex)
{

    $db = get_db();
    $document = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'message' => $message,
        'contact' => $contact,
        'consent' => $consent,
        'sex' => $sex,

    ];
    $db->contacts->insertOne($document);
}

function addNewUser()
{
    $db = get_db();

    // 1. Najpierw odbieramy dane
    $query = [
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),

    ];

    if ($_POST['password'] !== $_POST['rpassword']) {
        // $status = 'Hasła nie jest takie same!';
        $status = 'Hasła nie są takie same!';
        require_once '../views/loginpage.php';
        return;
    }

    // 2. SPRAWDZANIE DUPLIKATÓW (Przeniesione na górę!)
    // Nie ma sensu przetwarzać pliku, jeśli login jest zajęty.
    $existingUser = $db->users->findOne(['username' => $query['username']]);
    $existingEmail = $db->users->findOne(['email' => $query['email']]);

    if ($existingUser !== null) {
        $status = 'Użytkownik o takiej nazwie już istnieje!';
        require_once '../views/loginpage.php';
        return;
    }
    if ($existingEmail !== null) {
        $status = 'Użytkownik z takim emailem już istnieje!';
        require_once '../views/loginpage.php';
        return;
    }

    // 3. OBSŁUGA PLIKU (Dopiero teraz)
    $response_photo = $_FILES['file'];

    // Walidacja błędów uploadu
    if ($response_photo['error'] === UPLOAD_ERR_NO_FILE) {
        $status = "Nie dodałeś pliku (avatar jest wymagany)!"; // lub opcjonalny - zależy od Ciebie
        require_once '../views/loginpage.php';
        return;
    }

    // Walidacja typu i rozmiaru
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($fileInfo, $response_photo['tmp_name']);


    $allowedTypes = ['image/jpeg', 'image/png'];

    if ($response_photo['size'] > 1048576) {
        $status = "Plik jest za duży! Maksymalnie 1MB.";
        require_once '../views/loginpage.php';
        return;
    }

    if (!in_array($type, $allowedTypes)) {
        $status = "Niedozwolony format! Tylko JPG i PNG."; // Zmieniłem $error na $status dla spójności
        require_once '../views/loginpage.php';
        return;
    }

    // 4. PRZYGOTOWANIE ŚCIEŻKI
    // Używamy DOCUMENT_ROOT dla pewności
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/images/users_avatars/';

    // Tworzenie folderu jeśli nie istnieje
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    // POPRAWKA: Rozszerzenie bierzemy z PLIKU, nie z loginu
    $ext = pathinfo($response_photo['name'], PATHINFO_EXTENSION);
    $photoName = $query['username'] . '.' . $ext;
    $target = $uploadDirectory . $photoName;

    // 5. UPLOAD I ZAPIS
    // POPRAWKA LOGIKI: move_uploaded_file zwraca TRUE przy sukcesie
    if (generateThumbnail($response_photo['tmp_name'], $target, $type, 50, 50)) {

        // Dodajemy nazwę avatara do zapytania
        $query['avatar'] = $photoName;

        // Wstawiamy do bazy i pobieramy wynik
        $insertResult = $db->users->insertOne($query);

        // Ustawiamy sesję (auto-login po rejestracji)
        // Pobieramy ID nowo utworzonego rekordu
        $_SESSION['user_id'] = $insertResult->getInsertedId();
        $_SESSION['username'] = $query['username'];
        $_SESSION['avatarfile'] = $photoName;
        $status = 'Utworzono konto poprawnie!';

        // Header przed HTML!
        header("Refresh: 1; url=/home");
        require_once '../views/validlogin.php';
    } else {
        $status = "Błąd serwera: Nie udało się zapisać zdjęcia!";
        require_once '../views/loginpage.php';
        return;
    }
}

function loginAuth()
{

    $db = get_db();


    $query = [
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
    ];

    $user = $db->users->findOne(['username' => $query['username']]);


    if ($user === null) {
        $status = 'Nie znaleziono takiej użytkowanika!';

        require_once '../views/loginpage.php';
        return;
    }
    if ($user['email'] !== $query['email']) {
        $status = 'Błędny email!';

        require_once '../views/loginpage.php';
        return;
    }
    if (!password_verify($query['password'], $user['password'])) {
        $status = 'Błędne hasło!';

        require_once '../views/loginpage.php';
        return;
    }


    $_SESSION['user_id'] = $user['_id'];
    $_SESSION['username'] = $query['username'];
    $_SESSION['avatarfile'] = $user['avatar'];

    $status = 'Zalogowano!';

    header("Refresh: 1; url=/home");

    require_once '../views/validlogin.php';
}



function save_photo($filename, $title, $author, $visibility)
{

    $db = get_db();
    $dokument = [
        "filename" => $filename,
        "title" => $title,
        "author" => $author,
        "visibility" => $visibility,

    ];

    $db->photos->insertOne($dokument);
}

function load_selected()
{
    if (empty($_SESSION['user_id'])) {
        $_SESSION['SELECTED_PHOTOS'] = [];
        $_SESSION['SELECTED_AMOUNTS'] =[];
        return;
    }

    $db = get_db();
    $foundedPhotos = $db->saved_photos->find([
        'user_id' => $_SESSION['user_id']
    ]);
    $selectedPhotos = [];
    $selectedAmounts = [];
    foreach ($foundedPhotos as $field) {
        if (isset($field['filename'])  && is_string($field['filename'])) {
            $selectedPhotos[] = $field['filename'];

            $amount = isset($field['amount']) ? $field['amount'] : 1;
            $selectedAmounts[$field['filename']] = $amount;
        }
    }
    $_SESSION['SELECTED_PHOTOS'] = $selectedPhotos;
    $_SESSION['SELECTED_AMOUNTS'] =$selectedAmounts;
}




function handleSelected()
{
    $db = get_db();
    if (!isset($_SESSION['user_id'])) {
        $status = "nie jetes zalogowany!";
        header("Location: /gallery");
        return;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'clear_all') {
        
        
        $db->saved_photos->deleteMany([
            'user_id' => $_SESSION['user_id']
        ]);
        
        return;
    }



    $db->saved_photos->deleteMany([
        'user_id' => $_SESSION['user_id']
    ]);


    $amounts = isset($_POST['amounts']) ? $_POST['amounts'] : [];

    foreach ($_POST as $key => $filename) {
        if ($filename === 'save' || $key === 'action' || $key === 'amounts') {
            continue;
        }

        $amount = 1;
        if(isset($amounts[$filename])){
            $amount = (int)$amounts[$filename];
            if ($amount < 1) $amount = 1;
        }



        $db->saved_photos->insertOne([
            'user_id' => $_SESSION['user_id'],
            'filename' => $filename,
            'amount' => $amount
        ]);
    }
}


function CartCount(){
    

    if(empty($_SESSION['username'])){
        return 0;

    }

    $db = get_db();

    $saved_photos = $db->saved_photos->find(['user_id' => $_SESSION['user_id']]);



    $count =0;

    foreach($saved_photos as $item){
        $amount = isset($item['amount']) ? (int)$item['amount'] : 1;
        $count +=$amount;
    }

    return $count;
}