<?php require_once('./config.php'); ?>
<?php 
if($_settings->userdata('id') != '' && $_settings->userdata('id') != 2){
    $qry = $conn->query("SELECT * FROM `customer_list` where id = '{$_settings->userdata('id')}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }
}else{
    echo "<script>alert('Você não tem permissão para acessar essa página'); 
    location.replace('/');</script>";
    exit;
}
?>
<div class="container app-main app-form">
 <form id="form-cadastrar">

  <div class="perfil app-card card mb-2">
   <div class="card-body">
    <div class="mb-2">
        <label for="firstname" class="form-label">Nome</label>
        <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Primeiro nome" required="" value="<?php echo isset($firstname) ? $firstname : ''; ?>">
    </div>
    <div class="mb-2">
        <label for="lastname" class="form-label">Sobrenome</label>
        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Sobrenome" required="" value="<?php echo isset($lastname) ? $lastname : ''; ?>">
    </div>
    <div class="mb-2">
        <label for="cpf" class="form-label">CPF</label>
        <input name="cpf" class="form-control" id="cpf" required="" value="<?php echo isset($cpf) ? $cpf : ''; ?>" oninput="mascara(this)" onblur="valida_cpf(this)">
    </div>
    <div class="mb-2">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="exemplo@exemplo.com" value="<?php echo isset($email) ? $email : ''; ?>">
    </div>            
    <div class="mb-2">
        <label for="phone" class="form-label">Telefone</label>
        <input onkeyup="leowpMask(this);" class="form-control mb-2" name="phone" id="phone" maxlength="15" required="" value="<?php echo isset($phone) ? formatPhoneNumber($phone) : ''; ?>" disabled style="background:#eee;">
    </div>

</div>
</div>
<div class="endereco app-card card mb-2 ">
   <div class="card-body">
    <div class="mb-2">
        <label for="zipcode" class="form-label">CEP</label>
        <input name="zipcode" class="form-control" id="zipcode" value="<?php echo isset($zipcode) ? $zipcode : ''; ?>">
    </div>
    <div class="mb-2">
        <label for="address" class="form-label">Endereço</label>
        <input type="text" name="address" class="form-control" id="address" value="<?php echo isset($address) ? $address : ''; ?>">
    </div>
    <div class="mb-2">
        <label for="number" class="form-label">Número</label>
        <input type="text" name="number" class="form-control" id="number" value="<?php echo isset($number) ? $number : ''; ?>">
    </div>
    <div class="mb-2">
        <label for="neighborhood" class="form-label">Bairro</label>
        <input type="text" name="neighborhood" class="form-control" id="neighborhood" value="<?php echo isset($neighborhood) ? $neighborhood : ''; ?>">
    </div>
    <div class="mb-2">
        <label for="complement" class="form-label">Complemento</label>
        <input type="text" name="complement" class="form-control" id="complement" value="<?php echo isset($complement) ? $complement : ''; ?>">
    </div>
    <div class="mb-2">
     <label for="state" class="form-label">Estado</label>
     <select class="form-select" name="state" id="state">
      <option value="">-- Estado --</option>
      <option value="AC" <?php if($state == 'AC'){echo 'selected';}; ?>>Acre</option>
      <option value="AL" <?php if($state == 'AL'){echo 'selected';}; ?>>Alagoas</option>
      <option value="AP" <?php if($state == 'AP'){echo 'selected';}; ?>>Amapá</option>
      <option value="AM" <?php if($state == 'AM'){echo 'selected';}; ?>>Amazonas</option>
      <option value="BA" <?php if($state == 'BA'){echo 'selected';}; ?>>Bahia</option>
      <option value="CE" <?php if($state == 'CE'){echo 'selected';}; ?>>Ceará</option>
      <option value="DF" <?php if($state == 'DF'){echo 'selected';}; ?>>Distrito Federal</option>
      <option value="ES" <?php if($state == 'ES'){echo 'selected';}; ?>>Espí&shy;rito Santo</option>
      <option value="GO" <?php if($state == 'GO'){echo 'selected';}; ?>>Goiás</option>
      <option value="MA" <?php if($state == 'MA'){echo 'selected';}; ?>>Maranhão</option>
      <option value="MT" <?php if($state == 'MT'){echo 'selected';}; ?>>Mato Grosso</option>
      <option value="MS" <?php if($state == 'MS'){echo 'selected';}; ?>>Mato Grosso do Sul</option>
      <option value="MG" <?php if($state == 'MG'){echo 'selected';}; ?>>Minas Gerais</option>
      <option value="PA" <?php if($state == 'PA'){echo 'selected';}; ?>>Pará</option>
      <option value="PB" <?php if($state == 'PB'){echo 'selected';}; ?>>Paraiba</option>
      <option value="PR" <?php if($state == 'PR'){echo 'selected';}; ?>>Paraná</option>
      <option value="PE" <?php if($state == 'PE'){echo 'selected';}; ?>>Pernambuco</option>
      <option value="PI" <?php if($state == 'PI'){echo 'selected';}; ?>>Piauí&shy;</option>
      <option value="RJ" <?php if($state == 'RJ'){echo 'selected';}; ?>>Rio de Janeiro</option>
      <option value="RN" <?php if($state == 'RN'){echo 'selected';}; ?>>Rio Grande do Norte</option>
      <option value="RS" <?php if($state == 'RS'){echo 'selected';}; ?>>Rio Grande do Sul</option>
      <option value="RO" <?php if($state == 'RO'){echo 'selected';}; ?>>Rondônia</option>
      <option value="RR" <?php if($state == 'RR'){echo 'selected';}; ?>>Roraima</option>
      <option value="SC" <?php if($state == 'SC'){echo 'selected';}; ?>>Santa Catarina</option>
      <option value="SP" <?php if($state == 'SP'){echo 'selected';}; ?>>São Paulo</option>
      <option value="SE" <?php if($state == 'SE'){echo 'selected';}; ?>>Sergipe</option>
      <option value="TO" <?php if($state == 'TO'){echo 'selected';}; ?>>Tocantins</option>
  </select>
</div>
<div class="mb-2">
 <label for="city" class="form-label">Cidade</label>
 <input type="text" class="form-control" name="city" value="<?php echo isset($city) ? $city : ''; ?>">
</div>
<div class="mb-2">
    <label for="reference_point" class="form-label">Ponto de referência</label>
    <input type="text" name="reference_point" class="form-control" id="reference_point" value="<?php echo isset($reference_point) ? $reference_point : ''; ?>">
</div>
</div>
</div>
<button type="submit" class="btn btn-secondary btn-wide">Salvar</button>
</form>
</div>

<script>

  function mascara(i){
     var v = i.value;
   if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
      return;
  }
  
  i.setAttribute("maxlength", "14");
  if (v.length == 3 || v.length == 7) i.value += ".";
  if (v.length == 11) i.value += "-";

}
function valida_cpf(cpf) {
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
        if (!digitos_iguais) {
            numeros = cpf.substring(0, 9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
            numeros = cpf.substring(0, 10);
            soma = 0;
            for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;
            return true;
        }
        else
            return false;
    }
$(document).ready(function(){
    $('#form-cadastrar').submit(function(e){
        e.preventDefault()
        var phoneValue = $('#phone').val();
        if($('#phone')){
            if (phoneValue.length < 15 || phoneValue.length > 15) {
             alert('Telefone inválido. Por favor corrija.');
             return;
         }
     }
     var cpfValue = $('#cpf').val();
          cpfValue = cpfValue.replace(/[\s.-]*/igm, '');
     if($('#cpf')){
        if (!valida_cpf(cpfValue)) {
         alert('CPF inválido. Por favor corrija.');
         return;
     }
 }
 
 $.ajax({
    url:_base_url_+"classes/Users.php?f=update_customer_data",
    method:'POST',
    type:'POST',
    data:new FormData($(this)[0]),
    dataType:'json',
    cache:false,
    processData:false,
    contentType: false,
    error:err=>{
        console.log(err)
        alert('An error occurred')
        
    },
    success:function(resp){
        if(resp.status == 'success'){
          alert('Dados atualizados com sucessso.');
          location.href = (resp.redirect);
      }else if(!!resp.msg){
        el.html(resp.msg)
        el.show('slow')
        _this.prepend(el)
        
    }else{
        alert('An error occurred')
        console.log(resp)
    }
}
})
})
})
</script>