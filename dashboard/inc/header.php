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
  <style>
    /* Estilos adicionais para a navbar */
    .nav-item.active {
      border-bottom: 2px solid #9f7aea;
    }
    .nav-item:hover {
      border-bottom: 2px solid #9f7aea;
    }
    @media (max-width: 768px) {
      .mobile-menu {
        display: none;
      }
      .mobile-menu.show {
        display: block;
      }
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
          <button
            class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
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
          
          <!-- Logo -->
          <a
            class="text-lg font-bold text-gray-800 dark:text-gray-200"
            href="./"
          >
            FullRifas V.1
          </a>
        </div>
        
        <!-- Desktop Navigation -->
        <nav class="hidden md:flex md:items-center md:space-x-4">
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>"
            href="./"
          >
            <span>Dashboard</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : ''; ?>"
            href="./?page=products"
          >
            <span>Sorteios</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'orders') ? 'active' : ''; ?>"
            href="./?page=orders"
          >
            <span>Pedidos</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'ranking') ? 'active' : ''; ?>"
            href="./?page=ranking"
          >
            <span>Ranking</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'customers') ? 'active' : ''; ?>"
            href="./?page=customers"
          >
            <span>Clientes</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'user/list') ? 'active' : ''; ?>"
            href="./?page=user/list"
          >
            <span>Usuários</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'gateway') ? 'active' : ''; ?>"
            href="./?page=gateway"
          >
            <span>Gateway</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'system_info') ? 'active' : ''; ?>"
            href="./?page=system_info"
          >
            <span>Configuração</span>
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
        <nav class="flex flex-col space-y-2 py-4">
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>"
            href="./"
          >
            <span>Dashboard</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : ''; ?>"
            href="./?page=products"
          >
            <span>Sorteios</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'orders') ? 'active' : ''; ?>"
            href="./?page=orders"
          >
            <span>Pedidos</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'ranking') ? 'active' : ''; ?>"
            href="./?page=ranking"
          >
            <span>Ranking</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'customers') ? 'active' : ''; ?>"
            href="./?page=customers"
          >
            <span>Clientes</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'user/list') ? 'active' : ''; ?>"
            href="./?page=user/list"
          >
            <span>Usuários</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'gateway') ? 'active' : ''; ?>"
            href="./?page=gateway"
          >
            <span>Gateway</span>
          </a>
          <a
            class="nav-item px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400 <?php echo (isset($_GET['page']) && $_GET['page'] == 'system_info') ? 'active' : ''; ?>"
            href="./?page=system_info"
          >
            <span>Configuração</span>
          </a>
        </nav>
      </div>
    </header>
    
    <div class="flex flex-col flex-1 w-full">
</body>
</html>