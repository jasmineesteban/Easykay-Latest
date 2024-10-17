<?php
   session_start();
    include_once './libraries/vendor/autoload.php';

    $clientID = '917799045498-pj71p55m8rpqgsl4qqb5do8bursob573.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri = 'http://localhost/easykay/index.php';

    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);

    $client->addScope("email");
    $client->addScope("profile");

    if (isset($_GET['code'])) {
                    
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        $client->setAccessToken($token['access_token']);

        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;
        $name = $google_account_info->name;


            $stmt = $conn->prepare("SELECT * FROM tb_user_profile WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $emailfound = mysqli_num_rows($result);

            if($emailfound > 0){
                $row = mysqli_fetch_assoc($result);
                $_SESSION['userId'] = $row['user_id'];

                header('Location: reg_user/home/reg_home.php');
                exit;
            }
            else{
                userAccount($email, $name, $conn);
            }
    }else {
        // Redirect user to Google OAuth URL
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }
?>