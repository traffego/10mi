<?php 
if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}' ");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	#cimg{
		max-width:100%;
		max-height:25em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<main class="h-full pb-16 overflow-y-auto">
	<div class="container px-6 mx-auto grid">
		<h2
		class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
		>
		<?= isset($id) ? "Editar usuário" : "Novo usuário" ?> <a href="./?page=user/list"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
			Voltar
		</button></a>
	</h2>


	<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?= isset($meta['id']) ? $meta['id'] : '' ?>">				
			<label class="block text-sm">
				<span class="text-gray-700 dark:text-gray-400">Nome</span>
				<input name="firstname" id="firstname" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
				placeholder="Nome" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>"/>
			</label>


			<label class="block mt-4 text-sm">
				<span class="text-gray-700 dark:text-gray-400">Sobrenome</span>
				<input name="lastname" id="lastname" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
				placeholder="Sobrenome" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>"/>
			</label>

			<label class="block mt-4 text-sm">
				<span class="text-gray-700 dark:text-gray-400">Usuário</span>
				<input name="username" id="username" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
				placeholder="Usuário" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>"/>
			</label>

			<label class="block mt-4 text-sm">
				<span class="text-gray-700 dark:text-gray-400"><?= isset($meta['id']) ? "Nova" : "" ?> Senha</span>
				<input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
				 value=""/>
				   <?php if(isset($meta['id'])): ?>
					<small class="text-gray-700 dark:text-gray-200"><i>Deixe em branco se não quiser alterar a senha.</i></small>
                    <?php endif; ?>

			</label>


			<label class="block mt-4 text-sm">
				<span class="text-gray-700 dark:text-gray-400">
					Tipo de usuário
				</span>
				<select name="type" id="type"
				class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
				>
                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Administrador</option>
                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Staff</option>
			</select>
		</label>




<label class="block mt-4 text-sm">
	<span class="text-gray-700 dark:text-gray-400">Capa do Sorteio</span>
	<input id="customFile" name="img" onchange="displayImg(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"  accept="image/png, image/jpeg">
</label>

<label class="block mt-4 text-sm">
	<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
</div>


<div class="text-center">
	<button form="manage-user" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
		Salvar
	</button>
</div>

</main>

<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', "<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>");
		}
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					alert('Usuário cadastrado com sucesso!');
					location.href='./?page=user/list';
				}else{
					alert('Nome de usuário em uso!');
				}
			}
		})
	})

</script>