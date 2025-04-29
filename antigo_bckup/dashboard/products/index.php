<style>
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  height: 12px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}	

</style>
<main class="h-full pb-16 overflow-y-auto">
	<div class="container grid px-6 mx-auto">
		<h2
		class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
		>
		Sorteios <a href="./?page=products/manage_product" id="create_new"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
			Criar novo
		</button></a>
	</h2>         
	<div class="w-full overflow-hidden rounded-lg shadow-xs">
		<div class="w-full overflow-x-auto">
			<table class="w-full whitespace-no-wrap">
				<thead>
					<tr
					class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
					>
					<th class="px-4 py-3">Sorteio</th>
					<th class="px-4 py-3">Tipo</th>
					<th class="px-4 py-3">Valor</th>
					<th class="px-4 py-3">Qtd. Números</th>
					<th class="px-4 py-3">Status</th>
					<th class="px-4 py-3">Data</th>
					<th class="px-4 py-3">Ação</th>
				</tr>
			</thead>
			<tbody
			class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
			>
			<?php 
			$perPage = 20; 
			$page = isset($_GET['pg']) ? $_GET['pg'] : 1;
			$offset = ($page - 1) * $perPage;
			$totalResults = $conn->query('SELECT * FROM product_list')->num_rows;          
			$totalPages = ceil($totalResults / $perPage);

			$i = 1;

			$stmt = $conn->prepare("
				SELECT 
					pl.*, 
					pos.paid, 
					pos.pending 
				FROM 
					product_list pl 
				LEFT JOIN 
					product_order_status pos 
				ON 
					pl.id = pos.product_id 
				ORDER BY 
					pl.id DESC 
				LIMIT ? 
				OFFSET ?
			");

			if ($stmt) {
				$stmt->bind_param('ii', $perPage, $offset);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {

				while ($row = $result->fetch_assoc()):

				$paid_and_pending = $row['pending'] + $row['paid'];
				$available = intval($row['qty_numbers']) - $paid_and_pending;
				$percent = ($paid_and_pending * 100 / $row['qty_numbers']);
                $percent = number_format($percent, 1, '.', '');
				?>
				<tr class="text-gray-700 dark:text-gray-400">
					<td class="px-4 py-3">
						<div class="flex items-center text-sm">
							<!-- Avatar with inset shadow -->
							<div
							class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
							>
							<img
							class="object-cover w-full h-full rounded-full"
							src="<?= validate_image($row['image_path']) ?>"
							alt=""
							loading="lazy"
							/>
							<div
							class="absolute inset-0 rounded-full shadow-inner"
							aria-hidden="true"
							></div>
						</div>
						<div>
							<p class="font-semibold"><?= $row['name'] ?></p>
							<p class="text-xs text-gray-600 dark:text-gray-400">
								
							</p>
						</div>
					</div>
				</td>
				<td class="px-4 py-3 text-sm">
					<?php if($row['type_of_draw'] == 1){ ?>
						Automático
					<?php } ?>

					<?php if($row['type_of_draw'] == 2){ ?>
						Números
					<?php } ?>

					<?php if($row['type_of_draw'] == 3){ ?>
						Fazendinha
					<?php } ?>
					<?php if($row['type_of_draw'] == 4){ ?>
						Fazendinha metade
					<?php } ?>
				</td>

				<td class="px-4 py-3 text-sm">
					R$ <?= format_num($row['price'],2) ?>
				</td>

				<td class="px-4 py-3 text-sm">
					<div id="myProgress">
                    <div id="myBar" style="width:<?= $percent; ?>%"></div>
                    </div>
					<?= $percent; ?>% de <?= $row['qty_numbers']; ?> vendidos
				</td>

				<td class="px-4 py-3 text-xs">
					<?php if($row['status'] == 1){ ?>
						<span
						class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
						>
						Ativo
					</span>
				<?php } ?>

				<?php if($row['status'] == 2){ ?>
					<span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700">
						Pausado
					</span>			  

				<?php } ?>

				<?php if($row['status'] == 3){ ?>
					<span
					class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600"
					>
					Finalizado
				</span>
			<?php } ?>
		</td>
		<td class="px-4 py-3 text-sm">
			<?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?>
		</td>
		<td class="px-4 py-3">
			<div class="flex items-center space-x-4 text-sm">
				<a href="./report.php?id=<?php echo $row['id'] ?>" target="_blank">
					<button title="Relatório de vendas" 
					class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
					aria-label="Relatório de vendas"
					>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
						<path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
						<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
					</svg>
				</button>
			</a>
			<a href="<?php echo base_url ?>sorteio/<?php echo $row['slug'] ?>" target="_blank">
				<button title="Ver sorteio" 
				class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
				aria-label="View"
				>
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
					<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				</svg>
			</button>
		</a>
		<a href="./?page=products/manage_product&id=<?php echo $row['id'] ?>">
			<button title="Editar" 
			class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
			aria-label="Edit"
			>
			<svg
			class="w-5 h-5"
			aria-hidden="true"
			fill="currentColor"
			viewBox="0 0 20 20"
			>
			<path
			d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
			></path>
		</svg>
	</button>
</a>
<a class="delete_sorteio" href="javascript:void(0)" @click="openModal" data-id="<?php echo $row['id'] ?>">
	<button title="Deletar" 
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
<?php endwhile; 
}

$stmt->close();
}?>

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
					<a href='./?page=products&pg=<?php echo $page-1 ?>'><li>
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
			<a href="./?page=products&pg=1"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li></a>
			<li class="dots">...</li>
		<?php } ?>

		<?php if ($page-2 > 0){ ?>
			<a href="./?page=products&pg=<?php echo $page-2 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page-2 ?></button></li></a>
		<?php } ?>

		<?php if ($page-1 > 0){ ?>
			<a href="./?page=products&pg=<?php echo $page-1 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page-1 ?></button></li></a>
		<?php } ?>

		<a href="./?page=products&pg=<?php echo $page; ?>">
			<li>
				<button	class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page; ?></button>
			</li>
		</a>
		<?php if ($page+1 < $totalPages+1){ ?>
			<a href="./?page=products&pg=<?php echo $page+1 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page+1 ?></button></li></a>	
		<?php } ?>

		<?php if ($page+2 < $totalPages +1){ ?>
			<a href="./?page=products&pg=<?php echo $page+2 ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $page+2 ?></button></li></a>
		<?php } ?>

		<?php if ($page < $totalPages-2): ?>
			<li class="dots">...</li>
			<a href="./?page=products&pg=<?php echo $totalPages ?>"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"><?php echo $totalPages ?></button></li></a>
		<?php endif; ?>


		<?php if ($page < $totalPages){ ?>
			<a href="./?page=products&pg=<?php echo $page+1 ?>"><li>
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
				Você realmente deseja excluir esse sorteio?
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
<script>
	$(document).ready(function(){
		$('.delete_sorteio').click(function(){
			var id = $(this).attr('data-id');
			$('.delete_data').attr('data-id', id);	
		})
		$('.delete_data').click(function(){
			var id = $(this).attr('data-id');
			delete_product(id)	
		})

	})
	function delete_product($id){
		
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_product",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert("An error occured.");
				
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert("An error occured.");
					
				}
			}
		})
	}
</script>