<?php
ob_start();
ini_set('date.timezone','America/Sao_Paulo');
date_default_timezone_set('America/Sao_Paulo');
session_start();

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');
$db = new DBConnection;
$conn = $db->conn;

function exibir_cabecalho($conn) {
    global $_settings;
    $titulo_site = $_settings->info('name');
    $description = "";
    $image_path = '';
    // Verifique se estamos na página do produto (supondo que você tenha o ID do produto disponível na variável $_GET['id'])
    if (isset($_GET['id'])) {
        $id_produto = $_GET['id'];               
        // Obtenha os dados do produto com base no ID
        $qry = $conn->query("SELECT * from `product_list` where slug = '$id_produto'");

        // Verifique se a consulta retornou resultados
        if ($qry && $qry->num_rows > 0) {
            $row = $qry->fetch_assoc();
            $nome_produto = $row['name'];
            $image_path = validate_image($row['image_path']);
            $description = $row['description'];
            // Atualize o título da página com o nome do produto
            $titulo_pagina = "$nome_produto - $titulo_site";
        } else {
            $url = $_SERVER['REQUEST_URI'];
            if (strpos($url, '/compra/') !== false) {
                $titulo_pagina = "Checkout - $titulo_site";
            }else{
               $titulo_pagina = $titulo_site;

           } 
       }
   } else {
        // Obtenha o caminho da URL
    $url = $_SERVER['REQUEST_URI'];
    $titulo_pagina = $titulo_site;

    if (strpos($url, '/user/compras') !== false) {
        $titulo_pagina = "Compras - $titulo_site";
    } 
    if (strpos($url, '/cadastrar') !== false) {
        $titulo_pagina = "Faça seu cadastro - $titulo_site";
    } 

    if (strpos($url, '/user/atualizar-cadastro') !== false) {
        $titulo_pagina = "Atualizar cadastro - $titulo_site";
    } 

    if (strpos($url, '/meus-numeros') !== false) {
        $titulo_pagina = "Meus números - $titulo_site";
    } 
    if (strpos($url, '/sorteios') !== false) {
        $titulo_pagina = "Sorteios - $titulo_site";
    } 

    if (strpos($url, '/concluidos') !== false) {
        $titulo_pagina = "Concluídos - $titulo_site";
    } 

    if (strpos($url, '/em-breve') !== false) {
        $titulo_pagina = "Em breve - $titulo_site";
    } 

    if (strpos($url, '/ganhadores') !== false) {
        $titulo_pagina = "Ganhadores - $titulo_site";
    } 
    if (strpos($url, '/contato') !== false) {
        $titulo_pagina = "Contato - $titulo_site";
    } 
    if (strpos($url, '/alterar-senha') !== false) {
        $titulo_pagina = "Alterar senha - $titulo_site";
    } 
    if (strpos($url, '/recuperar-senha') !== false) {
        $titulo_pagina = "Recuperação de senha - $titulo_site";
    } 

}

    // Define a descrição da página


    // Define as metatags OpenGraph
$metatags = array(
    'og:title' => $titulo_pagina,
    'og:description' => $description,
    'og:image' => $image_path,
    'og:image:type' => 'image/jpeg',
    'og:image:width' => '',
    'og:image:height' => '',
        // Adicione outras metatags OpenGraph aqui, se necessário
);

    // Exibe as tags do cabeçalho
echo "<title>$titulo_pagina</title>\n";
echo "<meta name='description' content='$description'>\n";

    // Exibe as metatags OpenGraph
foreach ($metatags as $key => $value) {
    echo "<meta property='$key' content='$value'>\n";
}
}

function formatPhoneNumber($phoneNumber) {
    // Remover todos os caracteres que não sejam dígitos
    $phoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

    // Formatar o número de telefone no formato desejado
    $formattedPhoneNumber = "(" . substr($phoneNumber, 0, 2) . ") " . substr($phoneNumber, 2, 5) . "-" . substr($phoneNumber, 7);

    return $formattedPhoneNumber;
}

function redirect($url=''){
	if(!empty($url))
     echo '<script>location.href="'.base_url .$url.'"</script>';
}

