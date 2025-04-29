<?php $enable_raffle_mode = $_settings->info('enable_raffle_mode');
$enable_raffle_mode_class_phone = ($enable_raffle_mode == 1) ? 'enable_raffle_mode_class_phone' : '';

$enable_raffle_mode_class_phone_blur = ($enable_raffle_mode == 1) ? 'enable_raffle_mode_class_phone_blur' : '';
if(isset($_SERVER['HTTP_USER_AGENT'])) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    // Detecta se o usuário está usando um dispositivo móvel
    $is_mobile = preg_match('/(android|iphone|ipad|ipod)/i', $user_agent);
}
?>


<style>

.enable_raffle_mode_class_phone_blur {
  filter: blur(4px);
}

/* styles.css */
.enable_raffle_mode_class_phone .real-number {
    display: none; /* Esconde os números reais */
}

.enable_raffle_mode_class_phone .masked-number::before {
    content: attr(data-ddd) " *****-****"; /* Conteúdo a ser mostrado */
    color: black; /* Cor dos asteriscos */
}

/* Menu Dark Mode Fixes */
.dark .text-gray-800 {
  color: #e2e8f0 !important;
}

.dark .text-gray-700 {
  color: #e2e8f0 !important;
}

.dark li.relative.px-6.py-3 a.inline-flex.items-center.w-full.text-sm.font-semibold {
  color: #e2e8f0 !important;
}

.dark .text-gray-500 {
  color: #a0aec0 !important;
}

.dark .sidebar-item:hover {
  color: #fff !important;
}

.dark .submenu-link {
  color: #cbd5e0 !important;
}

.dark .submenu-link:hover {
  color: #fff !important;
}

