<?php
//
$enable_raffle_mode = $_settings->info('enable_raffle_mode');
$raffle_mode_class = ($enable_raffle_mode == 1) ? 'raffle_mode' : (($enable_raffle_mode == 2) ? 'raffle_mode' : '');
//
$enable_cpf = $_settings->info('enable_cpf');
$enable_email = $_settings->info('enable_email');
$enable_address = $_settings->info('enable_address');
$enable_share = $_settings->info('enable_share');
$enable_groups = $_settings->info('enable_groups');
$enable_footer = $_settings->info('enable_footer');
$enable_password = $_settings->info('enable_password');
$text_footer = $_settings->info('text_footer');
$telegram_group_url = $_settings->info('telegram_group_url');
$whatsapp_group_url = $_settings->info('whatsapp_group_url');

##########
$enable_pixel = $_settings->info('enable_pixel');
$facebook_access_token = $_settings->info('facebook_access_token');
$facebook_pixel_id = $_settings->info('facebook_pixel_id');
$enable_hide_numbers = $_settings->info('enable_hide_numbers');

#####
$whatsapp_footer = $_settings->info('whatsapp_footer');
$instagram_footer = $_settings->info('instagram_footer');
$facebook_footer = $_settings->info('facebook_footer');
$twitter_footer = $_settings->info('twitter_footer');
$youtube_footer = $_settings->info('youtube_footer');