function leowp_format_luck_numbers($client_lucky_numbers, $raffle_total_numbers, $class, $opt, $type_of_draw) {
    $bichos = array();
    if($type_of_draw == 3){
        $bichos = array(
            "00" => "Avestruz",
            "01" => "Águia",
            "02" => "Burro",
            "03" => "Borboleta",
            "04" => "Cachorro",
            "05" => "Cabra",
            "06" => "Carneiro",
            "07" => "Camelo",
            "08" => "Cobra",
            "09" => "Coelho",
            "10" => "Cavalo",
            "11" => "Elefante",
            "12" => "Galo",
            "13" => "Gato",
            "14" => "Jacaré",
            "15" => "Leão",
            "16" => "Macaco",
            "17" => "Porco",
            "18" => "Pavão",
            "19" => "Peru",
            "20" => "Touro",
            "21" => "Tigre",
            "22" => "Urso",
            "23" => "Veado",
            "24" => "Vaca"
        );
    } 
    if($type_of_draw == 4){
        $bichos = array(
            "00" => "Avestruz M1",
            "01" => "Avestruz M2",
            "02" => "Águia M1",
            "03" => "Águia M2",
            "04" => "Burro M1",
            "05" => "Burro M2",
            "06" => "Borboleta M1",
            "07" => "Borboleta M2",
            "08" => "Cachorro M1",
            "09" => "Cachorro M2",
            "10" => "Cabra M1",
            "11" => "Cabra M2",
            "12" => "Carneiro M1",
            "13" => "Carneiro M2",
            "14" => "Camelo M1",
            "15" => "Camelo M2",
            "16" => "Cobra M1",
            "17" => "Cobra M2",
            "18" => "Coelho M1",
            "19" => "Coelho M2",
            "20" => "Cavalo M1",
            "21" => "Cavalo M2",
            "22" => "Elefante M1",
            "23" => "Elefante M2",
            "24" => "Galo M1",
            "25" => "Galo M2",
            "26" => "Gato M1",
            "27" => "Gato M2",
            "28" => "Jacaré M1",
            "29" => "Jacaré M2",
            "30" => "Leão M1",
            "31" => "Leão M2",
            "32" => "Macaco M1",
            "33" => "Macaco M2",
            "34" => "Porco M1",
            "35" => "Porco M2",
            "36" => "Pavão M1",
            "37" => "Pavão M2",
            "38" => "Peru M1",
            "39" => "Peru M2",
            "40" => "Touro M1",
            "41" => "Touro M2",
            "42" => "Tigre M1",
            "43" => "Tigre M2",
            "44" => "Urso M1",
            "45" => "Urso M2",
            "46" => "Veado M1",
            "47" => "Veado M2",
            "48" => "Vaca M1",
            "49" => "Vaca M2"
        );  
    }

    if ($client_lucky_numbers !== null) {
        $client_lucky_numbers = explode(',', $client_lucky_numbers);
        $result = '';

        foreach ($client_lucky_numbers as $client_lucky_number) {
            // Remover zeros à esquerda, gravar '000000' como '0'
            $number = ltrim($client_lucky_number, '0');
            if ($number === '') {
                $number = 0; // Se o número for '000000', ele se torna '0'
            }
    
            // Formatar número de acordo com type_of_draw
            if ($type_of_draw == 3 || $type_of_draw == 4) {
                $formatted_number = $number == 0 ? "00" : str_pad($number, 2, "0", STR_PAD_LEFT);
            } else {
                $formatted_number = $client_lucky_number;
            }
    
            // Adicionar ao resultado de acordo com type_of_draw
            if ($type_of_draw == 3 || $type_of_draw == 4) {
                $bicho_name = $bichos[$formatted_number];
                if ($class === false) {
                    $result .= $bicho_name . ', ';
                } else {
                    $result .= '<span class="badge ' . $class . ' me-1">' . $bicho_name . '</span>';
                }
            } else {
                $output = $formatted_number;
                if ($opt == true) {
                    $result .= '<span class="badge ' . $class . ' me-1">' . $output . '</span>';
                } else {
                    $result .= $output . '<span class="comma-hide">,</span>';
                }
            }
        }
        $result = rtrim($result, ', ');
    } else {
        $result = '...';
    }

    echo $result;
}

