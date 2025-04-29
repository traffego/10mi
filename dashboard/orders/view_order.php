<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
	$qry = $conn->query("SELECT * from `order_list` where id = '{$_GET['id']}' ");
	if($qry->num_rows > 0){
		foreach($qry->fetch_assoc() as $k => $v){
			$$k=$v;
		}
	}
}
?>
<style>.order_numbers {
    padding: 10px;
    max-width: 150px;
    white-space: nowrap;
    overflow: auto;
}</style>
<main class="h-full pb-16 overflow-y-auto">
	<div class="container px-6 mx-auto grid">
		<h2
		class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
		>
		#<?= isset($id) ? $id : '' ?> Detalhes
	</h2>


	<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
		<label class="block text-sm">
			<span class="text-gray-700 dark:text-gray-400">Pedido:</span>
			<input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
			value="#<?= isset($id) ? $id : '' ?>" disabled/>
		</label>


		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">
				Status
			</span>
			<select name="order_status" id="order_status" @change="openChangeStatus('<?php echo $id; ?>', $event.target.value,'<?php echo $order_token; ?>')"
			class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
			>
			<?php 
			$status = isset($status) ? $status : '';
			switch($status){
				case 1:
				echo '<option value="1" selected>Pendente</option>';
				echo '<option value="2">Pago</option>';
				echo '<option value="3">Cancelado</option>';
				break;
				case 2:
				echo '<option value="1">Pendente</option>';
				echo '<option value="2" selected>Pago</option>';
				echo '<option value="3">Cancelado</option>';
				break;
				case 3:					
				echo '<option value="1">Pendente</option>';
				echo '<option value="2">Pago</option>';
				echo '<option value="3" selected>Cancelado</option>';
				break;	
			}
			?>
		</select>
	</label>
<?php 
// Consulta para obter os dados dos itens do pedido e a quantidade da tabela order_list
//
$stmt = $conn->prepare("
  SELECT 
    oi.*, 
    p.name AS product, 
    p.price, 
    p.image_path, 
    p.type_of_draw, 
    ol.order_numbers, 
    ol.quantity AS order_quantity, 
    ol.discount_amount,
	(
		SELECT GROUP_CONCAT(DISTINCT LPAD(onum.number, FLOOR(LOG10(p.qty_numbers - 1)) + 1, '0') ORDER BY onum.number ASC) 
		FROM order_numbers onum 
		WHERE onum.order_id = oi.order_id
	) AS o_numbers 
  FROM 
    order_items oi
  INNER JOIN 
    product_list p ON oi.product_id = p.id
  INNER JOIN 
    order_list ol ON oi.order_id = ol.id
  WHERE 
    oi.order_id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$order_items = $stmt->get_result();

// Consulta para obter o total_amount da tabela order_list
$stmt_total = $conn->prepare("SELECT total_amount FROM order_list WHERE id = ?");
$stmt_total->bind_param("i", $id);
$stmt_total->execute();
$order_total = $stmt_total->get_result();
$total = $order_total->fetch_assoc();

$gt = 0;

while ($row = $order_items->fetch_assoc()):
  $gt += $row['price'] * $row['order_quantity'];
?>

		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Sorteio</span>
			<input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?= $row['product'] ?>" disabled/>
		</label>

		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Quantidade de cotas</span>
			<input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="<?= $row['order_quantity'] ?>" disabled/>
		</label>

		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Valor da cota</span>
			<input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?= format_num($row['price'], 2) ?>" disabled/>
		</label>
    <?php if($row['discount_amount']){ 
      $subtotal = $total['total_amount'] + $row['discount_amount'];
      $subtotal = format_num($subtotal, 2);
    	?>
		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Subtotal</span>
			<input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?= $subtotal ?>" disabled/>
		</label>
		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Desconto</span>
			<input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?= format_num($row['discount_amount'], 2) ?>" disabled/>
		</label>
	  <?php } ?>

		<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Total</span>
			<input name="price" id="price" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="R$ <?= format_num($total['total_amount'], 2) ?>" disabled/>
		</label>

			<label class="block mt-4 text-sm">
			<span class="text-gray-700 dark:text-gray-400">Cotas</span>
			<textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Descrição do sorteio" disabled><?php 
							$type_of_draw = $row['type_of_draw'];
							if($type_of_draw > 2){
              					$order_numbers = leowp_format_luck_numbers_dashboard($row['o_numbers'], $row['quantity'], $class = false, $opt = true, $type_of_draw); 
								echo str_replace('<span class="comma-hide">', '', $order_numbers);
							}else{
								if ($row['o_numbers'] !== null) {
									echo rtrim($row['o_numbers'], ',');
								} else {
									echo '';
								}
							}							
							?>   
</textarea>
		</label>
	<?php endwhile; 
	// Close the statements
	$stmt->close();
	$stmt_total->close();
	//?>
</div>
</div>


</div>
</main>
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
<script>
	$(function(){
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this order permanently?","delete_order", ["<?= isset($id) ? $id :'' ?>"])
		})
		$('#order_status').on('change', function() {
			let status = $('#order_status').val();
			//update_order_status('<?= isset($id) ? $id :'' ?>', status);
		})
	})
	function delete_order(id){
		$.ajax({
			url: _base_url_+"classes/Master.php?f=delete_order",
			method: "POST",
			data: {id: id},
			dataType: "json",
			error: function(err){
				console.log(err);
				alert("[AO11] - An error occurred.");
			},
			success: function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.replace("./?page=orders");
				} else {
					alert("[AO12] - An error occurred.");
				}
			}
		});
	}
	function update_order_status(id, status){
		$.ajax({
			url: _base_url_+"classes/Master.php?f=update_order_status",
			method: "POST",
			data: {id: id, status: status},
			dataType: "json",
			error: function(err){
				console.log(err);
				console.log("[AO13] - An error occurred.");
			},
			success: function(resp){
				if (typeof resp == "object" && resp.msg) {
					console.log(resp.msg);
				}
				if(typeof resp == 'object' && resp.status == 'success'){
					console.log('O status do pedido foi atualizado com sucesso!');
					location.reload();
				} else {
					console.log("[AO14] - An error occurred.");
				}
			}
		});
	}

</script>