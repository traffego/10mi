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
    
    // Função para limpar o cache do dashboard
    function clearDashboardCache() {
      if (confirm('Deseja limpar o cache do dashboard? A página será recarregada.')) {
        // Limpar todos os tipos de cache que o navegador permite
        try {
          // Limpar cache de aplicação
          if ('caches' in window) {
            caches.keys().then(function(names) {
              names.forEach(function(name) {
                caches.delete(name);
              });
            });
          }
          
          // Limpar service workers
          if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
              for (let registration of registrations) {
                registration.unregister();
              }
            });
          }
          
          // Limpar localStorage para o dashboard
          const dashboardPrefix = 'dashboard_';
          Object.keys(localStorage).forEach(key => {
            if (key.startsWith(dashboardPrefix)) {
              localStorage.removeItem(key);
            }
          });
          
          // Forçar recarregamento sem cache
          const cacheBuster = new Date().getTime();
          window.location.href = window.location.pathname + '?clearcache=' + cacheBuster;
        } catch (e) {
          console.error('Erro ao limpar cache:', e);
          // Se algo der errado, pelo menos recarrega a página
          window.location.reload(true);
        }
      }
    }
  </script>
  <style>
    /* Estilos adicionais para a navbar */
    .nav-item.active {
      border-bottom: 2px solid #9f7aea;
      color: #805ad5 !important;
      background-color: rgba(159, 122, 234, 0.1);
      font-weight: 600;
    }
    .nav-item:hover {
      border-bottom: 2px solid #9f7aea;
      color: #805ad5 !important;
    }
    
    /* Forçar exibição do menu desktop */
    @media (min-width: 768px) {
      .md\:flex {
        display: flex !important;
      }
      .md\:items-center {
        align-items: center !important;
      }
      .md\:space-x-4 > * + * {
        margin-left: 1rem !important;
      }
    }
    
    /* Menu mobile */
    @media (max-width: 767px) {
      .mobile-menu {
        display: block;
        max-height: 0;
        transition: all 0.3s ease-out;
        overflow: hidden;
        z-index: 50;
        opacity: 0;
        transform: translateY(-10px);
      }
      .mobile-menu.show {
        max-height: 800px;
        opacity: 1;
        transform: translateY(0);
        transition: all 0.3s ease-in;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      }
      .mobile-menu nav {
        border-radius: 8px;
        overflow: hidden;
      }
      .mobile-menu .nav-item {
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
        padding: 0.75rem 1rem !important;
        margin-bottom: 2px;
      }
      .mobile-menu .nav-item:hover,
      .mobile-menu .nav-item.active {
        border-left: 3px solid #9f7aea;
        border-bottom: none;
        background-color: rgba(159, 122, 234, 0.1);
      }
    }
    
    /* Garantir que os ícones apareçam */
    .nav-item svg {
      display: inline-block !important;
      min-width: 1.25rem;
      min-height: 1.25rem;
    }

    .navbar-menu .mobile-menu {
      display: block;
      max-height: 0;
      overflow: hidden;
      transition: all 0.4s ease-out;
    }
    
    @media (max-width: 767px) {
      .navbar-menu .mobile-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        z-index: 50;
        border-radius: 0 0 8px 8px;
      }
      
      .navbar-menu .mobile-menu.show {
        max-height: 800px;
        transition: all 0.4s ease-in;
      }
      
      .navbar-menu .mobile-menu .nav-item {
        display: block;
        padding: 0.75rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
        font-weight: 500;
        transition: background-color 0.2s;
      }
      
      .navbar-menu .mobile-menu .nav-item:hover,
      .navbar-menu .mobile-menu .nav-item.active {
        background-color: #f9fafb;
        color: #6b46c1;
      }
    }
    
    .nav-item.active {
      color: #6b46c1;
      font-weight: 600;
      position: relative;
    }
    
    .nav-item.active::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 2px;
      background-color: #6b46c1;
      border-radius: 1px;
    }

    /* Dark mode fixes with more specific selectors */
    .dark .sidebar .sidebar-content a,
    html[class*="theme-dark"] .sidebar .sidebar-content a,
    .theme-dark .sidebar .sidebar-content a,
    :root.theme-dark .sidebar .sidebar-content a {
      color: #e2e8f0 !important;
    }
    
    .dark .sidebar .sidebar-content a:hover,
    html[class*="theme-dark"] .sidebar .sidebar-content a:hover,
    .theme-dark .sidebar .sidebar-content a:hover,
    :root.theme-dark .sidebar .sidebar-content a:hover {
      color: #fff !important;
    }
    
    .dark .sidebar-header h1,
    html[class*="theme-dark"] .sidebar-header h1,
    .theme-dark .sidebar-header h1,
    :root.theme-dark .sidebar-header h1 {
      color: #e2e8f0 !important;
    }
    
    .dark .sidebar-menu li a,
    html[class*="theme-dark"] .sidebar-menu li a,
    .theme-dark .sidebar-menu li a,
    :root.theme-dark .sidebar-menu li a {
      color: #e2e8f0 !important;
    }
    
    .dark .sidebar-menu li a:hover,
    html[class*="theme-dark"] .sidebar-menu li a:hover,
    .theme-dark .sidebar-menu li a:hover,
    :root.theme-dark .sidebar-menu li a:hover {
      color: #fff !important;
    }

    /* Mobile menu dark mode fixes */
    .dark .mobile-menu,
    html[class*="theme-dark"] .mobile-menu,
    .theme-dark .mobile-menu,
    :root.theme-dark .mobile-menu {
      background-color: #1a1c23 !important;
    }
    
    .dark .mobile-menu a,
    .dark .nav-item,
    html[class*="theme-dark"] .mobile-menu a,
    html[class*="theme-dark"] .nav-item,
    .theme-dark .mobile-menu a,
    .theme-dark .nav-item,
    :root.theme-dark .mobile-menu a,
    :root.theme-dark .nav-item {
      color: #e2e8f0 !important;
    }
    
    .dark .mobile-menu a:hover,
    .dark .nav-item:hover,
    html[class*="theme-dark"] .mobile-menu a:hover,
    html[class*="theme-dark"] .nav-item:hover,
    .theme-dark .mobile-menu a:hover,
    .theme-dark .nav-item:hover,
    :root.theme-dark .mobile-menu a:hover,
    :root.theme-dark .nav-item:hover {
      color: #fff !important;
    }
    
    .dark .mobile-menu a.active,
    .dark .nav-item.active,
    html[class*="theme-dark"] .mobile-menu a.active,
    html[class*="theme-dark"] .nav-item.active,
    .theme-dark .mobile-menu a.active,
    .theme-dark .nav-item.active,
    :root.theme-dark .mobile-menu a.active,
    :root.theme-dark .nav-item.active {
      color: #fff !important;
      background-color: rgba(159, 122, 234, 0.2) !important;
    }
    
    /* Desktop menu override */
    .dark nav.hidden.md\:flex .nav-item,
    html[class*="theme-dark"] nav.hidden.md\:flex .nav-item,
    .theme-dark nav.hidden.md\:flex .nav-item,
    :root.theme-dark nav.hidden.md\:flex .nav-item {
      color: #e2e8f0 !important;
    }
    
    .dark nav.hidden.md\:flex .nav-item:hover,
    html[class*="theme-dark"] nav.hidden.md\:flex .nav-item:hover,
    .theme-dark nav.hidden.md\:flex .nav-item:hover,
    :root.theme-dark nav.hidden.md\:flex .nav-item:hover {
      color: #fff !important;
    }
    
    .dark header.z-10.py-4.bg-white,
    html[class*="theme-dark"] header.z-10.py-4.bg-white,
    .theme-dark header.z-10.py-4.bg-white,
    :root.theme-dark header.z-10.py-4.bg-white {
      background-color: #1a1c23 !important;
    }
    
    /* Menu icon color */
    .dark #mobile-menu-button svg,
    html[class*="theme-dark"] #mobile-menu-button svg,
    .theme-dark #mobile-menu-button svg,
    :root.theme-dark #mobile-menu-button svg {
      color: #e2e8f0 !important;
    }

    /* Global layout for sticky footer */
    html, body {
      height: 100%;
    }
    
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    
    main {
      flex: 1 0 auto;
    }
    
    footer {
      flex-shrink: 0;
    }
  </style>
