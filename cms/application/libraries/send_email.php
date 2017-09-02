<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Send_email {
    #email's

    private $email;

    public function __construct() {
        $this->email = 'lenovotel@mail.ua';
    }

    public function __get($variable) {
        return get_instance()->$variable;
    }

    public function send_email($array) {
      // $array['email'] = 'kulbij@mail.ru';
      $array['email'] = $array['email'];
      $this->load->model('catalog/catalog_object_model');

      $data['cats'] = $this->catalog_object_model->getCats();
      $data['phones'] = $this->catalog_object_model->get_phones(null, true);
      $data['pages'] = $this->catalog_object_model->getPageShortData('top');

      $view = $this->load->view('mail/mail.php', $data, true);

        $subject = "Зворотній зв'язок";
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $header = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        #$header .= "From:  \r\n";
        $header .= "Content-type: text/html; charset=\"utf-8\"";

        $message = $view;


        $mail_bool = @mail($array['email'], $subject, $message, $header);
        if($mail_bool == true) return true;
        else return false;
    }

    public function send_feedphone($array) {
        $subject = "Зворотній зв'язок";
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $header = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        ##$header .= "From:  \r\n";
        $header .= "Content-type: text/html; charset=\"utf-8\"";

        $message = "
          Зворотній дзвінок від <b>" . date('d.m.Y H:i:s', strtotime($array['datetime'])) . "</b><br />
          <b>Ім'я:</b>&nbsp;{$array['name']}<br />
          <b>Телефон:</b>&nbsp;{$array['phone']}<br />
          <b>Текст:</b>&nbsp;{$array['text']}<br />
          <b>Зі сторінки:</b>&nbsp;<a href='{$array['link']}'>{$array['link']}</a><br />
          ---------------------------------------------------------<br />
          <font style='color: gray; font-size: 10px;'>Це автоматичне повідомлення, на яке не потрібно відповідати!</font>
      ";

        @mail($this->email, $subject, $message, $header);
    }

    public function send_buyback($array) {
        $subject = "Замовлення в один клік";
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $header = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        ##$header .= "From:  \r\n";
        $header .= "Content-type: text/html; charset=\"utf-8\"";

        $message = "
          Замовлення в один клік від <b>" . date('d.m.Y H:i:s', strtotime($array['datetime'])) . "</b><br />
          <b>Телефон:</b>&nbsp;{$array['phone']}<br />
          <b>Товар:</b>&nbsp;<a href='" . anchor_wta(site_url('product/' . $array['product']['link'])) . "'>{$array['product']['name']}</a><br />
          ---------------------------------------------------------<br />
          <font style='color: gray; font-size: 10px;'>Це автоматичне повідомлення, на яке не потрібно відповідати!</font>
      ";

        @mail($this->email, $subject, $message, $header);
    }

    public function sendClientSms(array $array) {
        $array['phone'] = $this->input->prepare_user_identity_phone($array['phone']);
        $array['text'] = "Спасибо за Ваш заказ №{$array['insert_id']}. Мы свяжемся с Вами в ближайшее время.";
        $array['desc'] = "Спасибо за заказ";
        $from = "Patifon"; //Ваше альфаимя!
        $to = $array['phone']; //Номер получателя
        $text = $array['text']; //Текст сообщения в кодировке UTF-8!!!!
        $res = $this->post_request($from, $to, $text);    
    }
    private function post_request($from, $to, $text) {
        $url = 'https://api.life.com.ua/ip2sms/'; //URL для отправки сообщений
        $login = 'Lenovotel'; //Логин
        $password = 'Kramar2210'; //Пароль
        $params = array('http' => array(
                'method' => 'POST',
                'header' => array('Authorization: Basic ' . base64_encode($login . ":" . $password),
                'Content-Type:text/xml',
                "User-Agent:MyAgent/1.0\r\n"), 
                'content' => '<message><service id="single" source="' . $from . '" validity="+2 hour"
/><to>' . $to . '</to><body content-type="text/plain">' . $text . '</body></message>'));
        $ctx = stream_context_create($params);
        $fp = fopen($url, 'rb', FALSE, $ctx);
        if ($fp) {
            $response = @stream_get_contents($fp);
            return $response;
        } else
            return false;
    }

    public function send_order($array, $cart) {
        $subject = "Замовлення №{$array['insert_id']}";
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $header = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        #$header .= "From:  \r\n";

        $message = "
          Замовлення від <b>" . date('d.m.Y H:i:s', strtotime($array['datetime'])) . "</b><br />
          <b>Ім'я:</b> {$array['name']}<br />
          <b>Телефон:</b> {$array['phone']}<br />
          <b>Пошта:</b> {$array['email']}<br />
          <b>Місто:</b> {$array['city']}<br />
          <b>Пункт видачі:</b> {$array['point']}<br />
          <b>Коментар:</b> {$array['message']}<br />
          <br /><br />";

        $message .= "<table width='600px' style='border: solid 1px black; margin: 5px;' rules='all'>
      <tr>
          <th style='padding: 3px;'>Назва товару</th>
          <th width='100px' style='padding: 3px;'>Кількість, шт.</th>
          <th width='70px' style='padding: 3px;'>Ціна, грн.</th>
          <th width='70px' style='padding: 3px;'>Вартість, грн.</th>
      </tr>";

        $sum = 0;
        foreach ($cart as $one) {
            $sum += round($one['price'] * $one['qty'], 2);

            if (isset($one['options']['color_name']) && !empty($one['options']['color_name']))
                $one['name'] .= ' (' . $one['options']['color_name'] . ')';

            $string = "<tr style='padding: 10px;'>";
            $string .= "<td style='padding: 3px;'>{$one['name']}</td>";
            $string .= "<td style='padding: 3px;'>{$one['qty']}</td>";
            $string .= "<td style='padding: 3px;'>" . round($one['price'] , 2) . "</td>";
            $string .= "<td style='padding: 3px;'>" . round($one['price'] * $one['qty'], 2) . "</td>";
            $string .= '</tr>';
            $message .= $string;
        }
        $message .= "</table><div style='width: 600px;'><b>Сума замовлення: </b>" . round($sum, 2) . " грн.</div>";

        $message .= "
          ---------------------------------------------------------<br />
          <font style='color: gray; font-size: 10px;'>Це автоматичне повідомлення, на яке не потрібно відповідати!</font>
      ";

        @mail($this->email, $subject, $message, $header);
        if($array['email'] != ""){
            @mail($array['email'], $subject, $message, $header);
        }
    }

    public function user_send_activation($array) {
        $subject = "Регистрация на сайте " . baseurl();
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $header = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        ##$header .= "From:  \r\n";

        $message = "
          Спасибо за регистрацию на нашем сайте " . baseurl() . "!<br />\n
          Для активации аккаунта пройдите по ссылке ниже.<br />\n
          <a href='" . anchor_wta(site_url('user/activate/' . $array['id'] . '/' . $array['activation'])) . "'>ссылка</a><br />\n
          <strong>Если вы не регистрировались на нашем сайте, просто проигнорируете данное письмо.</strong><br />\n
          ---------------------------------------------------------<br />\n
          <font style='color: gray; font-size: 10px;'>Это автоматическое сообщение, на которое не нужно отвечать!</font>
      ";

        return (bool) mail($array['email'], $subject, $message, $header);
    }

    #SMS region

    public function send_sms($array) {
        if (empty($array) || !isset($array['text']) || !isset($array['desc']) || !isset($array['phone']))
            return false;
        $array['phone'] = $this->input->prepare_user_identity_phone($array['phone']);

        //--------------- SMS повідомлення клієнту на телефон ------------------
        $text = htmlspecialchars($array['text']);
        $description = htmlspecialchars($array['desc']);
        $start_time = 'AUTO'; #date("Y-m-d H:i:s", time() + 50); // вибивала помилка, додав
        $end_time = date("Y-m-d H:i:s", time() + 10800); // плюс 3 часа
        $rate = 120; // svidkist vidpravki sms 1..120
        $livetime = 4; // live sms v godinah
        $source = ''; // Alfaname
        $recipient = $array['phone'];
        $user = '';
        $password = '';

        $my_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $my_xml .= "<request>";
        $my_xml .= "<operation>SENDSMS</operation>";
        $my_xml .= '        <message start_time="' . $start_time . '" end_time="' . $end_time . '" livetime="' . $livetime . '" rate="' . $rate . '" desc="' . $description . '" source="' . $source . '">' . "\n";
        $my_xml .= "        <body>" . $text . "</body>";
        $my_xml .= "        <recipient>" . $recipient . "</recipient>";
        $my_xml .= "</message>";
        $my_xml .= "</request>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, 'http://sms-fly.com/api/api.php');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $my_xml);
        $response = curl_exec($ch); // результат запроса, можно вывести на экран
        curl_close($ch);
        return true;
    }

}