function leowp_format_luck_numbers_dashboard($client_lucky_numbers, $raffle_total_numbers, $class, $opt, $type_of_draw) {
    $bichos = array();
    if($type_of_draw == 3){
        $bichos = array(
            "00" => "Avestruz",
            "01" => "Águia",
            "02" => "Burro",
            "03" => "Borboleta",
            "04" => "Cachorro",
            "05" => "Cabra",
            "06" => "Carneiro",
            "07" => "Camelo",
            "08" => "Cobra",
            "09" => "Coelho",
            "10" => "Cavalo",
            "11" => "Elefante",
            "12" => "Galo",
            "13" => "Gato",
            "14" => "Jacaré",
            "15" => "Leão",
            "16" => "Macaco",
            "17" => "Porco",
            "18" => "Pavão",
            "19" => "Peru",
            "20" => "Touro",
            "21" => "Tigre",
            "22" => "Urso",
            "23" => "Veado",
            "24" => "Vaca"
        );
    } 
    if($type_of_draw == 4){
        $bichos = array(
            "00" => "Avestruz M1",
            "01" => "Avestruz M2",
            "02" => "Águia M1",
            "03" => "Águia M2",
            "04" => "Burro M1",
            "05" => "Burro M2",
            "06" => "Borboleta M1",
            "07" => "Borboleta M2",
            "08" => "Cachorro M1",
            "09" => "Cachorro M2",
            "10" => "Cabra M1",
            "11" => "Cabra M2",
            "12" => "Carneiro M1",
            "13" => "Carneiro M2",
            "14" => "Camelo M1",
            "15" => "Camelo M2",
            "16" => "Cobra M1",
            "17" => "Cobra M2",
            "18" => "Coelho M1",
            "19" => "Coelho M2",
            "20" => "Cavalo M1",
            "21" => "Cavalo M2",
            "22" => "Elefante M1",
            "23" => "Elefante M2",
            "24" => "Galo M1",
            "25" => "Galo M2",
            "26" => "Gato M1",
            "27" => "Gato M2",
            "28" => "Jacaré M1",
            "29" => "Jacaré M2",
            "30" => "Leão M1",
            "31" => "Leão M2",
            "32" => "Macaco M1",
            "33" => "Macaco M2",
            "34" => "Porco M1",
            "35" => "Porco M2",
            "36" => "Pavão M1",
            "37" => "Pavão M2",
            "38" => "Peru M1",
            "39" => "Peru M2",
            "40" => "Touro M1",
            "41" => "Touro M2",
            "42" => "Tigre M1",
            "43" => "Tigre M2",
            "44" => "Urso M1",
            "45" => "Urso M2",
            "46" => "Veado M1",
            "47" => "Veado M2",
            "48" => "Vaca M1",
            "49" => "Vaca M2"
        );  
    }

    if ($client_lucky_numbers !== null) {
        $client_lucky_numbers = explode(',', $client_lucky_numbers);
        $result = '';

        foreach ($client_lucky_numbers as $client_lucky_number) {
            // Remover zeros à esquerda, gravar '000000' como '0'
            $number = ltrim($client_lucky_number, '0');
            if ($number === '') {
                $number = 0; // Se o número for '000000', ele se torna '0'
            }
    
            // Formatar número de acordo com type_of_draw
            if ($type_of_draw == 3 || $type_of_draw == 4) {
                $formatted_number = $number == 0 ? "00" : str_pad($number, 2, "0", STR_PAD_LEFT);
            } else {
                $formatted_number = $client_lucky_number;
            }
    
            // Adicionar ao resultado de acordo com type_of_draw
            if ($type_of_draw == 3 || $type_of_draw == 4) {
                $bicho_name = $bichos[$formatted_number];
                if ($class === false) {
                    $result .= $bicho_name . ', ';
                } else {
                    $result .= $bicho_name . '<span class="comma-hide">, </span>';
                }
            } else {
                $output = $formatted_number;
                if ($opt == true) {
                    $result .= $output . '<span class="comma-hide">, </span>';
                } else {
                    $result .= $output . ',';
                }
            }
        }
        $result = rtrim($result, ', ');
    } else {
        $result = '...';
    }

    return $result;
}