</head>
<body>
  <div class="flex flex-col h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Main Navbar -->
    <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
      <div class="container flex flex-wrap items-center justify-between px-6 mx-auto">
        <!-- Logo e Botão Mobile -->
        <div class="flex items-center">
          <!-- Mobile menu button -->
          <button id="mobile-menu-button" class="md:hidden flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <svg class="h-6 w-6 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path id="menu-open-icon" class="open-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path id="menu-close-icon" class="close-icon hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          
          <!-- Logo -->
          <a
            class="text-lg font-bold text-gray-800 dark:text-gray-200"
            href="./"
    >
    FullRifas V.1
  </a>
</div>
        
        <!-- Mobile menu for small screens, hidden by default -->
        <div id="mobile-menu" class="mobile-menu hidden md:hidden absolute top-full left-0 right-0 z-20 bg-white shadow-lg border-t border-gray-100">
          <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="./" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>">Dashboard</a>
            <a href="./?page=products" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : ''; ?>">Sorteios</a>
            <a href="./?page=orders" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'orders') ? 'active' : ''; ?>">Pedidos</a>
            <a href="./?page=ranking" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'ranking') ? 'active' : ''; ?>">Ranking</a>
            <a href="./?page=customers" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'customers') ? 'active' : ''; ?>">Clientes</a>
            <a href="./?page=user/list" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'user/list') ? 'active' : ''; ?>">Usuários</a>
            <a href="./?page=gateway" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'gateway') ? 'active' : ''; ?>">Gateway</a>
            <a href="./?page=system_info" class="nav-item block px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'system_info') ? 'active' : ''; ?>">Configuração</a>
            <a href="javascript:void(0)" onclick="clearDashboardCache()" class="nav-item block px-3 py-2 text-sm rounded-md bg-gray-100 hover:bg-gray-200 hover:text-purple-700 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600">
              <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
