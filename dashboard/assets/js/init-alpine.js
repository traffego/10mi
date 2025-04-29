function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark') !== null) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // Default to dark mode
    return true
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    initTheme() {
      // Set dark theme in localStorage if it's not already set
      if (localStorage.getItem('dark') === null) {
        localStorage.setItem('dark', 'true');
        this.dark = true;
      }
      
      // Forçar aplicação do tema escuro se estiver ativado
      if (this.dark) {
        document.documentElement.classList.add('theme-dark');
        document.body.classList.add('dark');
      }
    },
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
      
      // Atualizar classes diretamente
      if (this.dark) {
        document.documentElement.classList.add('theme-dark')
        document.body.classList.add('dark')
      } else {
        document.documentElement.classList.remove('theme-dark')
        document.body.classList.remove('dark')
      }
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen
    },
    // Modal
    isModalOpen: false,
    isModalOpenNumbers: false,
    isModalOpenStatus: false,
    isModalOpenCron: false,    
    dataId: null,
    dataNumbers: null,
    dataNumbersQtd: null,
    dataPedido: null,
    dataStatus: null,
    dataToken:null,
    msgStatus: null,
    trapCleanup: null,
    titleCron: 'Você realmente deseja executar a limpeza automática de pedidos expirados, em cancelados e pendentes ?',
    dataTimeCron: this.cronDateTime,
    msgCron: [],
    isCronStart: true,
    isCronEnd: false,
    copyModal() {
      const openModalNumbersContent = document.querySelector('.dataNumbers').textContent;
        
      const tempElement = document.createElement('textarea');
      tempElement.value = openModalNumbersContent;
      document.body.appendChild(tempElement);

      tempElement.select();
      document.execCommand('copy');
      document.body.removeChild(tempElement);
      alert('Texto copiado para a área de transferência!');
    },
    openModal() {
      this.isModalOpen = true
      //this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeModal() {
      this.isModalOpen = false
      //this.trapCleanup()
    },
    openModalNumbers(dataId) {
      this.isModalOpenNumbers = true
      this.dataId = dataId;      

      $.ajax({
          url: _base_url_ + "classes/Master.php?f=view_order_numbers",
          method: "POST",
          data: { id: this.dataId },
          dataType: "json",
          error: err => {
              console.log(err)
          },
          success: resp => {
              if (typeof resp == 'object' && resp.numbers) {
                  this.dataNumbers = resp.numbers;
                  if (resp.qtd) {
                    this.dataNumbersQtd = resp.qtd;
                  }

                  const elementsWithDataNumbers = document.querySelectorAll('.dataNumbers');
                  elementsWithDataNumbers.forEach(element => {
                    element.scrollTop = 0;
                  });

              } else {
                  console.log("Ocorreu um erro.");
              }
          }
      });
      //this.trapCleanup = focusTrap(document.querySelector('#modal-admin'))
    },
    closeModalNumbers() {
      this.isModalOpenNumbers = false
      //this.trapCleanup()
    },  
    openChangeStatus(dataPedido,dataStatus,dataToken) { 
      this.isModalOpenStatus = false;     
      this.dataPedido = dataPedido;   
      this.dataStatus = dataStatus;
      this.dataToken = dataToken;
      this.msgStatus = null;
      $.ajax({
        type: 'POST',
        url: _base_url_ + "classes/Master.php?f=check_payment_status",
        data: { order_token: this.dataToken },
        error: function(err) {
          //console.log(err);
          console.log("[AO05] - An error occurred.");
        },
        success: (resp) => {
          var returnedData = JSON.parse(resp);
          
          if (returnedData.status == '2' && returnedData.status_mp == 'approved' && dataStatus == '3') {
              this.msgStatus = 'o pedido foi PAGO! Deseja realmente marcar como CANCELADO?';
          } else if (returnedData.status == '1' && returnedData.status_mp == 'approved' && dataStatus == '3') {
              this.msgStatus = 'o pedido PENDENTE, foi PAGO! Deseja realmente marcar como CANCELADO?';
          } else if (returnedData.status == '1' && returnedData.status_mp == 'failed' && dataStatus == '2') {
              this.msgStatus = 'o pedido PENDENTE, não foi PAGO! Deseja realmente marcar como PAGO?';
          }
          // console.log(returnedData.status + '-' + returnedData.status_mp + '-' + dataStatus + '-' + returnedData.error);

          if(this.msgStatus) {
              this.isModalOpenStatus = true;
          } else {
              this.continueChangeStatus();
              //console.log('Error: '+returnedData.error);          
          }       
        },
      });      
    },
    continueChangeStatus() {
      $.ajax({
        url: _base_url_ + "classes/Master.php?f=update_order_status",
        method: "POST",
        data: { id: this.dataPedido, status: this.dataStatus },
        dataType: "json",
        error: function(err) {
          //console.log(err);
          console.log("[AO05] - An error occurred.");
        },
        success: function(resp) {
          if (typeof resp === "object" && resp.status === "success") {
            this.isModalOpenStatus = false;
            alert("O status do pedido foi atualizado com sucesso!");
            location.reload();            
          } else {
            //console.log(resp.msg);
            console.log("[AO06] - An error occurred.");
          }
        },
      });  
    },
    closeModalStatus() {
      this.isModalOpenStatus = false;
    },
    openCron() {     
      this.cronDateTime();
      setInterval(() => {
          this.cronDateTime();
      }, 1000);
      this.isModalOpenCron = true;
    },
    cronDateTime() {
      var data = new Date();      
      var day = data.getDate().toString().padStart(2, '0');
      var month = (data.getMonth() + 1).toString().padStart(2, '0');
      var year = data.getFullYear();
      var hour = data.getHours().toString().padStart(2, '0');
      var minute = data.getMinutes().toString().padStart(2, '0');
      var second = data.getSeconds().toString().padStart(2, '0');      
      this.dataTimeCron = day + '/' + month + '/' + year + ' ' + hour + ':' + minute + ':' + second;      
    },
    continueCron() { 
      this.titleCron = 'Carregando...por favor aguarde!';
      this.isCronStart = false;
      this.isCronEnd = true;
      this.isModalOpenCron = true;
      this.msgCron = [];
      //this.msgCron = ['Teste', 'Teste2'];
      //
      fetch(_base_url_ + 'dashboard/cron.php')
      .then(response => {
          if (!response.ok) {
            this.msgCron.push('Erro ao executar o cron.php');
          }
          return response.json();
      })
      .then(data => {
          if (typeof data.log === 'string') {
            this.msgCron.push('- ' + data.log);
          } else if (Array.isArray(data.log)) {
              data.log.forEach(log => {
                  this.msgCron.push('- ' + log);
              });
          }
          this.titleCron = 'Resultado: ';
      })
      .catch(error => {
          console.log(error);
          this.msgCron.push('Erro ao executar o cron.php');
      });
      //
    },
    closeModalCron(reload = false) {
      this.isModalOpenCron = false;
      this.titleCron = 'Você realmente deseja executar a limpeza automática de pedidos expirados, em cancelados e pendentes ?';
      this.msgCron = [];
      this.isCronStart = true;
      this.isCronEnd = false;
      if(reload === 1) {
        location.reload();
      }
    },    
  }
}

