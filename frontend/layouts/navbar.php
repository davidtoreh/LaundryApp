<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">

        <!-- Text Logo - Use this if you don't have a graphic logo -->
        <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Tivo</a> -->

        <!-- Image Logo -->
        <a class="navbar-brand logo-image" href="index.html"><img src="images/logo.svg"></a>

        <!-- Mobile Menu Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-awesome fas fa-bars"></span>
            <span class="navbar-toggler-awesome fas fa-times"></span>
        </button>
        <!-- end of mobile menu toggle button -->

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link " href="index.php">HOME <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="service.php">SERVICE</a>
                </li>
                <li class="nav-item dropdown">
                    <?php if (isset($_SESSION['name'])) : ?>
                        <a class="nav-link dropdown-toggle page-scroll" href="javascript:void(0)" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['name'] ?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item mb-2" href="order.php"><span class="item-text">Orders</span></a>
                            <a class="dropdown-item" href="logout.php"><span class="item-text">Logout</span></a>
                        </div>
                </li>
            <?php else : ?>
                <span class="nav-item">
                    <a class="btn-outline-sm" href="login.php">LOGIN</a>
                </span>
            <?php endif; ?>
            </ul>
        </div>
    </div> <!-- end of container -->
</nav> <!-- end of navbar -->
<!-- end of navigation -->