</svg>
              Limpar Cache
            </a>
</div>
</div>
        
        <!-- Desktop navigation menu -->
        <nav class="hidden md:flex md:items-center">
          <a href="./" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>">Dashboard</a>
          <a href="./?page=products" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : ''; ?>">Sorteios</a>
          <a href="./?page=orders" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'orders') ? 'active' : ''; ?>">Pedidos</a>
          <a href="./?page=ranking" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'ranking') ? 'active' : ''; ?>">Ranking</a>
          <a href="./?page=customers" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'customers') ? 'active' : ''; ?>">Clientes</a>
          <a href="./?page=user/list" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'user/list') ? 'active' : ''; ?>">Usuários</a>
          <a href="./?page=gateway" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'gateway') ? 'active' : ''; ?>">Gateway</a>
          <a href="./?page=system_info" class="nav-item px-3 py-2 text-sm rounded-md hover:text-purple-700 transition-colors <?php echo (isset($_GET['page']) && $_GET['page'] == 'system_info') ? 'active' : ''; ?>">Configuração</a>
          <a href="javascript:void(0)" onclick="clearDashboardCache()" class="nav-item px-3 py-2 text-sm rounded-md flex items-center bg-gray-100 hover:bg-gray-200 hover:text-purple-700 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Limpar Cache
          </a>
        </nav>
        
        <!-- Right side tools -->
        <div class="flex items-center space-x-4">
          <!-- Theme toggle -->
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
          
