<div class="container app-main app-form">
   <div class="app-perguntas">
      <div class="app-title">
         <h1>🤷 Perguntas frequentes</h1>
      </div>
      <div id="perguntas-box">
         <div class="mb-2">
            <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
               <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d4b6bd40368220230114" aria-expanded="false" aria-controls="pergunta-63c30d4b6bd40368220230114"><i class="bi bi-arrow-right me-2 text-cor-primaria"></i> <span>Como acessar minhas compras?</span></div>
               <div class="d-block">
                  <div class="pergunta-item--resp mt-1 text-muted collapse" id="pergunta-63c30d4b6bd40368220230114" data-bs-parent="#perguntas-box" style="">
                     <p>Fazendo login no site e abrindo o Menu Principal, você consegue consultar suas últimas compras no menu "Minhas compras".</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="mb-2">
            <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
               <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d9b86a97602220230114" aria-expanded="false" aria-controls="pergunta-63c30d9b86a97602220230114"><i class="bi bi-arrow-right me-2 text-cor-primaria"></i> <span>Como envio o comprovante?</span></div>
               <div class="d-block">
                  <div class="pergunta-item--resp mt-1 text-muted collapse" id="pergunta-63c30d9b86a97602220230114" data-bs-parent="#perguntas-box" style="">
                     <p>Caso você tenha feito o pagamento via Pix QR Code ou copiando o código, não é necessário enviar o comprovante, aguardando até 5 minutos após o pagamento, o sistema irá dar baixa automaticamente, para mais dúvidas entre em contato conosco <a href="/contato">clicando aqui</a>.</p>
                  </div>
               </div>
            </div>
         </div>
         <?php if($enable_password == 1){ ?>
         <div class="mb-2">
            <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
               <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d6c33f26255820230114" aria-expanded="false" aria-controls="pergunta-63c30d6c33f26255820230114"><i class="bi bi-arrow-right me-2 text-cor-primaria"></i> <span>Esqueci minha senha, como faço?</span></div>
               <div class="d-block">
                  <div class="pergunta-item--resp mt-1 text-muted collapse" id="pergunta-63c30d6c33f26255820230114" data-bs-parent="#perguntas-box" style="">
                     <p>Você consegue recuperar sua senha indo no menu do site, depois em "Entrar" e logo a baixo tem "Esqueci&nbsp;minha senha".</p>
                  </div>
               </div>
            </div>
         </div>
      <?php } ?>
      
      </div>
   </div>
   <div class="app-title mb-2">
      <h1>✉️ Contato</h1>
      <div class="app-title-desc">Tire suas dúvidas.</div>
   </div>

   <form id="form-contact">
      <div class="app-card card mb-2">
         <div class="card-body">
            <div class="mb-2"><label class="form-label">Nome</label><input type="text" name="nome" id="nome" class="form-control" required=""></div>
            <div class="mb-2"><label class="form-label">Telefone</label><input name="telefone" id="telefone" class="form-control" required="" value=""></div>
            <div class="mb-2">
               <label class="form-label">Sorteio</label>
               <select name="sorteio" id="sorteio" class="form-control" required="">
                  <option>Deseja falar sobre um sorteio?</option>
                  <?php 
                  $qry = $conn->query("SELECT * from `product_list` order by id desc");
                  if($qry->num_rows > 0){
                     while($row = $qry->fetch_assoc()):
                       ?>
                       <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                 <?php } ?>
              </select>
           </div>
           <div class="mb-2">
            <label class="form-label">Assunto</label>
            <select name="assunto" id="assunto" class="form-control" required="">
               <option>Outro(s)</option>
               <option>Problemas com cadastro</option>
               <option>Problemas com compras</option>
               <option>Quero ser parceiro</option>
               <option>Recuperar senha</option>
            </select>            </div>
            <div class="mb-2"><label class="form-label">Mensagem</label>
            <textarea type="text" name="mensagem" id="mensagem" class="form-control mb-1" required="" rows="6"></textarea>
            <small class="text-muted font-xss">mínimo de 20 caracteres</small></div>
         </div>
      </div>
      <div class="text-end">
      <button type="submit" class="btn btn-primary btn-wide">Enviar <i class="bi bi-arrow-right"></i></button></div>
   </form>
</div>
<script>
     $(document).ready(function(){
        $('#form-contact').submit(function(e){
            e.preventDefault();

           $.ajax({
            url:_base_url_+"classes/Master.php?f=contact_send_email",
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
                  alert('Email enviado com sucesso.');
                  location.href = ('./')                                    
              }else{
                alert('An error occurred')
                console.log(resp)
            }
        }
    })
       })
    })  

</script>