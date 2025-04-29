<?php require_once('./config.php');
$enable_cpf = $_settings->info('enable_cpf');
$enable_email = $_settings->info('enable_email');
$enable_address = $_settings->info('enable_address');
$enable_password = $_settings->info('enable_password');
 ?>
<div class="container app-main app-form">
 <form id="form-cadastrar">

  <div class="perfil app-card card mb-2">
   <div class="card-body">
    <div class="mb-2">
        <label for="firstname" class="form-label">Nome</label>
        <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Primeiro nome" required="">
    </div>
    <div class="mb-2">
        <label for="lastname" class="form-label">Sobrenome</label>
        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Sobrenome" required="">
    </div>
    <?php if($enable_cpf == 1){ ?>
    <div class="mb-2">
        <label for="cpf" class="form-label">CPF</label>
        <input name="cpf" class="form-control" id="cpf" required="" value="" oninput="mascara(this)" onblur="valida_cpf(this)">
    </div>
    <?php } ?>

    <?php if($enable_email == 1){ ?>
    <div class="mb-2">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="exemplo@exemplo.com " required>
    </div> 
     <?php } ?>

    <div class="mb-2">
        <label for="phone" class="form-label">Telefone</label>
        <input onkeyup="leowpMask(this);" class="form-control mb-2" name="phone" id="phone" maxlength="15" required="" value="" class=>
    </div>

    <?php if($enable_password == 1){ ?>
    <div class="mb-2">
        <label for="password" class="form-label">Senha</label>
        <input class="form-control mb-2" name="password" id="password" required="" minlength="5" maxlength="20" type="password">
    </div>
    <?php } ?>


</div>
</div>

<?php if($enable_address == 1){ ?>
<div class="endereco app-card card mb-2 ">
   <div class="card-body">
    <div class="mb-2">
        <label for="zipcode" class="form-label">CEP</label>
        <input name="zipcode" class="form-control" id="zipcode" required="" value="">
    </div>
    <div class="mb-2">
        <label for="address" class="form-label">Endereço</label>
        <input type="text" name="address" class="form-control" id="address" required="">
    </div>
    <div class="mb-2">
        <label for="number" class="form-label">Número</label>
        <input type="text" name="number" class="form-control" id="number">
    </div>
    <div class="mb-2">
        <label for="neighborhood" class="form-label">Bairro</label>
        <input type="text" name="neighborhood" class="form-control" id="neighborhood" required="">
    </div>
    <div class="mb-2">
        <label for="complement" class="form-label">Complemento</label>
        <input type="text" name="complement" class="form-control" id="complement">
    </div>
    <div class="mb-2">
     <label for="state" class="form-label">Estado</label>
     <select class="form-select" name="state" id="state" required="">
      <option value="">-- Estado --</option>
      <option value="AC">Acre</option>
      <option value="AL">Alagoas</option>
      <option value="AP">Amapá</option>
      <option value="AM">Amazonas</option>
      <option value="BA">Bahia</option>
      <option value="CE">Ceará</option>
      <option value="DF">Distrito Federal</option>
      <option value="ES">Espí&shy;rito Santo</option>
      <option value="GO">Goiás</option>
      <option value="MA">Maranhão</option>
      <option value="MT">Mato Grosso</option>
      <option value="MS">Mato Grosso do Sul</option>
      <option value="MG">Minas Gerais</option>
      <option value="PA">Pará</option>
      <option value="PB">Paraiba</option>
      <option value="PR">Paraná</option>
      <option value="PE">Pernambuco</option>
      <option value="PI">Piauí&shy;</option>
      <option value="RJ">Rio de Janeiro</option>
      <option value="RN">Rio Grande do Norte</option>
      <option value="RS">Rio Grande do Sul</option>
      <option value="RO">Rondônia</option>
      <option value="RR">Roraima</option>
      <option value="SC">Santa Catarina</option>
      <option value="SP">São Paulo</option>
      <option value="SE">Sergipe</option>
      <option value="TO">Tocantins</option>
  </select>
</div>
<div class="mb-2">
 <label for="city" class="form-label">Cidade</label>
 <input type="text" class="form-control" name="city">
</div>
<div class="mb-2">
    <label for="reference_point" class="form-label">Ponto de referência</label><input type="text" name="reference_point" class="form-control" id="reference_point">
</div>
</div>
</div>
<?php } ?>
<button type="submit" class="btn btn-secondary btn-wide">Cadastrar</button>
</form>
</div>
