<?php
// Initialize the session
session_start();

// Update the following variables
$google_oauth_client_id = '506695090182-64evsmamrs4fh1pcpgebdsvdbplfd8pr.apps.googleusercontent.com';
$google_oauth_client_secret = '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';
$google_oauth_redirect_uri = 'http://localhost/P002_Helpdesk/HelpdeskAPI/auth.php';

// Database connection parameters
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'helpdesk';


try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if (isset($_GET['code']) && !empty($_GET['code'])) {

    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);
    // Make sure access token is valid
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        // Execute cURL request to retrieve the user info associated with the Google account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v3/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);


        $profile = json_decode($response, true);

        if (isset($profile['sub'])) {
            $google_id = $profile['sub'];
            $_SESSION['google_id'] = $google_id;
        }
        //controlla se l'email è autorizzata    
        if (isset($profile['email'])) {
            $allowed_domain = 'itiszuccante.edu.it';
            $user_email = $profile['email'];
            $domain = substr($user_email, strpos($user_email, '@') + 1);
            if ($domain === $allowed_domain) {
                $query = "SELECT * FROM utente WHERE email = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $user_email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $_SESSION['google_loggedin'] = TRUE;
                    $_SESSION['google_id'] = $result['id'];
                    $_SESSION['google_email'] = $result['email'];
                    $_SESSION['google_name'] = $result['nome'];
                    $_SESSION['google_surname'] = $result['cognome'];
                    $_SESSION['google_role'] = $result['ruolo'];
                    $_SESSION['google_picture'] = $result['foto_profilo'];
                }
                else {

                    $name = isset($profile['given_name']) ? $profile['given_name'] : '';
                    $surname = isset($profile['family_name']) ? $profile['family_name'] : '';

                    $insert_query = "INSERT INTO utente (email, nome, cognome) VALUES (:email, :nome, :surname)";
                    $stmt = $conn->prepare($insert_query);
                    $stmt->bindParam(':email', $user_email);
                    $stmt->bindParam(':nome', $name);
                    $stmt->bindParam(':surname', $surname);
                    if ($stmt->execute()) {
                        // User added successfully, retrieve data from database
                        $inserted_id = $conn->lastInsertId();
                        $_SESSION['google_loggedin'] = TRUE;
                        $_SESSION['google_id'] = $inserted_id;
                        $_SESSION['google_email'] = $user_email;
                        $_SESSION['google_name'] = $name;
                        $_SESSION['google_surname'] = $surname;
                        $_SESSION['google_role'] = 'utente';
                    } else {
                        exit('Error adding user to database!');
                    }
                }
                // Redirect to profile page
                header('Location: ../HelpdeskAPI/myaccount');
                exit;
            } else {
                exit('Access denied! You are not authorized to access this system.');
            }
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // No response code, redirect to Google Authentication page with params
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
?>
