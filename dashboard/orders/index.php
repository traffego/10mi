<?php $enable_raffle_mode = $_settings->info('enable_raffle_mode');
$enable_raffle_mode_class_phone = ($enable_raffle_mode == 1) ? 'enable_raffle_mode_class_phone' : '';
?>
<style>

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
<?php 
$status = isset($_GET['status']) ? $_GET['status'] : '';
$stat_arr = ['Pending Orders', 'Packed Orders', 'Our for Delivery', 'Completed Order'];
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : '';
$order_number = trim(isset($_GET['order_number']) ? $_GET['order_number'] : '');
$customer_name = isset($_GET['customer_name']) ? $_GET['customer_name'] : '';
$tod = '';
if($product_id){
	$qry = $conn->query("SELECT type_of_draw FROM `product_list` WHERE id = $product_id");
	if ($qry->num_rows > 0) {
		$row = $qry->fetch_assoc();
		$tod = $row['type_of_draw'];    
	}
}
function strcasecmp_utf8($str1, $str2) {
	return strcasecmp(mb_strtolower($str1, 'UTF-8'), mb_strtolower($str2, 'UTF-8'));
}
?>
<style>/*.order_numbers {
	padding: 10px;
	max-width: 150px;
	white-space: nowrap;
	overflow: auto;
}*/
.adm-pedido-numeros {
	position: relative;
	color: #000;
    display: block;
    width: 100%;
    cursor: pointer;
    white-space: nowrap;
}
.dataNumbers {
	word-break: break-word;
    height: 150px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 5px;
    display: list-item;
	margin-top: 15px;
}
.order_numbers {
    white-space: normal;
}
tr.text-gray-700.dark\:text-gray-400 {
    vertical-align: text-bottom;
}
.leowp-tab, .leowp-tab * {
  font-family: arial, sans-serif;
  box-sizing: border-box;
}

.leowp-tab input { display: none; }

.leowp-tab label {
  position: relative; /* required for (f2) position:absolute */
  display: block;
  width: 100%; 
  cursor: pointer;
}


.leowp-tab .leowp-content { 
  overflow: hidden;
   
  max-height: 0;
}
leowp-tab .leowp-content p { padding: 10px; }

.leowp-tab input:checked ~ .leowp-content { max-height: 100%; }

