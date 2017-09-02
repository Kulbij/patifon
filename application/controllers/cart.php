<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'main.php';

class Cart extends Main {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $temp_object = $this->cart->contents();
        if (empty($temp_object))
            redirect(site_url(), 'refresh');

        $this->data = array();
        $this->data['__LINK'] = 'cart';
        $this->data['__GEN'] = array(
            'page_link' => 'cart',
            'page_other' => true
        );

        parent::generateInData($this->data['__GEN'], 'cart/cart_view', $this->data['__LINK']);

        #page parametter
        $this->data['PAGE'] = $this->page;
        #end

        $this->load->model('page_model');

        $content = array();

        $content['pagename'] = $this->page_model->getPageName($this->data['__LINK'], true);

        $this->data['SITE_CONTENT'] = $content;

        $this->display_lib->page($this->data, $this->view);
    }

    public function action_order() {

        $temp_object = $this->cart->contents();
        if (empty($temp_object))
            redirect(site_url(), 'refresh');

        $this->data = array();
        $this->data['__LINK'] = 'order';
        $this->data['__GEN'] = array(
            'breadpage' => 'order',
            'page_link' => 'order',
            'page_other' => true
        );

        parent::generateInData($this->data['__GEN'], 'cart/order_view', $this->data['__LINK']);
        $this->load->model('menu_model');
        $this->data['links'] = array();
        foreach ($this->cart->contents() as $key => $value) {
            $this->data['links'][$key] = $this->menu_model->getObjectCategories($value['id']);
        }
        #page parametter
        $this->data['PAGE'] = $this->page;
        #end

        $this->load->model('page_model');
        $this->load->model('catalog_model');

        $content = array();

        $content['pagename'] = $this->page_model->getPageName('order', true);

        $this->load->model('region_model');
        #$content['delivery_cat'] = $this->region_model->get_delivery_cat();
        #$content['delivery_type'] = $this->region_model->get_delivery_type(2);
        $content['order_region'] = $this->region_model->get_new_post_region();
        $content['catalog'] = $this->catalog_model->getCartCatalog();

        $this->data['SITE_CONTENT'] = $content;

        #FROM
        $form_array_temp = array();
        if ($this->session->userdata('form_post')) {
            $form_array_temp['POST'] = $this->session->userdata('form_post');
            $this->session->unset_userdata('form_post');
        }

        if ($this->session->userdata('form_errors')) {
            $form_array_temp['ERRORS'] = $this->session->userdata('form_errors');
            $this->session->unset_userdata('form_errors');
        }
        $this->data['FORM'] = $form_array_temp;
        #end FORM


        $this->display_lib->page($this->data, $this->view);
    }

    public function action_invoice($print = false, $pdf = false) {
        if ($print && $print != 'print')
            site_404_url();

        if ($print == 'print') {

            if (!$this->session->userdata('INVOICE_DATA_PRINT'))
                redirect(site_url(), 'refresh');
            #echo '<pre> <-------- '; print_r($this->session->userdata('INVOICE_DATA_PRINT')); echo '</pre>';
            $this->lang->load(SITELANG, SITELANG);
            $this->data = $this->session->userdata('INVOICE_DATA_PRINT');
            $this->view = 'cart/invoice_view';
            $this->page = 'invoice';
            $this->data['PRINT_PARAMETTER'] = $print;
            $this->session->unset_userdata('INVOICE_DATA_PRINT');
//            if ($pdf) {
//                require_once APPPATH . 'third_party/fpdf/fpdf.php';
//                $html = $this->load->view('general/header_view', $this->data, true);
//                $html .= $this->load->view('general/top_view', true);
//                $html .= $this->load->view('pages/' . $this->view, true);
//                $html .= $this->load->view('general/footer_view', true);
//                die();
//            }
        } else {

            $temp_object = $this->cart->contents();
            if (empty($temp_object))
                redirect(site_url());

            $order = $this->session->userdata($this->config->item('sess_order_id'));
            $this->session->unset_userdata($this->config->item('sess_order_id'));

            if ($order === false)
                redirect(anchor_wta(site_url('cart/order')));

            $total = $this->cart->total();
            $my__objects = $this->cart->contents();
            $this->cart->destroy();

            $this->data = array();
            $this->data['__LINK'] = 'invoice';
            $this->data['__GEN'] = array(
                'breadpage' => 'invoice',
                'page_link' => 'invoice',
                'page_other' => true
            );

            parent::generateInData($this->data['__GEN'], 'cart/invoice_view', $this->data['__LINK']);

            #page parametter
            $this->data['PAGE'] = $this->page;

            $this->data['TEMP_ORDER'] = $order;
            #end

            $this->load->model('page_model');

            $content = array();

            $content['customer'] = array();
            $content['customer']['orderid'] = $order['insert_id'];
            $content['customer']['datetime'] = $order['datetime'];
            $content['customer']['name'] = $order['name'];

            $content['customer']['discount'] = 0;

            $content['pp'] = $this->page_model->get_pp();

            $content['content'] = $my__objects;

            $content['total_price'] = $total - $content['customer']['discount'];

            $this->load->library('formed_lib');
            $content['total_price_str'] = $this->formed_lib->numprice2strprice($content['total_price']);

            $this->data['SITE_CONTENT'] = $content;

            if ($this->session->userdata('INVOICE_DATA_PRINT'))
                $this->session->unset_userdata('INVOICE_DATA_PRINT');
            $this->session->set_userdata('INVOICE_DATA_PRINT', $this->data);
        }
        $this->display_lib->page($this->data, $this->view);
    }

    public function action_clear() {
        $this->cart->destroy();
        redirect(site_url());
    }

    public function ajax_cartaction($action = '') {
        if (strtolower($this->input->server('HTTP_X_REQUESTED_WITH')) != 'xmlhttprequest')
            site_404_url();

        $action_array = array('show-cart', 'show_bay_option', 'change-quantity', 'remove-catalog', 'cart-data', 'load-content', 'load-view', 'check-order');

        if (empty($action) || !in_array($action, $action_array)) {
            echo false;
            die();
        }

        $data = false;
        switch ($action) {

            case 'show-cart': {
                    if ((int) $this->input->post('id') > 0 && (int) $this->input->post('quantity') > 0) {
                        $id = $this->input->post('id');
                        $quantity = $this->input->post('quantity');
                        $color = (int) $this->input->post('color');
                        $show = (bool) $this->input->post('show');
                        $id_product = $this->input->post('id_product');
                        return $this->showcart($id, $quantity, $color, $show, $id_product);
                    }
                } break;

                case 'show_bay_option': {
                    if ((int) $this->input->post('id') > 0) {
                        $id = $this->input->post('id');
                        $data = $this->showbayoption($id);
                    }
                } break;

            case 'change-quantity': {

                    if ($this->input->post('row') !== false && (int) $this->input->post('quantity') > 0) {
                        $rowid = $this->base_model->prepareDataString(mb_substr($this->input->post('row'), 0, 255));
                        $quantity = (int) $this->input->post('quantity');
                        $data = $this->quantity($rowid, $quantity);
                    }
                } break;

            case 'remove-catalog': {

                    if ($this->input->post('row') !== false) {
                        $rowid = $this->base_model->prepareDataString(mb_substr($this->input->post('row'), 0, 255));
                        $data = $this->remove($rowid);
                    }
                } break;

            case 'cart-data': {
                    $data['cart'] = parent::getTopCartData();
                } break;

            case 'load-content': {

                    $data = array();
                    $mydata = array();
                    $this->load->model('menu_model');
                    $mydata['links'] = array();
                    $mydata['move_to_shopping'] = false;
                    foreach ($this->cart->contents() as $key => $value) {
                        $mydata['links'][$key] = $this->menu_model->getObjectCategories($value['id']);
                    }                              
                    $data['cart'] = $this->load->view('ajax/ownbox/owb_cart_inside_view', $mydata, true);
                    $data['cart_page'] = $this->load->view('ajax/ownbox/owb_cart_inside_view', $mydata, true);
                    $data['cart_order'] = $this->load->view('ajax/cart/cart_order_view', null, true);
                } break;

            case 'load-view': {
                    echo $this->loadview();
                    die();
                } break;

            case 'check-order': {
                    $data = $this->checkOrder();
                } break;

            default: {
                    $data = false;
                } break;
        }

        if (!$data)
            echo false;
        else
            echo json_encode($data);

        die();
    }

    private function checkOrder() {
        if (!isset($_POST['robot']) || !empty($_POST['robot']))
            return false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', $this->lang->line('op_form_label_name'), 'required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('op_form_label_email'), 'valid_email|max_length[255]|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('op_form_label_phone'), 'required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('address', $this->lang->line('op_form_label_address'), 'max_length[255]|xss_clean');
        if ($this->input->post('delivery') == 1) {
            $this->form_validation->set_rules('payment', 'payment', 'is_natural');
            $this->form_validation->set_rules('point', $this->lang->line('op_form_label_region'), 'trim|xss_clean|callback_no_zero');
            $this->form_validation->set_rules('city', $this->lang->line('op_form_label_city'), 'trim|xss_clean|callback_no_zero');
        } else {
            $_POST['point'] = "Самовывоз";
            $_POST['city'] = "Самовывоз";
        }

        $this->form_validation->set_rules('comment', 'comment', 'max_length[2000]|trim|xss_clean');
        if ($this->form_validation->run() == true) {
            $data_array = array(
                'user_id' => (int) $this->session->userdata('user_id'),
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'city' => $this->input->post('city'),
                'point' => $this->input->post('point'),
                'address' => $this->input->post('address'),
                'message' => $this->input->post('comment'),
                'payment_type' => $this->input->post('payment'),
                'datetime' => date('Y-m-d H:i:s')
            );

            $this->load->model('form_model');
            $insert = $this->form_model->insert_order($data_array);

            if ($insert) {

                $data_array['insert_id'] = $insert;

                #$data_array['region_name'] = $this->region_model->get_region_name($data_array['region']);
                #$data_array['city_name'] = $this->region_model->get_region_city_name($data_array['city']);

                $this->load->library('send_lib');
                $this->send_lib->send_order($data_array, $this->cart->contents());
                $this->send_lib->sendClientSms($data_array);
                // send new view massasges 123321
            }

            $this->session->set_userdata($this->config->item('sess_order_id'), $data_array);

            return array('redirect' => anchor_wta(site_url('cart/invoice')));
        } else {

            $array_val = array(
                'name' => true,
                'email' => true,
                'phone' => true,
                'point' => true,
                'city' => true,
                'address' => true
            );

            foreach ($array_val as $key => $one) {
                $temp = form_error($key);
                if (empty($temp))
                    unset($array_val[$key]);
            }

            $array_val['errors'] = validation_errors();
            $array_val['is_err'] = true;

            return $array_val;
        }

        return false;
    }

    #PRIVATE VALIDATION

    public function val_delivery_order($value = 0) {
        $value = (int) $value;

        $del_service = (int) $this->input->post('delivery_service');
        if ($value > 1 && $del_service <= 0)
            return false;

        $this->load->model('region_model');
        return (bool) $this->region_model->is_delivery_cat($value);
    }

    public function val_delivery_service_order($value = 0) {
        $value = (int) $value;

        $delivery = (int) $this->input->post('delivery');
        if ($delivery > 1 && $value <= 0)
            return false;
        else if ($delivery <= 1)
            return true;

        $this->load->model('region_model');
        return (bool) $this->region_model->is_delivery_type($value, (int) $this->input->post('delivery'));
    }

    public function val_region_order($value = 0) {
        $value = (int) $value;

        $this->load->model('region_model');
        return (bool) $this->region_model->is_region($value);
    }

    public function val_city_order($value = 0) {
        $value = (int) $value;

        $this->load->model('region_model');
        return (bool) $this->region_model->is_region_city($value, (int) $this->input->post('region'));
    }

    public function val_order_phone($value = 0) {
        $value = strtolower($this->input->prepare_user_identity_phone($value));

        $this->load->model('user_model');
        if ($this->ion_auth->logged_in() &&
                ($this->user_model->is($value, $this->session->userdata('user_id')) ||
                $this->user_model->is_dod($value, $this->session->userdata('user_id'))
                )
        )
            return true;

        if (empty($value) || $this->user_model->is($value) || $this->user_model->is_dod($value))
            return false;

        return true;
    }

    public function val_order_phone_count($value) {
        $value = strtolower($this->input->prepare_user_identity_phone($value));

        $this->load->model('user_model');
        if ($this->ion_auth->logged_in() &&
                !$this->user_model->is($value, $this->session->userdata('user_id')) &&
                !$this->user_model->is_dod($value, $this->session->userdata('user_id')) &&
                $value != $this->session->userdata('identity') &&
                $this->user_model->add_phone_count($this->session->userdata('user_id')) >= $this->config->item('auth_user_phone_max_count')
        )
            return false;

        return true;
    }

    #this is the end... */

    private function showcart($id, $quantity, $color, $show, $id_product) {

        $id = $id;
        $quantity = $quantity;
        $color = (int) $color;
        $show = (bool) $show;

        $idis = array();
        $counter = array();
        if (is_array($id) && is_array($quantity)) {

            foreach ($id as $value)
                array_push($idis, (int) $value);

            foreach ($quantity as $key => $value) {
                $counter[$key] = (int) $value;
            }
        } else {
            $idis = array((int) $id);
            $counter[$id] = (int) $quantity;
        }

        $data = array();

        $this->load->model('page_model');

        $data['pagename'] = $this->page_model->getPageName('cart', true);
        $data['cartcatalog'] = array();

        $this->load->model('catalog_model');
        $catalog = $this->catalog_model->getCartObject($idis, $id_product);

        if (empty($catalog))
            return false;

        foreach ($catalog as $key => $value) {

            $elem = $this->cart->isElement($key);

            $quantity = isset($counter[$key]) ? $counter[$key] : 0;
            //$warranty = $this->catalog_model->getWarranty($warranty);
            if ($elem) {

                $array = array(
                    'rowid' => $elem['rowid'],
                    'price' => $value['price'],
                    'qty' => $quantity,
                    'options' => array(
                        'old_price' => $value['old_price'],
                        'cost' => $value['price'] * $quantity,
                    )
                );

                $this->cart->update($array);
            } else {

                $array = array(
                    'id' => $key,
                    'qty' => $quantity,
                    'price' => $value['price'],
                    'name' => $value['name'].$value['product_name'],
                    'options' => array(
                        'link' => $value['link'],
                        'old_price' => $value['old_price'],
                        'image' => $value['image'],
                        'cost' => $value['price'] * $quantity,
                        'product' => $value['product_name'],
                    )
                );

                $this->cart->insert($array);
            }
        }

        return true;
    }

    private function quantity($rowid, $quantity = 0) {
        $data = array();

        $elem = $this->cart->getElement($rowid);
        if (empty($elem))
            return $data;

        if (!isset($elem['id']))
            return false;

        $this->load->model('catalog_model');
        $temp_one = $this->catalog_model->getCartObject(array($elem['id']));
        if (isset($temp_one['price']))
            $elem['price'] = ceil($temp_one['price']);

        if ($quantity <= 0)
            return false;
        $qwentity = $quantity;

        $cost = $qwentity * $elem['price'];

        $array = array(
            'rowid' => $rowid,
            'qty' => $qwentity,
            'price' => $elem['price'],
            'options' => array(
                'cost' => $cost
            )
        );
        $this->cart->update($array);

        $data = array();

        /*
          $data['cart'] = parent::getTopCartData();
          $data['quantity'] = $qwentity;
          $data['price'] = $elem['price'];
          $data['cost'] = $cost;
          $data['row'] = $rowid;
         */

        return $data;
    }

    private function remove($rowid = '') {
        $data = array();

        if (!empty($rowid)) {
            $array = array(
                'rowid' => $rowid,
                'qty' => 0
            );
            $this->cart->update($array);
        }

        return $data;
    }

    private function loadview() {
        $this->load->model('page_model');
        $this->load->model('catalog_model');
        $this->load->model('menu_model');
        $data = array();
        $data['pagename'] = $this->page_model->getPageName('cart', true);

        $data['cart'] = parent::getTopCartData();
        $data['links'] = array();
        foreach ($this->cart->contents() as $key => $value) {
            $data['links'][$key] = $this->menu_model->getObjectCategories($value['id']);
        }
        return $this->load->view('ajax/ownbox/owb_cart_view.php', $data, true);
    }

    public function no_zero($value) {
        if ($value == "0") {
            return false;
        }
        return true;
    }

    public function showbayoption($id){
        if($id <= 0) return false;
        $id = (int)$id;

        $this->load->model('catalog_model', 'model');
        return $this->model->getOneOption($id);
    }

}