function dataTables() {
  return {
    fields: [],
    isModalOpenDel: false,
    isModalOpenAw: false,
    imgVisible: false,
    dataRowDel: false,
    dataRowLabel: false,
    dataVisible: null,
    modalAwName: null,
    modalAwPhone: null,
    modalAwNumber: null,
    modalAwLabel: null,
    modalAwView: false,
    dataId: null,
    loadInitialData(dataId) {

      const saveButton = document.getElementById('save-button');
      saveButton.disabled = true;
      saveButton.textContent = "Aguarde...";
      showLoading();

      $.ajax({
        url: _base_url_ + "classes/Master.php?f=product_number_awarded",
        method: "POST",
        data: { id: dataId },
        dataType: "json",
        error: err => {
            console.log(err);
            saveButton.disabled = false;
            saveButton.textContent = "Salvar";
            hideLoading();
        },
        success: resp => {
            if (resp !== null) {

                const initialData = [];

                let respArray;
                if (typeof resp === 'string') {
                    try {
                        respArray = JSON.parse(resp);
                    } catch (error) {
                        console.error('Erro ao analisar a string JSON:', error);
                        saveButton.disabled = false;
                        saveButton.textContent = "Salvar";
                        hideLoading();
                        return;
                    }
                } else if (Array.isArray(resp)) {
                    respArray = resp;
                }

                if (Array.isArray(respArray)) {
                    respArray.forEach(item => {
                        const formattedItem = {
                            aw_number: item.aw_number,
                            aw_label: item.aw_label,
                            aw_locked: item.aw_locked,
                            aw_view: item.aw_view,
                            aw_preview: item.aw_preview
                        };
                        initialData.push(formattedItem);
                        this.fields.push(formattedItem);
                    });
                } else {
                    console.error('O objeto retornado não é um array:', respArray);
                }

            } else {
                console.log("Ocorreu um erro. Os dados retornados não estão no formato esperado.");
            }
            saveButton.disabled = false;
            saveButton.textContent = "Salvar";
            hideLoading();
        }
      });
    },
    addNewField(dataId) {
        $.ajax({
          url: _base_url_ + "classes/Master.php?f=get_number_awarded",
          method: "POST",
          data: { id: dataId },
          dataType: "json",
          error: err => {
              console.log(err);
          },
          success: resp => {
              if (resp !== null) {
                  if (typeof resp === 'string') {
                    this.fields.push({
                        aw_number: resp,
                        aw_label: '',
                        aw_locked: false,
                        aw_view: false,
                        aw_preview: false
                    });
                    //console.log(resp);
                  } else {
                    console.log("Ocorreu um erro. Os dados retornados não estão no formato esperado.");
                  }
              } else {
                  console.log("Não há dados para exibir.");
              }
          }
        });        
    },
    removeField(index) {
      this.dataVisible = index;
      setTimeout(() => {
        this.fields.splice(index, 1);
        this.dataVisible = null;
      }, 600);      
      this.isModalOpenDel = false;
    }, 
    removeFieldConfirm(index,data) {
      this.isModalOpenDel = true;
      this.dataRowDel = index;
      this.dataRowLabel = data;
    },
    openAwConfirm(dataId,dataValue) {

      $.ajax({
        url: _base_url_ + "classes/Master.php?f=product_number_customer",
        method: "POST",
        data: { id: dataId, view: dataValue },
        dataType: "json",
        error: err => {
            console.log(err);
        },
        success: resp => {
            if (resp !== null) {               
                this.modalAwName = resp.name;
                this.modalAwPhone = this.formatPhoneNumber(resp.phone);
                this.modalAwNumber = resp.number;
                this.modalAwLabel = resp.label;
                this.modalAwView = resp.view;
            } else {
                console.log("Ocorreu um erro. Os dados retornados não estão no formato esperado.");
            }
        }
      }); 

      this.isModalOpenAw = true;
      setTimeout(() => {
          this.imgVisible = true;
      }, 150);
      //this.dataRowLabel = data;
    },
    closeModalDel() {
      this.isModalOpenDel = false;
      //this.trapCleanup()
    },
    closeAwConfirm() {      
      this.imgVisible = false;      
      setTimeout(() => {
          this.isModalOpenAw = false;
      }, 100);
    },
    closeAwSubmit() {   
      const index = this.fields.findIndex(item => item.aw_number === this.modalAwNumber);
      if (index !== -1) {
          if(this.modalAwView) {
            this.fields[index].aw_view = false;
          }else{
            this.fields[index].aw_view = true;
          }
          setTimeout(() => {
            this.isModalOpenAw = false;
            $('#product-form').trigger('submit');
          }, 100);          
      }      
    },
    formatPhoneNumber(phoneNumber) {
      if (phoneNumber.length === 10 || phoneNumber.length === 11) {
          return '(' + phoneNumber.substring(0, 2) + ') *****-' + phoneNumber.substring(phoneNumber.length - 4);
      } else {
          return phoneNumber;
      }
    }
  }
}


