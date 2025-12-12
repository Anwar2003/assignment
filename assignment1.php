<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = $_POST['message'];
        $method = "AES-256-CBC";
        
        if(isset($_POST['encrypt'])){
            $key = openssl_random_pseudo_bytes(32);// to store them in the session then use them agan
            $iv_length = openssl_cipher_iv_length($method);
            $iv = openssl_random_pseudo_bytes($iv_length);
            $encrypted = openssl_encrypt($data,$method,$key,0,$iv);
            $_SESSION['key'] = base64_encode($key);
            $_SESSION['iv'] = base64_encode($iv);
            $_SESSION['encrypted'] = $encrypted;

            echo "input value: $data<br>";

            echo "encrypted: $encrypted<br>";
    
    }
    elseif(isset($_POST['decrypt'])){
        if(isset($_SESSION['key']) && isset($_SESSION['iv']) && isset($_SESSION['encrypted'])){

        $key = base64_decode($_SESSION['key']);
            $iv = base64_decode($_SESSION['iv']);
            $encrypted = $_SESSION['encrypted'];

        $decrypted = openssl_decrypt($encrypted,$method,$key,0,$iv);
        echo "encrypted: $encrypted<br>";

        echo "decrypted: $decrypted<br>";
        }
    }

    }
?>

<form method="POST">
    
    <textarea name="message"></textarea><br><br>
    
    <button type="submit" name= "encrypt">encrypt</button>
    <button type="submit" name= "decrypt">decrypt</button>

</form>





