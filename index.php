<?php

session_start();
global $level;
global $member;

include_once 'database/koneksi.php';

$url = !isset($_GET['hal']) ? 'login' : $_GET['hal'];
$viewDir = 'views/';

// Mengecek apakah migration.php sudah dijalankan
if (!defined('MIGRATION_INCLUDED')) {
    include_once 'database/migration.php';
    define('MIGRATION_INCLUDED', true);
}

?>

<section class="flex-1 rounded-tl-xl rounded-tr-xl rounded-b-xl bg-whitesmoke flex flex-col items-start justify-start pt-[29px] px-[79px] pb-[99px] box-border gap-[14px] max-w-[calc(100%_-_135px)] m-4 text-left text-[38px] text-black font-poppins lg:pl-[39px] lg:pr-[39px] lg:box-border mq750:gap-[17px] mq1050:max-w-full">
    <div class="w-[1282px] h-[780px] relative rounded-tl-xl rounded-tr-none rounded-b-none bg-whitesmoke hidden max-w-full">
    </div>

    <?php

    if ($url == 'login') {
        include_once $viewDir . 'login.php';
    } else if (!empty($url)) {
        include_once $viewDir . $url . '.php';
    } else {
        include_once $viewDir . 'login.php';
    }

    ?>

</section>