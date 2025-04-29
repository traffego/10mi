<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}

	public function query_number_awarded($id,$value){
	
		$resp = null;

		if ($this->root_check_number($id, $value)) {
			$resp = null;
		} else {
			$resp = 1;
		}
		
		return json_encode($resp);
	}

	function save_product(){//ROOT
		$id = $_POST['id'];
		$name = $this->conn->real_escape_string(filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS));
		$description = $this->conn->real_escape_string(filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS));
		$type_of_draw = $this->conn->real_escape_string($_POST['type_of_draw']);
		$qty_numbers = $this->conn->real_escape_string($_POST['qty_numbers']);
		if($type_of_draw == 3){
		$qty_numbers = 25;
		}
		if($type_of_draw == 4){
		$qty_numbers = 50;
		}
		$price = $this->conn->real_escape_string($_POST['price']);
		$price = str_replace('.', '', $price);
		$price = str_replace(',', '.', $price);
		$price = (float) $price;
	
		$min_purchase = $this->conn->real_escape_string($_POST['min_purchase']);
		$max_purchase = $this->conn->real_escape_string($_POST['max_purchase']);
		$status = $this->conn->real_escape_string($_POST['status']);
		$discount_qty = json_encode($_POST['discount_qty']);
		$discount_amount = $_POST['discount_amount']; 
		
		$discount_amount = array_map(function($value) {
			$value = str_replace(',', '.', $value); 
			$value = number_format((float) $value, 2, '.', '');
			return $value;
		}, $discount_amount);
	
		$discount_amount = json_encode($discount_amount);
	
		$draw_name_list = filter_var($_POST['draw_name'], FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		$draw_name_json_str = json_encode($draw_name_list);
		$draw_name_json_escaped = $this->conn->real_escape_string($draw_name_json_str);
	
		$draw_name = $draw_name_json_escaped;
		$draw_number = json_encode($_POST['draw_number']);
	
		if($draw_name == '[""]'){
		 $draw_name = '';
		}
		if($draw_number == '[""]'){
		 $draw_number = '';
		}
	
		$enable_discount = isset($_POST['enable_discount']) ? 1 : 0;
		$enable_discount = $this->conn->real_escape_string($enable_discount);	
	
		$enable_cumulative_discount = isset($_POST['enable_cumulative_discount']) ? 1 : 0;
		$enable_cumulative_discount = $this->conn->real_escape_string($enable_cumulative_discount);	
	
		$ranking_qty = $this->conn->real_escape_string($_POST['ranking_qty']);
		$enable_ranking = isset($_POST['enable_ranking']) ? 1 : 0;
		$enable_ranking = $this->conn->real_escape_string($enable_ranking);	
	
		$ranking_message = $this->conn->real_escape_string($_POST['ranking_message']);
		$enable_ranking_show = isset($_POST['enable_ranking_show']) ? 1 : 0;
		$enable_ranking_show = $this->conn->real_escape_string($enable_ranking_show);
	
		$enable_ranking_date = isset($_POST['enable_ranking_date']) ? 1 : 0;
		$enable_ranking_date = $this->conn->real_escape_string($enable_ranking_date);
	
		$ranking_date_start = $this->conn->real_escape_string($_POST['ranking_date_start']);
		$ranking_date_end = $this->conn->real_escape_string($_POST['ranking_date_end']);
	
		$enable_progress_bar = isset($_POST['enable_progress_bar']) ? 1 : 0;
		$enable_progress_bar = $this->conn->real_escape_string($enable_progress_bar);
	
		$status_display = $this->conn->real_escape_string($_POST['status_display']);
		$subtitle = $this->conn->real_escape_string($_POST['subtitle']);
		//$cotapremiada = $this->conn->real_escape_string($_POST['cotapremiada']);
	
		$d_cotas_premiadas = [];
			if (isset($_POST['aw_number']) && is_array($_POST['aw_number'])) {
				foreach ($_POST['aw_number'] as $index => $aw_number) {
	
					if($this->query_number_awarded($id,$_POST['aw_number'][$index]) == 1) {
						$d_cotas_premiadas[] = [
							'aw_number' => str_pad($_POST['aw_number'][$index], strlen($qty_numbers-1), '0', STR_PAD_LEFT) ?? "",
							'aw_label' => $_POST['aw_label'][$index] ?? "",
							'aw_locked' => false,
							'aw_view' => isset($_POST['aw_view'][$index]) ? true : false
						];
					}else{
						$d_cotas_premiadas[] = [
							'aw_number' => str_pad($_POST['aw_number'][$index], strlen($qty_numbers-1), '0', STR_PAD_LEFT) ?? "",
							'aw_label' => $_POST['aw_label'][$index] ?? "",
							'aw_locked' => isset($_POST['aw_locked'][$index]) ? true : false,
							'aw_view' => isset($_POST['aw_view'][$index]) ? true : false
						];
					}
					
				}
			}
	
		$cotapremiada =  json_encode($d_cotas_premiadas, JSON_UNESCAPED_UNICODE);
		$cotapremiada_descricao = $this->conn->real_escape_string($_POST['cotapremiada_descricao']);
		$date_of_draw = $this->conn->real_escape_string($_POST['date_of_draw']);
		$date_of_draw = $date_of_draw ? "'".$date_of_draw."'" : 'NULL';
		$limit_order_remove = $this->conn->real_escape_string($_POST['limit_order_remove']);
	
		#SALE
		$enable_sale = isset($_POST['enable_sale']) ? 1 : 0;
		$enable_sale = $this->conn->real_escape_string($enable_sale);
		$sale_price = $this->conn->real_escape_string(0);
		$sale_qty = 0;
		$sale_price = str_replace('.', '', $sale_price);
		$sale_price = str_replace(',', '.', $sale_price);
		$sale_price = (float) $sale_price;
	
		#SALE
	
		$private_draw = isset($_POST['private_draw']) ? 1 : 0;
		$private_draw = $this->conn->real_escape_string($private_draw);
		$featured_draw = isset($_POST['featured_draw']) ? 1 : 0;
		$featured_draw = $this->conn->real_escape_string($featured_draw);
	
	
		$slug = slugify($name);
	
		$check = $this->conn->query("SELECT * FROM `product_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Product already exists.";
			return json_encode($resp);
			exit;
		}
	
		$sql = '';
		if(empty($id)){			
			$sql = "INSERT INTO `product_list` (`name`,`description`,`price`,`status`,`type_of_draw`,`qty_numbers`,`min_purchase`,`max_purchase`,`slug`,`ranking_qty`,`enable_ranking`,`enable_progress_bar`,`draw_number`,`status_display`, `subtitle`, `cotapremiada`,  `cotapremiada_descricao`, `date_of_draw`, `limit_order_remove`,`discount_qty`,`discount_amount`,`enable_discount`,`enable_cumulative_discount`,`enable_sale`,`sale_qty`,`sale_price`,`ranking_message`,`enable_ranking_show`,`enable_ranking_date`,`ranking_date_start`,`ranking_date_end`,`draw_winner`,`private_draw`,`featured_draw`) VALUES ('{$name}','{$description}','{$price}','{$status}','{$type_of_draw}','{$qty_numbers}','{$min_purchase}','{$max_purchase}','{$slug}','{$ranking_qty}', '{$enable_ranking}', '{$enable_progress_bar}', '{$draw_number}', '{$status_display}', '{$subtitle}', '{$cotapremiada}', '{$cotapremiada_descricao}', {$date_of_draw}, '{$limit_order_remove}','{$discount_qty}','{$discount_amount}', '{$enable_discount}', '{$enable_cumulative_discount}', '{$enable_sale}', '{$sale_qty}', '{$sale_price}', '{$ranking_message}', '{$enable_ranking_show}', '{$enable_ranking_date}', '{$ranking_date_start}', '{$ranking_date_end}', '{$draw_name}', '{$private_draw}', '{$featured_draw}') ";
	
		}else{		    
			$sql = "UPDATE `product_list`
			SET `name` = '{$name}', `description` = '{$description}', `price` = '{$price}', `status` = '{$status}', `type_of_draw` = '{$type_of_draw}', `qty_numbers` = '{$qty_numbers}', `min_purchase` = '{$min_purchase}', `max_purchase` = '{$max_purchase}', `slug` = '{$slug}', `ranking_qty` = '{$ranking_qty}', `enable_ranking` = '{$enable_ranking}', `enable_progress_bar` = '{$enable_progress_bar}', `draw_number` = '{$draw_number}', `status_display` = '{$status_display}', `subtitle` = '{$subtitle}', `cotapremiada` = '{$cotapremiada}', `cotapremiada_descricao` = '{$cotapremiada_descricao}', `date_of_draw` = {$date_of_draw}, `limit_order_remove` = '{$limit_order_remove}', `discount_qty` = '{$discount_qty}', `discount_amount` = '{$discount_amount}', `enable_discount` = '{$enable_discount}', `enable_cumulative_discount` = '{$enable_cumulative_discount}', `enable_sale` = '{$enable_sale}', `sale_qty` = '{$sale_qty}', `sale_price` = '{$sale_price}', `ranking_message` = '{$ranking_message}', `enable_ranking_show` = '{$enable_ranking_show}', `enable_ranking_date` = '{$enable_ranking_date}', `ranking_date_start` = '{$ranking_date_start}', `ranking_date_end` = '{$ranking_date_end}', `draw_winner` = '{$draw_name}', `private_draw` = '{$private_draw}', `featured_draw` = '{$featured_draw}' WHERE `id` = {$id};";
		}
	
		$save = $this->conn->query($sql);
	
		#echo $this->conn->error;
		#exit;
	
		if($save){		
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['pid'] = $pid;
			$resp['status'] = 'success';
			if(empty($id)){
				$resp['msg'] = 'Product has been addedd successfully';
			}else{
				$resp['msg'] = " Product has been updated successfully.";
			}
	
			if (!empty($_FILES['img']['tmp_name'])) {
				$img_path = "uploads/sorteios";
				if (!is_dir(base_app.$img_path)) {
					mkdir(base_app.$img_path);
				}
				$accept = array('image/jpeg', 'image/png');
				if (!in_array($_FILES['img']['type'], $accept)) {
					$resp['msg'] .= " Image file type is invalid";
				} else {
					if ($_FILES['img']['type'] == 'image/jpeg') {
						$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
					} elseif ($_FILES['img']['type'] == 'image/png') {
						$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
					}
					if (!$uploadfile) {
						$resp['msg'] .= " Image is invalid";
					} else {
						list($width, $height) = getimagesize($_FILES['img']['tmp_name']);
						$desired_width = 600;
						$desired_height = 600;
	
						$source_aspect_ratio = $width / $height;
						$desired_aspect_ratio = $desired_width / $desired_height;
	
						if ($source_aspect_ratio > $desired_aspect_ratio) {
							$temp_height = $desired_height;
							$temp_width = (int)($desired_height * $source_aspect_ratio);
						} else {
							$temp_width = $desired_width;
							$temp_height = (int)($desired_width / $source_aspect_ratio);
						}
	
						$temp_resized = imagecreatetruecolor($temp_width, $temp_height);
						imagecopyresampled($temp_resized, $uploadfile, 0, 0, 0, 0, $temp_width, $temp_height, $width, $height);
	
						$x = ($temp_width - $desired_width) / 2;
						$y = ($temp_height - $desired_height) / 2;
	
						$temp_cropped = imagecrop($temp_resized, ['x' => $x, 'y' => $y, 'width' => $desired_width, 'height' => $desired_height]);
	
						$spath = $img_path.'/'.$_FILES['img']['name'];
						$i = 1;
						while (true) {
							if (is_file(base_app.$spath)) {
								$spath = $img_path.'/'.($i++).'_'.$_FILES['img']['name'];
							} else {
								break;
							}
						}
	
						if ($_FILES['img']['type'] == 'image/jpeg') {
							$upload = imagejpeg($temp_cropped, base_app.$spath, 95);
						} elseif ($_FILES['img']['type'] == 'image/png') {
							$upload = imagepng($temp_cropped, base_app.$spath, 9);
						}
	
						if ($upload) {
							$this->conn->query("UPDATE product_list SET image_path = CONCAT('{$spath}', '?v=', UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) WHERE id = '{$pid}' ");
						}
	
						imagedestroy($temp_cropped);
						imagedestroy($temp_resized);
					}
				}
			}
			#GALERIA
			$on_gallery = isset($_POST['on-gallery']) ? $_POST['on-gallery'] : ''; 
			$image_gallery = empty(array_filter($_FILES['image_gallery']['name']));
	
			if(!$on_gallery && $image_gallery){
				$this->conn->query("UPDATE product_list set image_gallery = '[]' where id = '{$pid}' ");
			}
	
			if (isset($_FILES['image_gallery'])) {
				$img_path = "uploads/sorteios";
				if (!is_dir(base_app.$img_path)) {
					mkdir(base_app.$img_path);
				}
				$accept = array('image/jpeg', 'image/png');
				$image_paths = array();
	
				foreach ($_FILES['image_gallery']['tmp_name'] as $index => $tmp_name) {
					if (!in_array($_FILES['image_gallery']['type'][$index], $accept)) {
						$resp['msg'] .= " Image file type is invalid";
					} else {
						if ($_FILES['image_gallery']['type'][$index] == 'image/jpeg') {
							$uploadfile = imagecreatefromjpeg($tmp_name);
						} elseif ($_FILES['image_gallery']['type'][$index] == 'image/png') {
							$uploadfile = imagecreatefrompng($tmp_name);
						}
						if (!$uploadfile) {
							$resp['msg'] .= " Image is invalid";
						} else {
							list($width, $height) = getimagesize($tmp_name);
							if ($width > 600 || $height > 600) {
								$ratio = $width / $height;
								$new_width = 600;
								$new_height = $new_width / $ratio;
	
								if ($new_height < 600) {
									$new_height = 600;
									$new_width = $new_height * $ratio;
								}
	
								$temp_resized = imagecreatetruecolor($new_width, $new_height);
								imagecopyresampled($temp_resized, $uploadfile, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
								$x = ($new_width - 600) / 2;
								$y = ($new_height - 600) / 2;
	
								$temp_cropped = imagecrop($temp_resized, ['x' => $x, 'y' => $y, 'width' => 600, 'height' => 600]);
	
								if ($temp_cropped) {
									$spath = $img_path.'/'.$_FILES['image_gallery']['name'][$index];
									$i = 1;
									while (true) {
										if (is_file(base_app.$spath)) {
											$spath = $img_path.'/'.($i++).''.$_FILES['image_gallery']['name'][$index];
										} else {
											break;
										}
									}
	
									if ($_FILES['image_gallery']['type'][$index] == 'image/jpeg') {
										$upload = imagejpeg($temp_cropped, base_app.$spath, 95);
									} elseif ($_FILES['image_gallery']['type'][$index] == 'image/png') {
										$upload = imagepng($temp_cropped, base_app.$spath, 9);
									}
	
									if ($upload) {
										$image_paths[] = $spath;
									}
	
									imagedestroy($temp_cropped);
								}
								imagedestroy($temp_resized);
							} else {
								$spath = $img_path.'/'.$_FILES['image_gallery']['name'][$index];
								$i = 1;
								while (true) {
									if (is_file(base_app.$spath)) {
										$spath = $img_path.'/'.($i++).''.$_FILES['image_gallery']['name'][$index];
									} else {
										break;
									}
								}
	
								if ($_FILES['image_gallery']['type'][$index] == 'image/jpeg') {
									$upload = imagejpeg($uploadfile, base_app.$spath, 95);
								} elseif ($_FILES['image_gallery']['type'][$index] == 'image/png') {
									$upload = imagepng($uploadfile, base_app.$spath, 9);
								}
	
								if ($upload) {
									$image_paths[] = $spath;
								}
							}
						}
					}
				}
	
				if ($on_gallery) {
					$on_gallery_arr = [];
					foreach ($on_gallery as $img_gallery) {
						$on_gallery_arr[] = $img_gallery;
					}
					$image_paths = json_encode(array_merge($on_gallery_arr, $image_paths));
				} else {
					$image_paths = json_encode($image_paths, true);
				}
	
				$image_paths_str = $this->conn->real_escape_string($image_paths);
				$this->conn->query("UPDATE product_list SET image_gallery = '{$image_paths_str}' WHERE id = '{$pid}' ");
			}
			#FIM GALERIA
	
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success' && isset($resp['msg']))
			##$this->settings->set_flashdata('success', $resp['msg']);
			return json_encode($resp); 
	}

	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `product_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			#$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function add_to_card() {
		extract($_POST);
		$customer_id = $this->settings->userdata('id');

    // Limpar tabela cart_list para o cliente atual
		$delete = $this->conn->query("DELETE FROM `cart_list` WHERE customer_id = '{$customer_id}'");

		if ($delete) {
			$check = $this->conn->query("SELECT id FROM `cart_list` WHERE customer_id = '{$customer_id}' AND product_id = '{$product_id}'")->num_rows;

			if ($check > 0) {
				$update = $this->conn->query("UPDATE `cart_list` SET quantity = '{$qty}' WHERE customer_id = '{$customer_id}' AND product_id = '{$product_id}'");

				if ($update) {
					$resp['status'] = 'success';
				} else {
					$resp['status'] = 'failed';
					$resp['error'] = $this->conn->error;
				}
			} else {
				$insert = $this->conn->query("INSERT INTO `cart_list` (`customer_id`, `product_id`, `quantity`) VALUES ('{$customer_id}', '{$product_id}', '{$qty}')");

				if ($insert) {
					$resp['status'] = 'success';
				} else {
					$resp['status'] = 'failed';
					$resp['error'] = $this->conn->error;
				}
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		if ($resp['status'] == 'success') {
        // #$this->settings->set_flashdata('success', 'Product has been added to cart.');
		}

		return json_encode($resp);
	}

	function add_to_expres($customer_id,$product_id,$qty) {

		$delete = $this->conn->query("DELETE FROM `cart_list` WHERE customer_id = '{$customer_id}'");

		if ($delete) {
			$check = $this->conn->query("SELECT id FROM `cart_list` WHERE customer_id = '{$customer_id}' AND product_id = '{$product_id}'")->num_rows;

			if ($check > 0) {
				$sql = $this->conn->query("UPDATE `cart_list` SET quantity = '{$qty}' WHERE customer_id = '{$customer_id}' AND product_id = '{$product_id}'");
			} else {
				$sql = $this->conn->query("INSERT INTO `cart_list` (`customer_id`, `product_id`, `quantity`) VALUES ('{$customer_id}', '{$product_id}', '{$qty}')");
			}
			if ($sql) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $this->conn->error;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		return json_encode($resp);
	}

	function update_cart(){
		$cart_id = '';
		$qty = '';
		extract($_POST);
		$update = $this->conn->query("UPDATE `cart_list` set quantity = '{$qty}' where id = '{$cart_id}'");
		if($update){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success'){
			#$this->settings->set_flashdata('success', 'Cart Item has been updated.');
		}
		return json_encode($resp);
	}
	function delete_cart(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `cart_list` where id = '{$id}'");
		if($delete){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success'){
			#$this->settings->set_flashdata('success', 'Cart Item has been deleted.');
		}
		return json_encode($resp);
	}
	public function place_order() {//ROOT
		require_once __DIR__ . '/gaia_lock.php';
		$main_lock_args = ['file' => $_SERVER['DOCUMENT_ROOT'] . '/pedido.lock', 'timeout' => 10];
		$main_lock_data = gaia_get_lock($main_lock_args);
	
		if ($main_lock_data['error']) {
			print('Main Lock Error | ' . $main_lock_data['error'] . '<br>');
			exit();
		}
	
		$customer_id = $this->settings->userdata('id');
		$customer_fname = $this->settings->userdata('firstname');
		$customer_lname = $this->settings->userdata('lastname');
		$customer_phone = $this->settings->userdata('phone');
		$customer_email = $this->settings->userdata('email');
		$customer_name = $customer_fname . ' ' . $customer_lname;
		$dateCreated = date('Y-m-d H:i:s');
		$product_id = $_POST['product_id'];
		$numbers = (isset($_POST['numbers']) ? $_POST['numbers'] : '');
		$pref = date('Ymdhis.u');
		$code = uniqidReal();
		//$ref = $_POST['ref'];
		$order_token = md5($pref . $code);
		$cart_total = $this->conn->query("SELECT SUM(c.quantity * p.price) FROM `cart_list` c INNER JOIN product_list p ON c.product_id = p.id WHERE customer_id = '$customer_id'")->fetch_array()[0];    		
		
		$stmt_plist = $this->conn->prepare('SELECT name, qty_numbers, max_purchase, limit_order_remove, type_of_draw, cotapremiada FROM `product_list` WHERE id = ?');
		$stmt_plist->bind_param('i', $product_id);
		$stmt_plist->execute();
		$product_list = $stmt_plist->get_result();
	
		if (0 < $product_list->num_rows) {
			$product = $product_list->fetch_assoc();
			$product_name = $product['name'];
			$qty_numbers = $product['qty_numbers'];
			$type_of_draw = $product['type_of_draw'];		
			$order_expiration = $product['limit_order_remove'];	
			$cotapremiada = $product['cotapremiada'];
			$max_purchase = $product['max_purchase'];		
		}
	 
		$quantity = $this->conn->query("SELECT SUM(c.quantity) FROM `cart_list` c INNER JOIN product_list p ON c.product_id = p.id WHERE customer_id = '$customer_id'")->fetch_array()[0];
	
		if (!$quantity) {
			$resp['status'] = 'failed';
			$resp['error'] = 'Erro ao criar pedido.';   
			return json_encode($resp);
			exit();
		}
	
		//$limitOrder = 0;
		//$customerOrders = 0;
		//$limitOrdersQuery = $this->conn->query("SELECT limit_orders FROM product_list WHERE id = '$product_id'");
		//if ($limitOrdersQuery && 0 < $limitOrdersQuery->num_rows) {
			//$limitOrder = $limitOrdersQuery->fetch_assoc();
			//$limitOrder = $limitOrder['limit_orders'];
		//}
	
		//$customerOrdersQuery = $this->conn->query("SELECT id FROM order_list WHERE customer_id = '$customer_id' AND product_id = '$product_id'");
		//if ($customerOrdersQuery && 0 < $customerOrdersQuery->num_rows) {
			//$customerOrders = $customerOrdersQuery->num_rows;
		//}
	
		//if ($limitOrder != 0) {
			//if ($limitOrder <= $customerOrders) {
				//$resp['status'] = 'failed';
				//$resp['error'] = 'Você atingiu o limite de pedido(s) para essa campanha.';
				//return json_encode($resp);
				//exit();
			//}
		//}
		$stmt = $this->conn->prepare("
			SELECT 
				discount_qty, 
				enable_discount, 
				discount_amount, 
				enable_cumulative_discount, 
				enable_sale, 
				sale_qty, 
				sale_price, 
				status, 
				qty_numbers, 
				date_of_draw 
			FROM 
				product_list 
			WHERE 
				id = ?
		");
	
		if ($stmt) {
			$stmt->bind_param('i', $product_id);
			$stmt->execute();
			$result = $stmt->get_result();
	
			if ($result && $result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$discount_qty = $row['discount_qty'];
				$enable_discount = $row['enable_discount'];
				$enable_cumulative_discount = $row['enable_cumulative_discount'];
				$discount_amount = $row['discount_amount'];
				$enable_sale = $row['enable_sale'];
				$sale_qty = $row['sale_qty'];
				$sale_price = $row['sale_price'];
				$status = $row['status'];
				$date_of_draw = $row['date_of_draw'];
			}
	
			$stmt->close();
		}
	
		//View root
		$paid_n = 0;
		$pending_n = 0;
	
		$stmt = $this->conn->prepare('SELECT * FROM product_order_status WHERE product_id = ?');
		$stmt->bind_param('i', $product_id);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$paid_n = $row['paid'];
				$pending_n = $row['pending'];
			}
		} 
		$stmt->close();
	
		$totalSales = $paid_n + $pending_n;
	
		if (1 < $status) {
			$resp['status'] = 'failed';
			$resp['error'] = 'Campanha pausada ou finalizada.';   
			return json_encode($resp);
			exit();
		}
	
		if ($qty_numbers <= $totalSales) {
			$this->conn->query("UPDATE product_list SET status = '2', status_display = '3' WHERE id = '$product_id'");
			$resp['status'] = 'failed';
			$resp['error'] = 'Camnpanha pausada ou finalizada.';   
			return json_encode($resp);
			exit();
		}
		
		if ($date_of_draw) {
			$expirationTime = date('Y-m-d H:i:s', strtotime($date_of_draw));
			$currentDateTime = date('Y-m-d H:i:s');
	
			if ($expirationTime < $currentDateTime) {
				$resp['status'] = 'failed';
				$resp['error'] = 'Compra não permitida. A campanha foi pausada ou finalizada.';
				return json_encode($resp);
				exit();
			}
		}
		
		$total_amount = (0 < $cart_total ? $cart_total : 0);
		$pay_status = 1;
	
		if ($total_amount == 0) {
			$pay_status = 2;
		}
	
		$order_discount_amount = '';
		if ($enable_discount && $discount_amount) {
			$discount_qty = json_decode($discount_qty, true);
			$discount_amount = json_decode($discount_amount, true);
			$discounts = [];
	
			foreach ($discount_qty as $qty_index => $qty) {
				foreach ($discount_amount as $amount_index => $amount) {
					if ($qty_index === $amount_index) {
						$discounts[$qty_index] = ['qty' => $qty, 'amount' => $amount];
					}
				}
			}
	
			if ($enable_cumulative_discount == 1) {
				$accumulative_discount = 0;
				$remaining_quantity = $quantity;              
				usort($discounts, function($a, $b) {
					return $b['qty'] - $a['qty'];
				});
	
				foreach ($discounts as $discount) {
					if ($discount['qty'] <= $remaining_quantity) {
						$multiples = floor($remaining_quantity / $discount['qty']);
						$discount_amount = $multiples * $discount['amount'];
						$accumulative_discount += $discount_amount;
						$remaining_quantity -= $multiples * $discount['qty'];
					}
				}
	
				if (0 < $accumulative_discount) {
					$total_amount -= $accumulative_discount;
					$order_discount_amount = $accumulative_discount;
				}
			} 
			else {
				usort($discounts, function($a, $b) {
					return $b['qty'] - $a['qty'];
				});
	
				foreach ($discounts as $discount) {
					if ($discount['qty'] <= $quantity) {
						$total_amount -= $discount['amount'];
						$order_discount_amount = $discount['amount'];
						break;
					}
				}
			}
		}
		if (($enable_sale == 1) && $enable_discount == 0 && $sale_qty <= $quantity) {
			$order_discount_amount = $total_amount - ($quantity * $sale_price);
			$total_amount = $quantity * $sale_price;
		}
	
		$order_numbers = '';       
		$insert = $this->conn->query("INSERT INTO `order_list` (`code`, `customer_id`, `product_name`, `quantity`, `status`, `total_amount`, `order_token`, `order_numbers`, `product_id`, `order_expiration`, `discount_amount`, `date_created`) VALUES ('$code', '$customer_id', '$product_name', '$quantity', '$pay_status', '$total_amount', '$order_token', '$order_numbers', '$product_id', '$order_expiration', '$order_discount_amount', '$dateCreated')");
	
	
		if ($insert) {
			$oid = $this->conn->insert_id;         
			$data = '';            
			$sql_cart = "SELECT c.*, p.name AS product, p.price, p.image_path
			FROM cart_list c
			INNER JOIN product_list p ON c.product_id = p.id
			WHERE customer_id = '$customer_id'";
			$cart = $this->conn->query($sql_cart);
			$qty_numbers = $qty_numbers - 1;
			$total_numbers_generated = $quantity;
			$use_manual_numbers = false; 
	
			if (1 < $type_of_draw) {
				$use_manual_numbers = true; 
			}
	
			if ($use_manual_numbers) {
	
				$all_lucky_numbers = [];
				$cotas_vendidas = [];
				$inserted_count = 0;
	
				$stmt_count = $this->conn->prepare("SELECT GROUP_CONCAT(DISTINCT number ORDER BY number ASC) as numbers FROM order_numbers WHERE product_id = ?");
				$stmt_count->bind_param("i", $product_id);
				$stmt_count->execute();
				$result_count = $stmt_count->get_result();
				$row_count = $result_count->fetch_assoc();
				$stmt_count->close();
	
				if ($row_count && isset($row_count['numbers'])) {
					$numbers_string = $row_count['numbers'];
					$cotas_vendidas = explode(',', $numbers_string);
				}                
				
				//$manual_numbers = $numbers;
				//COTAS PREMIADAS
				$data_aw = json_decode($cotapremiada, true);
				if ($data_aw) {
					foreach ($data_aw as $linha) {
						$aw_number = $linha['aw_number'];
						//$aw_label = $linha['aw_label'];
						$aw_locked = $linha['aw_locked'];
						if($aw_locked == true) {
							$cotas_vendidas[] =  ltrim($aw_number, '0');
						}		 
					}
				}
	
				$all_lucky_numbers = implode(',', $cotas_vendidas);
				$all_lucky_numbers = explode(',', $all_lucky_numbers);
				$cotas_vendidas = array_filter($cotas_vendidas);
				$arrValues = array_filter(explode(',', implode(',', $cotas_vendidas)));
				$result = $this->is_in_array($numbers, $arrValues);
	
				if ($result) {
					$resultNumber = implode(',', $result);
					$resp['status'] = 'failed';
					$resp['error'] = (1 < count($result) ? 'Os números ' . $resultNumber . ' acabaram de ser reservados por outra pessoa. Por favor, escolha outros números' : 'O número ' . $resultNumber . ' acabou de ser reservado por outra pessoa. Por favor, escolha outro número');
					$this->conn->query("DELETE FROM `order_list` WHERE code = '$code'");
					return json_encode($resp);
				}
	
				$stmt_migrate = $this->conn->prepare("INSERT INTO order_numbers (order_id, product_id, number) VALUES (?, ?, ?)");				
	
				$numbers = is_array($numbers) ? implode(',', $numbers) : $numbers;
				$numbers = explode(',', $numbers);
				$numbers = array_map('trim', $numbers);
	
				foreach ($numbers as $number) {
					// Remover zeros à esquerda, gravar '000000' como '0'
					if (ctype_digit($number)) {
						$number = ltrim($number, '0');
						if ($number === '') {
							$number = 0; // Se o número for '000000', ele se torna ''
						}
					} else {
						continue; // Ignorar valores não numéricos
					}
				
					$stmt_migrate->bind_param("iii", $oid, $product_id, $number);
					if ($stmt_migrate->execute()) {
						$inserted_count++;
					}
				}
	
				if ($inserted_count > 0) {
					// Verifica se todos os números foram inseridos
					$stmt_count = $this->conn->prepare("SELECT COUNT(DISTINCT number) as total FROM order_numbers WHERE order_id = ?");
					$stmt_count->bind_param("i", $oid);
					$stmt_count->execute();
					$result_count = $stmt_count->get_result();
					$row_count = $result_count->fetch_assoc();
					$total_unique_numbers = $row_count['total'];
					$stmt_count->close();
	
					if ($total_unique_numbers != $total_numbers_generated) {
						// Exclui todos os números do pedido se a quantidade não for igual
						$stmt_delete = $this->conn->prepare("DELETE FROM order_numbers WHERE order_id = ?");
						$stmt_delete->bind_param("i", $oid);
						$stmt_delete->execute();
						$stmt_delete->close();
	
						$resp['status'] = 'failed';
						$resp['error'] = '[DP01] - Erro ao criar pedido, selecione uma quantidade menor.';
						$this->conn->query("DELETE FROM `order_list` WHERE code = '$code'");
						$insert = $this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Não foi possível gerar todos os números necessários para o pedido #$oid em order_numbers.', '$dateCreated')");
						return json_encode($resp);						
										
					} else {
						$this->conn->query("UPDATE `order_list` SET `order_numbers` = '' WHERE `id` = '$oid'");
						$insert = $this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Total de $total_unique_numbers novas cotas adicionadas ao pedido #$oid em order_numbers.', '$dateCreated')");
					}
	
				}
				//$order_numbers = implode(',', $numbers) . ',';
				//$update = $this->conn->query("UPDATE `order_list` SET `order_numbers` = '$order_numbers' WHERE `code` = '$code'");
			}
			else {
			
				$this->root_gen_numbers($oid, $product_id, $total_numbers_generated);
			}
			if (($this->settings->info('mercadopago') == 1) && 0 < $total_amount) {            
				mercadopago_generate_pix($oid, $total_amount, $customer_name, $customer_email, $order_expiration); 
			}
			if (($this->settings->info('gerencianet') == 1) && 0 < $total_amount) {
				gerencianet_generate_pix($oid, $total_amount, $customer_name, $customer_email, $order_expiration); 
			}
			if (($this->settings->info('paggue') == 1) && 0 < $total_amount) {
				paggue_generate_pix($oid, $total_amount, $customer_name, $customer_email, $order_expiration); 
			}
	
			//if (!empty($ref)) {
				//$referral = $this->conn->query("SELECT status FROM referral WHERE referral_code = '$ref'");
	
	
				//if (0 < $referral->num_rows) {
					//$row = $referral->fetch_assoc();
					//$status_affiliate = $row['status'];
	
					//if ($status_affiliate == 1) {
						//$update = $this->conn->query('UPDATE order_list SET referral_id = ' . $ref . ' WHERE id = ' . $oid);
					//}
				//}
			//}
			
			//if ($this->settings->info('enable_dwapi') == 1) {                
				//$queryPhone = $this->conn->query("SELECT phone FROM customer_list WHERE id = '$customer_id'");
				//if ($queryPhone && 0 < $queryPhone->num_rows) {
					//$customerRow = $queryPhone->fetch_assoc();
					//$customerPhone = $customerRow['phone'];
					//$message = $this->settings->info('mensagem_novo_pedido_dwapi');
					//$queryPIX = $this->conn->query("SELECT pix_code FROM order_list WHERE id = '$oid'");
					//if ($queryPIX && 0 < $queryPIX->num_rows) {
						//$pixRow = $queryPIX->fetch_assoc();
						//$pix_code = $pixRow['pix_code'];
						//$this->send_order_whatsapp($customerPhone, $customer_name, $product_name, $order_numbers, $total_amount, $message, $pix_code);
					//}
				//}
			//}
	
			while ($row = $cart->fetch_assoc()) {
				if (!empty($data)) {
					$data .= ', ';
				}
	
				//$data .= "('" . $oid . "', '" . $row['product_id'] . "', '" . $row['quantity'] . "', '" . $row['price'] . "'), ";
				$data .= "('{$oid}', '{$row['product_id']}', '{$row['quantity']}', '{$row['price']}')";
	
			}
	
			if (!empty($data)) {

				$this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        		$this->conn->set_charset("utf8mb4");

				if (!$this->conn->ping()) {
					$this->reconnect();
				}

				$sql = 'INSERT INTO order_items (`order_id`, `product_id`, `quantity`, `price`) VALUES ' . $data;
				$save = $this->conn->query($sql);
	
				if ($save) {
					$resp['status'] = 'success';
					$this->conn->query("DELETE FROM `cart_list` WHERE customer_id = '$customer_id'");
	
				}
				else {
					$resp['status'] = 'failed';
					$resp['error'] = $this->conn->error;
					$this->conn->query("DELETE FROM `order_list` WHERE id = '$oid'");
	
				}
			}
			else {
				$resp['status'] = 'success';
			}
		} 
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
	
		if ($resp['status'] == 'success') {
			$resp['redirect'] = '/compra/' . $order_token . '';//#$this->settings->set_flashdata('success', 'Order has been placed successfully.');
		}
	
		// if ($this->settings->info('enable_pixel') == 1) {
			//$dados = ['first_name' => $customer_fname, 'last_name' => $customer_lname, 'phone' => '55' . $customer_phone, 'id' => $oid, 'total_amount' => $total_amount];
			//send_event_pixel('InitiateCheckout', $dados);
		//}
	
		if ($status == 1) {
			$query = $this->conn->query("SELECT SUM(quantity) as quantity FROM order_list WHERE product_id = '$product_id' AND status <> 3");
	
			if ($query && 0 < $query->num_rows) {
				$row = $query->fetch_assoc();
				$quantidade = $row['quantity'];
	
				if (($qty_numbers + 1) <= $quantidade) {
					$this->conn->query("UPDATE product_list SET status = '3', status_display = '3' WHERE id = '$product_id'");
	
				}
			}
		}
	
		//order_email($this->settings->info('email_order'), '[' . $this->settings->info('name') . '] - Confirmação de pedido', $oid);
		$main_lock_released = gaia_release_lock($main_lock_data);
		return json_encode($resp);
	}

	function binarySearch($array, $target) {
		$left = 0;
		$right = count($array) - 1;
		
		while ($left <= $right) {
			$mid = $left + intdiv($right - $left, 2);
			
			if ($array[$mid] == $target) {
				return true; // encontrado
			} elseif ($array[$mid] < $target) {
				$left = $mid + 1;
			} else {
				$right = $mid - 1;
			}
		}
		
		return false;
	}

	function get_number_awarded(){
		extract($_POST);
		$resp = $this->root_one_number($id);	
		return json_encode($resp);
	}

	function product_number_awarded() {
		extract($_POST);

		$resp = null;

		$qry = $this->conn->query("SELECT id, cotapremiada FROM product_list WHERE id = '{$id}'");

		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			//$resp = $row['cotapremiada'];

			$data = json_decode($row['cotapremiada'], true);

			if ($data !== null) {
				foreach ($data as &$item) {
					if ($this->root_check_number($id, $item['aw_number'])) {
						$item['aw_preview'] = false;
					} else {
						$item['aw_preview'] = $item['aw_number'];//true
					}
				}
				$resp = $data;
			}
		} 
		
		return json_encode($resp);
	}

	function product_number_customer(){
		extract($_POST);
		$output = [];	
		$resp = null;

		$qry = $this->conn->query("SELECT id, cotapremiada, qty_numbers FROM product_list WHERE id = '{$id}'");

		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			$row['qty_numbers'] = $row['qty_numbers'] - 1;
			$globos = strlen($row['qty_numbers']);

			$data = json_decode($row['cotapremiada'], true);

			if ($data !== null) {
				foreach ($data as &$item) {
					if ($item['aw_number'] == $view) {

						$item['aw_number'] = ltrim($item['aw_number'], '0');
						if ($item['aw_number'] === '') {
							$item['aw_number'] = 0;
						}
			
						$aw_number_condition = "";
						if ($item['aw_number'] === "0" || $item['aw_number'] === 0) {
							$aw_number_condition = " AND FIND_IN_SET('0', (SELECT GROUP_CONCAT(DISTINCT onum.number ORDER BY onum.number ASC) 
															FROM order_numbers onum 
															WHERE onum.order_id = o.id)) > 0";
						} else {
							$aw_number_condition = " AND FIND_IN_SET(?, (SELECT GROUP_CONCAT(DISTINCT onum.number ORDER BY onum.number ASC) 
															FROM order_numbers onum 
															WHERE onum.order_id = o.id)) > 0";
						}
			
						$sql = "
							SELECT c.id, 
								c.firstname, 
								c.lastname, 
								c.phone,
								(
									SELECT GROUP_CONCAT(DISTINCT LPAD(onum.number, FLOOR(LOG10(p.qty_numbers - 1)) + 1, '0') ORDER BY onum.number ASC) 
									FROM order_numbers onum 
									WHERE onum.order_id = o.id
								) AS o_numbers 
							FROM `order_list` o
							INNER JOIN customer_list c ON o.customer_id = c.id
							INNER JOIN product_list p ON o.product_id = p.id
							WHERE 1=1 AND o.product_id = ? $aw_number_condition";
			
						$stmt = $this->conn->prepare($sql);
						if ($item['aw_number'] === "0" || $item['aw_number'] === 0) {
							$stmt->bind_param("i", $id);
						} else {
							$stmt->bind_param("is", $id, $item['aw_number']);
						}
						$stmt->execute();
						$result = $stmt->get_result();
			
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								$output = array(
									"name" => ucfirst(strtolower($row["firstname"] . ' ' . $row["lastname"])),
									"phone" => $row["phone"],
									"number" => str_pad($item['aw_number'], $globos, "0", STR_PAD_LEFT),
									"label" => $item['aw_label'],
									"view" => $item['aw_view']
								);
							}
						}
			
						$stmt->close();
					}
				}
				$resp = $output;
			}
		} 
		
		return json_encode($resp);
	}

	function view_order_numbers() {
		extract($_POST);

		$resp['qtd'] = null;
		$resp['numbers'] = null;

		$stmt = $this->conn->prepare('
		SELECT 
				o.status, 
				o.product_id, 
				o.quantity, 
				p.qty_numbers
			FROM 
				order_list o
			INNER JOIN 
				product_list p ON o.product_id = p.id 
			WHERE 
				o.id = ?
		');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		$resp = [];
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$resp['qtd'] = $row['quantity'];
			$qty_numbers = $row['qty_numbers'] - 1; // Ajusta o qty_numbers conforme a lógica original
			// $resp['numbers'] = $row['order_numbers'];		
			$globos = strlen($qty_numbers);		
		}

		$stmt_count = $this->conn->prepare("
			SELECT GROUP_CONCAT(DISTINCT LPAD(number, ?, '0') ORDER BY number ASC) as numbers 
			FROM order_numbers 
			WHERE order_id = ?
		");

		$stmt_count->bind_param("ii", $globos, $id);
		$stmt_count->execute();
		$result_count = $stmt_count->get_result();
		$row_count = $result_count->fetch_assoc();
		$stmt_count->close();

		if ($row_count !== false && $row_count['numbers'] !== null) {
			$resp['numbers'] = $row_count['numbers'];
		}

		$stmt->close();

		return json_encode($resp);
	}

	public function update_order_status() {//ROOT
		extract($_POST);
		date_default_timezone_set('America/Sao_Paulo');
		$payment_date = date('Y-m-d H:i:s');
	
		$stmt = $this->conn->prepare("
			SELECT 
			o.status, 
			o.product_id, 
			o.quantity, 
			o.code, 
			o.date_created, 
			o.order_expiration,
			o.total_amount,
			o.id_mp,
			p.qty_numbers,
			p.max_purchase
			FROM order_list o
			INNER JOIN product_list p ON o.product_id = p.id
			WHERE o.id = ?
		");
	
		if ($stmt) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$result = $stmt->get_result();
	
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$status_order = $row['status'];
				$product_id = $row['product_id'];
				$quantity = $row['quantity'];		
				$code = $row['code'];
				$id_mp = $row['id_mp'];
				$qty_numbers = $row['qty_numbers'];
				$max_purchase = $row['max_purchase'];
				$dateCreated = $row['date_created'];
				$orderExpiration = $row['order_expiration'];
				$expirationTime = date('Y-m-d H:i:s', strtotime("$dateCreated + $orderExpiration minutes"));
				$currentDateTime = date('Y-m-d H:i:s');
				
				if (($expirationTime < $currentDateTime) && ($orderExpiration > 0) && ($row['status'] == '1')) {//PEDIDO EXPIRADO
					$status = '3';
				}
				
				if (($id_mp) && ($this->check_order_mp($id, $id_mp) == 'approved') && ($row['status'] == '1')) {//PEDIDO PAGO
					$status = '2';
				}
			}
			$stmt->close();
		}
		
		//View root
		$paidNumbers = 0;
		$pendingNumbers = 0;
	
		$stmt = $this->conn->prepare('SELECT * FROM product_order_status WHERE product_id = ?');
		$stmt->bind_param('i', $product_id);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$paidNumbers = $row['paid'];
				$pendingNumbers = $row['pending'];
			}
		} 
		$stmt->close();    
	
		if ($status_order == 3) {
			if ($qty_numbers < ($pendingNumbers + $paidNumbers + $quantity)) {
				$resp['failed'] = 'failed';
				$resp['msg'] = 'Não é possível aprovar este pedido pois ultrapassa a quantidade disponível.';
				return json_encode($resp);
			}
	
			$total_numbers_generated = $quantity;
			$qty_numbers = $qty_numbers - 1;
	
			$query = $this->conn->query("SELECT 
			SUM(quantity) as quantity 
			FROM 
			order_list 
			WHERE 
			product_id = '$product_id' 
			AND status <> 3");
	
			if ($query && $query->num_rows > 0) {
				$row = $query->fetch_assoc();
				$total_ordered_numbers = $row['quantity'];
			}
	
			if (($total_ordered_numbers + $total_numbers_generated) > $qty_numbers || $total_numbers_generated > $max_purchase) {
				$resp['status'] = 'failed';
				$resp['error'] = '[DP01] - Erro ao criar pedido, selecione uma quantidade menor.';
				$this->conn->query("DELETE FROM `order_list` WHERE code = '$code'");
				return json_encode($resp);
			}
	
			//
			$this->root_gen_numbers($id, $product_id, $total_numbers_generated);
			// Verifica se todos os números foram inseridos
			$stmt_count = $this->conn->prepare("SELECT COUNT(DISTINCT number) as total FROM order_numbers WHERE order_id = ?");
			$stmt_count->bind_param("i", $id);
			$stmt_count->execute();
			$result_count = $stmt_count->get_result();
			$row_count = $result_count->fetch_assoc();
			$total_unique_numbers = $row_count['total'];
			$stmt_count->close();
	
			if ($total_unique_numbers != $quantity) {
				$resp['status'] = 'failed';
				$resp['error'] = '[DP01] - Erro ao criar pedido, selecione uma quantidade menor.';
				$this->conn->query("DELETE FROM `order_list` WHERE code = '$code'");
				$this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ADMIN', 'Pedido #$id deletado. Não foi possível gerar os números do pedido #$id - ao atualizar status do pedido.', '$payment_date')");
				
				return json_encode($resp);
			} else {
				$this->conn->query("UPDATE `order_list` SET `order_numbers` = '' WHERE `id` = '$id'");
				$this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ADMIN', 'Todos os números do pedido #$id foram gerados com sucesso - ao atualizar status do pedido.', '$payment_date')");
			}
			//
	
			$update = $this->conn->query("UPDATE `order_list` SET `status` = '$status', `payment_method` = 'Manual', `whatsapp_status` = '', `date_updated` = '$payment_date' WHERE id = '$id'");
		}
		else {
			$update = $this->conn->query("UPDATE `order_list` SET `status` = '$status', `payment_method` = 'Manual', `whatsapp_status` = '', `date_updated` = '$payment_date' WHERE id = '$id'");
	
		}
	
		if ($update) {
	
			$user_name = $this->settings->userdata('firstname');		
			$insert = $this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Pedido $id aprovado manualmente pelo usuário $user_name', '$payment_date')");
			
			if ($status == '3') {
				$result_json = $this->check_order_expired($id);
				$result_array = json_decode($result_json, true);
	
				if (isset($result_array['action']) && $result_array['action'] === 'success') {
					$resp['msg'] = 'Pedido expirado cancelado e enviado para backup';
				}		
			}
	
			$resp['status'] = 'success';
		}
		else {
			$resp['failed'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
	
		$this->revert_product($product_id);
		$query = $this->conn->query("SELECT SUM(quantity) as quantity FROM order_list WHERE product_id = '$product_id' AND status <> 3");
	
		if ($query && 0 < $query->num_rows) {
			$row = $query->fetch_assoc();
			$quantidade = $row['quantity'];
	
			if ($qty_numbers <= $quantidade) {
				$this->conn->query("UPDATE product_list SET status = '3', status_display = '3' WHERE id = '$product_id'");
	
			}
		}
	
		return json_encode($resp);
	}

	function update_whatsapp_status(){
		extract($_POST);
		$status = 1;

		$update = $this->conn->query("UPDATE `order_list` set `whatsapp_status` = '{$status}' where id = '{$id}'");
		if($update){
		$resp['status'] = 'success';

		}else{
			$resp['failed'] = 'failed';
			$resp['msg'] = $this->conn->error;
		} 

		return json_encode($resp);
	}

	public function check_order_status() {//ROOT
		$resp = []; // Inicializa a variável $resp para garantir que ela sempre exista
		if (isset($_POST['order_token'])) { // Verifica se 'order_token' foi enviado no POST
			$order_token = $this->conn->real_escape_string($_POST['order_token']); // Evita SQL injection
			$qry = $this->conn->query("SELECT * FROM order_list WHERE order_token = '$order_token'");
			// Evita SQL injection usando prepared statements seria ainda melhor
	
			if ($qry) {
				if ($qry->num_rows > 0) {
					while ($row = $qry->fetch_assoc()) {
						$resp['status'] = $row['status'];
						$order_id = $row['id'];
						$customer_id = $row['customer_id'];
						$dateCreated = $row['date_created'];
						$orderExpiration = $row['order_expiration'];
						$product_id = $row['product_id'];
						$quantity = $row['quantity'];
						$payment_method = $row['payment_method'];
						$id_mp = $row['id_mp'];
						$expirationTime = date('Y-m-d H:i:s', strtotime("$dateCreated + $orderExpiration minutes"));
						$currentDateTime = date('Y-m-d H:i:s');
	
						if (($expirationTime < $currentDateTime) && ($orderExpiration > 0) && ($row['status'] != '3')) {
							$result_json = $this->check_order_expired($order_id);
							$result_array = json_decode($result_json, true);
						
							if (isset($result_array['action']) && $result_array['action'] === 'success') {
								//$customer_id = $this->settings->userdata('id');
								$add_to_expres = $this->add_to_expres($customer_id, $product_id, $quantity);    
								$add_to_expres_dec = json_decode($add_to_expres, true);	
								$resp['msg'] = 'Pedido expirado cancelado e enviado para backup';
							}
							
							if ($row['status'] != '2' && $payment_method == 'MercadoPago') {
								if (($id_mp) && ($this->check_order_mp($order_id, $id_mp) == 'failed')) {
									$this->revert_product($product_id);
									$resp['status'] = '3';
									$resp['msg'] = 'O pedido nao foi pago';
								}
								continue;
							}
							$this->revert_product($product_id);
						}                    
					}
				}
			} else {
				$resp['status'] = 'deleted';
				$resp['error'] = $this->conn->error;
			}
	
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Order token not provided.';
		}
	
		return json_encode($resp);
	}

	public function check_order_expired($id) {//ROOT

		$qry = $this->conn->query("SELECT o.status, o.product_id, o.quantity, o.code, o.date_created, o.order_expiration, o.total_amount, o.customer_id, o.id_mp 
			FROM order_list o
			INNER JOIN product_list p ON o.product_id = p.id
			WHERE o.id = '$id'");
		$resp = [];
		$status = '0';   
			
		if (0 < $qry->num_rows) {
			$row = $qry->fetch_assoc();
			$status_order = $row['status'];
			$product_id = $row['product_id'];
			$quantity = $row['quantity'];		
			$code = $row['code'];
			$total_amount = $row['total_amount'];
			$customer_id = $row['customer_id'];
			$id_mp = $row['id_mp'];

			$dateCreated = $row['date_created'];
			$orderExpiration = $row['order_expiration'];
			$expirationTime = date('Y-m-d H:i:s', strtotime("$dateCreated + $orderExpiration minutes"));
			$currentDateTime = date('Y-m-d H:i:s');
			if (($expirationTime < $currentDateTime) && ($orderExpiration > 0) && ($row['status'] == '1') || ($expirationTime < $currentDateTime) && ($orderExpiration > 0) && ($row['status'] == '3')) {//PEDIDO EXPIRADO
				$status = '3';
			}

			$customer = $this->conn->query("
				SELECT id, firstname, lastname, phone, email, cpf 
				FROM customer_list
				WHERE id = '$customer_id'");

			if (0 < $customer->num_rows) {
				$row = $customer->fetch_assoc();
				if($status == '3'){
					$c_firstname = isset($row['firstname']) ? $row['firstname'] : '';
					$c_lastname = isset($row['lastname']) ? $row['lastname'] : '';
					$c_email = isset($row['email']) ? $row['email'] : '';
					$c_name = $c_firstname.' '.$c_lastname;	
					$c_phone = isset($row['phone']) ? '55'.$row['phone'].'' : '';			
					$c_cpf = isset($row['cpf']) ? $row['cpf'] : '';			
				}
			}
		}               

		if(isset($status) && $status == '3'){    
			$c_product_list = [
				'qty_numbers',
				'limit_order_remove',
				'price',
				'type_of_draw',
				'cotapremiada'
			];
			
			$c_product_list_str = implode(', ', $c_product_list);
			$product_list = $this->conn->query("
				SELECT {$c_product_list_str}
				FROM product_list
				WHERE id = '$product_id'");            
				
			if (0 < $product_list->num_rows) {
				$row = $product_list->fetch_assoc();
				$qty_numbers = $row['qty_numbers'];
				$p_price = $row['price'];
				$p_type_of_draw = $row['type_of_draw'];			
				$p_cotapremiada = $row['cotapremiada'];  
			}
		
			date_default_timezone_set('America/Sao_Paulo');
			$payment_date = date('Y-m-d H:i:s');

			$qry_columns = $this->conn->query("SHOW COLUMNS FROM order_list");
			if ($qry_columns) {

				$check = $this->conn->query("SELECT * FROM `order_list_expired` where `id` = '{$id}'")->num_rows;

				if($this->capture_err())
					return $this->capture_err();

				if($check > 0){//UPDATE

					$columns = [];

					while ($column = $qry_columns->fetch_assoc()) {
						$columns[] = $column['Field'];
					}
				
					$columns_str = implode(", ", $columns);

					$update_values = [];
					foreach ($columns as $column) {
						if ($column != 'id') {
							$update_values[] = "`$column` = VALUES(`$column`)";
						}
					}

					$update_query = "INSERT INTO order_list_expired ($columns_str) SELECT $columns_str FROM order_list WHERE id = '{$id}' ON DUPLICATE KEY UPDATE " . implode(", ", $update_values);
					$update_insert = $this->conn->query($update_query);

				}else{//INSERT
					$columns = [];

					while ($column = $qry_columns->fetch_assoc()) {
						$columns[] = $column['Field'];
					}
				
					$columns_str = implode(", ", $columns);

					$update_query = "INSERT INTO order_list_expired ($columns_str) SELECT $columns_str FROM order_list WHERE id = '{$id}'";
					$update_insert = $this->conn->query($update_query);
				}

				if ($update_insert) {

					$stmt_count = $this->conn->prepare("SELECT GROUP_CONCAT(DISTINCT number ORDER BY number ASC) as numbers FROM order_numbers WHERE order_id = ?");
					$stmt_count->bind_param("i", $id);
					$stmt_count->execute();
					$result_count = $stmt_count->get_result();
					$row_count = $result_count->fetch_assoc();
					$o_numbers = $row_count['numbers'];
					$stmt_count->close();

					$p_cotapremiada_array = json_decode($p_cotapremiada, true);
					$p_cotapremiada_sql = json_encode($p_cotapremiada_array);
					$p_cotapremiada_sql = trim($p_cotapremiada_sql);

					$update_query = "
						UPDATE `order_list_expired` 
						SET 
							`date_updated` = '" . $this->conn->real_escape_string($payment_date) . "',
							`order_numbers` = '" . $o_numbers . "',						
							`product_price` = '" . $this->conn->real_escape_string($p_price) . "', 
							`product_type_of_draw` = '" . $this->conn->real_escape_string($p_type_of_draw) . "', 
							`product_qty_numbers` = '" . $this->conn->real_escape_string($qty_numbers) . "', 
							`product_cotapremiada` = '" . $this->conn->real_escape_string($p_cotapremiada_sql) . "', 
							`customer_firstname` = '" . $this->conn->real_escape_string($c_firstname) . "', 
							`customer_lastname` = '" . $this->conn->real_escape_string($c_lastname) . "', 
							`customer_phone` = '" . $this->conn->real_escape_string($c_phone) . "', 
							`customer_email` = '" . $this->conn->real_escape_string($c_email) . "', 
							`customer_cpf` = '" . $this->conn->real_escape_string($c_cpf) . "' 
						WHERE id = '{$id}'
					";

					$update_result = $this->conn->query($update_query);

					if ($update_result) {

						$sql_ol = $this->conn->query("UPDATE order_list SET status = '3', date_updated = '$payment_date', whatsapp_status = '' WHERE id = '$id'");
						$insert = $this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Pedido $id expirado cancelado e enviado para backup', '$payment_date')");
						
						$stmt_delete = $this->conn->prepare("DELETE FROM order_numbers WHERE order_id = ?");
						$stmt_delete->bind_param("i", $id);
						$stmt_delete->execute();
						$stmt_delete->close();

						$resp['action'] = 'success';					
					} else {
						$resp['failed'] = 'failed';
						$resp['msg'] = 'Erro ao atualizar os dados para a tabela order_list_expired: ' . $this->conn->error;
						return json_encode($resp);
					}
				}else{
					$resp['failed'] = 'failed';
					$resp['msg'] = 'Erro ao duplicar os dados para a tabela order_list_expired: ' . $this->conn->error;
					return json_encode($resp);
				}
			}

		}else{
			//$resp['failed'] = 'failed';
			//$resp['msg'] = 'O pedido não expirou.';
			//return json_encode($resp);
		}

		return json_encode($resp);	
	}

	public function check_payment_status() {
		$resp = []; // Inicializa a variável $resp para garantir que ela sempre exista
		if (isset($_POST['order_token'])) { // Verifica se 'order_token' foi enviado no POST
			$order_token = $this->conn->real_escape_string($_POST['order_token']); // Evita SQL injection
			$qry = $this->conn->query("SELECT * FROM order_list WHERE order_token = '$order_token'");
			// Evita SQL injection usando prepared statements seria ainda melhor

			if ($qry) {
				if ($qry->num_rows > 0) {
					while ($row = $qry->fetch_assoc()) {
						$resp['status'] = $row['status'];
						$order_id = $row['id'];
						$payment_method = $row['payment_method'];
						$id_mp = $row['id_mp'];

						if ($payment_method == 'MercadoPago' || $payment_method == 'Manual' && $id_mp) {

							if (($id_mp) && ($this->check_order_mp($order_id, $id_mp) == 'approved')){ // Adicionei $this para chamar o método corretamente
								$resp['status_mp'] = 'approved';
							} else {
								$resp['status_mp'] = 'failed';
							}
							
						}
					}
				} else {
					$resp['status'] = 'failed';
					$resp['error'] = 'No order found with the provided token.';
				}
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $this->conn->error;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Order token not provided.';
		}

		return json_encode($resp);
	}

	function export_raffle_contacts(){
		extract($_GET);
		$where = "";
		
		if ($raffle) {
			$where .= " AND o.product_id = '$raffle'";
		}
		
		if ($status) {
			$where .= " AND o.status = '$status'";
		}
		
		if (!empty($where)) {
			$where = " WHERE " . ltrim($where, ' AND');
		}

		$qry = $this->conn->query("SELECT o.*, CONCAT(c.firstname, ' ', c.lastname) as customer, p.type_of_draw, c.phone, o.whatsapp_status
			FROM `order_list` o
			INNER JOIN customer_list c ON o.customer_id = c.id
			INNER JOIN product_list p ON o.product_id = p.id
			$where
			ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC");
		
		if ($qry->num_rows > 0) {
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="contatos-'.base64_encode($raffle).'.csv"');
			header('Pragma: no-cache');
			header('Expires: 0');

			$file = fopen('php://output', 'w');
			fwrite($file, "\xEF\xBB\xBF"); // UTF-8 BOM
			
			while($row = $qry->fetch_assoc()) {        	
				fputcsv($file, array($row['customer'], $row['phone']), ';', ' ');
				#fputcsv($file, array($row['customer'], "'" . $row['phone']), ';', ' ');
			}
			
			fclose($file);
			exit;  
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		
		return json_encode($resp);
	}

	public function delete_order() {//ROOT
		extract($_POST);
		$qry = $this->conn->query("SELECT status, product_id, quantity, id_mp FROM order_list WHERE id = '$id'");
		$payment_date = date('Y-m-d H:i:s');
		$resp = [];

		if ($qry && $qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			$status_order = $row['status'];
			$product_id = $row['product_id'];
			$quantity = $row['quantity'];
			$id_mp = $row['id_mp'];

            if (($id_mp) && ($this->check_order_mp($id, $id_mp) == 'approved') && ($status_order == '1')) {
                $resp['status'] = 'failed';
                $resp['error'] = 'Este pedido foi pago!';
            }else{

                $delete = $this->conn->query("DELETE FROM `order_list` WHERE id = '$id'");
                $this->revert_product($product_id);

                if ($delete) {
                    $resp['status'] = 'success';
                    $user_name = $this->settings->userdata('firstname');				
                    $insert = $this->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Pedido $id deletado pelo usuário $user_name', '$payment_date')");
                } else {
                    $resp['status'] = 'failed';
                    $resp['error'] = $this->conn->error;
                }
            } 
            
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Nenhum resultado encontrado no pedido.';
		}

		return json_encode($resp);
	}

	function contact_send_email(){
		global $_settings;
		extract($_POST);
		$to = $_settings->info('email');
		$message = '';
		$message .= 'Nome: ' . $nome . "\n";
		$message .= 'Telefone: ' . $telefone . "\n";
		$message .= 'Sorteio: ' . $sorteio . "\n";
		$message .= 'Assunto: ' . $assunto . "\n";
		$message .= 'Mensagem: ' . $mensagem . "\n";

		$mailSent = mail($to, $assunto, $message);
		if ($mailSent) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'success';
		}

		return json_encode($resp);
	}

	function recover_password(){
		global $_settings;
		extract($_POST);
		$assunto = 'Recuperação de senha';
		$message = '';
		$senha = '';
		$message .= 'Nova senha: ' . $senha . "\n";

		$qry = $this->conn->query("SELECT * FROM customer_list WHERE email = '{$email}'");
		if ($qry->num_rows > 0) {
			$mailSent = mail($email, $assunto, $message);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
		}


		return json_encode($resp);
	}

	function search_orders_by_phone() {
		$phone = $this->conn->real_escape_string($_POST['phone']); 
		$phone = preg_replace("/[^0-9]/", "", $phone);
		$resp = array();

		$customerQuery = $this->conn->query("
			SELECT id
			FROM customer_list
			WHERE phone = '{$phone}'
			");

		if ($customerQuery && $customerQuery->num_rows > 0) {
			$customerRow = $customerQuery->fetch_assoc();
			$customerId = $customerRow['id'];

			$orderQuery = $this->conn->query("
				SELECT *
				FROM order_list
				WHERE customer_id = '{$customerId}'
				");

			if ($orderQuery && $orderQuery->num_rows > 0) {
				$_SESSION['phone'] = $phone;
				$resp['status'] = 'success';
				$resp['redirect'] = '/meus-numeros';

			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'Nenhum resultado encontrado na tabela order_list para o número de telefone fornecido.';
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Nenhum resultado encontrado na tabela customer_list para o número de telefone fornecido.';
		}

		return json_encode($resp);
	}

	function load_numbers(){//ROOT
		$status = $_POST['status'];
		$id = $_POST['id'];
		$resultado = [];
		$numeros = [];
		$firstnames = [];
		$payment_status = [];
	
		if (in_array($status, [1, 4, 5])) {
			//View root
			$paid_numbers = 0;
			$pending_numbers = 0;
	
			$stmt = $this->conn->prepare('SELECT * FROM product_order_status WHERE product_id = ?');
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$paid_numbers = $row['paid'];
					$pending_numbers = $row['pending'];                
				}
			} 
			$stmt->close();
	
			$stmt_plist = $this->conn->prepare("SELECT qty_numbers FROM `product_list` WHERE id = ?");
			$stmt_plist->bind_param("i", $id);
			$stmt_plist->execute();
			$product_list = $stmt_plist->get_result();
			if ($product_list->num_rows > 0) {
				$product = $product_list->fetch_assoc();
				$qty_numbers = $product["qty_numbers"];            
			}  
			$stmt_plist->close();  
	
			$total_numbers_generated = ($status == 4) ? 25 : (($status == 5) ? 50 : $qty_numbers - ($pending_numbers + $paid_numbers));
			
			if ($status == 1) {//NÚMEROS LIVRES NUMBERS.php
				$all_lucky_numbers = [];
	
				$stmt_count = $this->conn->prepare("SELECT GROUP_CONCAT(DISTINCT number ORDER BY number ASC) as numbers FROM order_numbers WHERE product_id = ?");
				$stmt_count->bind_param("i", $id);
				$stmt_count->execute();
				$result_count = $stmt_count->get_result();
				$row_count = $result_count->fetch_assoc();
				$stmt_count->close();
	
				if ($row_count && isset($row_count['numbers'])) {
					$numbers_string = $row_count['numbers'];
					$all_lucky_numbers = explode(',', $numbers_string);
				}
	
				$used_numbers = array_flip($all_lucky_numbers);
	
				for ($j = 0; $j < $total_numbers_generated; $j++) {
					do {
						$random_number = rand(0, $qty_numbers - 1);
					} while (isset($used_numbers[$random_number]));
	
					$used_numbers[$random_number] = true;
					$numeros[] = str_pad($random_number, strlen($qty_numbers - 1), '0', STR_PAD_LEFT);
				}
			} else {//NÚMEROS LIVRES FARM.php e HALF-FARM.php


				$all_lucky_numbers = [];

				$stmt = $this->conn->prepare("
					SELECT GROUP_CONCAT(onum.number ORDER BY onum.number ASC) as order_numbers, ol.status, cl.firstname
					FROM order_numbers onum
					JOIN order_list ol ON onum.order_id = ol.id
					JOIN customer_list cl ON ol.customer_id = cl.id
					WHERE ol.product_id = ?
					GROUP BY ol.status, cl.firstname
				");

				if (!$stmt) {
					die("Falha na preparação da consulta: " . $this->conn->error);
				}

				$stmt->bind_param("i", $id);
				$stmt->execute();
				$result = $stmt->get_result();

				if (!$result) {
					die("Falha na execução da consulta: " . $stmt->error);
				}

				$firstnames = [];
				$payment_status = [];
				while ($row = $result->fetch_assoc()) {
					$order_numbers = explode(',', $row['order_numbers']);
					foreach ($order_numbers as $numero) {
						$all_lucky_numbers[] = $numero;
						$firstnames[$numero] = $row['firstname'];
						$payment_status[$numero] = $row['status'];
					}
				}

				$stmt->close();
				$all_numbers = range(0, $qty_numbers - 1);

				$numeros = array_map(function($number) {
					return $number;//str_pad($number, 2, '0', STR_PAD_LEFT);
				}, $all_numbers);

				foreach ($all_numbers as $number) {
					$padded_number = $number;//str_pad($number, 2, '0', STR_PAD_LEFT);
					$firstnames[$padded_number] = isset($firstnames[$padded_number]) ? $firstnames[$padded_number] : '';
					$payment_status[$padded_number] = isset($payment_status[$padded_number]) ? $payment_status[$padded_number] : 0;
				}			
			}
		} elseif (in_array($status, [2, 3])) {//NÚMEROS RESERVADOS/PAGOS NUMBERS.php      
			
			$query_status = $status - 1;
			$stmt = $this->conn->prepare("
				SELECT GROUP_CONCAT(onum.number ORDER BY onum.number ASC) as order_numbers, ol.status, cl.firstname
				FROM order_numbers onum
				JOIN order_list ol ON onum.order_id = ol.id
				JOIN customer_list cl ON ol.customer_id = cl.id
				WHERE ol.product_id = ? AND ol.status = ?
				GROUP BY ol.status, cl.firstname
			");
			$stmt->bind_param("ii", $id, $query_status);
			$stmt->execute();
			$result = $stmt->get_result();
	
			while ($row = $result->fetch_assoc()) {
				$order_numbers = explode(',', $row['order_numbers']);
				foreach ($order_numbers as $numero) {
					$numeros[] = $numero;
					$firstnames[$numero] = $row['firstname'];
				}
			}
			$stmt->close();
		}
	
		if (!empty($numeros)) {
			$resultado['status'] = 'success';
			$resultado['numeros'] = $numeros;
			$resultado['nomes'] = $firstnames;
			$resultado['payment_status'] = isset($payment_status) ? $payment_status : '';
		} else {
			$resultado['status'] = 'error';
		}
	
		echo json_encode($resultado);
	}

	function search_raffle_winner(){    
		extract($_POST);

		$resp = array(
			'status' => 'failed',
			'name' => '',
			'phone' => '',
			'raffle' => '',
			'date' => '',
			'payment_status' => '',
			'number' => '',
		);
	
		$stmt = $this->conn->prepare("
			SELECT 
			o.id, o.code, o.date_created, o.status,
			p.name,
			c.firstname, c.lastname, c.phone,
			n.number
			FROM 
			product_list p
			INNER JOIN order_list o ON p.id = o.product_id
			INNER JOIN customer_list c ON o.customer_id = c.id
			INNER JOIN order_numbers n ON o.id = n.order_id
			WHERE 
			p.id = ? AND n.number = ? AND o.status = 2
		");
	  
		if ($stmt === false) {
			$resp['status'] = 'failed';
			return json_encode($resp);
		}
	  
		$stmt->bind_param("is", $raffle, $number);
	  
		if (!$stmt->execute()) {
			$resp['status'] = 'failed';
			return json_encode($resp);
		}
	  
		$result = $stmt->get_result();
	  
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$resp['status'] = 'success';
			$resp['name'] = $row['firstname'] . ' ' . $row['lastname'];
			$resp['phone'] = formatPhoneNumber($row['phone']);
			$resp['raffle'] = $row['name'];
			$resp['date'] = date("d/m/Y H:i", strtotime($row['date_created']));
			$resp['payment_status'] = ($row['status'] == 2) ? 'Pago' : 'Pendente';
			$resp['number'] = $row['number'];
		}
	  
		$stmt->close();
	  
		return json_encode($resp);
	}

	function highest_and_lowest_numbers() {
		extract($_POST);
		
		$resp = array(
			'status' => 'failed',
			'raffle_name' => '',
			'highest_number' => '',
			'highest_client' => '',
			'highest_order_id' => '',
			'lowest_number' => '',
			'lowest_client' => '',
			'lowest_order_id' => ''
		);
		
		// Buscar o nome do sorteio
		$raffle_query = $this->conn->prepare("SELECT name FROM product_list WHERE id = ?");
		if ($raffle_query === false) {
			return json_encode($resp);
		}
		
		$raffle_query->bind_param("i", $raffle_id);
		$raffle_query->execute();
		$raffle_result = $raffle_query->get_result();
		
		if ($raffle_result->num_rows > 0) {
			$raffle_row = $raffle_result->fetch_assoc();
			$resp['raffle_name'] = $raffle_row['name'];
		} else {
			return json_encode($resp);
		}
		
		// Buscar o maior número, com informações do cliente e pedido
		$highest_query = $this->conn->prepare("
			SELECT 
				n.number,
				o.id AS order_id,
				o.code AS order_code,
				CONCAT(c.firstname, ' ', c.lastname) AS client_name
			FROM 
				order_numbers n
			INNER JOIN 
				order_list o ON n.order_id = o.id
			INNER JOIN 
				customer_list c ON o.customer_id = c.id
			WHERE 
				o.product_id = ? AND o.status = 2
			ORDER BY 
				CAST(n.number AS UNSIGNED) DESC
			LIMIT 1
		");
		
		if ($highest_query === false) {
			return json_encode($resp);
		}
		
		$highest_query->bind_param("i", $raffle_id);
		$highest_query->execute();
		$highest_result = $highest_query->get_result();
		
		// Buscar o menor número, com informações do cliente e pedido
		$lowest_query = $this->conn->prepare("
			SELECT 
				n.number,
				o.id AS order_id,
				o.code AS order_code,
				CONCAT(c.firstname, ' ', c.lastname) AS client_name
			FROM 
				order_numbers n
			INNER JOIN 
				order_list o ON n.order_id = o.id
			INNER JOIN 
				customer_list c ON o.customer_id = c.id
			WHERE 
				o.product_id = ? AND o.status = 2
			ORDER BY 
				CAST(n.number AS UNSIGNED) ASC
			LIMIT 1
		");
		
		if ($lowest_query === false) {
			return json_encode($resp);
		}
		
		$lowest_query->bind_param("i", $raffle_id);
		$lowest_query->execute();
		$lowest_result = $lowest_query->get_result();
	 
		if ($highest_result->num_rows > 0 && $lowest_result->num_rows > 0) {
			$highest_row = $highest_result->fetch_assoc();
			$lowest_row = $lowest_result->fetch_assoc();
			
			// Obter o número de dígitos para formatação
			$digits_query = $this->conn->prepare("SELECT qty_numbers FROM product_list WHERE id = ?");
			$digits_query->bind_param("i", $raffle_id);
			$digits_query->execute();
			$digits_result = $digits_query->get_result();
			$digits_row = $digits_result->fetch_assoc();
			
			$qty_numbers = $digits_row['qty_numbers'];
			$num_digits = strlen($qty_numbers) - 1;
			
			// Formatar os números com zeros à esquerda
			$resp['highest_number'] = str_pad($highest_row['number'], $num_digits, '0', STR_PAD_LEFT);
			$resp['highest_client'] = $highest_row['client_name'];
			$resp['highest_order_id'] = $highest_row['order_id'];
			
			$resp['lowest_number'] = str_pad($lowest_row['number'], $num_digits, '0', STR_PAD_LEFT);
			$resp['lowest_client'] = $lowest_row['client_name'];
			$resp['lowest_order_id'] = $lowest_row['order_id'];
			
			$resp['status'] = 'success';
		}
		
		return json_encode($resp);
	}

	public function verify_orders_mp() {
		
		extract($_GET);
		$mercadopago_access_token = $this->settings->info('mercadopago_access_token');
		$orders = $this->conn->query("SELECT o.id, o.id_mp
			FROM order_list o
			WHERE o.status = 3 
			AND o.date_created BETWEEN '$start 00:00:00' AND '$end 23:59:59'
			AND o.product_id = $product
			AND payment_method = 'MercadoPago'");

		if ($orders->num_rows > 0) {
			echo 'Quantidade de pedidos: ' . $orders->num_rows . '<hr>';

			while ($row = $orders->fetch_assoc()) {
				$order_id = $row['id'];
				$url = 'https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&external_reference=' . $order_id . '&range=date_created&begin_date=NOW-5DAYS&end_date=NOW';
				$headers = ['Accept: application/json', 'Authorization: Bearer ' . $mercadopago_access_token];
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$resposta = curl_exec($ch);
				curl_close($ch);
				$payment_info = json_decode($resposta, true);
				$status = $payment_info['results'][0]['status'];
				echo 'Pedido ' . $order_id . ' está com status: ' . $status . ' no Mercado Pago<br>';
			}

			echo '<hr>Fim da verificação de pedidos.';
		} else {
			echo 'Nenhum pedido a ser verificado.';
		}
	}

	function check_order_mp($order_id, $id_mp) {//ROOT
		global $_settings;
		$mercadopago_access_token = $_settings->info('mercadopago_access_token');
		$url = 'https://api.mercadopago.com/v1/payments/' . $id_mp;
		$headers = ['Accept: application/json', 'Authorization: Bearer ' . $mercadopago_access_token];
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$resposta = curl_exec($ch);
		curl_close($ch);
		$payment_info = json_decode($resposta, true);
		$status = $payment_info['status'];

		if ($status == 'approved') {    
			date_default_timezone_set('America/Sao_Paulo');
			$payment_date = date('Y-m-d H:i:s');
			$sql_ol = "UPDATE order_list SET status = '2', date_updated = '$payment_date', whatsapp_status = '' WHERE id = '$order_id'";
			$_settings->conn->query($sql_ol);                
			return 'approved';
		}
		else {
			return 'failed';
		}
	}

	public function revert_product($id) {//ROOT
		global $conn; 
		$paid_numbers = 0;
		$pending_numbers = 0;
	
		$status = '';
		$qty_numbers = 0;
		
		$stmt = $this->conn->prepare("
			SELECT pos.paid, pos.pending, pl.status, pl.qty_numbers 
			FROM product_order_status pos
			INNER JOIN product_list pl ON pos.product_id = pl.id
			WHERE pos.product_id = ?
		");
		
		if ($stmt) {
			$stmt->bind_param('i', $id);    
			$stmt->execute();    
			$result = $stmt->get_result();
		
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$paid_numbers = $row['paid'];
					$pending_numbers = $row['pending'];
					$status = $row['status'];
					$qty_numbers = $row['qty_numbers'];
	
					if ((($pending_numbers + $paid_numbers) < $qty_numbers) && 1 < $status) {
						$update = $conn->query("UPDATE product_list SET status = '1', status_display = '1' WHERE id = '$id'");
					}
				}
			} 
			$stmt->close();
		}
	}

	public function is_in_array($values, $array) {
		$numbers = [];

		foreach ((array) $values as $value) {
			$value = ltrim($value, '0');
			if ($value === '') {
				$value = 0;
			}
			if (in_array($value, $array)) {
				$numbers[] = $value;
			}
		}

		return $numbers;
	}

	//ROOT GENERATE ORDER NUMBERS
	public function root_gen_numbers($order_id, $product_id, $quantity) {//ROOT
		global $_settings;
	 
		$stmt_plist = $_settings->conn->prepare('SELECT qty_numbers, cotapremiada FROM `product_list` WHERE id = ?');
		$stmt_plist->bind_param('i', $product_id);
		$stmt_plist->execute();
		$product_list = $stmt_plist->get_result();
	 
		if (0 < $product_list->num_rows) {
		   $product = $product_list->fetch_assoc();
		   $qty_numbers = $product['qty_numbers'];
		   $qty_numbers = $qty_numbers - 1;
		   $cotapremiada = $product['cotapremiada'];
		}
	 
		$order_date = date('Y-m-d H:i:s');
		$_settings->conn->begin_transaction();
	 
		$stmt_insert = $_settings->conn->prepare("INSERT INTO order_numbers (order_id, product_id, number) VALUES (?, ?, ?)");
	 
		try {
		   $batch_size = 5000; // Tamanho do lote
		   $remaining_quantity = $quantity;
	 
		   while ($remaining_quantity > 0) {
			  // Determina o tamanho do lote para esta iteração
			  $current_batch_size = min($batch_size, $remaining_quantity);
		   
			  // Gera um lote de números
			  $batch_numbers = $this->root_gen_number($current_batch_size, $qty_numbers);
		   
			  // Verifica quais números do lote já existem no banco de dados
			  $placeholders = implode(',', array_fill(0, count($batch_numbers), '?'));
			  $sql_check = "SELECT number 
					   FROM order_numbers  						  
					   WHERE number IN ($placeholders) 
					   AND product_id = ?";
			  $stmt_check = $_settings->conn->prepare($sql_check);
		   
			  // Cria um array com os tipos e os valores dos parâmetros
			  $types = str_repeat('i', count($batch_numbers)) . 'i';
			  $params = array_merge($batch_numbers, [$product_id]);
		   
			  // Usa call_user_func_array para passar os parâmetros
			  $stmt_check->bind_param($types, ...$params);
			  $stmt_check->execute();
			  $result = $stmt_check->get_result();
		   
			  $existing_numbers = [];
			  while ($row = $result->fetch_assoc()) {
				 $existing_numbers[] = $row['number'];
			  }
			  $stmt_check->close();
		   
			  // Cotas premiadas
			  $data_aw = json_decode($cotapremiada, true);
			  if ($data_aw) {
				 foreach ($data_aw as $linha) {
					$aw_number = $linha['aw_number'];
					$aw_locked = $linha['aw_locked'];
					if ($aw_locked == true) {         
					   $aw_number = ltrim($aw_number, '0');
					   if ($aw_number === '') {
						  $aw_number = 0; // Se o número for '000000', ele se torna ''
					   }
					   $existing_numbers[] = $aw_number;
					}         
				 }
			  }
		   
			  // Insere os números que não existem no banco de dados
			  foreach ($batch_numbers as $number) {
				 if (!in_array($number, $existing_numbers)) {
					$stmt_insert->bind_param("iii", $order_id, $product_id, $number);
					$stmt_insert->execute();
					$remaining_quantity--;
		   
					// Se a quantidade atingir 0, saímos do loop
					if ($remaining_quantity === 0) {
					   break 2;
					}
				 }
			  }
		   }
	 
		   $_settings->conn->commit();
		} catch (Exception $e) {
		   $_settings->conn->rollback();
		   throw $e;
		} finally {
		   $stmt_insert->close();
		}
	 
		// Verifica se todos os números foram inseridos
		$stmt_count = $_settings->conn->prepare("SELECT COUNT(DISTINCT number) as total FROM order_numbers WHERE order_id = ?");
		$stmt_count->bind_param("i", $order_id);
		$stmt_count->execute();
		$result_count = $stmt_count->get_result();
		$row_count = $result_count->fetch_assoc();
		$total_unique_numbers = $row_count['total'];
		$stmt_count->close();
	 
		if ($total_unique_numbers != $quantity) {
		   // throw new Exception("Não foi possível gerar todos os números necessários.".$quantity." -".$total_unique_numbers);
		   $resp['status'] = 'failed';
		   $resp['error'] = '[DP01] - Erro ao criar pedido, selecione uma quantidade menor.';
		   $_settings->conn->query("DELETE FROM `order_list` WHERE id = '$order_id'");
		   return json_encode($resp);
	 
		   $insert = $_settings->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Não foi possível gerar todos os números necessários para o pedido #$order_id em order_numbers.', '$order_date')");
		} else {
		   $insert = $_settings->conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('ORDER', 'Total de $total_unique_numbers novas cotas adicionadas ao pedido #$order_id em order_numbers.', '$order_date')");
		}
	}

	//public function root_gen_number($quantity, $qty_numbers) {
		//$globos = strlen($qty_numbers);
		//$intervalo_por_estrato = ceil($qty_numbers / $quantity);
		//$numeros_sorteados = [];

		//for ($i = 0; $i < $quantity; $i++) {
			// Sorteia um número dentro do intervalo do estrato
			//$numero_sorteado = mt_rand($i * $intervalo_por_estrato, min(($i + 1) * $intervalo_por_estrato - 1, $qty_numbers));
			//$numeros_sorteados[] = str_pad($numero_sorteado, $globos, "0", STR_PAD_LEFT);//$numero_sorteado;
		//}

		//shuffle($numeros_sorteados);
		//return $numeros_sorteados;
	//}

	public function root_gen_number($quantity, $qty_numbers) {
		$globos = strlen($qty_numbers);
		$intervalo_por_estrato = ceil($qty_numbers / $quantity);
		$numeros_sorteados = [];

		for ($i = 0; $i < $quantity; $i++) {
			// Sorteia um número dentro do intervalo do estrato
			$min = $i * $intervalo_por_estrato;
			$max = min(($i + 1) * $intervalo_por_estrato - 1, $qty_numbers);
			
			if ($max >= $min) {
				$numero_sorteado = mt_rand($min, $max);
				$numeros_sorteados[] = str_pad($numero_sorteado, $globos, "0", STR_PAD_LEFT);
			} else {
				$numeros_sorteados[] = str_pad($min, $globos, "0", STR_PAD_LEFT);
			}
		}

		shuffle($numeros_sorteados);
		return $numeros_sorteados;
	}

	public function root_check_number($product_id, $number) {
		global $_settings;
		$sql = "SELECT COUNT(*) AS count FROM order_numbers WHERE product_id = ? AND number = ?";
		$stmt = $_settings->conn->prepare($sql);
		$stmt->bind_param("ii", $product_id, $number);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
		return $count == 0;
	}

	public function root_one_number($product_id) {
		global $_settings;
		$resp = null;
		$quantity = 1;

		$stmt_plist = $_settings->conn->prepare('SELECT qty_numbers, cotapremiada FROM `product_list` WHERE id = ?');
		$stmt_plist->bind_param('i', $product_id);
		$stmt_plist->execute();
		$product_list = $stmt_plist->get_result();

		if (0 < $product_list->num_rows) {
			$product = $product_list->fetch_assoc();
			$qty_numbers = $product['qty_numbers'];
			$qty_numbers = $qty_numbers - 1;
			$cotapremiada = $product['cotapremiada'];
		}
		$order_date = date('Y-m-d H:i:s');
		$_settings->conn->begin_transaction();

		try {
			$batch_size = 5000; // Tamanho do lote
			$remaining_quantity = $quantity;

			while ($remaining_quantity > 0) {
				// Determina o tamanho do lote para esta iteração
				$current_batch_size = min($batch_size, $remaining_quantity);
			
				// Gera um lote de números
				$batch_numbers = $this->root_gen_number($current_batch_size, $qty_numbers);
			
				// Verifica quais números do lote já existem no banco de dados
				$placeholders = implode(',', array_fill(0, count($batch_numbers), '?'));
				$sql_check = "SELECT number 
							FROM order_numbers  						  
							WHERE number IN ($placeholders) 
							AND product_id = ?";
				$stmt_check = $_settings->conn->prepare($sql_check);
			
				// Cria um array com os tipos e os valores dos parâmetros
				$types = str_repeat('i', count($batch_numbers)) . 'i';
				$params = array_merge($batch_numbers, [$product_id]);
			
				// Usa call_user_func_array para passar os parâmetros
				$stmt_check->bind_param($types, ...$params);
				$stmt_check->execute();
				$result = $stmt_check->get_result();
			
				$existing_numbers = [];
				while ($row = $result->fetch_assoc()) {
					$existing_numbers[] = $row['number'];
				}
				$stmt_check->close();
			
				// Cotas premiadas
				$data_aw = json_decode($cotapremiada, true);
				if ($data_aw) {
					foreach ($data_aw as $linha) {
						$aw_number = $linha['aw_number'];
						$aw_locked = $linha['aw_locked'];
						if ($aw_locked == true) {         
							$aw_number = ltrim($aw_number, '0');
							if ($aw_number === '') {
								$aw_number = 0;
							}
							$existing_numbers[] = $aw_number;
						}         
					}
				}
			
				foreach ($batch_numbers as $number) {
					if (!in_array($number, $existing_numbers)) {					
						$resp = $number;
						$remaining_quantity--;		

						if ($remaining_quantity === 0) {
							break 2;
						}
					}
				}
			}

			$_settings->conn->commit();
		} catch (Exception $e) {
			$_settings->conn->rollback();
			throw $e;
		}
		
		return $resp;
	}

}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'delete_product':
		echo $Master->delete_product();
		break;
	case 'add_to_card':
		echo $Master->add_to_card();
		break;
	case 'update_cart':
		echo $Master->update_cart();
		break;
	case 'delete_cart':
		echo $Master->delete_cart();
		break;
	case 'place_order':
		echo $Master->place_order();
		break;
	case 'verify_orders_mp':
		echo $Master->verify_orders_mp();
		break;
	case 'delete_order':
		echo $Master->delete_order();
		break;
	case 'view_order_numbers':
		echo $Master->view_order_numbers();
		break;
	case 'product_number_awarded':
		echo $Master->product_number_awarded();
		break;
	case 'product_number_customer':
		echo $Master->product_number_customer();
		break;
	case 'get_number_awarded':
		echo $Master->get_number_awarded();
		break;
	case 'query_number_awarded':
		echo $Master->query_number_awarded();
		break;
 	case 'update_order_status':
		echo $Master->update_order_status();
		break;
	case 'check_order_status':
		echo $Master->check_order_status();
		break;
	case 'check_payment_status':
		echo $Master->check_payment_status();
		break;
	case 'update_whatsapp_status':
		echo $Master->update_whatsapp_status();
		break;
	case 'export_raffle_contacts':
		echo $Master->export_raffle_contacts();
		break;
	case 'search_orders_by_phone':
			echo $Master->search_orders_by_phone();
	break;
	case 'contact_send_email':
		echo $Master->contact_send_email();
		break;
	case 'recover_password':
		echo $Master->recover_password();
		break;
	case 'load_numbers':
		echo $Master->load_numbers();
		break;
	case 'search_raffle_winner':
		echo $Master->search_raffle_winner();
		break;
	case 'highest_and_lowest_numbers':
		echo $Master->highest_and_lowest_numbers();
		break;

	default:
		// echo $sysset->index();
	break;
}