function leowp_send_whatsapp($order, $code, $status, $customer, $phone, $raffle, $numbers, $quantity, $total, $whatsapp_status, $type_of_draw){
    global $_settings;
    $siteName = $_settings->info('name'); 
    $siteUrl = base_url;
    $numbers = leowp_format_luck_numbers_dashboard($numbers, $quantity, $class = false, $opt = false, $type_of_draw);
    $btn = '';
    #Pendente
    if($status == 1){
    $message = "⚠️ Olá *".$customer."*, evite o cancelamento da sua reserva, o próximo ganhador pode ser você. 😉

    ------------------------------------
    *SORTEIO:* ".$raffle."
    *NÚMERO:* ".$numbers."
    *VALOR TOTAL:* R$ ".$total."
    *STATUS*: 🟠 PENDENTE
    ------------------------------------

    *Para pagar agora, clique no link abaixo* ⤵️
    ".$siteUrl."compra/".md5($code)."

   _Só ganha quem joga!_

   *". $siteName . "*
 ";
  $text = urlencode($message);
        
    }
    #Pago
    if($status == 2){
    $message ="Oii *".$customer."*, seu pagamento foi confirmado com sucesso! ✅

    ------------------------------------
    *SORTEIO:* ".$raffle."
    *NÚMERO:* ".$numbers."
    *VALOR TOTAL:* R$ ".$total."
    *STATUS:* 🟢 PAGO
    ------------------------------------

    _Boa Sorte!_ 🤞🏽🍀

    *". $siteName . "*
    "; 

    $text = urlencode($message);

    }
    #Cancelado
    if($status == 3){
    $message ="❌ RESERVA CANCELADA
            
    Olá *".$customer."*, a reserva *#".$order."*, do sorteio ".$raffle.", *foi cancelada por não ser paga no prazo*.

    🚨 O número/bicho desta reserva foi novamente disponibilizado automaticamente na plataforma. 

    _Atenciosamente,_
 
    *". $siteName . "*
    ";    
    $text = urlencode($message); 
    }

    $btn = '<a class="send-whatsapp" data-post-id="'.$order.'" href="https://api.whatsapp.com/send?phone=55'.$phone.'&text='.$text.'" target="_blank"><img src="'.$siteUrl.'dashboard/assets/img/whatsapp.png" style="height: 30px"></a>';
     if($whatsapp_status){
     $btn = '<a class="send-whatsapp" data-post-id="'.$order.'" href="https://api.whatsapp.com/send?phone=55'.$phone.'&text='.$text.'" target="_blank"><img src="'.$siteUrl.'dashboard/assets/img/whatsapp-sent.png" style="height: 30px"></a>';
     }

    return $btn;
   
}



function slugify($text, $length = null){
    $replacements = [
        '<' => '', '>' => '', '-' => ' ', '&' => '', '"' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae', 'Ä' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae', 'Ç' => 'C', "'" => '', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D', 'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G', 'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I', 'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'L', 'Ľ' => 'L', 'Ĺ' => 'L', 'Ļ' => 'L', 'Ŀ' => 'L', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe', 'Ö' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O', 'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S', 'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T', 'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U', 'Ü' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U', 'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'ae', 'ä' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a', 'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c', 'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h', 'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j', 'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe', 'ö' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe', 'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ś' => 's', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'ue', 'ū' => 'u', 'ü' => 'ue', 'ů' => 'u', 'ű' => 'u', 'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'α' => 'a', 'ß' => 'ss', 'ẞ' => 'b', 'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', '.' => '-', '€' => '-eur-', '$' => '-usd-'
    ];
    // Replace non-ascii characters
    $keys = array_keys($replacements);
    $values = array_values($replacements);

    // Replace non-ascii characters
    $text = str_replace($keys, $values, $text);
    // Replace non letter or digits with "-"
    $text = preg_replace('~[^\pL\d.]+~u', '-', $text);
    // Replace unwanted characters with "-"
    $text = preg_replace('~[^-\w.]+~', '-', $text);
    // Trim "-"
    $text = trim($text, '-');
    // Remove duplicate "-"
    $text = preg_replace('~-+~', '-', $text);
    // Convert to lowercase
    $text = strtolower($text);
    // Limit length
    if (isset($length) && $length < strlen($text))
        $text = rtrim(substr($text, 0, $length), '-');
    return $text;
}

function validate_image($file){
    global $_settings;
    if(!empty($file)){
            // exit;
        $ex = explode("?",$file);
        $file = $ex[0];
        $ts = isset($ex[1]) ? "?".$ex[1] : '';
        if(is_file(base_app.$file)){
         return base_url.$file.$ts;
     }else{
         return ''.base_url.'no_image.jpg';
     }
 }else{
   return ''.base_url.'no_image.jpg';
}
}
function format_num($number = '', $decimal = '', $decimalSeparator = ',', $thousandsSeparator = '.'){
    if(is_numeric($number)){
        $ex = explode(".", $number);
        $decLen = isset($ex[1]) ? strlen($ex[1]) : 0;
        
        if(is_numeric($decimal)){
            return number_format($number, $decimal, $decimalSeparator, $thousandsSeparator);
        } else {
            return number_format($number, $decLen, $decimalSeparator, $thousandsSeparator);
        }
    } else {
        return "Invalid Input";
    }
}

