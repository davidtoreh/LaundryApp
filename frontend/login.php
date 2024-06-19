<?php
session_start();
require 'config/config.php';

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $url = API_URL_USERS . '/api/auth/login';

    // Data login yang akan dikirim
    $data = [
        'email' => $email,
        'password' => $password,
    ];

    // Menginisialisasi cURL
    $ch = curl_init($url);

    // Mengatur opsi cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    // Mengeksekusi permintaan cURL dan mendapatkan respons
    $response = curl_exec($ch);

    // Menangani kesalahan cURL
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    // Menutup koneksi cURL
    curl_close($ch);

    // Mengubah respons JSON menjadi array asosiatif
    $result = json_decode($response, true);

    // Memeriksa apakah respons mengandung access_token
    if (isset($result['access_token'])) {
        $_SESSION['token'] =  $result['access_token'];
        $_SESSION['name'] =  $result['name'];
        $_SESSION['email'] =  $result['email'];

        echo "
        <script>
            alert('Login berhasil.')
            window.location.href = 'index.php';
        </script>
        ";
    } else {
        $errors = $result['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Tivo is a HTML landing page template built with Bootstrap to help you crate engaging presentations for SaaS apps and convert visitors into users.">
    <meta name="author" content="Inovatik">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article" />

    <!-- Website Title -->
    <title>Log In - Tivo - SaaS App HTML Landing Page Template</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/fontawesome-all.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/swiper.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/magnific-popup.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/styles.css" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="images/favicon.png">
</head>

<body data-spy="scroll" data-target=".fixed-top">

    <!-- Preloader -->
    <div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->


    <?php include('layouts/navbar.php') ?>

    <!-- Header -->
    <header id="header" class="ex-2-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Log In</h1>
                    <p>You don't have a password? Then please <a class="white" href="register.php">Register</a></p>
                    <!-- Sign Up Form -->
                    <div class="form-container">
                        <?php if (isset($errors)) : ?>
                            <p class="text-dark"><?= $errors ?></p>
                        <?php endif; ?>
                        <form data-focus="false" action="" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control-input" id="lemail" name="email" required>
                                <label class="label-control" for="lemail">Email</label>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control-input" id="lpassword" name="password" required>
                                <label class="label-control" for="lpassword">Password</label>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <button name="login" type="submit" class="form-control-submit-button">LOG IN</button>
                            </div>
                        </form>
                    </div> <!-- end of form container -->
                    <!-- end of sign up form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->


    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src="<?= BASE_URL ?>/js/popper.min.js"></script> <!-- Popper tooltip library for Bootstrap -->
    <script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script> <!-- Bootstrap framework -->
    <script src="<?= BASE_URL ?>/js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src="<?= BASE_URL ?>/js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
    <script src="<?= BASE_URL ?>/js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
    <script src="<?= BASE_URL ?>/js/validator.min.js"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
    <script src="<?= BASE_URL ?>/js/scripts.js"></script> <!-- Custom scripts -->
</body>

</html>