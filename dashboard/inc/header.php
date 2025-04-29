<?php
require_once('sess_auth.php');  
?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
  <?php 
   $pageTitle = isset($_GET['page']) ? $_GET['page'] : '';
   $siteName = $_settings->info('name');   
   if(!$pageTitle){
    echo $siteName;
   }

   if($pageTitle == 'products'){
    echo 'Sorteios - '.$siteName;
   }
   if($pageTitle == 'products/manage_product'){
    echo 'Novo sorteio - '.$siteName;
   }
   if($pageTitle == 'orders'){
    echo 'Pedidos - '.$siteName;
   }
   if($pageTitle == 'orders/view_order'){
    echo 'Visualizar pedido - '.$siteName;
   }
   if($pageTitle == 'ranking'){
    echo 'Ranking de compradores - '.$siteName;
   }
   if($pageTitle == 'customers'){
    echo 'Clientes - '.$siteName;
   }
   if($pageTitle == 'customers/manage_customer'){
    echo 'Editar usuário - '.$siteName;
   }
   if($pageTitle == 'user/list'){
    echo 'Usuários - '.$siteName;
   }

   if($pageTitle == 'gateway'){
    echo 'Gateway de pagamento - '.$siteName;
   }

   if($pageTitle == 'system_info'){
    echo 'Configuração - '.$siteName;
   }

  
  ?>
</title>
  
  <?php if($_settings->info('favicon')){ ?>
   <link rel="shortcut icon" href="<?= validate_image($_settings->info('favicon')); ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= validate_image($_settings->info('favicon')); ?>"> 
  <link rel="icon" type="image/png" sizes="32x32" href="<?= validate_image($_settings->info('favicon')); ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= validate_image($_settings->info('favicon')); ?>">

  <?php } ?>

  <link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
  rel="stylesheet"
  />
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>dashboard/assets/css/tailwind.output.css" />
  <link rel="stylesheet" href="<?php echo base_url ?>dashboard/assets/css/tailwind-bib.css" />
  <script
  src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
  defer
  ></script>
  <script src="<?php echo base_url ?>dashboard/assets/js/init-alpine.js"></script>
  <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
  <script>
    var _base_url_ = '<?php echo base_url ?>';
  </script>
</head>
<body>
  <div
  class="flex h-screen bg-gray-50 dark:bg-gray-900"
  :class="{ 'overflow-hidden': isSideMenuOpen}"
  >
  <!-- Desktop sidebar -->
  <aside
  class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
  >
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a
    class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
    href="#"
    >
    FullRifas V.1
  </a>
  <ul class="mt-6">
    <li class="relative px-6 py-3">
      <a
      class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
      href="./"
      >
      <svg
      class="w-5 h-5"
      aria-hidden="true"
      fill="none"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
      viewBox="0 0 24 24"
      stroke="currentColor"
      >
      <path
      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
      ></path>
    </svg>
    <span class="ml-4">Dashboard</span>
  </a>
</li>
</ul>
<ul>
  <li class="relative px-6 py-3">
    <span
    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
    aria-hidden="true"
    ></span>
    <a
    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
    href="./?page=products"
    >
    <svg
    class="w-5 h-5"
    aria-hidden="true"
    fill="none"
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke-width="2"
    viewBox="0 0 24 24"
    stroke="currentColor"
    >
    <path
    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
    ></path>
  </svg>
  <span class="ml-4">Sorteios</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=orders"
  >
  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
  </svg>
  <span class="ml-4">Pedidos</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=ranking"
  >

  <svg
  class="w-5 h-5"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke="currentColor"
  >
  <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
</svg>
<span class="ml-4">Ranking</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=customers"
  >
  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
  </svg>                
  <span class="ml-4">Clientes</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=user/list"
  >

  <svg
  class="w-5 h-5"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke="currentColor"
  >
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
  <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
</svg>
<span class="ml-4">Usuários</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=gateway"
  >

  <svg  class="w-4 h-4"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke="currentColor">
  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
