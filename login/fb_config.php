<?php
define('ADD_ID', '1063917711301012');
define('APP_SECRET', '0253890e38c2ac2f71d55949133987f3'); 
define('API_VERSION', 'v2.10');
define('FB_BASE_URL', 'http://localhost/easykay/index.php');

if(!session_id()){
    session_start();
}

require_once('./libraries/Facebook/autoload.php');

$fb = new \Facebook\Facebook([
    'app_id' => ADD_ID,
    'app_secret' => APP_SECRET,
    'default_graph_version' => API_VERSION,
]);

$fb_helper = $fb->getRedirectLoginHelper();

// try to get access token
try{
    if(isset($_SESSION['facebook_access_token'])){
        $fbAccessToken = $_SESSION['facebook_access_token'];
    }
    else {
        $fbAccessToken = $fb_helper->getAccessToken();
    }
}catch(FacebookResponseException $e){
    echo "Facebook API Error: " . $e->getMessage();
    exit;
}catch(FacebookSDKException $e){
    echo "Facebook SDK Error: " . $e->getMessage();
    exit;
}

if (isset($fbAccessToken)) {

    if(!isset($_SESSION['facebook_access_token'])){
        $_SESSION['facebook_access_token'] = (string) $fbAccessToken;
        $oAuth2Client = $fb->getOAuth2Client();

        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    else {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }

    try {
        $fb_response = $fb->get('/me?fields=name,first_name,last_name,email');
        $fb_response_picture = $fb->get('/me/picture?redirect=false&height=200');

        $fb_user = $fb_response->getGraphUser();
        $picture = $fb_response_picture->getGraphUser();

        $fb_user_email = $fb_user->getProperty('email');
        $fb_user_name = $fb_user->getProperty('name');
        $fb_user_pic = $picture['url'];

        $stmt = $conn->prepare("SELECT * FROM tb_user_profile WHERE user_email = ?");
        $stmt->bind_param("s", $fb_user_email);
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
            userAccount($fb_user_email, $fb_user_name, $conn);
        }

    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        echo "Facebook API Error: " . $e->getMessage();
        session_destroy();
        
        header('location: ./');
        exit;
    }catch(Facebook\Exceptions\FacebookSDKException $e){
        echo "Facebook SDK Error: " . $e->getMessage();
        exit;
    }

} else {
    
    $fb_login_url = $fb_helper->getLoginUrl(FB_BASE_URL,  ['email']);
    
} 
    
    
 
?>