?>
<style>
	.active-tab{border-bottom:none!important;}.can-toggle {position: relative;margin-bottom:20px;}.can-toggle *, .can-toggle *:before, .can-toggle *:after {box-sizing: border-box;}.can-toggle input[type=checkbox] {opacity: 0;position: absolute;top: 0;left: 0;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:before {content: attr(data-unchecked);left: 0;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {content: attr(data-checked);}.can-toggle label {cursor:pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;position: relative;display: flex;align-items: center;}.can-toggle label .can-toggle__switch {position: relative;}.can-toggle label .can-toggle__switch:before {content: attr(data-checked);position: absolute;top: 0;text-transform: uppercase;text-align: center;}.can-toggle label .can-toggle__switch:after {content: attr(data-unchecked);position: absolute;z-index: 5;text-transform: uppercase;text-align: center;background: white;transform: translate3d(0, 0, 0);}.can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch {background-color: #777;}.can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch:after {color: #5e5e5e;}.can-toggle input[type=checkbox]:hover ~ label {color: #6a6a6a;}.can-toggle input[type=checkbox]:checked ~ label:hover {color: #55bc49;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch {background-color: #70c767;}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {color: #4fb743;}.can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch {background-color: #5fc054;}.can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {color: #47a43d;}.can-toggle label .can-toggle__switch {transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);background: #848484;}.can-toggle label .can-toggle__switch:before {color: rgba(255, 255, 255, 0.5);}.can-toggle label .can-toggle__switch:after {transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);color: #777;}.can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch:after {box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);}.can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {transform: translate3d(65px, 0, 0);}.can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);}.can-toggle label {font-size: 14px;}.can-toggle label .can-toggle__switch {height: 36px;flex: 0 0 134px;border-radius: 4px;}.can-toggle label .can-toggle__switch:before {left: 67px;font-size: 12px;line-height: 36px;width: 67px;padding: 0 12px;}.can-toggle label .can-toggle__switch:after {top: 2px;left: 2px;border-radius: 2px;width: 65px;line-height: 32px;font-size: 12px;}.can-toggle label .can-toggle__switch:hover:after {box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);}@media all and (max-width:40em){#tabs{flex-wrap:wrap;}#tabs .mr-1{margin-bottom:15px;}}	#cimg{
		max-width:100%;
		max-height:25em;
		object-fit:scale-down;
		object-position:center center;
	}h2.social-rodape {
    font-weight: bold;
    margin-top: 20px;
}
</style>
<main class="h-full pb-16 overflow-y-auto">
	<div class="container px-6 mx-auto grid">
		<h2
		class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
		>
		Configuração
	</h2>


	<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

		<div class="flex">
			<ul class="flex" id="tabs">
				<li class="mr-1">
					<a href="#tab1" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700 active-tab">Configurações do site</a>
				</li>
				<li class="mr-1">
					<a href="#tab2" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Campos do cadastro</a>
				</li>

				<li class="mr-1">
					<a href="#tab3" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Redes Sociais</a>
				</li>
				<li class="mr-1">
					<a href="#tab4" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Rodapé</a>
				</li>
				<li class="mr-1">
					<a href="#tab5" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">API de Conversão - Facebook</a>
				</li>
				<li class="mr-1">
					<a href="#tab6" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 inline-block py-2 px-4 font-semibold border rounded-t text-gray-700">Ocultar Cotas</a>
				</li>
				
				

			</ul>
		</div>



		<form action="" id="manage-system">

			<div class="mt-4">	


				<div id="tab1" class="tabcontent text-gray-700 dark:text-gray-400">
					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">ATIVAR MODO SORTEIO</span>	
					</label>
					<div class="can-toggle">
						<input type="checkbox" name="enable_raffle_mode" id="enable_raffle_mode" <?= isset($enable_raffle_mode) && $enable_raffle_mode == 1 ? 'checked' : '' ?>>
						<label for="enable_raffle_mode">
							<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
						</label>
					</div>

					<label class="block text-sm">
						<span class="text-gray-700 dark:text-gray-400">Titulo do site</span>
						<input name="name" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
						placeholder="Titulo" value="<?php echo $_settings->info('name') ?>"/>
					</label>


					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">E-mail</span>
						<input name="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
						placeholder="admin@admin.com" value="<?php echo $_settings->info('email') ?>"/>
					</label>

					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">Telefone</span>
						<input name="phone" id="phone" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
						placeholder="(00) 00000-0000" value="<?php echo $_settings->info('phone') ?>"/>
					</label>

					<label class="block mt-4 text-sm">
						<span class="text-gray-700 dark:text-gray-400">Logo:</span>
						<input id="customFile1" name="img" onchange="displayImg(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"  accept="image/png, image/jpeg">
					</label>

					<label class="block mt-4 text-sm">
						<img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">


						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Favicon:</span>
							<input id="customFile2" name="favicon" onchange="displayFavicon(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"  accept="image/png, image/jpeg">
						</label>

						<label class="block mt-4 text-sm">
							<img src="<?php echo validate_image($_settings->info('favicon')) ?>" alt="" id="favicon" class="img-fluid img-thumbnail">
						</div>





					</div>

					<div id="tab2" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
						<p>Os dados habilitados abaixo serão obrigatórios no formulário de cadastro do site.</p>
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar senha?</span>
							<p style="font-size:13px;color: orange;font-style:italic;">Quando essa opção estiver desabilitada, não será necessário inserir uma senha durante o processo de cadastro e também para fazer o login no sistema.</p>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_password" id="enable_password" <?= isset($enable_password) && $enable_password == 1 ? 'checked' : '' ?>>
							<label for="enable_password">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>
						<hr>
						
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar CPF?</span>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_cpf" id="enable_cpf" <?= isset($enable_cpf) && $enable_cpf == 1 ? 'checked' : '' ?>>
							<label for="enable_cpf">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>
						
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar E-mail?</span>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_email" id="enable_email" <?= isset($enable_email) && $enable_email == 1 ? 'checked' : '' ?>>
							<label for="enable_email">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar Endereço?</span>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_address" id="enable_address" <?= isset($enable_address) && $enable_address == 1 ? 'checked' : '' ?>>
							<label for="enable_address">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

					</div>

					<div id="tab3" class="tabcontent text-gray-700 dark:text-gray-400 hidden">
						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar botões de compartilhamento?</span>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_share" id="enable_share" <?= isset($enable_share) && $enable_share == 1 ? 'checked' : '' ?>>
							<label for="enable_share">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar botão para acessar os grupos?</span>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_groups" id="enable_groups" <?= isset($enable_groups) && $enable_groups == 1 ? 'checked' : '' ?>>
							<label for="enable_groups">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

						<div class="groups">
							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Link do grupo Telegram:</span>
								<input name="telegram_group_url" id="telegram_group_url"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://telegram.org" value="<?php echo isset($telegram_group_url) ? $telegram_group_url : ''; ?>" />
							</label>	

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Link do grupo WhatsApp:</span>
								<input name="whatsapp_group_url" id="whatsapp_group_url"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://whatsapp.com/" value="<?php echo isset($whatsapp_group_url) ? $whatsapp_group_url : ''; ?>" />
							</label>	

						</div>
						<h2 class="social-rodape">Redes Sociais - Rodapé</h2>
						<p>Preencha os campos abaixo para exibir as redes sociais no rodapé ou deixe sem preencher para não exibir.</p>
							<div class="groups">

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">WhatsApp:</span>
								<input name="whatsapp_footer" id="whatsapp_footer"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://api.whatsapp.com/send?l=pt_br&phone=00000" value="<?php echo isset($whatsapp_footer) ? $whatsapp_footer : ''; ?>" />
							</label>	

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Instagram:</span>
								<input name="instagram_footer" id="instagram_footer"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://instagram.com/" value="<?php echo isset($instagram_footer) ? $instagram_footer : ''; ?>" />
							</label>	

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Facebook:</span>
								<input name="facebook_footer" id="facebook_footer"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://facebook.com/" value="<?php echo isset($facebook_footer) ? $facebook_footer : ''; ?>" />
							</label>	

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Twitter:</span>
								<input name="twitter_footer" id="twitter_footer"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://twitter.com/" value="<?php echo isset($twitter_footer) ? $twitter_footer : ''; ?>" />
							</label>	

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Youtube:</span>
								<input name="youtube_footer" id="youtube_footer"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="https://youtube.com/" value="<?php echo isset($youtube_footer) ? $youtube_footer : ''; ?>" />
							</label>	

						</div>




					</div>
					<div id="tab4" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar rodapé?</span>	
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_footer" id="enable_footer" <?= isset($enable_footer) && $enable_footer == 1 ? 'checked' : '' ?>>
							<label for="enable_footer">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

						<div class="footer-text">
							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Texto do rodapé:</span>
								<input name="text_footer" id="text_footer"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="ex: Todos os direitos reservados." value="<?php echo isset($text_footer) ? $text_footer : ''; ?>" />
							</label>


						</div>



					</div>			

					<div id="tab5" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Habilitar API de conversão?</span>	
							<p>Área destinada ao gestor de tráfego para implantação da API de conversão do Facebook ADS.</p>
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_pixel" id="enable_pixel" <?= isset($enable_pixel) && $enable_pixel == 1 ? 'checked' : '' ?>>
							<label for="enable_pixel">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

						<div class="pixel-facebook">
							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Access Token (Facebook) *:</span>
								<input name="facebook_access_token" id="facebook_access_token"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="Informe o ACCESS TOKEN do facebook" value="<?php echo isset($facebook_access_token) ? $facebook_access_token : ''; ?>" />
							</label>

							<label class="block mt-4 text-sm">
								<span class="text-gray-700 dark:text-gray-400">Pixel ID (Facebook) *:</span>
								<input name="facebook_pixel_id" id="facebook_pixel_id"
								class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								placeholder="Informe o PIXEL ID do facebook" value="<?php echo isset($facebook_pixel_id) ? $facebook_pixel_id : ''; ?>" />
							</label>


						</div>



					</div>
					<div id="tab6" class="tabcontent text-gray-700 dark:text-gray-400 hidden">

						<label class="block mt-4 text-sm">
							<span class="text-gray-700 dark:text-gray-400">Ocultar cotas</span>	
							<p>Ao habilitar essa opção as cotas do <strong>sorteio automático</strong> não irá aparecer após a compra, somente após o pagamento confirmado.</p>
						</label>
						<div class="can-toggle">
							<input type="checkbox" name="enable_hide_numbers" id="enable_hide_numbers" <?= isset($enable_hide_numbers) && $enable_hide_numbers == 1 ? 'checked' : '' ?>>
							<label for="enable_hide_numbers">
								<div class="can-toggle__switch" data-checked="Sim" data-unchecked="Não"></div>
							</label>
						</div>

					</div>
				</div>




				<div style="margin-top:20px;"> 
					<button form="manage-system" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
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
	if($('#enable_groups').is(":checked")){
		$('.groups').show();
	}else{
		$('.groups').hide();	
	}
	$('#enable_groups').change(function() {
		if($('#enable_groups').is(":checked")){
			$('.groups').show();
		}else{
			$('.groups').hide();	
		}
	}); 
	if($('#enable_footer').is(":checked")){
		$('.footer-text').show();
	}else{
		$('.footer-text').hide();	
	}
	$('#enable_footer').change(function() {
		if($('#enable_footer').is(":checked")){
			$('.footer-text').show();
		}else{
			$('.footer-text').hide();	
		}
	}); 
	$('#enable_pixel').change(function() {
		if($('#enable_pixel').is(":checked")){
			$('.pixel-facebook').show();
		}else{
			$('.pixel-facebook').hide();	
		}
	}); 
	function displayImg(input,_this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}else{
			$('#cimg').attr('src', "<?php echo validate_image($_settings->info('logo')) ?>");
		}
	}
	function displayFavicon(input,_this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#favicon').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}else{
			$('#favicon').attr('src', "<?php echo validate_image($_settings->info('favicon')) ?>");
		}
	}

	var pageToken = 'system_info'; 
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

		var storedTab = localStorage.getItem('system_info' + pageToken);
		if (storedTab) {
			var selectedTab = storedTab.substring(pageToken.length + 1);
			$("#tabs a").removeClass("active-tab");
			$(selectedTab).addClass("active-tab");
			$(".tabcontent").hide();
			$(selectedTab).show();
		}


		$('#manage-system').submit(function(e){
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

	});

</script>