</svg>

<span class="ml-4">Gateway de pagamento</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=system_info"
  >
  <svg
  class="w-5 h-5"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke-width="2"
  viewBox="0 0 24 24"
  stroke="currentColor"
  >
  <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
</svg>
<span class="ml-4">Configuração</span>
</a>
</li>

</ul>
</div>
</aside>
<!-- Mobile sidebar -->
<!-- Backdrop -->
<div
x-show="isSideMenuOpen"
x-transition:enter="transition ease-in-out duration-150"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in-out duration-150"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
></div>
<aside
class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
x-show="isSideMenuOpen"
x-transition:enter="transition ease-in-out duration-150"
x-transition:enter-start="opacity-0 transform -translate-x-20"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in-out duration-150"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0 transform -translate-x-20"
@click.away="closeSideMenu"
@keydown.escape="closeSideMenu"
>
<div class="py-4 text-gray-500 dark:text-gray-400">
  <a
  class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
  href="#"
  >
  FullRifas V.1
</a>
<ul class="mt-6">
  <li class="relative px-6 py-3">
    <a
    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
    href="index.html"
    >
    <svg
    class="w-5 h-5"
    aria-hidden="true"
    fill="none"
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke-width="2"
    viewBox="0 0 24 24"
    stroke="currentColor"
    >
    <path
    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
    ></path>
  </svg>
  <span class="ml-4">Dashboard</span>
</a>
</li>
</ul>
<ul>
  <li class="relative px-6 py-3">
    <span
    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
    aria-hidden="true"
    ></span>
    <a
    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
    href="./?page=products"
    >
    <svg
    class="w-5 h-5"
    aria-hidden="true"
    fill="none"
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke-width="2"
    viewBox="0 0 24 24"
    stroke="currentColor"
    >
    <path
    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
    ></path>
  </svg>
  <span class="ml-4">Sorteios</span>
</a>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=orders"
  >
  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
  </svg>
  <span class="ml-4">Pedidos</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=ranking"
  >
 <svg
  class="w-5 h-5"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke="currentColor"
  >
  <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
</svg>
<span class="ml-4">Ranking</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
  href="./?page=customers"
  >
  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
  </svg>                
  <span class="ml-4">Clientes</span>
</a>
</li>
<li class="relative px-6 py-3">
 <a
 class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
 href="./?page=user/list"
 >
  <svg
  class="w-5 h-5"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke="currentColor"
  >
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
  <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
</svg>
<span class="ml-4">Usuários</span>
</a>
</li>
<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
  href="./?page=gateway"
  >
 <svg  class="w-4 h-4"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke="currentColor">
  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
</svg>
<span>Gateway de pagamento</span>
</a>

</li>

<li class="relative px-6 py-3">
  <a
  class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
  href="./?page=system_info"
  >
  <svg
  class="w-4 h-4 mr-3"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke-width="2"
  viewBox="0 0 24 24"
  stroke="currentColor"
  >
  <path
  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
  ></path>
  <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
</svg>
<span>Configuração</span>
</a>

</li>

</ul>

</div>
</aside>
<div class="flex flex-col flex-1">
  <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div
    class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
    >
    <!-- Mobile hamburger -->
    <button
    class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
    @click="toggleSideMenu"
    aria-label="Menu"
    >
    <svg
    class="w-6 h-6"
    aria-hidden="true"
    fill="currentColor"
    viewBox="0 0 20 20"
    >
    <path
    fill-rule="evenodd"
    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
    clip-rule="evenodd"
    ></path>
  </svg>
</button>
<!-- Search input -->
<div class="flex justify-center flex-1 lg:mr-32">
  <div
  class="relative w-full max-w-xl mr-6 focus-within:text-purple-500"
  >

  
