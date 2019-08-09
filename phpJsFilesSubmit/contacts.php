<?php
  $to = "mail@gmail.com"; // поменять на свой электронный адрес
  // $from = $_POST['ferrari'];
  $subject = "Заполнена  форма с ".$_SERVER['HTTP_REFERER'];
  $message = "Имя: ".$_POST['fullName']."\nIP: ".$_SERVER['REMOTE_ADDR']."\nСообщение: ".$_POST['msg']."\nEmail: ".$_POST['email'];
  // "Фамилия Имя Отчество: ".$_POST['nameFF']
  // "Телефон: ".$_POST['phone']
  // "Email: ".$_POST['email']
  // "Адрес по месту жительства: ".$_POST['address']
  // "Марка и модель авто: ".$_POST['carModel']
  // "Год выпуска авто: ".$_POST['carYear']
  // "Цвет автомобиля: ".$_POST['carColor']
  // "Гоc номер автомобиля: ".$_POST['carNum']
  // "Серия паспорта: ".$_POST['passeria']
  // "Номер паспорта: ".$_POST['pasnomer']
  // "Дата выдачи паспорта: ".$_POST['datavidach']
  // "Кем выдан паспорт: ".$_POST['paskem']
  // "Серия ВУ: ".$_POST['servu']
  // "Номер ВУ: ".$_POST['sernomer']
  // "Дата выдачи ВУ: ".$_POST['vudatavidach']
  // "Действует до: ".$_POST['deistvvu']
  // "Серия и номер лицензии (если есть): ".$_POST['license']
  // "Город: ".$_POST['city']
  // "Номер счета личной карты, ИНН банка, БИК банка (через запятую): ".$_POST['rekvisit']
  
  // ."\nEmail: ".$from."\nIP: "
  // .$_SERVER['REMOTE_ADDR']
  // ."\nСообщение: "
  // .$_POST['messageFF'];
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: Отправитель <form>\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"

--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit

$message";
  for($i=0;$i<count($_FILES['fileFF']['name']);$i++) {
     if(is_uploaded_file($_FILES['fileFF']['tmp_name'][$i])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'][$i])));
         $filename = $_FILES['fileFF']['name'][$i];
         $filetype = $_FILES['fileFF']['type'][$i];
         $filesize += $_FILES['fileFF']['size'][$i];
         $message.="

--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"

$attachment";
     }
   }
   $message.="
--$boundary--";

  if ($filesize < 10000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
    mail($to, $subject, $message, $headers);
    echo $_POST['license'].', Ваше сообщение получено, спасибо!';
  } else {
    echo 'Извините, письмо не отправлено. Размер всех файлов превышает 10 МБ.';
  }
?>