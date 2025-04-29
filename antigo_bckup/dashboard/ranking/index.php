<?php 
$raffle = isset($_GET['raffle']) ? $_GET['raffle'] : '';
$d_start = isset($_GET['ranking_date_start']) ? $_GET['ranking_date_start'] : date('Y-m-d');
$d_end = isset($_GET['ranking_date_end']) ? $_GET['ranking_date_end'] : date('Y-m-d');

$enable_raffle_mode = $_settings->info('enable_raffle_mode');
echo $enable_raffle_mode;
$enable_raffle_mode_class_phone = ($enable_raffle_mode == 1) ? 'enable_raffle_mode_class_phone' : '';
?>
<style>
    .theme-dark input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(1);
    }
    
/* styles.css */
.enable_raffle_mode_class_phone .real-number {
    display: none; /* Esconde os números reais */
}

.enable_raffle_mode_class_phone .masked-number::before {
    content: attr(data-ddd) " *****-****"; /* Conteúdo a ser mostrado */
    color: black; /* Cor dos asteriscos */
}



</style>

<script>
    // script.js
document.addEventListener("DOMContentLoaded", function() {
    var phoneNumbers = document.querySelectorAll('.enable_raffle_mode_class_phone');
    phoneNumbers.forEach(function(phoneNumber) {
        var text = phoneNumber.textContent.trim();
        var ddd = text.slice(0, 4); // Extrai o DDD com parênteses
        var number = text.slice(4).trim(); // Extrai o restante do número
        phoneNumber.innerHTML = '<span class="real-number">' + text + '</span>' +
                                '<span class="masked-number" data-ddd="' + ddd + '"></span>';
    });
});