/* Estilos para os cards estatísticos */
.stat-card {
  background-color: #fff;
  border-radius: 0.5rem;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.dark .stat-card {
  background-color: #1a1c23 !important;
  border: 1px solid rgba(74, 85, 104, 0.2) !important;
  color: #e2e8f0 !important;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.dark .stat-card:hover {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
}

.stat-icon {
  width: 3rem;
  height: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.stat-icon.campaigns {
  background-color: rgba(72, 187, 120, 0.2);
  color: #48bb78;
}

.dark .stat-icon.campaigns {
  background-color: rgba(72, 187, 120, 0.1);
  color: #68d391;
}

.stat-icon.clients {
  background-color: rgba(237, 137, 54, 0.2);
  color: #ed8936;
}

.dark .stat-icon.clients {
  background-color: rgba(237, 137, 54, 0.1);
  color: #f6ad55;
}

.stat-icon.orders {
  background-color: rgba(66, 153, 225, 0.2);
  color: #4299e1;
}

.dark .stat-icon.orders {
  background-color: rgba(66, 153, 225, 0.1);
  color: #63b3ed;
}

.stat-icon.billing {
  background-color: rgba(160, 174, 192, 0.2);
  color: #a0aec0;
}

.dark .stat-icon.billing {
  background-color: rgba(160, 174, 192, 0.1);
  color: #cbd5e0;
}

.stat-content {
  text-align: left;
}

.stat-title {
  color: #718096;
  font-size: 0.875rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.dark .stat-title {
  color: #d5d6d7 !important;
}

.stat-value {
  color: #2d3748;
  font-size: 1.5rem;
  font-weight: 700;
}

.dark .stat-value {
  color: #f7fafc !important;
}

.stat-eye {
  opacity: 0.6;
}

/*ALTERAÇÇÕES A PARTIR DE JULHO 2024*/

@media (max-width: 700px) {

tr.text-gray-700.dark\:text-gray-400 {
    vertical-align: text-bottom;
    width: 100% !important;
    display: grid;
}

tbody {
    line-height: 4px !important;
}

}

/* Estilos para o footer */
footer {
  width: 100%;
  left: 0;
  right: 0;
  bottom: 0;
  position: relative;
  margin-top: auto;
}

.footer-wrapper {
  width: 100%;
  max-width: 100%;
  padding-left: 0;
  padding-right: 0;
}

footer.bg-white {
  box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
}

.dark footer.bg-white {
  background-color: #1a1c23 !important;
  color: #e2e8f0;
  box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.3);
}

.dark footer p {
  color: #a0aec0;
}

.dark footer a:hover {
  color: #90cdf4;
}

.container.footer-container {
  width: 100%;
  max-width: 100%;
  padding-left: 0;
  padding-right: 0;
}

@media (max-width: 768px) {
  footer .container {
    padding: 0 1rem;
    width: 100%;
  }
}

/* Updated Footer Styles */
footer {
  position: sticky !important;
  bottom: 0 !important;
  width: 100vw !important;
  left: 0 !important;
  right: 0 !important;
  margin-left: calc(-50vw + 50%) !important;
  margin-top: 2rem !important;
  z-index: 10 !important;
}

/* Set min height for main content to ensure footer stays at bottom */
html, body {
  height: 100%;
}

body {
  display: flex;
  flex-direction: column;
}

main {
  flex: 1 0 auto;
  min-height: calc(100vh - 200px);
}

/* Fix for dark mode footer */
.dark footer {
  background-color: var(--dark-bg);
  color: var(--dark-text);
}

.footer-container {
  padding: 0.5rem 1rem;
}

@media (max-width: 768px) {
  .footer-container {
    padding: 0.5rem;
  }
}

/* Estilos para os cards com resultados de análise */
.dark .bg-gray-50 {
  background-color: #2d3748 !important;
}

.dark .text-gray-600 {
  color: #cbd5e0 !important;
}

.dark .text-gray-500 {
  color: #a0aec0 !important;
}

/* Garantir que modais e cards de análise tenham cores corretas no modo escuro */
.dark .bg-white {
  background-color: #1a1c23 !important;
}

/* Corrigindo problema dos cards no modo escuro, com seletores mais específicos */
html[class*="theme-dark"] .stat-card,
.theme-dark .stat-card,
:root.theme-dark .stat-card {
  background-color: #1a1c23 !important;
  border: 1px solid rgba(74, 85, 104, 0.2) !important;
  color: #e2e8f0 !important;
}

html[class*="theme-dark"] .stat-title,
.theme-dark .stat-title,
:root.theme-dark .stat-title {
  color: #d5d6d7 !important;
}

html[class*="theme-dark"] .stat-value,
.theme-dark .stat-value,
:root.theme-dark .stat-value {
  color: #f7fafc !important;
}

html[class*="theme-dark"] .stat-icon.campaigns,
.theme-dark .stat-icon.campaigns,
:root.theme-dark .stat-icon.campaigns {
  background-color: rgba(72, 187, 120, 0.1) !important;
  color: #68d391 !important;
}

html[class*="theme-dark"] .stat-icon.clients,
.theme-dark .stat-icon.clients,
:root.theme-dark .stat-icon.clients {
  background-color: rgba(237, 137, 54, 0.1) !important;
  color: #f6ad55 !important;
}

html[class*="theme-dark"] .stat-icon.orders,
.theme-dark .stat-icon.orders,
:root.theme-dark .stat-icon.orders {
  background-color: rgba(66, 153, 225, 0.1) !important;
  color: #63b3ed !important;
}

html[class*="theme-dark"] .stat-icon.billing,
.theme-dark .stat-icon.billing,
:root.theme-dark .stat-icon.billing {
  background-color: rgba(160, 174, 192, 0.1) !important;
  color: #cbd5e0 !important;
}

/* Corrigir navegação no modo escuro */
html[class*="theme-dark"] nav a,
.theme-dark nav a,
:root.theme-dark nav a {
  color: #e2e8f0 !important;
}

html[class*="theme-dark"] nav a:hover,
.theme-dark nav a:hover,
:root.theme-dark nav a:hover {
  color: #fff !important;
}

html[class*="theme-dark"] .nav-item.active,
.theme-dark .nav-item.active,
:root.theme-dark .nav-item.active {
  color: #fff !important;
  background-color: rgba(159, 122, 234, 0.2) !important;
}

/* Garantir logo visível no modo escuro */
html[class*="theme-dark"] .text-gray-800,
.theme-dark .text-gray-800,
:root.theme-dark .text-gray-800 {
  color: #e2e8f0 !important;
}

/* Menu Items in Dark Mode */
html.theme-dark .nav-item {
  color: #e2e8f0 !important;
}

html.theme-dark .nav-item:hover {
  color: #fff !important;
}

html.theme-dark .nav-item.active {
  color: #fff !important;
  background-color: rgba(159, 122, 234, 0.2) !important;
}

/* Force dark mode cards to have the right colors */
.theme-dark .stat-card,
html[data-theme="dark"] .stat-card,
:root.dark .stat-card,
.dark .stat-card {
  background-color: #1a1c23 !important;
  border: 1px solid rgba(74, 85, 104, 0.2) !important;
  color: #e2e8f0 !important;
}

.theme-dark .stat-title,
html[data-theme="dark"] .stat-title,
:root.dark .stat-title,
.dark .stat-title {
  color: #d5d6d7 !important;
}

.theme-dark .stat-value,
html[data-theme="dark"] .stat-value,
:root.dark .stat-value,
.dark .stat-value {
  color: #f7fafc !important;
}

.theme-dark .stat-icon.campaigns,
html[data-theme="dark"] .stat-icon.campaigns,
:root.dark .stat-icon.campaigns,
.dark .stat-icon.campaigns {
  background-color: rgba(72, 187, 120, 0.1) !important;
  color: #68d391 !important;
}

.theme-dark .stat-icon.clients,
html[data-theme="dark"] .stat-icon.clients,
:root.dark .stat-icon.clients,
.dark .stat-icon.clients {
  background-color: rgba(237, 137, 54, 0.1) !important;
  color: #f6ad55 !important;
}

.theme-dark .stat-icon.orders,
html[data-theme="dark"] .stat-icon.orders,
:root.dark .stat-icon.orders,
.dark .stat-icon.orders {
  background-color: rgba(66, 153, 225, 0.1) !important;
  color: #63b3ed !important;
}

.theme-dark .stat-icon.billing,
html[data-theme="dark"] .stat-icon.billing,
:root.dark .stat-icon.billing,
.dark .stat-icon.billing {
  background-color: rgba(160, 174, 192, 0.1) !important;
  color: #cbd5e0 !important;
}

/* Footer dark mode overrides */
.theme-dark footer.bg-white,
html[data-theme="dark"] footer.bg-white,
:root.dark footer.bg-white,
.dark footer.bg-white {
  background-color: #1a1c23 !important;
  color: #e2e8f0 !important;
}

.theme-dark footer .text-gray-600,
html[data-theme="dark"] footer .text-gray-600,
:root.dark footer .text-gray-600,
.dark footer .text-gray-600 {
  color: #cbd5e0 !important;
}

.theme-dark footer .text-gray-500,
html[data-theme="dark"] footer .text-gray-500,
:root.dark footer .text-gray-500,
.dark footer .text-gray-500 {
  color: #a0aec0 !important;
}

@media(max-width: 700px){
  thead tr {
    display: none;
  }
  td {
    display: grid;
    gap: 0.5rem;
    grid-template-columns: 15ch auto;
    padding: 0.5rem 1rem;
  }
  td:first-child {
    padding-top: 1rem;
  }
  td:last-child {
    padding-bottom: 1rem;
  }
  td::before {
    content: attr(data-cell);
    font-weight: 700;
  }
  body {
    line-height: 1.5;
  }
}

/* Button consistency in dark mode */
.dark .bg-purple-600,
.dark .bg-green-600,
.dark .bg-blue-600,
.dark button.bg-purple-600,
.dark button.bg-green-600,
.dark button.bg-blue-600 {
  background-color: var(--color-purple-600, #805ad5) !important;
  color: white !important;
}

.dark .bg-purple-600:hover,
.dark .bg-green-600:hover,
.dark .bg-blue-600:hover,
.dark button.bg-purple-600:hover,
.dark button.bg-green-600:hover,
.dark button.bg-blue-600:hover {
  background-color: var(--color-purple-700, #6b46c1) !important;
}

.dark .active\:bg-purple-600:active,
.dark .active\:bg-green-600:active,
.dark .active\:bg-blue-600:active {
  background-color: var(--color-purple-600, #805ad5) !important;
}

/* Fix for modal buttons */
@media (max-width: 640px) {
  #modal-admin footer {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
  
  #modal-admin footer button {
    font-size: 0.75rem !important;
    padding: 0.5rem 0.75rem !important;
  }
}

</style>

<script>
    // script.js
document.addEventListener("DOMContentLoaded", function() {
    var phoneNumbers = document.querySelectorAll('.enable_raffle_mode_class_phone');
    phoneNumbers.forEach(function(phoneNumber) {
        var text = phoneNumber.textContent.trim();
        var ddd = text.slice(0, 4); // Extrai o DDD com parênteses
        var number = text.slice(4).trim(); // Extrai o restante do número
        phoneNumber.innerHTML = '<span class="real-number">' + text + '</span>' +
                                '<span class="masked-number" data-ddd="' + ddd + '"></span>';
    });
});

</script>
<?php
$raffle = isset($_GET['raffle']) ? $_GET['raffle'] : '';
$d_start = isset($_GET['ranking_date_start']) ? $_GET['ranking_date_start'] : date('Y-m-d');
$d_end = isset($_GET['ranking_date_end']) ? $_GET['ranking_date_end'] : date('Y-m-d');
$top = isset($_GET['top']) ? $_GET['top'] : '';
 ?>
 <style>
 .adm-pedido-numeros {
position: relative;
    display: block;
    width: max-content;
    padding: 1px 5px 1px 5px;
    border: 1px solid #aed2c2;
    background-color: #def7ec;
    color: #046c4e;
    font-weight: 500;
    font-size: small;
    border-radius: 5px;
    cursor: pointer;
    white-space: nowrap;
}
.phone-number-star {
  position: relative;
  display: inline-block;
}


.dataNumbers {
	word-break: break-word;
    height: 150px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 5px;
    display: list-item;
	margin-top: 15px;
}
 .order_numbers {
  padding: 10px;
  max-width: 150px;
  white-space: nowrap;
  overflow: auto;
}
.winner-info span{
display:block;
}
.order_numbers {
    white-space: normal;
}
tr.text-gray-700.dark\:text-gray-400 {
    vertical-align: text-bottom;
}
.leowp-tab, .leowp-tab * {
  font-family: arial, sans-serif;
  box-sizing: border-box;
}

.leowp-tab input { display: none; }

.leowp-tab label {
  position: relative; /* required for (f2) position:absolute */
  display: block;
  width: 100%; 
  cursor: pointer;
}


.leowp-tab .leowp-content { 
  overflow: hidden;
   
  max-height: 0;
}
leowp-tab .leowp-content p { padding: 10px; }

.leowp-tab input:checked ~ .leowp-content { max-height: 100%; }

.leowp-tab label::after {
  display: block;  
  content: "\25BC"; 
  position: absolute;
  left: 60px; 
  top: 0px; 
  transition: all 0.4s;
}
 
.leowp-tab input:checked ~ label::after { transform: rotate(-180deg); }
.theme-dark input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    filter: invert(1);
}

/*ALTERAÇÇÕES A PARTIR DE JULHO 2024*/

@media (max-width: 700px) {

tr.text-gray-700.dark\:text-gray-400 {
    vertical-align: text-bottom;
    width: 100% !important;
    display: grid;
}

tbody {
    line-height: 4px !important;
}

}
</style>       

<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2
    class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
    >
    Dashboard
  </h2>

  <!-- Cards Estatísticos -->
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Card Campanhas -->
    <div class="stat-card">
      <div class="stat-content">
        <p class="stat-title">Campanhas</p>
        <?php 
        $campaigns_count = $conn->query("SELECT COUNT(*) as total FROM product_list")->fetch_assoc()['total'];
        ?>
        <p class="stat-value"><?= $campaigns_count ?></p>
      </div>
      <div class="stat-icon campaigns">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
        </svg>
      </div>
    </div>

    <!-- Card Clientes -->
    <div class="stat-card">
      <div class="stat-content">
        <p class="stat-title">Clientes</p>
        <?php 
        $clients_count = $conn->query("SELECT COUNT(*) as total FROM customer_list")->fetch_assoc()['total'];
        ?>
        <p class="stat-value"><?= $clients_count ?></p>
      </div>
      <div class="stat-icon clients">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
        </svg>
      </div>
    </div>

    <!-- Card Pedidos -->
    <div class="stat-card">
      <div class="stat-content">
        <p class="stat-title">Pedidos</p>
        <?php 
        $orders_count = $conn->query("SELECT COUNT(*) as total FROM order_list")->fetch_assoc()['total'];
        ?>
        <p class="stat-value"><?= $orders_count ?></p>
      </div>
      <div class="stat-icon orders">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
        </svg>
      </div>
    </div>

    <!-- Card Faturamento -->
    <div class="stat-card">
      <div class="stat-content">
        <p class="stat-title">Faturamento</p>
        <?php 
        $total_billing = $conn->query("SELECT SUM(ol.total_amount) as total 
                                     FROM order_list ol 
                                     INNER JOIN product_list pl ON ol.product_id = pl.id
                                     WHERE ol.status = 2 AND pl.status = 1")->fetch_assoc()['total'];
        $total_billing = $total_billing ? format_num($total_billing, 2) : '0.00';
        ?>
        <p class="stat-value flex items-center">
          <span id="billing-value" class="hidden mr-2">R$ <?= $total_billing ?></span>
          <button id="toggle-billing" class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none transition-colors duration-150">
            <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
            </svg>
          </button>
        </p>
      </div>
      <div class="stat-icon billing">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
        </svg>
      </div>
    </div>
  </div>
  <!-- Fim dos Cards Estatísticos -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleButton = document.getElementById('toggle-billing');
      const billingValue = document.getElementById('billing-value');
      const eyeOpen = document.getElementById('eye-open');
      const eyeClosed = document.getElementById('eye-closed');
      
      toggleButton.addEventListener('click', function() {
        billingValue.classList.toggle('hidden');
        eyeOpen.classList.toggle('hidden');
        eyeClosed.classList.toggle('hidden');
      });
    });
  </script>

<!--Busca Ganhador x Ranking -->
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
    <!-- Card Buscar Ganhador -->
    <div class="bg-white rounded-lg shadow-xs overflow-hidden dark:bg-gray-800">
        <div class="flex items-center p-4 bg-purple-50 dark:bg-gray-700">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z"></path>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
    BUSCAR GANHADOR
            </h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
        <div class="p-4">
      <form action="" id="buscar-ganhador" style="margin-bottom:10px">
                <div class="flex flex-col w-full">
                    <div class="flex w-full mb-4">
                        <div class="w-1/2 pr-2">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Selecione a rifa:</p>
            <select name="raffle" id="raffle" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Selecione</option>
                <?php 
                $qry = $conn->query("SELECT * FROM `product_list`");
                while ($row = $qry->fetch_assoc()) { ?>
              <option value="<?= $row['id'] ?>" <?php if($raffle == $row['id']){echo 'selected';} ?>><?= $row['name'] ?></option>
               <?php }  ?>
            </select>
          </div>
                        <div class="w-1/2 pl-2">
              <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Número / bicho sorteado</p>
             <input type="text" name="number" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ex: 15 / Leão">
           </div>
                    </div>
                    <div class="w-full">
                        <button class="w-full px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar">Buscar</button>
          </div>
        </div>
    </form>

  <p class="text-gray-700 dark:text-gray-200 winner-info">
  <span id="name"></span>
  <span id="phone"></span>
  <span id="raffle"></span>
  <span id="date"></span>
  <span id="payment_status"></span>
  <span id="number"></span>
  <span class="winner"></span>
</p>
</div>
</div>
    <!-- Card Análise de Números -->
    <div class="bg-white rounded-lg shadow-xs overflow-hidden dark:bg-gray-800">
        <div class="flex items-center p-4 bg-green-50 dark:bg-gray-700">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                MAIOR E MENOR NÚMERO
            </h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
        <div class="p-4">
            <form action="" id="number-minmax" style="margin-bottom:10px">
                <div class="flex flex-col w-full">
                    <div class="w-full mb-4">
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Selecione o sorteio:</p>
                        <select name="raffle_minmax" id="raffle_minmax" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="">Selecione</option>
                            <?php 
                            $qry = $conn->query("SELECT * FROM `product_list`");
                            while ($row = $qry->fetch_assoc()) { ?>
                          <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                           <?php }  ?>
                        </select>
                    </div>
                    <div class="w-full">
                        <button type="button" id="check-minmax" class="w-full px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">Analisar</button>
                    </div>
                </div>
            </form>

            <div class="mt-4 text-gray-700 dark:text-gray-200" id="number-minmax-result">
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hidden">
                    <p class="mb-3"><strong>Sorteio:</strong> <span id="raffle-name">-</span></p>
                    
                    <div class="border-l-4 border-green-500 pl-3 py-1 mb-3">
                        <p class="text-lg font-semibold mb-1"><span id="highest-number">-</span> <small class="text-xs text-gray-500">(maior)</small></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span id="highest-client">-</span> • 
                            <a href="./?page=orders/view_order&id=" id="highest-order-link" class="text-blue-500 hover:underline">Pedido #<span id="highest-order">-</span></a>
                        </p>
                    </div>
                    
                    <div class="border-l-4 border-blue-500 pl-3 py-1">
                        <p class="text-lg font-semibold mb-1"><span id="lowest-number">-</span> <small class="text-xs text-gray-500">(menor)</small></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span id="lowest-client">-</span> • 
                            <a href="./?page=orders/view_order&id=" id="lowest-order-link" class="text-blue-500 hover:underline">Pedido #<span id="lowest-order">-</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Ranking de Compradores -->
    <div class="bg-white rounded-lg shadow-xs overflow-hidden dark:bg-gray-800">
        <div class="flex items-center p-4 bg-blue-50 dark:bg-gray-700">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
  RANKING DE COMPRADORES
            </h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
        <div class="p-4">
    <form action="" id="filter-form" style="margin-bottom:10px">
        <div class="flex flex-wrap justify-between items-end">
            <div class="xs:w-full w-auto mb-4 md:mb-0">
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Selecione a rifa</p>
                        <select name="raffle" id="raffle" class="block w-full mt-1 pr-2 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Selecione</option>
                    <?php 
                    $qry = $conn->query("SELECT * FROM `product_list`");
                    while ($row = $qry->fetch_assoc()) { ?>
                  <option value="<?= $row['id'] ?>" <?php if($raffle == $row['id']){echo 'selected';} ?>><?= $row['name'] ?></option>
                  <?php }  ?>
                </select>
            </div>
            <div class="xs:w-4/12 w-auto mb-4 md:mb-0">
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Data Inicial</p>
                <input name="ranking_date_start" id="ranking_date_start" type="date" value="<?=$d_start;?>" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
            </div>
            <div class="xs:w-4/12 w-auto mb-4 md:mb-0">
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Data Final</p>
                <input name="ranking_date_end" id="ranking_date_end" type="date" value="<?=$d_end;?>" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
            </div>
            <div class="xs:w-5/12 w-auto mb-4 md:mb-0">
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Quantidade</p>
                <select name="top" id="top" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                  <option value="1" <?php if($top == 1){echo 'selected';} ?>>1</option>               
                  <option value="2" <?php if($top == 2){echo 'selected';} ?>>2</option>               
                  <option value="3" <?php if($top == 3){echo 'selected';} ?>>3</option>               
                  <option value="4" <?php if($top == 4){echo 'selected';} ?>>4</option>               
                  <option value="5" <?php if($top == 5){echo 'selected';} ?>>5</option>               
                  <option value="6" <?php if($top == 6){echo 'selected';} ?>>6</option>               
                  <option value="7" <?php if($top == 7){echo 'selected';} ?>>7</option>               
                  <option value="8" <?php if($top == 8){echo 'selected';} ?>>8</option>               
                  <option value="9" <?php if($top == 9){echo 'selected';} ?>>9</option>               
                  <option value="10" <?php if($top == 10){echo 'selected';} ?>>10</option>               
                </select>
            </div>
            <div class="xs:w-auto w-full mb-4 md:mb-0">
                <button class="w-full px-5 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar">Gerar lista</button>
            </div>
        </div>
    </form>
<p class="text-lg text-gray-700 dark:text-gray-200">
           <?php 
            $g_total = 0;
            $i = 1; 
            if($raffle && $top){
              
              if(empty($_GET['ranking_date_start']) || empty($_GET['ranking_date_end'])) {

                $stmt = $conn->prepare("
                    SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
                    o.code, CONCAT(' ', o.product_name) AS product
                    FROM order_list o
                    INNER JOIN customer_list c ON o.customer_id = c.id
                    WHERE o.product_id = ? AND o.status = 2
                    GROUP BY o.customer_id
                    ORDER BY total_quantity DESC
                    LIMIT ?
                ");
                
                if ($stmt === false) {
                    die('Erro na preparação da consulta: ' . $conn->error);
                }
               
                $stmt->bind_param("ii", $raffle, $top);
                $stmt->execute();           
                $requests = $stmt->get_result();
            }else{
                $date_start = isset($d_start) ? new DateTime($d_start) : '';
                $date_end = isset($d_end) ? new DateTime($d_end) : '';
                $date_start_formatted = $date_start->format('Y-m-d') . " 00:00:00";
                $date_end_formatted = $date_end->format('Y-m-d') . " 23:59:59";  
                $stmt = $conn->prepare("
                    SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
                    o.code, CONCAT(' ', o.product_name) AS product, o.date_created
                    FROM order_list o
                    INNER JOIN customer_list c ON o.customer_id = c.id
                    WHERE o.product_id = ? AND o.status = 2
                    AND o.date_created >= ? AND o.date_created <= ?
                    GROUP BY o.customer_id
                    ORDER BY total_quantity DESC
                    LIMIT ?
                ");
                
                if ($stmt === false) {
                    die('Erro na preparação da consulta: ' . $conn->error);
                }
                
                $stmt->bind_param("issi", $raffle, $date_start_formatted, $date_end_formatted, $top);
                $stmt->execute();           
                $requests = $stmt->get_result();
            }

            while ($row = $requests->fetch_assoc()) {

                ?>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400" style="border:1px solid #eee;margin-bottom:10px;padding:10px;">
                      
                    <span>Nome: <?= $row['firstname'] ?> <?= $row['lastname'] ?></span><br>
                    
                    <span class="<?=$enable_raffle_mode_class_phone;?>">Telefone: <?= formatPhoneNumber($row['phone']); ?></span><br>
                    
                    <span>Rifa: <?= $row['product'] ?></span><br>
                    
                    <span>Qtd. Cotas: <?= $row['total_quantity'] ?></span><br>
                    
                    <span>Total: R$ <?= format_num($row['total_amount'],2) ?></span>
                    
                    </p>         

            <?php } ?>

            <?php } ?>
</p>
</div>
</div>
</div>
<!-- Busca Ganhador x Ranking -->

<?php 
$status = isset($_GET['status']) ? $_GET['status'] : '';
$stat_arr = ['Pending Orders', 'Packed Orders', 'Our for Delivery', 'Completed Order']
?>
<div class="flex justify-between items-center my-6">
  <h4 class="font-semibold text-gray-700 dark:text-gray-200">
  Últimos pedidos
</h4>
  <a href="./?page=orders" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
    Ver Todos
  </a>
</div>
<div class="w-full overflow-hidden rounded-lg shadow-xs">

  <div class="w-full overflow-x-auto">
    <table class="w-full whitespace-no-wrap">
      <thead>
          
        <?php 
        // Detecta se o usuário está usando um dispositivo móvel
    $is_mobile = preg_match('/(android|iphone|ipad|ipod)/i', $user_agent);
    
    // Se não for um dispositivo móvel, exibe a largura e altura da tela
    if(!$is_mobile) {
        ?>  
        
        <tr
        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
        >
        <th class="px-4 py-3">ID</th>
        <th class="px-4 py-3">Data</th>
        <th class="px-4 py-3">Sorteio</th>
        <th class="px-4 py-3">Cliente</th>
        <th class="px-4 py-3">Qtd</th>
        <th class="px-4 py-3">Números</th>
        <th class="px-4 py-3">Total</th>
        <th class="px-4 py-3">Status</th>
      </tr>
      
      <?php } else {?>
      

        
        <tr
        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
        >
        <th class="px-4 py-3">ID</th>

      </tr>
      
      <?php } ?>
      
      
    </thead>
    <tbody
    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
    <?php 
    $i = 1;
    $where = "";
    switch($status){
      case 1:
      $where = " where o.`status` = 1 ";
      break;
      case 2:
      $where = " where o.`status` = 2 ";
      break;
      case 3:
      $where = " where o.`status` = 3 ";
      break;

    }

    $qry = $conn->query("
			SELECT o.*, 
				CONCAT(c.firstname, ' ', c.lastname) as customer, 
				p.type_of_draw,
        (
            SELECT GROUP_CONCAT(DISTINCT LPAD(onum.number, FLOOR(LOG10(p.qty_numbers - 1)) + 1, '0') ORDER BY onum.number ASC) 
            FROM order_numbers onum 
            WHERE onum.order_id = o.id
        ) AS o_numbers 
			FROM `order_list` o
			INNER JOIN customer_list c ON o.customer_id = c.id
			INNER JOIN product_list p ON o.product_id = p.id
			$where
			ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC
			LIMIT 10");

      while($row = $qry->fetch_assoc()):
      ?>
      <tr class="text-gray-700 dark:text-gray-400">

        <td class="px-4 py-3">
         #<?= $row['id'] ?>
       </td>

       <td class="px-4 py-3">
         <?= date("d-m-Y", strtotime($row['date_created'])) ?>
       </td>

       <td class="px-4 py-3 text-sm">
        <?= $row['product_name'] ?>
      </td>

      <td class="px-4 py-3 text-sm">
        <?= $row['customer'] ?>   
      </td>

      <td class="px-4 py-3 text-sm">
        <?= $row['quantity']; ?>  
      </td>

      <td class="px-4 py-3 text-sm">
        <div class="order_numbers">
        <?php 
            $vnumbers = $row['o_numbers'] ?? '';
            $nCollection = explode(',' , $vnumbers);
            $qty_nums = count($nCollection);
            $type_of_draw = $row['type_of_draw'];
            if($qty_nums > 0 && $row['status'] != '3'){
                
                  echo '<a class="adm-pedido-numeros" href="javascript:void(0)" @click="openModalNumbers('.$row["id"].')" data-pedido-id="'.$row["id"].'">&#x1F50D;Ver todos';
                  echo '</a>';
                } else {
                    echo 'Sem Números';
                }   
        ?>           
        </div>
        
        
        <?php 
        //     $vnumbers = $row['o_numbers'] ?? '';
        //     $nCollection = explode(',' , $vnumbers);
        //     $qty_nums = count($nCollection);
        //     $type_of_draw = $row['type_of_draw'];
        //     if($qty_nums > 0){
        //         if (0 < $qty_nums) {
        //           echo '<a class="adm-pedido-numeros" href="javascript:void(0)" @click="openModalNumbers('.$row["id"].')" data-pedido-id="'.$row["id"].'"><i class="bi bi-eye-slash"></i> Ver todos';
        //           echo '</a>';
        //         }else{
        //           echo '<div class="leowp-tab">
        //           <input id="leowp-tab-'.$row['id'].'" type="checkbox">
        //           <label for="leowp-tab-'.$row['id'].'">Ver todos</label>
        //           <div class="leowp-content">'.leowp_format_luck_numbers_dashboard($row['o_numbers'], $row['quantity'], $class = false, $opt = true, $type_of_draw).'</div>
        //           </div>';
        //         }
        //     }else{                  
        //       echo leowp_format_luck_numbers_dashboard($row['o_numbers'], $row['quantity'], $class = false, $opt = true, $type_of_draw);
        //     }              
        // ?>           
        </div> 
        
        
        
      </td>
      <td class="px-4 py-3 text-sm">
        R$ <?= format_num($row['total_amount'],2) ?>
      </td>


      <td class="px-4 py-3 text-xs">
        <?php 
        switch($row['status']){
          case 1:
          echo '<span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">Pendente</span>';
          break;
          case 2:
          echo '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Pago</span>';
          break;
          case 3:
          echo '<span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700">Cancelado</span>';
          break;

        }
        ?>        
      </td>


    </tr>
  <?php endwhile; ?>

  <?php 
  // Verificar se não existem pedidos para mostrar feedback
  if($qry->num_rows == 0): 
  ?>
  <tr class="text-gray-700 dark:text-gray-400">
    <td colspan="8" class="px-4 py-8 text-center">
      <div class="flex flex-col items-center justify-center">
        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Nenhum pedido encontrado</p>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ainda não há pedidos registrados no sistema.</p>
      </div>
    </td>
  </tr>
  <?php endif; ?>

</tbody>
</table>

</div>

</div>
<br>
<br>
</div>
</main>

<!-- Modal Numbers More -->
<div x-show="isModalOpenNumbers" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;">
	<!-- Modal -->
	<div x-show="isModalOpenNumbers" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModalNumbers" @keydown.escape="closeModalNumbers" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal-admin" style="display: none;">
		<!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
		<header class="flex justify-end">
			<button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModalNumbers">
				<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
					<path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
				</svg>
			</button>
		</header>
		<div class="mt-4 mb-6">
			<p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
				Pedido #<span x-text="dataId"></span>
			</p>
			<p class="text-sm text-gray-700 dark:text-gray-400">
			    <span class="font-semibold text-gray-700 dark:text-gray-300">QTD.:</span> <span x-text="dataNumbersQtd"></span>
				<span class="font-semibold text-gray-700 dark:text-gray-300">NÚMEROS</span> <span x-text="dataNumbers" class="dataNumbers"></span>
			</p>
		</div>
		<footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
			<button @click="closeModalNumbers" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
				Fechar
			</button>
			<button @click="copyModal" class="copy_data w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
				Copiar
			</button>
		</footer>
	</div>
</div>
<!-- End Modal Numbers More -->
<script>
  $(document).ready(function(){   
  $('#buscar-ganhador').submit(function(e){
    e.preventDefault()

    $.ajax({
      url:_base_url_+"classes/Master.php?f=search_raffle_winner",
      method:'POST',
      type:'POST',
      data:new FormData($(this)[0]),
      dataType:'json',
      cache:false,
      processData:false,
      contentType: false,
      error:err=>{
        //console.log(err)
        //alert('An error occurred')
        $('#name').html('');
        $('#phone').html('');
        $('#date').html('');
        $('#number').html('');
        $('#payment_status').html('');
        $('.winner').text('Nenhum registro foi encontrado');
    },
    success:function(resp){
        if(resp.status == 'success'){
          $('#name').html('<strong>Nome:</strong> ' + resp.name);
          $('#phone').html('<strong>Telefone:</strong><p class="<?=$enable_raffle_mode_class_phone_blur;?>">' + resp.phone+'</p>');
          $('#date').html('<strong>Data da compra:</strong> ' + resp.date);
          $('#number').html('<strong>Número/Bicho:</strong> ' + resp.number);
          $('#payment_status').html('<strong>Status:</strong> ' + resp.payment_status);
          $('.winner').text('');
         //console.log(resp);                                  
        }else{
          $('#name').html('');
          $('#phone').html('').addClass('<?=$enable_raffle_mode_class_phone_blur;?>');
          $('#date').html('');
          $('#number').html('');
          $('#payment_status').html('');
          $('.winner').text('Nenhum registro foi encontrado');
          //console.log(resp)
        }
    }
    })
  })
  
  // Funcionalidade para análise de números
  $('#check-minmax').click(function() {
    const raffleId = $('#raffle_minmax').val();
    
    if (!raffleId) {
      alert('Por favor, selecione um sorteio para analisar.');
      return;
    }
    
    $.ajax({
      url: _base_url_+"classes/Master.php?f=highest_and_lowest_numbers",
      method: 'POST',
      data: {raffle_id: raffleId},
      dataType: 'json',
      success: function(resp) {
        if (resp.status == 'success') {
          // Atualizar os dados exibidos
          $('#raffle-name').text(resp.raffle_name);
          $('#highest-number').text(resp.highest_number);
          $('#lowest-number').text(resp.lowest_number);
          
          // Informações do cliente de forma mais discreta
          $('#highest-client').text(resp.highest_client);
          $('#lowest-client').text(resp.lowest_client);
          
          // Configurar os links dos pedidos
          const highestOrderId = resp.highest_order_id;
          const lowestOrderId = resp.lowest_order_id;
          
          $('#highest-order').text(highestOrderId);
          $('#lowest-order').text(lowestOrderId);
          
          $('#highest-order-link').attr('href', './?page=orders/view_order&id=' + highestOrderId);
          $('#lowest-order-link').attr('href', './?page=orders/view_order&id=' + lowestOrderId);
          
          // Mostrar o resultado
          $('#number-minmax-result div').removeClass('hidden');
        } else {
          $('#raffle-name').text(resp.raffle_name || '-');
          $('#highest-number').text('-');
          $('#lowest-number').text('-');
          $('#highest-client').text('-');
          $('#lowest-client').text('-');
          $('#highest-order').text('-');
          $('#lowest-order').text('-');
          
          // Esconder o resultado
          $('#number-minmax-result div').addClass('hidden');
          
          alert('Nenhum número encontrado para este sorteio.');
        }
      },
      error: function(err) {
        $('#raffle-name').text('-');
        $('#highest-number').text('-');
        $('#lowest-number').text('-');
        $('#highest-client').text('-');
        $('#lowest-client').text('-');
        $('#highest-order').text('-');
        $('#lowest-order').text('-');
        
        // Esconder o resultado
        $('#number-minmax-result div').addClass('hidden');
        
        alert('Ocorreu um erro ao analisar os números.');
      }
    });
  });
  })
</script>