<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'main.php';

class Auth extends Main {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

  $this->lang->load('auth', SITELANG);
		$this->lang->load(SITELANG, SITELANG);
		$this->load->helper('language');

  $this->load->model('user_model');
	}


 #MY
 
 public function action_auth_ajax($parametter = '', $link = '') {
  if (strtolower($this->input->server('HTTP_X_REQUESTED_WITH')) != 'xmlhttprequest') site_404_url();
  
  $arr_ajax = array('form', 'form-send', 'operation');
  
  if (empty($parametter) || !in_array($parametter, $arr_ajax)) {
   echo false;
   die();
  }
  
  $data = false;
  
  switch($parametter) {
   
   case 'form': {
    $data = $this->action_ajax_load_form($link);
    return true;
   } break;

   case 'form-send': {

    switch($link) {

     case 'login-form': {
      $data = $this->validate_login();
     } break;

     case 'forgot-password-form': {
      $data = $this->validate_forgot_password();
     } break;

     case 'register-form': {
      $data = $this->validate_register();
     } break;

     case 'my-info-form': {
      $data = $this->validate_my_info();
     } break;

    }

   } break;

   case 'operation': {

    if ($this->ion_auth->logged_in() && $this->input->post('action') !== false) {
     $action = $this->base_model->prepareDataString($this->input->post('action', true));

     switch ($action) {

      case 'user-favorite': {

       $this->load->model('catalog_model');
       $object = (int)$this->input->post('object');
       if ($object > 0 && $this->catalog_model->isByID($object)) {

        $this->load->model('user_model');
        $msg = $this->user_model->user_favorite($this->session->userdata('user_id'), $object);
        
        if ($msg == 'fav_rem') {

         $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'op_fav_rem_okey');
         $data = array(
          'form' => 'true',
          'settext' => array(
            'elem' => '.user-to-favorite',
            'text' => $this->lang->line('op_add_to_favorite')
           )
          );

        } else if ($msg == 'fav_add') {

         $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'op_fav_add_okey');
         $data = array(
          'form' => 'true',
          'settext' => array(
            'elem' => '.user-to-favorite',
            'text' => $this->lang->line('op_remove_to_favorite')
           )
          );

        } else {

         $this->session->set_userdata($this->config->item('own_box_error_msg'), 'site_default_form_error_msg');
         $data = array('form' => 'true');

        }

       }

      } break;

      case 'phone-add': {

       $temper_count = (int)$this->session->userdata('temp_user_phone');

       if ($this->ion_auth->logged_in() && 
           $temper_count >= $this->config->item('auth_user_phone_max_count')
       ) {

        $data['errors'] = $this->lang->line('up_phone_error_max');

       } else {

        ++$temper_count;
        $this->session->set_userdata('temp_user_phone', $temper_count);

        $data['view'] = $this->load->view('auth/inside/user_edit_info_phone_field_view', null, true);

       }

      } break;

      case 'phone-remove': {

       $phone = (int)$this->input->post('phone');
       if ($this->ion_auth->logged_in() && $phone > 0) {
        
        $this->load->model('user_model');
        $res = $this->user_model->remove_phone($this->session->userdata('user_id'), $phone);

       }

       $temper_count = (int)$this->session->userdata('temp_user_phone');
        --$temper_count;
        $this->session->set_userdata('temp_user_phone', $temper_count);

      } break;

     }

    }

   } break;

  }
  
  if (!$data) echo false;
  else echo json_encode($data);
  
  die();
 }

 private function action_ajax_load_form($link = '') {
  $link = $this->base_model->prepareDataString($link);
  if (empty($link)) return false;

  switch ($link) {

   case 'login-form': {
    if ($this->ion_auth->logged_in()) return false;
    echo $this->load->view('auth/ajax/login_form_view', null, true);

   } break;

   case 'forgot-password-form': {
    if ($this->ion_auth->logged_in()) return false;
    echo $this->load->view('auth/ajax/forgot_password_form_view', null, true);

   } break;

   case 'register-form': {
    if ($this->ion_auth->logged_in()) return false;

    $data = array();
    $data['knows'] = $this->user_model->know_get();

    echo $this->load->view('auth/ajax/register_form_view', array('SITE_FORM' => $data), true);

   } break;

   default: {
    return false;
   } break;

  }

 }

 private function validate_login() {
  if ($this->ion_auth->logged_in()) return false;
  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return false;

  $this->load->library('form_validation');

  $this->form_validation->set_rules('identity', $this->lang->line('ap_l_field_login'), 'required|xss_clean');
  $this->form_validation->set_rules('password', $this->lang->line('ap_l_field_password'), 'required|xss_clean');

  if ($this->form_validation->run() == true) {
   //check to see if the user is logging in
   //check for "remember me"
   $remember = (bool)$this->input->post('remember');
   $identity = strtolower($this->input->prepare_user_identity_phone($this->input->post('identity')));

   if ($this->ion_auth->login($identity, $this->input->post('password'), $remember)) {
    //if the login is successful
    //redirect them back to the home page
    
    // $this->session->set_flashdata('message', $this->ion_auth->messages());
    // redirect('/', 'refresh');

    return array('refresh' => 'true');
    #return array('redirect' => anchor_wta(site_url($this->config->item('auth_user_page_link'))));

   } else {
    //if the login was un-successful
    //redirect them back to the login page
    // $this->session->set_flashdata('message', $this->ion_auth->errors());
    // redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
    
    #$this->session->set_userdata($this->config->item('own_box_error_msg'), 'ap_l_error_msg');
    #return array('okey' => 'true');
    
    return array('errors' => $this->ion_auth->errors());

   }

  } else {
   
   $array_val = array(
    'identity' => true,
    'password' => true
    );

   foreach ($array_val as $key => $one) {
    $temp = form_error($key);
    if (empty($temp)) unset($array_val[$key]);
   }

   $array_val['is_err'] = true;

   return $array_val;

  }

  return array('error' => '!');
 }

 private function validate_forgot_password() {
  if ($this->ion_auth->logged_in()) return false;
  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return false;

  $this->load->library('form_validation');
  
  $this->form_validation->set_rules('identity', $this->lang->line('ap_fp_field_identity'), 'required|xss_clean');
  
  if ($this->form_validation->run() == true) {
   
   $identity = strtolower($this->input->prepare_user_identity_phone($this->input->post('identity')));
   $identity = $this->ion_auth->where('identity', $identity)->users()->row();
   if(empty($identity)) {
    
    return array('errors' => $this->lang->line('ap_fp_identity_error_msg'));

   } else {

    //run the forgotten password method to email an activation code to the user
    $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

    if ($forgotten) {

     //if there were no errors
     // $this->session->set_flashdata('message', $this->ion_auth->messages());
     // redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
     
     $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_fp_okey_msg');
     return array('okey' => 'true');

    } else {

     // $this->session->set_flashdata('message', $this->ion_auth->errors());
     // redirect("auth/forgot_password", 'refresh');

     $this->session->set_userdata($this->config->item('own_box_error_msg'), $this->ion_auth->errors());
     return array('okey' => 'true');

    }

   }

  } else {
   return array('errors' => validation_errors());
  }

  return array('error' => '!');
 }

 private function validate_register() {
  if ($this->ion_auth->logged_in()) return false;
  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return false;

  $this->load->library('form_validation');

  $tables = $this->config->item('tables','ion_auth');

  //validate form input
  $this->form_validation->set_rules('phone', $this->lang->line('ap_reg_field_phone'), 'required|callback_val_user_identity|xss_clean');
  $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
  $this->form_validation->set_rules('licence', $this->lang->line('ap_reg_field_licence_2'), 'required');

  if ($this->form_validation->run() == true) {

   $username = '';
   $email    = '';
   $password = $this->input->post('password');

   $additional_data = array(
    'identity' => strtolower($this->input->prepare_user_identity_phone($this->input->post('phone')))
    );

   $user = $this->ion_auth->register($username, $password, $email, $additional_data);
   if (isset($user['id']) && isset($user['activation'])) {

    if ($this->input->post('info')) {
     $this->user_model->know_to_user($this->user_model->know_is($this->input->post('info')), $user['id']);
    }

    if ($this->activate($user['id'], $user['activation'])) {

     $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_reg_okey_msg');

     #send sms about user register
     $this->load->library('send_lib');
     $sms = array(
      'phone' => $additional_data['identity'],
      'desc' => $this->lang->line('senderman_sms_theme_user_reg'),
      'text' => sprintf($this->lang->line('senderman_sms_text_user_reg'), $this->input->post('phone'), $password)
     );
     $this->send_lib->send_sms($sms);

    } else {
     $this->session->set_userdata($this->config->item('own_box_error_msg'), 'ap_reg_error_msg');
    }

    return array('okey' => 'true');
   }

  } else {

   // $array_val = array(
   //  'phone' => true,
   //  'password' => true,
   //  'licence' => true
   //  );

   // foreach ($array_val as $key => $one) {
   //  $temp = form_error($key);
   //  if (empty($temp)) unset($array_val[$key]);
   // }

   // return $array_val;

   return array('errors' => validation_errors());

  }

  return array('error' => '!');
 }

 private function validate_my_info() {
  if (!$this->ion_auth->logged_in()) return false;
  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return false;
  
  $this->load->library('form_validation');

  $tables = $this->config->item('tables','ion_auth');

  //validate form input
  $this->form_validation->set_rules('name', rtrim($this->lang->line('accp_info_name_title'), ':'), 'max_length[255]|xss_clean');
  $this->form_validation->set_rules('phone', rtrim($this->lang->line('accp_info_phone_title'), ':'), 'callback_val_user_identity_array|xss_clean');
  $this->form_validation->set_rules('email', rtrim($this->lang->line('accp_info_email_title'), ':'), 'valid_email|max_length[255]|xss_clean');
  $this->form_validation->set_rules('password_old', rtrim($this->lang->line('accp_info_password_old_title'), ':'), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
  $this->form_validation->set_rules('password_new', rtrim($this->lang->line('accp_info_password_new_title'), ':'), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
  $this->form_validation->set_rules('password_confirm', rtrim($this->lang->line('accp_info_password_confirm_title'), ':'), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');

  if ($this->form_validation->run() == true) {
   
   $success = '';
   $errors = '';

   $ins_array = array(
    'username' => $this->input->post('name'),
    'email' => $this->input->post('email')
    );

   if ($this->user_model->user_up_info($this->session->userdata('user_id'), $ins_array, $this->input->post('phone'))) {
    $success = $this->lang->line('accp_info_change_okey_msg').' ';
   } else {
    $errors = $this->lang->line('accp_info_change_err_msg').' ';
   }
   
   if ($this->input->post('password_old') && $this->input->post('password_new')) {
    $identity = $this->session->userdata('identity');
    $change = $this->ion_auth->change_password($identity, $this->input->post('password_old'), $this->input->post('password_new'));
    
    if ($change) {
     $success .= $this->lang->line('accp_info_change_pass_okey_msg');
     #$this->logout();
    } else {
     $errors .= $this->lang->line('accp_info_change_pass_err_msg'); #$this->ion_auth->errors();
    }

   }
   
   return array(
    'success' => $success,
    'errors' => $errors
    );

  } else {

   return array('errors' => validation_errors());

  }

  return array('error' => '!');
 }

 #this is the end... */


 #public val function for validation
 
 public function val_user_identity($value) {
  $value = strtolower($this->input->prepare_user_identity_phone($value));
  if (empty($value)) return false;

  $this->load->model('user_model');
  if ($this->user_model->is($value) || $this->user_model->is_dod($value)) return false;
  
  return true;
 }

 public function val_user_identity_array($value) {
  $return = true;
  if (!$this->input->post('phone')) return true;
  if (!is_array($value)) return false;

  $this->load->model('user_model');

  foreach ($value as $key => $phone) {
   
   $identity = strtolower($this->input->prepare_user_identity_phone($phone));
   if ($this->user_model->is_idenitity_not_user($identity, $this->session->userdata('user_id'))) {
    $this->form_validation->set_message('val_user_identity_array', sprintf($this->lang->line('up_phone_error_each'), $phone));
    $return = false;
   }

  }

  return $return;
 }

 #this is the end... */
 
 public function action_index($link = 'info', $bug = 'page', $page = 1) {
  if (!$this->ion_auth->logged_in()) site_404_url();
  
  $this->load->model('user_model');
  $this->load->model('catalog_model');
  
  $this->data = array();
  
  $page_id = (int)$this->user_model->page_is($link);
  if (!$page_id) site_404_url();
  
  $this->data['PAGE'] = 'user';
  $this->data['__LINK'] = $link;
  
  $this->data['__GEN'] = array(
   'page_link' => $link
  );
  
  $this->data['__VIEW'] = $this->user_model->page_get_view($page_id);
  
  parent::generateInData($this->data['__GEN'], $this->data['__VIEW'], $this->data['PAGE']);
  
  $pagination = array();

  $content = array();
  $content['page_list'] = $this->user_model->page_get_list(7);
  
  switch ($link) {

   case 'edit-info': {

    $this->session->set_userdata('temp_user_phone', $this->user_model->add_phone_count($this->session->userdata('user_id')));

    $content['user-phones'] = $this->user_model->phone_get_list($this->session->userdata('user_id'));

   } break;

   case 'favorites': {

    $pagination['COUNTONPAGE'] = 30;
    $pagination['COUNTALL'] = $this->catalog_model->get_catalog_by_user_fav_count($this->session->userdata('user_id'));

    $pagination['THISPAGE'] = (int)$page;
    if ($pagination['THISPAGE'] <= 0) site_404_url();

    $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);
    if ($pagination['COUNTPAGE'] > 0 && $pagination['THISPAGE'] > $pagination['COUNTPAGE']) site_404_url();

    $pagination['COUNTSHOWPAGE'] = 6;
    if ($pagination['THISPAGE'] == 1 || $pagination['THISPAGE'] == $pagination['COUNTPAGE']) $pagination['COUNTSHOWPAGE'] = 15;
    if ($pagination['COUNTPAGE'] <= 15) $pagination['COUNTSHOWPAGE'] = 15;

    $content['catalog'] = $this->catalog_model->get_catalog_by_user_fav($this->session->userdata('user_id'), $pagination['THISPAGE'], $pagination['COUNTONPAGE']);

   } break;

   case 'visited': {

    if ($bug !== 'page' || $page !== 1) site_404_url();
    
    $content['catalog'] = $this->catalog_model->get_catalog_by_user_visited($this->session->userdata('user_id'));

   } break;

   case 'comments': {

    $pagination['COUNTONPAGE'] = 10;
    $pagination['COUNTALL'] = $this->user_model->comm_get_count($this->session->userdata('user_id'));

    $pagination['THISPAGE'] = (int)$page;
    if ($pagination['THISPAGE'] <= 0) site_404_url();

    $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);
    if ($pagination['COUNTPAGE'] > 0 && $pagination['THISPAGE'] > $pagination['COUNTPAGE']) site_404_url();

    $pagination['COUNTSHOWPAGE'] = 6;
    if ($pagination['THISPAGE'] == 1 || $pagination['THISPAGE'] == $pagination['COUNTPAGE']) $pagination['COUNTSHOWPAGE'] = 15;
    if ($pagination['COUNTPAGE'] <= 15) $pagination['COUNTSHOWPAGE'] = 15;

    $content['comments'] = $this->user_model->comm_get($this->session->userdata('user_id'), $pagination['THISPAGE'], $pagination['COUNTONPAGE']);
    
   } break;

   case 'orders': {

    if ($bug !== 'page' || $page !== 1) site_404_url();

    $content['orders'] = $this->user_model->user_get_orders($this->session->userdata('user_id'));

   } break;

   case 'order': {
    
    if ($page !== 1) site_404_url();

    $bug = (int)$bug;
    if (!$this->user_model->user_is_order($bug)) site_404_url();

    $content['order'] = $this->user_model->user_get_order($bug);

   } break;

  }

  $content['user'] = $this->user_model->user_get_info($this->session->userdata('user_id'));

  $this->data['SITE_CONTENT'] = $content;
  $this->data['PAGINATION'] = $pagination;
  
  $this->display_lib->user($this->data, $this->view);
 }


	//redirect if needed, otherwise display the user list
	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->_render_page('auth/index', $this->data);
		}
	}

	//log the user in
	function login()
	{
		$this->data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/', 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/login', $this->data);
		}
	}

	//log the user out
	function logout() {
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		// $this->session->set_flashdata('message', $this->ion_auth->messages());
		// redirect('auth/login', 'refresh');
  
  redirect(site_url(), 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->_render_page('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{  
		//setting validation rules by checking wheather identity is username or email
		if($this->config->item('identity', 'ion_auth') == 'username' )
		{
		   $this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required');	
		}
		else
		{
		   $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');	
		}
		
		
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $this->data);
		}
		else
		{
			// get identity from username or email
			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
			}
			else
			{
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
			}
	            	if(empty($identity)) {
	            		
	            		if($this->config->item('identity', 'ion_auth') == 'username')
		            	{
                                   $this->ion_auth->set_message('forgot_password_username_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_message('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->messages());
                		redirect("auth/forgot_password", 'refresh');
            		}

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				//if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false) {

		if ($code !== false) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

  #$this->session->set_userdata($this->config->item('own_box_show_on_load'), true);

		if ($activation) {
			//redirect them to the auth page
			// $this->session->set_flashdata('message', $this->ion_auth->messages());
			// redirect("auth", 'refresh');
   
   #$this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_act_okey_title');
   return true;
		} else {
			//redirect them to the forgot password page
			// $this->session->set_flashdata('message', $this->ion_auth->errors());
			// redirect("auth/forgot_password", 'refresh');
   
   #$this->session->set_userdata($this->config->item('own_box_error_msg'), 'ap_act_error_title');
   return false;
		}

  #redirect(site_url(), 'refresh');
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{
		$this->data['title'] = "Create User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$tables = $this->config->item('tables','ion_auth');

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->_render_page('auth/create_user', $this->data);
		}
	}

	//edit a user
	function edit_user($id)
	{
		$this->data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
		$this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);
				
				//update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}
				
			//check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }		
				
			}
		}

		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->_render_page('auth/edit_user', $this->data);
	}

	// create a new group
	function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $this->data);
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth/edit_group', $this->data);
	}


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

  public function registration(){

    $link = 'reg';

    $this->data = array();
    $this->data['__LINK'] = 'reg';
    $this->data['OTHER'] = true;

    $this->data['__GEN'] = array(
     'page_link' => $this->data['__LINK'],
     'page_other' => $this->data['OTHER']
    );

    parent::generateInData(
                           $this->data['__GEN'],
                           'registration_view',
                           'otherpage'
                          );

    $content = array();

    $this->data['SITE_CONTENT'] = $content;
    
    $this->display_lib->user($this->data, $this->view);
  }

  public function checkreg($link){
    switch ($link) {
      case 'form': {
              $data = $this->checkRegistration();
              } break;
      
      default:
        redirect(baseurl());
        break;
    }
    if(!$data) return false;
    else echo json_encode($data);
  }

  public function checkRegistration(){

  if (!isset($_POST['robot'])) return false;
  
  $this->load->library('form_validation');
  
  $this->form_validation->set_rules('name', 'name', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('surname', 'surname', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('fname', 'fname', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('email', 'email', 'required|valid_email');
  $this->form_validation->set_rules('phone', 'phone', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('people', 'people', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
  $this->form_validation->set_rules('password-conf', 'password-conf', 'required|xss_clean');
  
  $this->form_validation->set_message('required', '!');
  $this->form_validation->set_message('max_length', '!');
  $this->form_validation->set_message('valid_email', '!');
  
  if ($this->form_validation->run() == true) {
   
   $data_array = array(
    'name' => $this->input->post('name'),
    'surname' => $this->input->post('surname'),
    'fname' => $this->input->post('fname'),
    'email' => $this->input->post('email'),
    'phone' => $this->input->post('phone'),
    'people' => $this->input->post('people'),
    'password' => mb_substr($this->input->post('password'), 0, 5000),
    'datetime' => date('Y-m-d H:i:s')
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_order($data_array);
   
   if ($insert) {
    $data_array['insert_id'] = $insert;
    
    $this->load->library('send_lib');
    $this->send_lib->send_order($data_array, $this->cart->contents());
    
   }
   $_SESSION['id'] = $data_array;
   return array('order' => 'okey');
  } else {
   
   $errors = array();

   $temp = form_error('name');
   if (!empty($temp)) $errors['name'] = '!';
   
   $temp = form_error('name');
   if (!empty($temp)) $errors['surname'] = '!';

   $temp = form_error('name');
   if (!empty($temp)) $errors['fname'] = '!';
   
   $temp = form_error('email');
   if (!empty($temp)) $errors['email'] = '!';

   $temp = form_error('phone');
   if (!empty($temp)) $errors['phone'] = '!';
   
   $temp = form_error('address');
   if (!empty($temp)) $errors['passwrd'] = '!';
   
   $temp = form_error('message');
   if (!empty($temp)) $errors['password-conf'] = '!';
   
   return $errors;
  }
  
  return array('error' => '!');
  }

}