</script>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2
        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
        >
        Ranking de compradores
    </h2>  


    <form action="" id="filter-form" style="margin-bottom:10px">
        <label for="date" class="block text-sm dark:text-gray-300 dark:focus:shadow-outline-gray">Selecione a campanha</label>
        <div class="flex">
            <select name="raffle" id="raffle" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Selecione</option>
                <?php 
                $qry = $conn->query("SELECT * FROM `product_list`");
                while ($row = $qry->fetch_assoc()) { ?>
              <option value="<?= $row['id'] ?>" <?php if($raffle == $row['id']){echo 'selected';} ?>><?= $row['name'] ?></option>
               <?php }  ?>
            </select>
            <input name="ranking_date_start" id="ranking_date_start" type="date" value="<?=$d_start;?>" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
            <input name="ranking_date_end" id="ranking_date_end" type="date" value="<?=$d_end;?>" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
            <button class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar"> Filtrar</button>
        </div>
    </form>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >               
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Telefone</th>
                    <th class="px-4 py-3">Sorteio</th>
                    <th class="px-4 py-3">Qtd. Números</th>
                    <th class="px-4 py-3">Total</th>
                </tr>
            </thead>
            <tbody
            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php 
            $perPage = 20; 
            $page = isset($_GET['pg']) ? $_GET['pg'] : 1;
            $offset = ($page - 1) * $perPage;
            $totalResults = $conn->query('SELECT * FROM order_list')->num_rows;          
            $totalPages = ceil($totalResults / $perPage);
            
            $g_total = 0;
            $i = 1; 
            if($raffle){  

                if(empty($_GET['ranking_date_start']) || empty($_GET['ranking_date_end'])) {
                    $stmt = $conn->prepare("
                        SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
                        o.code, CONCAT(' ', o.product_name) AS product
                        FROM order_list o
                        INNER JOIN customer_list c ON o.customer_id = c.id
                        WHERE o.product_id = ? AND o.status = 2
                        GROUP BY o.customer_id
                        ORDER BY total_quantity DESC
                        LIMIT ? OFFSET ?
                    ");
                    
                    if ($stmt === false) {
                        die('Erro na preparação da consulta: ' . $conn->error);
                    }
                   
                    $stmt->bind_param("iii", $raffle, $perPage, $offset);
                    $stmt->execute();           
                    $requests = $stmt->get_result();
                }else{
                    $date_start = isset($d_start) ? new DateTime($d_start) : '';
                    $date_end = isset($d_end) ? new DateTime($d_end) : '';
                    $date_start_formatted = $date_start->format('Y-m-d') . " 00:00:00";
                    $date_end_formatted = $date_end->format('Y-m-d') . " 23:59:59";  
                    $stmt = $conn->prepare("
                        SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
                        o.code, CONCAT(' ', o.product_name) AS product, o.date_created
                        FROM order_list o
                        INNER JOIN customer_list c ON o.customer_id = c.id
                        WHERE o.product_id = ? AND o.status = 2
                        AND o.date_created >= ? AND o.date_created <= ?
                        GROUP BY o.customer_id
                        ORDER BY total_quantity DESC
                        LIMIT ? OFFSET ?
                    ");
                    
                    if ($stmt === false) {
                        die('Erro na preparação da consulta: ' . $conn->error);
                    }
                    
                    $stmt->bind_param("isssi", $raffle, $date_start_formatted, $date_end_formatted, $perPage, $offset);
                    $stmt->execute();           
                    $requests = $stmt->get_result();
                }        

            while ($row = $requests->fetch_assoc()) {

                ?>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3"><?= $row['firstname'] ?> <?= $row['lastname'] ?></td>
                    <td class="px-4 py-3 <?=$enable_raffle_mode_class_phone;?>"><?= formatPhoneNumber($row['phone']); ?></td>
                    <td class="px-4 py-3"><?= $row['product'] ?></td>
                    <td class="px-4 py-3"><?= $row['total_quantity'] ?></td>
                    <td class="px-4 py-3">R$ <?= format_num($row['total_amount'],2) ?></td>          

                </tr>
            <?php } ?>
            <?php }else{ ?>
                <tr>
                    <td class="dark:text-gray-300 dark:focus:shadow-outline-gray p-4 text-sm" colspan="6">Nada até o momento.</td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>
<div
class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
>
<span class="flex items-center col-span-3">
</span>
<span class="col-span-2"></span>

<!-- Pagination -->
<?php if($totalPages > 0){ ?>
    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        <nav aria-label="Table navigation">
            <ul class="inline-flex items-center">

                <?php if ($page > 1){ ?>
                    <a href='./?page=ranking&pg=<?php echo $page-1 ?>'><li>
                        <button
                                class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                aria-label="Previous"
                                >
                                <svg
                                class="w-4 h-4 fill-current"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                >
                                <path
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </li></a>
        <?php } ?>

        <?php if ($page > 3){ ?>
            <a href="./?page=ranking&pg=1"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li></a>
            <li class="dots">...</li>
        <?php } ?>

        <?php if ($page-2 > 0){ ?>
            <a href="./?page=ranking&pg=<?php echo $page-2 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page-2 ?></button></li></a>
        <?php } ?>

        <?php if ($page-1 > 0){ ?>
            <a href="./?page=ranking&pg=<?php echo $page-1 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page-1 ?></button></li></a>
        <?php } ?>

        <a href="./?page=ranking&pg=<?php echo $page; ?>">
            <li>
                <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page; ?></button>
            </li>
        </a>
        <?php if ($page+1 < $totalPages+1){ ?>
            <a href="./?page=ranking&pg=<?php echo $page+1 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page+1 ?></button></li></a>   
        <?php } ?>

        <?php if ($page+2 < $totalPages +1){ ?>
            <a href="./?page=ranking&pg=<?php echo $page+2 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page+2 ?></button></li></a>
        <?php } ?>

        <?php if ($page < $totalPages-2): ?>
            <li class="dots">...</li>
            <a href="./?page=ranking&pg=<?php echo $totalPages ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $totalPages ?></button></li></a>
        <?php endif; ?>


        <?php if ($page < $totalPages){ ?>
            <a href="./?page=ranking&pg=<?php echo $page+1 ?>"><li>
                <button
                class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                aria-label="Next"
                >
                <svg
                class="w-4 h-4 fill-current"
                aria-hidden="true"
                viewBox="0 0 20 20"
                >
                <path
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
                fill-rule="evenodd"
                ></path>
            </svg>
        </button>
    </li>
</a>
<?php } ?>

</ul>
</nav>
</span>
<!-- End pagination -->
<?php } ?>

</div>
</div>
</div>
</main>

<script>
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = './?page=ranking&'+$(this).serialize()
        })


    })
</script>