function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}
function date_brazil($format, $timestamp = null) {
    $timestamp = $timestamp ? $timestamp : 'now';
    $timestamp = is_numeric($timestamp) ? date('Y-m-d H:i:s', $timestamp) : $timestamp;
    $date = new \DateTime($timestamp);
    $timezone = new \DateTimeZone('America/Sao_Paulo');
    $date->setTimezone($timezone);
    return $date->format($format);
}

function mercadopago_generate_pix($order_id, $amount, $client_name, $client_email, $order_expiration){
   global $_settings;
   global $conn;
   require_once('gateway/mercadopago/vendor/autoload.php');
   $access_token = $_settings->info('mercadopago_access_token');   
   $minutes_pix_expiration = $order_expiration;
   if($minutes_pix_expiration == 0 || $minutes_pix_expiration < 15){
    $minutes_pix_expiration = 4500;
}
if(!$client_email){
    $client_email = 'supercomprador2024@gmail.com';
}
MercadoPago\SDK::setAccessToken($access_token);

$payment = new MercadoPago\Payment();
$payment->transaction_amount = $amount;
$payment->description = 'Pedido #'.$order_id;
$payment->payment_method_id = "pix";
$payment->payer = array(
    "email" => $client_email,
    "first_name" => $client_name
);

$payment->notification_url = base_url.'webhook.php?notify=mercadopago';
$payment->external_reference = $order_id;

if($minutes_pix_expiration){        
   $payment->date_of_expiration = date_brazil('Y-m-d\TH:i:s.vP', time() + ($minutes_pix_expiration * 60));
}

$payment->save();

$pix_qrcode = $payment->point_of_interaction->transaction_data->qr_code_base64;
$pix_code = $payment->point_of_interaction->transaction_data->qr_code;
$payment_method = 'MercadoPago';

$sql = "UPDATE order_list
SET payment_method = '{$payment_method}', pix_code = '{$pix_code}', pix_qrcode = '{$pix_qrcode}', order_expiration = '{$order_expiration}'
WHERE id = {$order_id}";

if ($conn->query($sql)) {
    // A atualização foi bem-sucedida
    #echo "Atualização realizada com sucesso!";
} else {
    // Ocorreu um erro na atualização
    #echo "Erro na atualização: " . $conn->error;
}
}

# INTEGRAÇÃO GERENCIANET/PIX
function leowp_gn_access_token($api_pix_certificate, $client_id, $client_secret){
    $curl = curl_init();
    $authorization =  base64_encode("$client_id:$client_secret");
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-pix.gerencianet.com.br/oauth/token', 
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{"grant_type": "client_credentials"}',
        CURLOPT_SSLCERT => $api_pix_certificate, 
        CURLOPT_SSLCERTPASSWD => "",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic $authorization",
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}
function leowp_txid($quantity = 35) {
    $txid = 'leowp'.strval(time());
    $quantity = $quantity >= 26 && $quantity <= 35 ? $quantity : 35;
    $chars_str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $chars_len = strlen($chars_str);
    for ($j = 0; $j < $quantity; $j++) {
        if (strlen($txid) >= $quantity) {
            break;
        }
        $current_char = rand(0, $chars_len-1);
        $txid .= $chars_str[$current_char];
    }
    return $txid;
}
function leowp_gn_emite_pix($pix_url_cob, $api_pix_certificate, $body, $tokenType, $accessToken){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $pix_url_cob,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_SSLCERT => $api_pix_certificate,
        CURLOPT_SSLCERTPASSWD => "",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => array(
            "authorization: $tokenType $accessToken",
            "Content-Type: application/json"
        ),
    ));

    $dadosPix = json_decode(curl_exec($curl), true);
    curl_close($curl);
    return $dadosPix;
}
function leowp_gn_setwebhook($tokenType, $client_chave_pix, $accessToken, $api_pix_certificate){
    $webhook_url = base_url.'webhook.php?notify=gerencianet';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-pix.gerencianet.com.br/v2/webhook/'.$client_chave_pix,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_SSLCERT => $api_pix_certificate,
        CURLOPT_SSLCERTPASSWD => "",
        CURLOPT_POSTFIELDS =>'{
            "webhookUrl": "'.$webhook_url.'"
        }',
        CURLOPT_HTTPHEADER => array(
            "authorization: $tokenType $accessToken",
            "x-skip-mtls-checking: true",
            "Content-Type: application/json"
        ),

    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);
    return $response;
}
function leowp_gn_get_qrcode($loc_id, $tokenType, $accessToken, $api_pix_certificate){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-pix.gerencianet.com.br/v2/loc/'.$loc_id.'/qrcode',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSLCERT => $api_pix_certificate,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            "authorization: $tokenType $accessToken",
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);
    return $response;
}

