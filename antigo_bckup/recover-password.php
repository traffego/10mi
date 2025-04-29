<div class="container app-main">
   <div class="app-title mb-2">
      <h1>🔐 Recuperação de senha</h1>
   </div>
   <div class="app-content app-form">
      <form id="recover-password">
         <div class="app-card card mb-2">
            <div class="card-body">
               <p class="font-xs text-muted mb-1">Enviaremos um link para criação de uma nova senha.</p>
               <div class="form-group">
               <label for="email" class="form-label">E-mail</label>
               <input type="email" name="email" class="form-control" id="email" placeholder="Seu e-mail de cadastro" required="">
            </div>
            </div>
         </div>
         <button type="submit" class="btn btn-secondary btn-wide">Enviar</button>
      </form>
   </div>
</div>
<script>
     $(document).ready(function(){
        $('#recover-password').submit(function(e){
            e.preventDefault();

           $.ajax({
            url:_base_url_+"classes/Master.php?f=recover_password",
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
                  alert('Um link para a criação de uma nova senha foi enviada para o seu e-mail. Por favor verifique a caixa de entrada ou de spam.');
                  location.href = ('./')                                    
              }else{
                alert('Usuário não encontrado com o e-mail informado.')
                console.log(resp)
            }
        }
    })
       })
    })  

</script>