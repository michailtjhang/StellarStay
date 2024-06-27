<?php

session_start();

include_once '../database/koneksi.php';

// models
include_once '../app/models/user.php';

$sesi = $_SESSION['MEMBER'];
if (isset($sesi)) {

    $url = !isset($_GET['url']) ? 'dashboard' : strtolower($_GET['url']);

    // Menentukan judul halaman dinamis
    switch ($url) {
        case 'dashboard':
            $pageTitle = "Dashboard - Your Site Name";
            break;
        case 'laporan':
            $pageTitle = "Laporan - Your Site Name";
            break;
        case 'pages/penujung/dtpenujung':
            $pageTitle = "Data Penujung - Your Site Name";
            break;
        default:
            $pageTitle = "HomePage - Your Site Name";
    }

    include_once 'template/header.php';

?>

    <section class="flex-1 rounded-tl-xl rounded-tr-xl rounded-b-xl bg-whitesmoke flex flex-col items-start justify-start pt-[29px] px-[79px] pb-[99px] box-border gap-[14px] max-w-[calc(100%_-_135px)] m-4 text-left text-[38px] text-black font-poppins lg:pl-[39px] lg:pr-[39px] lg:box-border mq750:gap-[17px] mq1050:max-w-full">
        <div class="w-[1282px] h-[780px] relative rounded-tl-xl rounded-tr-none rounded-b-none bg-whitesmoke hidden max-w-full">
        </div>

        <?php

        if ($url == 'dashboard') {
            include_once 'dashboard.php';
        } else if (!empty($url)) {
            include_once $url . '.php';
        } else {
            include_once 'dashboard.php';
        }

        ?>

    </section>



<?php
    include_once 'template/footer.php';
} else {
    echo '<script> alert("Anda Tidak bisa Masuk!!!"); history.back(); </script>';
}
