<?php
 $mercadopago = $_settings->info('mercadopago'); 
 $mercadopago_access_token = $_settings->info('mercadopago_access_token');
 $gerencianet = $_settings->info('gerencianet');
 $gerencianet_client_id = $_settings->info('gerencianet_client_id');
 $gerencianet_client_secret = $_settings->info('gerencianet_client_secret');
 $gerencianet_pix_key = $_settings->info('gerencianet_pix_key');
 $paggue = $_settings->info('paggue');
 $paggue_client_key = $_settings->info('paggue_client_key');
 $paggue_client_secret = $_settings->info('paggue_client_secret');

?>

<style>
 .active-tab{border-bottom:none!important;}.can-toggle {position: relative;margin-bottom:20px;}.can-toggle *, .can-toggle *:before, .can-toggle *:after {box-sizing: border-box;}.can-toggle input[type=checkbox] {opacity: 0;position: absolute;top: 0;left: 0;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:before {content: attr(data-unchecked);left: 0;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {content: attr(data-checked);}.can-toggle label {cursor:pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;position: relative;display: flex;align-items: center;}.can-toggle label .can-toggle__switch {position: relative;}.can-toggle label .can-toggle__switch:before {content: attr(data-checked);position: absolute;top: 0;text-transform: uppercase;text-align: center;}.can-toggle label .can-toggle__switch:after {content: attr(data-unchecked);position: absolute;z-index: 5;text-transform: uppercase;text-align: center;background: white;transform: translate3d(0, 0, 0);}.can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch {background-color: #777;}.can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch:after {color: #5e5e5e;}.can-toggle input[type=checkbox]:hover ~ label {color: #6a6a6a;}.can-toggle input[type=checkbox]:checked ~ label:hover {color: #55bc49;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch {background-color: #70c767;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {color: #4fb743;}.can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch {background-color: #5fc054;}.can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {color: #47a43d;}.can-toggle label .can-toggle__switch {transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);background: #848484;}.can-toggle label .can-toggle__switch:before {color: rgba(255, 255, 255, 0.5);}.can-toggle label .can-toggle__switch:after {transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);color: #777;}.can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch:after {box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {transform: translate3d(65px, 0, 0);}.can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);}.can-toggle label {font-size: 14px;}.can-toggle label .can-toggle__switch {height: 36px;flex: 0 0 134px;border-radius: 4px;}.can-toggle label .can-toggle__switch:before {left: 67px;font-size: 12px;line-height: 36px;width: 67px;padding: 0 12px;}.can-toggle label .can-toggle__switch:after {top: 2px;left: 2px;border-radius: 2px;width: 65px;line-height: 32px;font-size: 12px;}.can-toggle label .can-toggle__switch:hover:after {box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);}@media all and (max-width:40em){#tabs{flex-wrap:wrap;}#tabs .mr-1{margin-bottom:15px;}}
</style>
<main class="h-full pb-16 overflow-y-auto">
	<div class="container px-6 mx-auto grid">
		<h2
		class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
		>
		Gateway de pagamento
	</h2>


	<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

		<div class="flex">
			<ul class="flex" id="tabs">
				<li class="mr-1">
					<a href="#tab1" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700 active-tab">MercadoPago</a>
				</li>
				<li class="mr-1">
					<a href="#tab2" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Gerencianet</a>
				</li>

				<li class="mr-1">
					<a href="#tab3" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Paggue</a>
				</li>

			</ul>
		</div>



		<form action="" id="gateway-form">

			<div class="mt-4">	


				<div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400">

					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">Habilitar MercadoPago?</span>	
					</label>
					<div class="can-toggle">
						<input type="checkbox" name="mercadopago" id="mercadopago" <?= isset($mercadopago) && $mercadopago == 1 ? 'checked' : '' ?>>
						<label for="mercadopago">
							<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
						</label>
					</div>
					<div class="mercadopago">
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Access Token:</strong></span>
							<input name="mercadopago_access_token" id="mercadopago_access_token"
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							placeholder="ex: APP_USR-3168251416537780-022013-002dd7b5414e26092866660fb80a874a-190911003" value="<?php echo isset($mercadopago_access_token) ? $mercadopago_access_token : ''; ?>" />
						</label>
					</div>

				</div>

				<div id="tab2" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">Habilitar Gerencianet?</span>	
					</label>
					<div class="can-toggle">
						<input type="checkbox" name="gerencianet" id="gerencianet" <?= isset($gerencianet) && $gerencianet == 1 ? 'checked' : '' ?>>
						<label for="gerencianet">
							<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
						</label>
					</div>
					<div class="gerencianet">
						<p>Preencha os dados abaixo e faça upload do certificado com o nome <strong>pagamentos.pem</strong> no diretório principal do site.</p>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Client ID:</strong></span>
							<input name="gerencianet_client_id" id="gerencianet_client_id"
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							placeholder="ex: Client_Id_2456913797e93b8933243e1d4ef36e52c9c6" value="<?php echo isset($gerencianet_client_id) ? $gerencianet_client_id : ''; ?>" />
						</label>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
							<input name="gerencianet_client_secret" id="gerencianet_client_secret"
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							placeholder="ex: Client_Secret_afc18534a5534ab49b36f370871d088a1cce3cc" value="<?php echo isset($gerencianet_client_secret) ? $gerencianet_client_secret : ''; ?>" />
						</label>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Chave Aleatória:</strong></span>
							<input name="gerencianet_pix_key" id="gerencianet_pix_key"
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							placeholder="ex: b3b6d68a-50db-3d88-b7ee-g215b41d0ec2" value="<?php echo isset($gerencianet_pix_key) ? $gerencianet_pix_key : ''; ?>" />
						</label>
					</div>

				</div>

				<div id="tab3" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">Habilitar Paggue?</span>	
					</label>
					<div class="can-toggle">
						<input type="checkbox" name="paggue" id="paggue" <?= isset($paggue) && $paggue == 1 ? 'checked' : '' ?>>
						<label for="paggue">
							<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
						</label>
					</div>
					<div class="paggue">
						<p>Clique no link para obter as chaves de integração com o <a style="color:blue;text-decoration:underline;" href="https://portal.paggue.io/integrations" target="_blank">Paggue</a></p>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Client KEY:</strong></span>
							<input name="paggue_client_key" id="paggue_client_key"
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							placeholder="Informe a chave Client Key do Paggue" value="<?php echo isset($paggue_client_key) ? $paggue_client_key : ''; ?>" />
						</label>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Client Secret:</strong></span>
							<input name="paggue_client_secret" id="paggue_client_secret"
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							placeholder="Informe a chave Client Secret do Paggue" value="<?php echo isset($paggue_client_secret) ? $paggue_client_secret : ''; ?>" />
						</label>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400"><strong>Webhook URL:</strong><p>Adicone a url abaixo na área "Webhook URL" no Paggue!</p></span>
							<input name="" id=""
							class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							 value="<?php echo ''.base_url.'webhook.php?notify=paggue'; ?>" />
						</label>
					</div>

				</div>
			</div>




			<div style="margin-top:20px;"> 
				<input type="hidden" name="gateway" value='1'>
				<button form="gateway-form" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
					Salvar
				</button>
			</div>

		</form>

	</div>


</div>
</main>
<span id="openModal" href="javascript:void(0)" @click="openModal"></span>
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
				Parabéns!
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400">
				Alterações salvas com sucesso!
			</p>
		</div>

	</div>
</div>
<script>
	var pageToken = 'gateway'; 
	$("#tabs a").click(function() {
		var selectedTab = $(this).attr("href");
		$("#tabs a").removeClass("active-tab");
		$(this).addClass("active-tab");
		$(".tabcontent").hide();
		$(selectedTab).show();
		localStorage.setItem('selectedTab_' + pageToken, pageToken + '_' + selectedTab);
		return false;
	});
	$(document).ready(function(){
		var storedTab = localStorage.getItem('selectedTab_' + pageToken);
		if (storedTab) {
			var selectedTab = storedTab.substring(pageToken.length + 1);
			$("#tabs a").removeClass("active-tab");
			$(selectedTab).addClass("active-tab");
			$(".tabcontent").hide();
			$(selectedTab).show();
		}	


		if($('#mercadopago').is(":checked")){
			$('.mercadopago').show();
		}else{
			$('.mercadopago').hide();	
		}
		$('#mercadopago').change(function() {
			if($('#mercadopago').is(":checked")){
				$('.mercadopago').show();
			}else{
				$('.mercadopago').hide();	
			}
		}); 

		if($('#gerencianet').is(":checked")){
			$('.gerencianet').show();
		}else{
			$('.gerencianet').hide();	
		}
		$('#gerencianet').change(function() {
			if($('#gerencianet').is(":checked")){
				$('.gerencianet').show();
			}else{
				$('.gerencianet').hide();	
			}
		}); 
		if($('#paggue').is(":checked")){
			$('.paggue').show();
		}else{
			$('.paggue').hide();	
		}
		$('#paggue').change(function() {
			if($('#paggue').is(":checked")){
				$('.paggue').show();
			}else{
				$('.paggue').hide();	
			}
		}); 
// Fim ranking


//Save products
		$('#gateway-form').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:_base_url_+'classes/SystemSettings.php?f=update_settings',
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					success:function(resp){
						var returnedData = JSON.parse(resp);
						if(returnedData.status == 'success'){
							alert('Configurações salvas com sucesso!');
							location.reload();
						}else{
							alert('Ops');
						}
					}
				})
		})
//End save products

	});

</script>