</div>
</div>
<ul class="flex items-center flex-shrink-0 space-x-6">
  <!-- Theme toggler -->
  <li class="flex">
    <button
    class="rounded-md focus:outline-none focus:shadow-outline-purple"
    @click="toggleTheme"
    aria-label="Toggle color mode"
    >
    <template x-if="!dark">
      <svg
      class="w-5 h-5"
      aria-hidden="true"
      fill="currentColor"
      viewBox="0 0 20 20"
      >
      <path
      d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
      ></path>
    </svg>
  </template>
  <template x-if="dark">
    <svg
    class="w-5 h-5"
    aria-hidden="true"
    fill="currentColor"
    viewBox="0 0 20 20"
    >
    <path
    fill-rule="evenodd"
    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
    clip-rule="evenodd"
    ></path>
  </svg>
</template>
</button>
</li>
<!-- 
<li class="relative">
  <button
  class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
  @click="toggleNotificationsMenu"
  @keydown.escape="closeNotificationsMenu"
  aria-label="Notifications"
  aria-haspopup="true"
  >
  <svg
  class="w-5 h-5"
  aria-hidden="true"
  fill="currentColor"
  viewBox="0 0 20 20"
  >
  <path
  d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
  ></path>
</svg>

<span
aria-hidden="true"
class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"
></span>
</button>
<template x-if="isNotificationsMenuOpen">
  <ul
  x-transition:leave="transition ease-in duration-150"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  @click.away="closeNotificationsMenu"
  @keydown.escape="closeNotificationsMenu"
  class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700"
  aria-label="submenu"
  >
  <li class="flex">
    <a
    class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
    href="#"
    >
    <span>Messages</span>
    <span
    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600"
    >
    13
  </span>
</a>
</li>


<li class="flex">
  <a
  class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
  href="#"
  >
  <span>Sales</span>
  <span
  class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600"
  >
  2
</span>
</a>
</li>
<li class="flex">
  <a
  class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
  href="#"
  >
  <span>Alerts</span>
</a>
</li>-->
</ul>
</template>
</li>
<!-- Profile menu -->
<li class="relative">
  <button
  class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
  @click="toggleProfileMenu"
  @keydown.escape="closeProfileMenu"
  aria-label="Account"
  aria-haspopup="true"
  >
  <img
  class="object-cover w-8 h-8 rounded-full"
  src="<?php echo validate_image($_settings->userdata('avatar')); ?>"
  alt=""
  aria-hidden="true"
  />
</button>
<template x-if="isProfileMenuOpen">
  <ul
  x-transition:leave="transition ease-in duration-150"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  @click.away="closeProfileMenu"
  @keydown.escape="closeProfileMenu"
  class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
  aria-label="submenu"
  >

  <li class="flex">
    <a
    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
    href="<?php echo base_url.'dashboard/?page=user/manage_user&id='.$_settings->userdata('id').'' ?>">
    <svg
    class="w-4 h-4 mr-3"
    aria-hidden="true"
    fill="none"
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke-width="2"
    viewBox="0 0 24 24"
    stroke="currentColor"
    >
    <path
    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
    ></path>
  </svg>
  <span>Minha conta</span>
</a>
</li>
<li class="flex">
  <a
  class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
  href="./?page=system_info"
  >
  <svg
  class="w-4 h-4 mr-3"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke-width="2"
  viewBox="0 0 24 24"
  stroke="currentColor"
  >
  <path
  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
  ></path>
  <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
</svg>
<span>Configuração</span>
</a>
</li>
<li class="flex">
  <a
  class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
  href="<?php echo base_url.'/classes/Login.php?f=logout' ?>"
  >
  <svg
  class="w-4 h-4 mr-3"
  aria-hidden="true"
  fill="none"
  stroke-linecap="round"
  stroke-linejoin="round"
  stroke-width="2"
  viewBox="0 0 24 24"
  stroke="currentColor"
  >
  <path
  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
  ></path>
</svg>
<span>Log out</span>
</a>
</li>
</ul>
</template>
</li>
</ul>
</div>
</header>