<?php
session_start();
require 'config/config.php';
cekLogin();

function getService($id)
{
    $ch = curl_init();

    $url = API_URL_SERVICES . '/api/service/' . $id;

    // Mengatur opsi cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
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
    return $result;
}

$id = $_GET['id'];
$response = getService($id);

if ($response['status'] === 'success') {
    $service = $response['data'];
} else {
    $service = [];
}


// submit
if (isset($_POST['submit'])) {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $customer_email = htmlspecialchars($_POST['customer_email']);
    $customer_address = htmlspecialchars($_POST['customer_address']);
    $item_name = htmlspecialchars($_POST['item_name']);
    $qty = htmlspecialchars($_POST['qty']);
    $pickup_date = htmlspecialchars($_POST['pickup_date']);
    $service_id = htmlspecialchars($_POST['service_id']);

    $url = API_URL_SERVICES . '/api/orders/create';

    // Data login yang akan dikirim
    $data = [
        'customer_name' => $customer_name,
        'customer_email' => $customer_email,
        'customer_address' => $customer_address,
        'service_id' => $service_id,
        'item_name' => $item_name,
        'qty' => $qty,
        'pickup_date' => $pickup_date,
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

    if ($result['status'] === 'success') {

        echo "
        <script>
            alert('Pesanan anda berhasil dibuat.')
            window.location.href = 'order.php';
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
    <title>Serivice</title>

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

    <!-- Pricing -->
    <div id="pricing" class="cards-2 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="above-heading">Form Pemesanan</div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    <?php if (isset($_SESSION['name'])) : ?>
                        <form action="" method="post">
                            <input type="number" hidden name="service_id" value="<?= $service['id'] ?>">
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Service<span class='text-danger'>*</span></label>
                                <input type='text' name='' class='form-control ' value="<?= $service['serviceType'] . ' | ' . number_format($service['PricePerUnit']) . '/' . $service['unit'] ?>" readonly>
                            </div>
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Name<span class='text-danger'>*</span></label>
                                <input type='text' name='customer_name' class='form-control ' value="<?= $_SESSION['name'] ?>" readonly>
                            </div>
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Email<span class='text-danger'>*</span></label>
                                <input type='text' name='customer_email' class='form-control ' value="<?= $_SESSION['email'] ?>" readonly>
                            </div>
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Address<span class='text-danger'>*</span></label>
                                <textarea name="customer_address" class="form-control" id="customer_address" cols="30" rows="5"></textarea>
                            </div>
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Item<span class='text-danger'>*</span></label>
                                <input type='text' name='item_name' class='form-control ' value="">
                            </div>
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Qty/<?= $service['unit'] ?><span class='text-danger'>*</span></label>
                                <input type='number' name='qty' class='form-control ' value="">
                            </div>
                            <div class='form-group mb-3 text-left'>
                                <label for='' class='mb-2'>Pickupd Date<span class='text-danger'>*</span></label>
                                <input type='date' name='pickup_date' class='form-control ' value="">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit" name="submit">Pesan</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of cards-2 -->
    <!-- end of pricing -->


    <!-- Footer -->
    <svg class="footer-frame" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1920 79">
        <defs>
            <style>
                .cls-2 {
                    fill: #5f4def;
                }
            </style>
        </defs>
        <title>footer-frame</title>
        <path class="cls-2" d="M0,72.427C143,12.138,255.5,4.577,328.644,7.943c147.721,6.8,183.881,60.242,320.83,53.737,143-6.793,167.826-68.128,293-60.9,109.095,6.3,115.68,54.364,225.251,57.319,113.58,3.064,138.8-47.711,251.189-41.8,104.012,5.474,109.713,50.4,197.369,46.572,89.549-3.91,124.375-52.563,227.622-50.155A338.646,338.646,0,0,1,1920,23.467V79.75H0V72.427Z" transform="translate(0 -0.188)" />
    </svg>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-col first">
                        <h4>About Tivo</h4>
                        <p class="p-small">We're passionate about designing and developing one of the best marketing apps in the market</p>
                    </div>
                </div> <!-- end of col -->
                <div class="col-md-4">
                    <div class="footer-col middle">
                        <h4>Important Links</h4>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Our business partners <a class="white" href="#your-link">startupguide.com</a></div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Read our <a class="white" href="terms-conditions.html">Terms & Conditions</a>, <a class="white" href="privacy-policy.html">Privacy Policy</a></div>
                            </li>
                        </ul>
                    </div>
                </div> <!-- end of col -->
                <div class="col-md-4">
                    <div class="footer-col last">
                        <h4>Contact</h4>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li class="media">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="media-body">22 Innovative, San Francisco, CA 94043, US</div>
                            </li>
                            <li class="media">
                                <i class="fas fa-envelope"></i>
                                <div class="media-body"><a class="white" href="mailto:contact@tivo.com">contact@tivo.com</a> <i class="fas fa-globe"></i><a class="white" href="#your-link">www.tivo.com</a></div>
                            </li>
                        </ul>
                    </div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of footer -->
    <!-- end of footer -->


    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small">Copyright © 2020 <a href="https://inovatik.com">Template by Inovatik</a><br>
                        Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    </p>
                </div> <!-- end of col -->
            </div> <!-- enf of row -->
        </div> <!-- end of container -->
    </div> <!-- end of copyright -->
    <!-- end of copyright -->


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