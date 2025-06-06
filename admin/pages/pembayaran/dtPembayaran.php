<?php

$model =  new pembayaran();
$data_pembayaran = $model->dataPembayaran();

?>

<!-- ======================== datatable ========================= -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<!-- ======================== Font Awesome ========================= -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="flex flex-col items-start justify-start gap-[7px]">
    <h1 class="mt-4 h-[47px] relative text-inherit font-bold font-inherit inline-block z-[1] mq1050:text-[30px] mq450:text-[23px]">
        Table Data Pembayaran
    </h1>
    <h3 class="m-0 relative text-xl font-normal font-inherit text-gray-100 z-[1] mq450:text-[16px]">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="index.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Data Pembayaran</span>
                    </div>
                </li>
            </ol>
        </nav>
    </h3>

</div>
<div class="w-[1066px] max-w-full flex flex-col items-start gap-4  font-inter mr-4">
    <div class="w-full rounded-xl mr-10 bg-white p-6 mq750:p-4">
        <table id="tableData" class="display w-full text-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Penunjung</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($data_pembayaran as $row) : ?>
                    <?php
                    $total_pembayaran = $model->getTotalPembayaran($row['harga'], $row['jumlah_kamar'], $row['komisi']);
                    $status = is_null($row['total_bayar']) ? "Pending" : "Lunas";
                    ?>
                    <tr>
                        <td><?php echo $id++ ?></td>
                        <td><?php echo $row['nama_penunjung'] ?></td>
                        <td>RP. <?php echo number_format($total_pembayaran, 2) ?></td>
                        <td><?php echo $status ?></td>
                        <td>
                            <a href="index.php?url=Pages/pembayaran/pembayaran_form&idedit=<?= $row['reservasi_id'] ?>">
                                <?php if ($status == "Pending") : ?>
                                    <button type="button" class="focus:outline-none text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-2 text-center me-2 mb-2 dark:focus:ring-yellow-900">
                                        <i class="fa-regular fa-credit-card"></i>
                                    </button>
                                <?php else : ?>
                                    <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-2 text-center me-2 mb-2 dark:focus:ring-yellow-900 cursor-not-allowed" disabled >
                                        <i class="fa-regular fa-credit-card"></i>
                                    </button>

                                <?php endif; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        $('#tableData').DataTable({
            dom: '<"flex justify-between items-center mb-4"<"text-sm"l><"text-sm"f>>rt<"flex justify-between items-center mt-4"<"text-sm"i><"text-sm"p>>',
            language: {
                lengthMenu: "Show _MENU_ entries",
            }
        });
    });
</script>