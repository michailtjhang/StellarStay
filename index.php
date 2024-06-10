<?php


include_once 'database/koneksi.php';
include_once 'views/template/header.php';


?>

<section
    class="flex-1 rounded-tl-xl rounded-tr-xl rounded-b-xl bg-whitesmoke flex flex-col items-start justify-start pt-[29px] px-[79px] pb-[99px] box-border gap-[14px] max-w-[calc(100%_-_135px)] m-4 text-left text-[38px] text-black font-poppins lg:pl-[39px] lg:pr-[39px] lg:box-border mq750:gap-[17px] mq1050:max-w-full">
    <div
        class="w-[1282px] h-[780px] relative rounded-tl-xl rounded-tr-none rounded-b-none bg-whitesmoke hidden max-w-full">
    </div>

    <?php
    $url = !isset($_GET['url']) ? 'home' : $_GET['url'];

    $viewDir = 'views/';

    if ($url == 'home') {
        include_once $viewDir . 'home.php';
    } else if (!empty($url)) {
        include_once $viewDir . $url . '.php';
    } else {
        include_once $viewDir . 'home.php';
    }

    ?>

</section>



<?php
include_once 'views/template/footer.php';

