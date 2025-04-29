<?php require_once('../config.php'); ?>
<?php require_once('inc/header.php') ?>
<?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>


<?php 
if(!file_exists($page.".php") && !is_dir($page)){
  exit;
  include '404.php';
}else{
  if(is_dir($page))
    include $page.'/index.php';
  else
    include $page.'.php';

}
?>

<?php require_once('inc/footer.php') ?>