function gerencianet_generate_pix($order_id, $amount, $client_name, $client_email, $order_expiration){  
    global $_settings;
    global $conn;

    $api_pix_certificate = $_SERVER['DOCUMENT_ROOT'].'/pagamentos.pem';
    $client_id = $_settings->info('gerencianet_client_id'); 
    $client_secret = $_settings->info('gerencianet_client_secret');
    $client_chave_pix = $_settings->info('gerencianet_pix_key');

    $dadosToken =  leowp_gn_access_token($api_pix_certificate, $client_id, $client_secret);
    $tokenType = $dadosToken['token_type'];
    $accessToken = $dadosToken['access_token'];
    $txID = leowp_txid();
    $webhook_url = leowp_gn_setwebhook($tokenType, $client_chave_pix, $accessToken, $api_pix_certificate);
    $pix_url_cob = 'https://api-pix.gerencianet.com.br/v2/cob/'.$txID;
    $pix_expire = $order_expiration;
    $pix_expire_time = $pix_expire * 60;
    if(!$pix_expire || $pix_expire == '0'){
        $pix_expire_time = 260000;  
    }
    

    $body = [
      "calendario" => [
          "expiracao" => $pix_expire_time
      ],    
      "valor" => [
          "original" => $amount
      ],
      "chave" => $client_chave_pix, 
      "solicitacaoPagador" => 'Reserva #'.$order_id,
      "infoAdicionais" => [
          [
            "nome" => "Pedido", 
            "valor" => 'Reserva #'.$order_id
        ]

    ]
];

$dados = leowp_gn_emite_pix($pix_url_cob, $api_pix_certificate, $body, $tokenType, $accessToken);
$loc_id = $dados['loc']['id'];
$pix = leowp_gn_get_qrcode($loc_id, $tokenType, $accessToken, $api_pix_certificate); 
$pix_code = $pix['qrcode'];
$pix_qrcode = $pix['imagemQrcode'];
$txid = $dados['txid'];
$payment_method = 'Gerencianet';

$sql = "UPDATE order_list
SET payment_method = '{$payment_method}', pix_code = '{$pix_code}', pix_qrcode = '{$pix_qrcode}', order_expiration = '{$order_expiration}', txid = '{$txid}'
WHERE id = {$order_id}";

if ($conn->query($sql)) {
    // A atualização foi bem-sucedida
    #echo "Atualização realizada com sucesso!";
} else {
    // Ocorreu um erro na atualização
    #echo "Erro na atualização: " . $conn->error;
}

}
#Fim Gerencianet

#Paggue
function decode_brcode($brcode){
   $n=0;
   while($n < strlen($brcode)) {
      $codigo=substr($brcode,$n,2);
      $n+=2;
      $tamanho=intval(substr($brcode,$n,2));
      if (!is_numeric($tamanho)) {
         return false;
      }
      $n+=2;
      $valor=substr($brcode,$n,$tamanho);
      $n+=$tamanho;
      if (preg_match("/^[0-9]{4}.+$/", $valor) && ($codigo != 54)){
        $bug_fix = isset($retorno['26']['01']) ? $retorno['26']['01'] : ''; 
        if(is_array($bug_fix)){
         $extrai = strstr($brcode, 'PIX');
         $extrai = substr($extrai, 7);
         $extrai = substr($extrai, 0, 36);
         $retorno['26']['01'] = $extrai;
         unset($retorno['26']['26']);
        }
       #if (($codigo==26) || ($codigo==)) {
 
         $retorno[$codigo]=decode_brcode($valor);
      }else {
         $retorno[$codigo]="$valor";
      }
   }
   return $retorno;
}
function leowp_paggue_get_info($info){
global $_settings;    
$client_key = $_settings->info('paggue_client_key');
$client_secret = $_settings->info('paggue_client_secret');
$access_token = '';
$curl = curl_init();
$data = array(
"client_key"  => $client_key,
"client_secret" => $client_secret
);
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ms.paggue.io/payments/api/auth/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data),  
));