.leowp-tab label::after {
  display: block;  
  content: "\25BC"; 
  position: absolute;
  left: 60px; 
  top: 0px; 
  transition: all 0.4s;
}
 .exportar-contatos {
    max-width: 189px;
    display: inline-block;
    margin-bottom: 10px;
}
.leowp-tab input:checked ~ label::after { transform: rotate(-180deg); }

  @media all and (max-width:40em){
    .filtro-busca{
      display:block!important;
    }

  }
  span#approve-payment {
    background: #2271b1;
    padding: 6px;
    display: inline-block;
    margin-top: 6px;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
}
.msgCron {
	max-height: 100px;
    display: inline-block;
    overflow: auto;
    width: 100%;
}
@media (min-width: 640px) {
	.msgCron {
		max-height: 75px;
	}
}
</style>
<main class="h-full pb-16 overflow-y-auto">
	<div class="container grid px-6 mx-auto">
		<h2
		class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
		>
		Pedidos
	</h2>
	<form action="" id="filter-form" style="margin-bottom:10px" method="GET">
		<div class="flex filtro-busca">
			<select name="product_id" id="product_id" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
				<option value="">Todas as campanhas</option>
				<?php 
				$qry = $conn->query("SELECT * FROM `product_list`");
				while ($row = $qry->fetch_assoc()) { ?>
					<option value="<?= $row['id'] ?>" <?php if($product_id == $row['id']){echo 'selected';} ?>><?= $row['name'] ?></option>
				<?php }  ?>
			</select>
			<select name="status_id" id="status_id" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
				<option value="">Todos os status</option>
				<option value="2" <?php if($status_id == '2'){echo 'selected';} ?>>Pago</option>
				<option value="1" <?php if($status_id == '1'){echo 'selected';} ?>>Pendente</option>
				<option value="3" <?php if($status_id == '3'){echo 'selected';} ?>>Cancelado</option>
			</select>

			<input name="order_number" id="order_number" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Pesquisar por cota">

			<input name="customer_name" id="customer_name" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Pesquisar por nome">

			<button class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar"> Filtrar</button>
		</div>
	</form>
	<div class="flex flex-row justify-between">
		<div class="w-auto">
			<button class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple exportar-contatos mr-2 sm:mr-0" onclick="export_raffle_contacts();"> Exportar Contatos</button>
		</div>
		<div class="w-auto">
			<button @click="openCron" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg text-orange-700 bg-orange-100 dark:text-white dark:bg-orange-600 focus:outline-none flex flex-row" onclick=""> 
				<svg class="w-5 h-5 mr-2 hidden md:block" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
				</svg>
				Apagar Cancelados
			</button>
		</div>
    </div>

	<div class="w-full overflow-hidden rounded-lg shadow-xs">
		<div class="w-full overflow-x-auto">
			<table class="w-full lg:whitespace-normal whitespace-no-wrap">
				<thead>
					<tr
					class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
					>
					<th class="px-4 py-3">ID</th>
					<th class="px-4 py-3 w-32">Data</th>
					<th class="px-4 py-3">Sorteio</th>
					<th class="px-4 py-3">Cliente</th>
					<th class="px-4 py-3">Whats</th>
					<th class="px-4 py-3">Qtd</th>
					<th class="px-4 py-3">Números</th>
					<th class="px-4 py-3">Desconto</th>
					<th class="px-4 py-3">Total</th>
					<th class="px-4 py-3">Status</th>
					<th class="px-4 py-3">Ação</th>
				</tr>
			</thead>
			<tbody
			class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
			<?php 
			$perPage = 20; 
			$page = isset($_GET['pg']) ? $_GET['pg'] : 1;
			$offset = ($page - 1) * $perPage;
			$totalResults = $conn->query('SELECT * FROM order_list')->num_rows;          

			$i = 1;
			$where = "";
			if ($product_id) {
				$where .= " AND o.product_id = '$product_id'";
			}
			if ($status_id) {
				$where .= " AND o.status = '$status_id'";
			}
			if ($order_number) {
				if(ctype_alpha($order_number) && $tod == '3'){
					$bichos = array(
						"00" => "Avestruz",
						"01" => "Águia",
						"02" => "Burro",
						"03" => "Borboleta",
						"04" => "Cachorro",
						"05" => "Cabra",
						"06" => "Carneiro",
						"07" => "Camelo",
						"08" => "Cobra",
						"09" => "Coelho",
						"10" => "Cavalo",
						"11" => "Elefante",
						"12" => "Galo",
						"13" => "Gato",
						"14" => "Jacaré",
						"15" => "Leão",
						"16" => "Macaco",
						"17" => "Porco",
						"18" => "Pavão",
						"19" => "Peru",
						"20" => "Touro",
						"21" => "Tigre",
						"22" => "Urso",
						"23" => "Veado",
						"24" => "Vaca"
					);	
					$foundNumber = null; 
					foreach ($bichos as $number => $animal) {
						if (strcasecmp_utf8($order_number, $animal) === 0) {
							$foundNumber = $number;
							break; 
						}
					}
					if ($foundNumber !== null) {
						$order_number = $foundNumber;
					}

				}elseif(ctype_alpha($order_number) && $tod == '4'){
					$bichos = array(
						"00" => "Avestruz M1",
						"01" => "Avestruz M2",
						"02" => "Águia M1",
						"03" => "Águia M2",
						"04" => "Burro M1",
						"05" => "Burro M2",
						"06" => "Borboleta M1",
						"07" => "Borboleta M2",
						"08" => "Cachorro M1",
						"09" => "Cachorro M2",
						"10" => "Cabra M1",
						"11" => "Cabra M2",
						"12" => "Carneiro M1",
						"13" => "Carneiro M2",
						"14" => "Camelo M1",
						"15" => "Camelo M2",
						"16" => "Cobra M1",
						"17" => "Cobra M2",
						"18" => "Coelho M1",
						"19" => "Coelho M2",
						"20" => "Cavalo M1",
						"21" => "Cavalo M2",
						"22" => "Elefante M1",
						"23" => "Elefante M2",
						"24" => "Galo M1",
						"25" => "Galo M2",
						"26" => "Gato M1",
						"27" => "Gato M2",
						"28" => "Jacaré M1",
						"29" => "Jacaré M2",
						"30" => "Leão M1",
						"31" => "Leão M2",
						"32" => "Macaco M1",
						"33" => "Macaco M2",
						"34" => "Porco M1",
						"35" => "Porco M2",
						"36" => "Pavão M1",
						"37" => "Pavão M2",
						"38" => "Peru M1",
						"39" => "Peru M2",
						"40" => "Touro M1",
						"41" => "Touro M2",
						"42" => "Tigre M1",
						"43" => "Tigre M2",
						"44" => "Urso M1",
						"45" => "Urso M2",
						"46" => "Veado M1",
						"47" => "Veado M2",
						"48" => "Vaca M1",
						"49" => "Vaca M2"
					);	
					$foundNumber = null; 
					foreach ($bichos as $number => $animal) {
						if (strcasecmp_utf8($order_number, $animal) === 0) {
							$foundNumber = $number;
							break; 
						}
					}
					if ($foundNumber !== null) {
						$order_number = $foundNumber;
				 }

				}
				//$regex = "(^".$order_number.",|,".$order_number.",|,".$order_number."$|^".$order_number."$)";
				//$where .= " AND o.order_numbers REGEXP '$regex'";
				$order_number = $conn->real_escape_string($order_number);
				if (ctype_digit($order_number)) {
                    $order_number = ltrim($order_number, '0');
                    if ($order_number === '') {
                        $order_number = 0;
                    }
                }

				if ($order_number === "0" || $order_number === 0) {
					$where .= " AND FIND_IN_SET('0', (SELECT GROUP_CONCAT(DISTINCT onum.number ORDER BY onum.number ASC) 
							 FROM order_numbers onum 
							 WHERE onum.order_id = o.id)) > 0";
				} else {
					$where .= " AND FIND_IN_SET('$order_number', (SELECT GROUP_CONCAT(DISTINCT onum.number ORDER BY onum.number ASC) 
							 FROM order_numbers onum 
							 WHERE onum.order_id = o.id)) > 0";
				}
			}
			if ($customer_name) {
				$subquery = "(SELECT id FROM customer_list WHERE CONCAT(firstname, ' ', lastname) LIKE '%$customer_name%')";
				$where .= " AND o.customer_id IN $subquery";
			}

			if (!empty($where)) {
				$where = " WHERE " . ltrim($where, ' AND');
			}

			//ROOT	
			$qry = $conn->query("
			SELECT o.*, 
				CONCAT(c.firstname, ' ', c.lastname) as customer, 
				p.type_of_draw, 
				c.phone, 
				o.whatsapp_status,
				(
					SELECT GROUP_CONCAT(DISTINCT LPAD(onum.number, FLOOR(LOG10(p.qty_numbers - 1)) + 1, '0') ORDER BY onum.number ASC) 
					FROM order_numbers onum 
					WHERE onum.order_id = o.id
				) AS o_numbers 
			FROM `order_list` o
			INNER JOIN customer_list c ON o.customer_id = c.id
			INNER JOIN product_list p ON o.product_id = p.id
			$where
			ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC
			LIMIT $perPage OFFSET $offset");

			//$qry = $conn->query("SELECT o.*, CONCAT(c.firstname, ' ', c.lastname) as customer, p.type_of_draw, c.phone, o.whatsapp_status
			//FROM `order_list` o
			//INNER JOIN customer_list c ON o.customer_id = c.id
			//INNER JOIN product_list p ON o.product_id = p.id
			//$where
			//ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC
			//LIMIT $perPage OFFSET $offset");
			while($row = $qry->fetch_assoc()):
				?>
				<tr class="text-gray-700 dark:text-gray-400">

					<td class="px-4 py-3">
						#<?= $row['id'] ?>
					</td>

					<td class="px-4 py-3">
						<?= date("d-m-Y", strtotime($row['date_created'])) ?>
					</td>

					<td class="px-4 py-3 text-sm">
						<?= $row['product_name'] ?>			
					</td>

					<td class="px-4 py-3 text-sm">
						<?= $row['customer'] ?><br>
						<span class="<?=$enable_raffle_mode_class_phone;?>"><?= formatPhoneNumber($row['phone']); ?></span>
					</td>
	
					<td class="px-4 py-3 text-sm">
                    <?php 
					if ($row['quantity'] > 500) {
						echo leowp_send_whatsapp($row['id'], $row['code'], $row['status'], $row['customer'], $row['phone'], $row['product_name'], null, $row['quantity'], format_num($row['total_amount'],2), $row['whatsapp_status'], $row['type_of_draw']); 
					} else {
						echo leowp_send_whatsapp($row['id'], $row['code'], $row['status'], $row['customer'], $row['phone'], $row['product_name'], $row['o_numbers'], $row['quantity'], format_num($row['total_amount'],2), $row['whatsapp_status'], $row['type_of_draw']); 
					}				
					?>		
					</td>

					<td class="px-4 py-3 text-sm">
						<?= $row['quantity']; ?>	
					</td>

					<td class="px-4 py-3 text-sm">
						<div class="order_numbers">							
						<?php 

						$type_of_draw = $row['type_of_draw'];
												
						if ($row['quantity'] > 0) {
							echo '<a style="color: #000;" class="adm-pedido-numeros" href="javascript:void(0)" @click="openModalNumbers(' . $row["id"]. ')" data-pedido-id="' . $row["id"] . '">Ver todos</a>';
						} else {
							if ($row['quantity'] < 0) {
								echo leowp_format_luck_numbers_dashboard($row['o_numbers'], $row['quantity'], false, true, $type_of_draw);
							} else {
								echo '<div class="leowp-tab">
								<input id="leowp-tab-' . $row['id'] . '" type="checkbox">
								<label for="leowp-tab-' . $row['id'] . '">Ver todos</label>
								<div class="leowp-content">'
								. leowp_format_luck_numbers_dashboard($row['o_numbers'], $row['quantity'], false, true, $type_of_draw) .
								'</div>
								</div>';
							}
						}
						?>
						</div>	
					</td>

					<td class="px-4 py-3 text-sm">
						<?php if($row['discount_amount']){ ?>
							R$ <?= format_num($row['discount_amount'],2) ?>
						<?php }else{ ?>
							...
						<?php } ?>

					</td>

					<td class="px-4 py-3 text-sm">
						R$ <?= format_num($row['total_amount'],2) ?>
					</td>


					<td class="px-4 py-3 text-xs">
						<?php 
						switch($row['status']){
							case 1:
							echo '<span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">Pendente</span>';					
							echo '<br><span @click="openChangeStatus('.$row['id'].', 2,\''.$row['order_token'].'\')" id="approve-payment">Aprovar</span>';							
							break;

							case 2:
							echo '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Pago</span>';
							if($row['payment_method']){
                            echo '<br>'.$row['payment_method'].'<br>';
							}else{
                            echo '<br>Automático<br>';
							}
							if($row['date_updated']){
							echo ''.date("d-m-Y", strtotime($row['date_updated'])).'<br> ás '.date("H:i", strtotime($row['date_updated'])).'';
						    }
							break;
							case 3:
							echo '<span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700">Cancelado</span>';
							if($row['date_created'] || $row['date_updated']){
								$dateCreated = $row['date_created'];
								$orderExpiration = $row['order_expiration'];
								$expirationTime = date('Y-m-d H:i:s', strtotime("$dateCreated + $orderExpiration minutes"));
								$currentDateTime = date('Y-m-d H:i:s');
								if (($expirationTime < $currentDateTime) && ($orderExpiration > 0)) {
									$dateCreated = new DateTime($row['date_created']);
									$dateCreated->add(new DateInterval('PT' . $row['order_expiration'] . 'M'));
									echo '<br>Expirado em:<br>'.date("d-m-Y", strtotime($dateCreated->format("d-m-Y H:i"))).'<br> ás '.date("H:i", strtotime($dateCreated->format("d-m-Y H:i"))).'';
								}else{								
									echo '<br>Cancelamento:<br>'.date("d-m-Y", strtotime($row['date_updated'])).'<br> ás '.date("H:i", strtotime($row['date_updated'])).'';
								}
							}
							break;
						}
						?>				
					</td>

					<td class="px-4 py-3">
						<div class="flex items-center space-x-4 text-sm">
							<a href="./?page=orders/view_order&id=<?php echo $row['id'] ?>">
								<button
								class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
								aria-label="View"
								>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
									<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
								</svg>
							</button>
						</a>

						<a class="delete_pedido" href="javascript:void(0)" @click="openModal" data-id="<?= $row['id'] ?>">
							<button
							class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
							aria-label="Delete"
							>
							<svg
							class="w-5 h-5"
							aria-hidden="true"
							fill="currentColor"
							viewBox="0 0 20 20"
							>
							<path
							fill-rule="evenodd"
							d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
							clip-rule="evenodd"
							></path>
						</svg>
					</button>
				</a>

			</div>
		</td>
	</tr>
<?php endwhile; ?>

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
<span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
	<nav aria-label="Table navigation">
		<ul class="inline-flex items-center">
			<?php 
			$totalPages = ceil($totalResults / $perPage);
			?>
			<?php if ($page > 1){ ?>
				<a href='./?page=orders&pg=<?php echo $page-1 ?>'><li>
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
		<a href="./?page=orders&pg=1"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li></a>
		<li class="dots">...</li>
	<?php } ?>

	<?php if ($page-2 > 0){ ?>
		<a href="./?page=orders&pg=<?php echo $page-2 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page-2 ?></button></li></a>
	<?php } ?>

	<?php if ($page-1 > 0){ ?>
		<a href="./?page=orders&pg=<?php echo $page-1 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page-1 ?></button></li></a>
	<?php } ?>

	<a href="./?page=orders&pg=<?php echo $page; ?>">
		<li>
			<button	class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page; ?></button>
		</li>
	</a>
	<?php if ($page+1 < $totalPages+1){ ?>
		<a href="./?page=orders&pg=<?php echo $page+1 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page+1 ?></button></li></a>	
	<?php } ?>

	<?php if ($page+2 < $totalPages +1){ ?>
		<a href="./?page=orders&pg=<?php echo $page+2 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page+2 ?></button></li></a>
	<?php } ?>

	<?php if ($page < $totalPages-2): ?>
		<li class="dots">...</li>
		<a href="./?page=orders&pg=<?php echo $totalPages ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $totalPages ?></button></li></a>
	<?php endif; ?>


	<?php if ($page < $totalPages){ ?>
		<a href="./?page=orders&pg=<?php echo $page+1 ?>"><li>
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


</div>
</div>
</div>
</main>

<!-- Modal Delete -->
<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
	<!-- Modal -->
	<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal" style="display: none;">
		<!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
		<header class="flex justify-end">
			<button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
					<path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
				</svg>
			</button>
		</header>
		<div class="mt-4 mb-6">
			<p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
				Deseja excluir?
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400">
				Você realmente deseja excluir esse pedido?
			</p>
		</div>
		<footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
			<button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
				Não
			</button>
			<button class="delete_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
				Sim
			</button>
		</footer>
	</div>
</div>
<!-- End Modal Delete -->

<!-- Modal Numbers More -->
<div x-show="isModalOpenNumbers" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
	<!-- Modal -->
	<div x-show="isModalOpenNumbers" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModalNumbers" @keydown.escape="closeModalNumbers" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal-admin" style="display: none;">
		<!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
		<header class="flex justify-end">
			<button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModalNumbers">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
					<path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
				</svg>
			</button>
		</header>
		<div class="mt-4 mb-6">
			<p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
				Pedido #<span x-text="dataId"></span>
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400">
			    <span class="font-semibold text-gray-700 dark:text-gray-300">QTD.:</span> <span x-text="dataNumbersQtd"></span>
				<span class="font-semibold text-gray-700 dark:text-gray-300">NÚMEROS</span> <span x-text="dataNumbers" class="dataNumbers"></span>
			</p>
		</div>
		<footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
			<button @click="closeModalNumbers" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
				Fechar
			</button>
			<button @click="copyModal" class="copy_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
				Copiar
			</button>
		</footer>
	</div>
</div>
<!-- End Modal Numbers More -->

<!-- Modal Confirm Status -->
<div x-show="isModalOpenStatus" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
	<!-- Modal -->
	<div x-show="isModalOpenStatus" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModalNumbers" @keydown.escape="closeModalNumbers" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal-admin" style="display: none;">
		<!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
		<header class="flex justify-end">
			<button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModalStatus">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
					<path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
				</svg>
			</button>
		</header>
		<div class="mt-4 mb-6">
			<p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
				Pedido #<span x-text="dataPedido"></span>
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400">
				Você realmente deseja alterar o status deste pedido?
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400" x-text="msgStatus"></p>
		</div>
		<footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
			<button @click="closeModalStatus" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
				Não
			</button>
			<button @click="continueChangeStatus" class="copy_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
				Sim
			</button>
		</footer>
	</div>
</div>
<!-- End Modal Confirm Status -->

<!-- Modal Open Cron -->
<div x-show="isModalOpenCron" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
	<!-- Modal -->
	<div x-show="isModalOpenCron" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModalCron" @keydown.escape="closeModalCron" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal-admin" style="display: none;">
		<!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
		<header class="flex justify-end">
			<button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModalCron">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
					<path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
				</svg>
			</button>
		</header>
		<div class="mt-4 mb-6">
			<p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
				CRON - <span x-text="dataTimeCron"><?=date('d/m/Y H:i:s');?></span>
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400" x-text="titleCron"></p>
			<div x-show="msgCron.length > 0" class="msgCron text-purple-700 dark:text-purple-100">
				<template x-for="(msg, index) in msgCron" :key="index">
					<div x-text="msg"></div>
				</template>
			</div>
		</div>
		<footer x-show="isCronEnd" class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
			<button @click="closeModalCron(1)" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
				Fechar
			</button>
		</footer>
		<footer x-show="isCronStart" class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
			<button @click="closeModalCron" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
				Não
			</button>
			<button @click="continueCron" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
				Sim
			</button>
		</footer>
	</div>
</div>
<!-- End Modal Open Cron -->
<script>
	$(document).ready(function(){
		$('.delete_pedido').click(function(){
			var id = $(this).attr('data-id');
			$('.delete_data').attr('data-id', id);	
		})
		$('.delete_data').click(function(){
			var id = $(this).attr('data-id');
			delete_order(id)	
		})
		$('.send-whatsapp').click(function(){
			var id = $(this).attr('data-post-id');
			update_whatsapp_status(id);
		})


	})
	function delete_order(id) {
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_order",
			method: "POST",
			data: { id: id },
			dataType: "json",
			error: function(err) {
				console.log(err);
				console.log("[AO01] - An error occurred.");
			},
			success: function(resp) {
				if (typeof resp === "object" && resp.status === "success") {
					location.reload();
				} else {
					console.log("[AO02] - An error occurred.");
					if (typeof resp === "object" && resp.error) {
						console.log(resp.error);
					}
				}
			}
		});
	}

	function update_whatsapp_status($id){
		
		$.ajax({
			url:_base_url_+"classes/Master.php?f=update_whatsapp_status",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				console.log("An error occured.");
				
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					console.log("An error occured.");
					
				}
			}
		})
	}
	function export_raffle_contacts() {
		var raffle = $('#product_id').val();
		var status = $('#status_id').val();
		
		// Montar a URL do download
		var downloadURL = _base_url_ + "classes/Master.php?f=export_raffle_contacts&raffle=" + raffle + "&status=" + status;

		// Redirecionar o navegador para a URL de download
		window.location.href = downloadURL;
	}
	$(function(){
		$('#filter-form').submit(function(e) {
			e.preventDefault()
			location.href = './?page=orders&' + $(this).serialize();
		})


	})
</script>