<!-- Profile menu -->
          <div class="relative">
  <button
              class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none border-2 border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-500 transition-colors duration-150"
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
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
  @click.away="closeProfileMenu"
  @keydown.escape="closeProfileMenu"
  class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
  aria-label="submenu"
  >
  <li class="flex">
    <a
    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                    href="<?php echo base_url.'dashboard/?page=user/manage_user&id='.$_settings->userdata('id').'' ?>"
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
          </div>
        </div>
      </div>
      
      <!-- Mobile Menu (Sidebar replacement) -->
      <div 
        class="mobile-menu md:hidden px-6 mt-3"
        :class="{'show': isSideMenuOpen}"
      >
        <nav class="flex flex-col space-y-1 py-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg" style="display: block !important;">
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>"
            href="./"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span style="display: inline !important;">Dashboard</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : ''; ?>"
            href="./?page=products"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span style="display: inline !important;">Sorteios</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'orders') ? 'active' : ''; ?>"
            href="./?page=orders"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
            </svg>
            <span style="display: inline !important;">Pedidos</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'ranking') ? 'active' : ''; ?>"
            href="./?page=ranking"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
            </svg>
            <span style="display: inline !important;">Ranking</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'customers') ? 'active' : ''; ?>"
            href="./?page=customers"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
            </svg>
            <span style="display: inline !important;">Clientes</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'user/list') ? 'active' : ''; ?>"
            href="./?page=user/list"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
              <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
            </svg>
            <span style="display: inline !important;">Usuários</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'gateway') ? 'active' : ''; ?>"
            href="./?page=gateway"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
              <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
              <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
              <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
            </svg>
            <span style="display: inline !important;">Gateway</span>
          </a>
          <a
            class="nav-item px-3 py-3 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 flex items-center rounded-md <?php echo (isset($_GET['page']) && $_GET['page'] == 'system_info') ? 'active' : ''; ?>"
            href="./?page=system_info"
            style="display: flex !important; align-items: center !important;"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" style="display: block !important; min-width: 1.25rem; min-height: 1.25rem;">
              <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
            </svg>
            <span style="display: inline !important;">Configuração</span>
          </a>
        </nav>
</div>
</header>
    
    <div class="flex flex-col flex-1 w-full">
      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          <div class="flex-1 h-full overflow-y-auto">
           <div class="py-4 text-gray-500 dark:text-gray-400">
              <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="./">
              <?php echo $_settings->info('name') ?>
              </a>
              <div>
               <nav class="mt-5 overflow-y-auto" style="display: block !important;">

<script>
  // Definir url base para as requisições
  const base_url = '<?php echo base_url ?>';
  
  // Menu mobile toggle
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOpenIcon = document.getElementById('menu-open-icon');
    const menuCloseIcon = document.getElementById('menu-close-icon');

    // Toggle mobile menu
    mobileMenuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      mobileMenu.classList.toggle('show');
      menuOpenIcon.classList.toggle('hidden');
      menuCloseIcon.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
      if (mobileMenu.classList.contains('show') && !mobileMenu.contains(e.target) && e.target !== mobileMenuButton) {
        mobileMenu.classList.remove('show');
        menuOpenIcon.classList.remove('hidden');
        menuCloseIcon.classList.add('hidden');
      }
    });

    // Prevent menu closing when clicking inside the menu
    mobileMenu.addEventListener('click', function(e) {
      e.stopPropagation();
    });

    // Mark current page in navigation
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
      const href = item.getAttribute('href');
      if (href && currentPath.includes(href) && href !== '/dashboard/') {
        item.classList.add('active');
      } else if (href === '/dashboard/' && (currentPath === '/dashboard/' || currentPath === '/dashboard/index.php' || currentPath === '/dashboard/home.php')) {
        item.classList.add('active');
      }
    });

    // Add smooth hover effect for desktop menu items
    const desktopNavItems = document.querySelectorAll('.hidden.md\\:flex .nav-item');
    desktopNavItems.forEach(item => {
      item.addEventListener('mouseenter', function() {
        this.style.transition = 'all 0.2s ease';
      });
      
      item.addEventListener('mouseleave', function() {
        this.style.transition = 'all 0.2s ease';
      });
    });
  });
</script>