$response = curl_exec($curl);
$get = json_decode($response, true);
curl_close($curl);

if($info == 'access_token'){
  $info = $get['access_token'];
} 

if($info == 'company_id'){
  $info = $get['user']['companies']['0']['id'];
} 

return $info;
}


function leowp_paggue_create_order($client_name, $order_item, $amount, $order_id) {
    global $_settings;  
    $curl = curl_init();
  
    $data = array(
        "payer_name"  => $client_name,
        "amount" => intval($amount),
        "external_id" => $order_id,
        "description" => $order_item,
    ); 
 
    $signature = hash_hmac('sha256', json_encode($data), $_settings->info('paggue_client_secret'));
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json', 
        'Authorization: Bearer ' . leowp_paggue_get_info("access_token"),
        'X-Company-ID: ' . leowp_paggue_get_info("company_id"),
        'Signature: ' . $signature
    );

    // Uncomment the following lines for debugging purposes
    // print_r($headers);
    // exit;

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://ms.paggue.io/payments/api/billing_order',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data), // Corrected here
        CURLOPT_HTTPHEADER => $headers, // Corrected here
    ));

    $response = curl_exec($curl);
    $get = json_decode($response, true);
    curl_close($curl);
    $pix = $get['payment'];

    if(!$pix){
        $pix = 'ERRO - PIX INDISPONÍVEL';   
    }   
    return $pix;
}


#echo leowp_paggue_create_order();
function leowp_normalize_price($price) {

    $price = trim(preg_replace('`(R|\$|\x20)`i', '', $price));

    /**
     * 123.456.789,01
     */

    if (preg_match('`^([0-9]+(?:\.[0-9]+)+)\,([0-9]+)$`', $price, $match)) {
        return str_replace('.', '', $match[1]).'.'.$match[2];
    }

    /**
     * 123456789,01
     */

    if (preg_match('`^([0-9]+)\,([0-9]+)$`', $price, $match)) {
        return $match[1].'.'.$match[2];
    }

    /**
     * 123,456,789.01
     */

    if (preg_match('`^([0-9]+(?:\,[0-9]+)+)\.([0-9]+)$`', $price, $match)) {
        return str_replace(',', '', $match[1]).'.'.$match[2];
    }

    /**
     * 123456789.01
     */

    if (preg_match('`^([0-9]+)\.([0-9]+)$`', $price, $match)) {
        return $match[1].'.'.$match[2];
    }

    /**
     * 12345678901
     */

    if (preg_match('`^([0-9]+)$`', $price, $match)) {
        return $match[1];
    }

    /**
     * default
     */

    $price = preg_replace('`(\.|\,)`', '', $price);
    if (preg_match('`^([0-9]+)$`', $price, $match)) {
        return $match[1];
    }

    /**
     * error
     */

    return false;
}
function paggue_generate_pix($oid, $total_amount, $customer_name, $customer_email, $order_expiration){
      global $conn;
      require_once('gateway/phpqrcode/qrlib.php');
      require_once('gateway/funcoes_pix.php');

      $order_id = $oid;
      $order_item = $order_id;
      $order_amount = leowp_normalize_price($total_amount);
      $order_amount = number_format($order_amount, 2, ".", "");         
      $order_amount = ($order_amount * 100);
      $order_user = $customer_name;  
      $pix_code = leowp_paggue_create_order($order_user, $order_item, $order_amount, $order_id );
      $px = decode_brcode($pix_code);
      $monta_pix = montaPix($px);
      ob_start();
      QRCode::png($monta_pix, null,'M',5);
      $imageString = base64_encode( ob_get_contents() );
      ob_end_clean();
      $pix_qrcode = $imageString; 

      $payment_method = 'Paggue';

      $sql = "UPDATE order_list
SET payment_method = '{$payment_method}', pix_code = '{$pix_code}', pix_qrcode = '{$pix_qrcode}', order_expiration = '{$order_expiration}'
WHERE id = {$order_id}";

      if ($conn->query($sql)) {
    // A atualização foi bem-sucedida
    #echo "Atualização realizada com sucesso!";
      } else {
    // Ocorreu um erro na atualização
    #echo "Erro na atualização: " . $conn->error;
       }

}
#Fim Paggue

ob_end_flush();
?>