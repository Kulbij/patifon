    <?php @session_start(); if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Main extends CI_Controller {

        private $b_array = array(
         'brand', 'c_color', 'k_desktop', 's_type', 's_cat', 's_textile', 'wr_type', 'wr_fasade', 'wr_corpus', 'wr_mirror', 'wr_size'
        );

        public function index() {
            $this->checkEnter();

            $data = array();

            $data['PAGE'] = 'index';

            $this->generateTop($data['PAGE']);
            $this->generateContent($data['PAGE']);
            $this->generateFooter();
        }

        /* IP */
        public function int2ip($i) {
         $d[0]=(int)($i/256/256/256);
         $d[1]=(int)(($i-$d[0]*256*256*256)/256/256);
         $d[2]=(int)(($i-$d[0]*256*256*256-$d[1]*256*256)/256);
         $d[3]=$i-$d[0]*256*256*256-$d[1]*256*256-$d[2]*256;
         return "$d[0].$d[1].$d[2].$d[3]";
        }

        public function ip2int($ip) {
         $a=explode(".",$ip);
         return $a[0]*256*256*256+$a[1]*256*256+$a[2]*256+$a[3];
        }
        /* end IP */

        public function module($module, $submodule = null, $category = null, $page = 0, $cat = 0, $brand = 0) {

            $this->checkEnter();	
            $this->load->model('security/module_model', 'model');

            if (!$this->model->isModule($module) || !$this->model->isSubmodule($submodule)) redirect(base_url());

            $data = array();

            $data['PAGE'] = $module;

            $this->generateTop($module);

            #if ($module != 'catalog' || (!is_null($submodule) && $submodule != 'object')) $cat = 0;

            if ($module == 'catalog') {
                if (is_null($submodule) || $submodule == 'object' || $submodule == 'components') $this->generateCatalogContent($module, $submodule, $page, $cat, $brand, $category);
                if ($submodule == 'catalog' || in_array($submodule, $this->b_array)) $this->generatePageCatContent($module, $submodule, $category);
                if ($submodule == 'color') $this->generatePageCatPageContent($module, $submodule, $category, $page);
                if ($submodule == 'auto') $this->generateDybokAuto($module, $submodule);
                if ($submodule == 'paket_option' || $submodule == 'cat_option' || $submodule == 'pakets') $this->generatePaketOption($module, $submodule, $category, $page);
            }
            elseif ($module == 'setting' && $submodule == 'scripts') $this->generateSettingScriptsContent($module, $submodule);
            elseif ($module == 'page' && ($submodule == 'artical' || $submodule == 'share')) $this->generateArtContent($module, $submodule, $category, $page);
            elseif ($module == 'clients' && (is_null($submodule) || $submodule == 'clients')) $this->generateClientContent($module, $submodule, $category, $page);
            elseif ($module == 'order') {

                if (is_null($submodule) || $submodule == 'order' || $submodule == 'order_one_click') $this->generateOrderContent($module, $submodule, $page, $category);
                elseif ($submodule == 'move') $this->generateMoveView($module, $submodule, $category);
                elseif ($submodule == 'move_saveuser') $this->generateMoveSaveUserView($module, $submodule, $category, $page);
                elseif ($submodule == 'move_savezakaz') $this->generateMoveSaveZakazView($module, $submodule, $category, $page);

            }
            elseif ($module == 'comments' && (is_null($submodule) || $submodule == 'comments')) 
    	    $this->generateCommContent($module, $submodule, $page);
            elseif ($module == 'message') {
                if (is_null($submodule)) $submodule = 'feedback';
                $this->generateOrderContent($module, $submodule, $category, $page);
            }
            elseif ($module == 'gallery') {

                if (is_null($submodule)) $submodule = 'gallerycat';

                if ($submodule == 'gallerycat') $this->generateGalleryCat($module, $submodule);
                elseif ($submodule == 'gallery') $this->generateGallery($module, $submodule, $category);

            }
            else $this->generateContent($module, $submodule);

            $this->generateFooter();
        }

        protected function generateCatalogBPContent($module, $submodule, $page) {
            $this->load->model('menu_model');

            $data = array();

            if (is_null($submodule) || empty($submodule)) $submodule = 'brand';

            $count = 100;

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['data'] = $this->submodel->getAll($page, $count)
;
            $data['COUNTONPAGE'] = $count;
            $data['ALLPAGE'] = $this->submodel->countAll();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            if ($page == 0) $page = 1;

            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);
        }

        protected function generateCatalogCatContent($module, $submodule) {
            $this->load->model('menu_model');

            $data = array();

            if (is_null($submodule) || empty($submodule)) $submodule = 'category';
            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['menu'] = $this->submodel->getParentItems();
            $data['submenu'] = $this->submodel->getChildItems();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);
        }

        protected function generateCatalogContent($module, $submodule, $page = 0, $cat = -1, $brand = 0, $cobject_components = 0) {
            $this->load->model('menu_model');

            $data = array();

            $count = 100;
            if ($submodule == 'components') $count = 10;
            if (!empty($_GET)) $count = 99999;

            if (is_null($submodule) || empty($submodule)) $submodule = 'object';
            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            #if ($submodule == 'object' /* && $cat == -1*/) $cat = 0; #$this->submodel->getFirstCat();

            if ($submodule == 'components') {
             $data['content']['data_main'] = $this->submodel->getPreviewObj(0, 0, $cat, $brand);

             $data['content']['data'] = $this->submodel->getPreviewObj(0, 0, 0, 0, $cobject_components, true);

             $data['OBJECT_THIS'] = $cobject_components;
            } else $data['content']['data'] = $this->submodel->getPreviewObj($page, $count, $cat, $brand);

            if ($submodule == 'components') $data['COUNTPRO'] = 0;
            else $data['COUNTPRO'] = $this->submodel->countProduct($cat, $brand);

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $data['COUNTONPAGE'] = $count;
            $data['ALLPAGE'] = $data['COUNTPRO'];
            
            $data['cats'] = $this->submodel->getCats();
            $data['sorts'] = $this->submodel->getSorts();

            $_SESSION['cat_selected'] = $cat;
            $_SESSION['prod_selected'] = $brand;

            $data['CATTHIS'] = $cat;
            $data['BRANDTHIS'] = $brand;

            if ($page == 0) $page = 1;

            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);
        }

        //---GALLERY region
        public function generateGalleryCat($module, $submodule) {

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['content']['data'] = $this->submodel->selectPreviewAll();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }

        public function generateGallery($module, $submodule, $catid = 0) {

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            if ($catid <= 0) $catid = $this->submodel->getFirstCatID();

            $data['content']['data'] = $this->submodel->selectPreviewAll($catid);
            $data['COUNTPRO'] = $this->submodel->countProduct($catid);

            $data['categories'] = $this->submodel->getCategories();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;
            $data['THISCATALOG'] = $catid;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }
        //--end GALLERY region

        //---PAGE region
        private function image_to_ext($img = '', $ext = '') {
         if (empty($img)) return '';
         if (empty($ext)) return $img;
         $two = explode('.', $img);
         $count = count($two);
         if (!is_array($two) || count($two) < 2) return '';
         $return = '';
         for ($i = 0; $i < $count - 1; ++$i) $return .= $two[$i];
         $return .= $ext.'.'.end($two);
         return $return;
        }

        protected function generateContent($module, $submodule = null) {
            $this->load->model('menu_model');
            if ($module == 'index') {

             $data = array();

             if ($this->input->get('get_product_file') !== false) {

              $products = $this->db->select('id, name_ru, price, old_price')->from('site_catalog')->order_by('id', 'ASC')->get()->result_array();

              require_once $this->input->server('DOCUMENT_ROOT').$this->config->item('test_add').'/application/third_party/php_excel_1.8/PHPExcel.php';
              $file = new PHPExcel();

              $file->getProperties()->setCreator("Ukrmebli")
               ->setLastModifiedBy("Ukrmebli")
               ->setTitle("Ukrmebli products")
               ->setSubject("Ukrmebli products")
               ->setDescription("Ukrmebli products with prices")
               ->setKeywords("Ukrmebli products with prices")
               ->setCategory("Ukrmebli products with prices")
               ;

              $file->setActiveSheetIndex(0)
               ->setCellValue('A1', 'ИД')
               ->setCellValue('B1', 'Название')
               ->setCellValue('C1', 'Старая цена')
               ->setCellValue('D1', 'Цена')
               ;

              $file_index = 2;
              foreach ($products as $one) {

               $file->setActiveSheetIndex(0)
                ->setCellValue('A'.$file_index, $one['id'])
                ->setCellValue('B'.$file_index, $one['name_ru'])
                ->setCellValue('C'.$file_index, $one['old_price'])
                ->setCellValue('D'.$file_index, $one['price'])
                ;

               ++$file_index;
              }


              #return to browser
              // Redirect output to a client’s web browser (Excel5)
              header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="ukrmebli_prices.xls"');
              header('Cache-Control: max-age=0');
              // If you're serving to IE 9, then the following may be needed
              header('Cache-Control: max-age=1');

              // If you're serving to IE over SSL, then the following may be needed
              header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
              header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
              header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
              header ('Pragma: public'); // HTTP/1.0

              $writer = PHPExcel_IOFactory::createWriter($file, 'Excel5');
              $writer->save('php://output');

              die();

             } else if ($this->input->post('read_prices') !== false) {

              if (!isset($_FILES['price_file']['tmp_name']) || empty($_FILES['price_file']['tmp_name']))
               $data['f_errors'] = 'Ви не вибрали файл з цінами!';
              else {

               require_once $this->input->server('DOCUMENT_ROOT').$this->config->item('test_add').'/application/third_party/php_excel_1.8/PHPExcel.php';

               $file_type = PHPExcel_IOFactory::identify($_FILES['price_file']['tmp_name']);

               $_reader = PHPExcel_IOFactory::createReader($file_type);
               $_reader->setReadDataOnly(true);

               $_file = $_reader->load($_FILES['price_file']['tmp_name']);
               $_data = $_file->getActiveSheet()->toArray(null, true, true, true);
               #echo '<pre>', print_r($_data, true), '</pre>'; die();

               #--> to 2
               foreach ($_data as $key => $value) {

                if ($key > 1 && isset($value['A']) && $value['A'] > 0) {

                 $up_array = array(
                  'name_ru' => isset($value['B']) ? $value['B'] : '',
                  'old_price' => isset($value['C']) ? (float)$value['C'] : 0,
                  'price' => isset($value['D']) ? (float)$value['D'] : 0
                 );

                 $this->db
                         ->where('id = '.$this->db->escape($value['A']))
                         ->limit(1)
                         ->update('site_catalog', $up_array)
                         ;

                }

               }

               $data['f_okey'] = 'Ціни оновлено!';
              }

             }

             $this->load->view('index_page', $data);

            } else {
                if (is_null($submodule)) {
                    $submodule = $this->menu_model->selectChildrenByLink($module);
                    if ($submodule == false || count($submodule) <= 0) redirect(base_url());

                    $submodule = $submodule[0]['link'];
                }

                $data = array();

                $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
                $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

                if ($submodule == 'number') $this->load->model($module.'/'.$module.'_page_model', 'submodel');
                else $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

                if ($submodule == 'number') $data['content']['data'] = $this->submodel->selectNumberAll();
                else $data['content']['data'] = $this->submodel->selectPreviewAll();

                $data['MODULE'] = $module;
                $data['SUBMODULE'] = $submodule;

                if ($submodule == 'number') $submodule = 'page';

                $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

            }
        }

        public function generatePageCatContent($module, $submodule, $cat = 0) {

            $this->load->model('menu_model');

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['content']['data'] = $this->submodel->selectPreviewAll($cat);

            if ($submodule == 'group') {
             $data['cats'] = $this->submodel->getCats();
            }

            if (in_array($submodule, $this->b_array)) {
             $data['cats'] = $this->submodel->getCats();
            }

            $data['CATTHIS'] = $cat;
            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            // echo "<pre>"; print_r($data['content']['data']); die();

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }

        public function generatePaketOption($module, $submodule, $page, $category = 0) {

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $count = 100;

            $data['content']['data'] = $this->submodel->selectPreviewAll($page, $count, $category);
            if($submodule != 'cat_option') $data['cats'] = $this->submodel->getCategory();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;
            $data['CATEGORY'] = $category;

            $data['CATTHIS'] = $page;

            $data['COUNTPRO'] = 1000;

            $data['COUNTONPAGE'] = $count;

            if ($page == 0) $page = 1;
            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);
        }

        public function generatePageCatPageContent($module, $submodule, $page, $category = 0) {

            $this->load->model('menu_model');

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $count = 100;

            $data['content']['data'] = $this->submodel->selectPreviewAll($page, $count, $category);

            $this->load->model('page/page_page_model');
            $data['menu'] = $this->page_page_model->selectPreviewAll(0, 0, false);

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;
            $data['CATEGORY'] = $category;

            $data['COUNTONPAGE'] = $count;

            $data['ALLPAGE'] = $data['COUNTPRO'] = $this->submodel->getCount($category);

            if ($page == 0) $page = 1;
            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }
        //---end PAGE region

        public function generateCommContent($module, $submodule, $page = 1) {

            $this->load->model('menu_model');

            $submodule = 'comments';

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $count = 100;

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['content']['data'] = $this->submodel->selectPreviewAll($page, $count);

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $data['allcomments'] = $this->submodel->countComm();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $data['COUNTONPAGE'] = $count;
            $data['ALLPAGE'] = $data['allcomments'];

            if ($page == 0) $page = 1;

            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }

        public function generateOrderContent($module, $submodule, $category = 0, $page = 0, $pages = 1) {

            $this->load->model('menu_model');
            $_SESSION['order_search'] = '';

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            /////////==============================
            if(isset($_POST) && !empty($_POST)) {
              $query_result_post_searh = 1;
              $array = $_POST;
              $this->load->model('catalog/catalog_object_model');
             } else {$query_result_post_searh = 0;}
            ////////==============

            if (is_null($submodule)) $submodule = 'order';

            $count = 100;

            if($submodule == 'review'){if($category == '') $category = 0;}

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            if($submodule == 'order' || $submodule == 'order_one_click' || $submodule == 'feedback' || $submodule == 'feedphone' || $submodule == 'review') {
              foreach($data['content']['subs'] as $key => $value){
                $data['content']['subs'][$key]['count'] = $this->submodel->selectAllCountOrder($value['link']);
              }
            }

            unset($data['content']['subs'][3]);

            if($submodule == 'order_one_click'){
              if($query_result_post_searh == 1){
                if(isset($array['search']) && !empty($array['search'])){
                  $data['content']['data'] = $this->catalog_object_model->SearchOrderOneClick($array);
                  if(isset($data['content']['data']) && !empty($data['content']['data'])){
                    $_SESSION['order_search'] = 0;
                  } else $_SESSION['order_search'] = 1;
                } else {
                  $_SESSION['order_search'] = 1;
                  $data['content']['data'] = '';
                }
              } else {
                if($page == '') $page = 0;
                if($page == '' || $page == 0){
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count);
                } elseif($page == 1){
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count, 1);
                } elseif($page == 2){
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count, 2);
                } else $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count);
              }
            } elseif($submodule == 'order'){
              if($query_result_post_searh == 1){
                if(isset($array['search']) && !empty($array['search'])){
                  $data['content']['data'] = $this->catalog_object_model->SearchOrder($array);
                  if(isset($data['content']['data']) && !empty($data['content']['data'])){
                    $_SESSION['order_search'] = 0;
                  } else $_SESSION['order_search'] = 1;
                } else {
                  $_SESSION['order_search'] = 1;
                  $data['content']['data'] = '';
                }
              } else {
                if($page == '') $page = 0;
                if($page == '' || $page == 0){
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count);
                } elseif($page == 1){
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count, 1);
                } elseif($page == 2){
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count, 2);
                } else $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count);
              }
            } elseif($submodule == 'review'){
                $data['content']['data'] = $this->submodel->selectPreviewAll($page, $count);
            } else {
              $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count);
            }

            if($submodule == 'review'){
                $data['cats'] = $this->submodel->getCategory();
            }
            if($submodule != 'order') {
                if(isset($category) && $category > 0) {
                    $data['content']['data'] = $this->submodel->selectPreviewAll($category, $count);
                }
            }
            if($submodule == 'review'){
                if(isset($category) && $category > 0) {
                    $data['content']['data'] = $this->submodel->selectMessages($category, $count);
                }
            }
            if($module == 'order'){
              if($submodule == 'order'){
                if(isset($data['content']['data']) && !empty($data['content']['data'])){
                  foreach($data['content']['data'] as $k => $v){
                      $data['content']['data'][$k]['phone'] = $this->create_phone($v['phone']);
                    } unset($v);
                }
              }
            }

            // echo "<pre>"; print_r($data['content']['data']); die()
;
            if($submodule == 'review') {
                foreach($data['content']['data'] as $key => $value) {
                    $data['content']['data'][$key]['name_obj'] = $this->submodel->selectProduct($value['id']);
                }unset($value);
            }
            if($submodule == 'order_one_click') {
                $this->load->model('order/order_order_one_click_model', 'one');
                if(isset($data['content']['data']) && !empty($data['content']['data'])) {
                  if($page == 0){
                      foreach($data['content']['data'] as $key => $one) {
                          $data['content']['data'][$key]['phone'] = $this->create_phone($one['phone']);
                          $data['content']['data'][$key]['object'] = $this->one->getObject($one['product_id']);
                      }unset($value);
                  }
                }
            }

            if($submodule == 'order'){
                $data['content']['statuses'] = $this->submodel->getOrderStatuses();
                $data['content']['statuses_email'] = $this->submodel->getOrderStatusEmail();
                //echo "<pre>"; print_r($data['content']['statuses_email']); die();
                if($query_result_post_searh == 1){

                }
                $data['content']['count'] = 1;
            } elseif($submodule == 'order_one_click'){
                $data['content']['statuses'] = $this->submodel->getOrderStatuses();
            }
            
            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            if($submodule == 'review') {
                if($category == '0') $data['COUNTPRO'] = $this->submodel->countOrderAll();
                else $data['COUNTPRO'] = $this->submodel->countOrder($category, $page);
            } elseif($submodule == 'order'){
              if($query_result_post_searh == 1){
                $data['COUNTPRO'] = count($data['content']['data']);
              } else $data['COUNTPRO'] = $this->submodel->countOrder($category, $page);
          } elseif($submodule == 'order_one_click'){
            if($query_result_post_searh == 1){
                $data['COUNTPRO'] = count($data['content']['data']);
              } else $data['COUNTPRO'] = $this->submodel->countOrder($category, $page);
          }

          if(isset($data['COUNTPRO']) && !empty($data['COUNTPRO'])) $data['COUNTPRO'] = $data['COUNTPRO'];
          else $data['COUNTPRO'] = 0;



            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $data['COUNTONPAGE'] = $count;
            $data['ALLPAGE'] = $data['COUNTPRO'];
            if($submodule == 'order_one_click') {
                if($page == '') $page = 0;
                $data['CATTHIS'] = $page;
            } elseif($submodule == 'order'){
                if($page == '') $page = 0;
                $data['CATTHIS'] = $page;
            } else {
                if ($page == 0) $page = 1;
                $data['CATTHIS'] = $category;
            }

            if($submodule == 'order' || $submodule == 'order_one_click') {
                if($category == '') $category = 1;
                $data['THISPAGE'] = $category;
            } elseif($submodule == 'review') {
                $data['THISPAGE'] = $page;
                $data['PAGE'] = $category;
            }
            else $data['THISPAGE'] = $category;

            // review_view
            if(isset($category) && $category > 0) $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);
            else $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }

        public function create_phone($phone){
            $phone = $phone;
            $new_p = explode('(', $phone);
            $new_p1 = $new_p[0].$new_p[1];
            $new_p2 = explode(')', $new_p1);
            $new_p3 = $new_p2[0].$new_p2[1];
            $new_p4 = explode(' ', $new_p3);
            $new_p01 = $new_p4[0].$new_p4[1].$new_p4[2];
            $new_p5 = explode('–', $new_p01);

            $create_new_phone = $new_p5[0].$new_p5[1].$new_p5[2];
            $create_new_phone_pne = explode('+38', $create_new_phone);
            return $create_new_phone_pne[1];
        }

        //---ART region
        protected function generateArtContent($module, $submodule, $cat = 'all', $page = 0) {

            $this->load->model('menu_model');

            $data = array();

            $count = 50;

            if (is_null($submodule) || empty($submodule)) $submodule = 'artical';

            if (is_null($cat) || empty($cat)) $cat = 'all';

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['content']['data'] = $this->submodel->selectPreviewAll($page, $count, $cat);

            $data['COUNTPRO'] = $this->submodel->countProduct($cat);

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $data['COUNTONPAGE'] = $count;
            $data['ALLPAGE'] = $data['COUNTPRO'];

            $data['cats'] = $this->submodel->getCats();

            $data['CATTHIS'] = $cat;

            if ($page == 0) $page = 1;

            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }
        //---end ART region

        //---CLIENT region
        protected function generateClientContent($module, $submodule, $cat = 0, $page = 0) {
            $this->load->model('menu_model');

            $data = array();

            $count = 100;
            if (!empty($_POST)) $count = 9999999;

            if (is_null($submodule) || empty($submodule)) $submodule = 'clients';

            if (is_null($cat) || empty($cat)) $cat = 0;

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['content']['data'] = $this->submodel->get($page, $count, $cat);

            $data['COUNTPRO'] = $this->submodel->get_count($cat);

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $data['COUNTONPAGE'] = $count;
            $data['ALLPAGE'] = $data['COUNTPRO'];

            $data['CATTHIS'] = $cat;

            if ($page == 0) $page = 1;

            $data['THISPAGE'] = $page;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);
        }
        //---end CLIENT region

        //---SETTING region
        public function generateSettingScriptsContent($module, $submodule) {

            $this->load->model('menu_model');

            $data = array();

            $data['content']['modulename'] = $this->menu_model->selectMenuName($module);
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink($module);

            $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'submodel');

            $data['content']['data'] = $this->submodel->selectPreviewAll();

            $data['MODULE'] = $module;
            $data['SUBMODULE'] = $submodule;

            $this->load->view($module.'/'.$module.'_'.$submodule.'_view.php', $data);

        }
        //---end SETTING region

        //---TOP FOOTER region
        protected function generateTop($PAGE) {
            $data = array();

            $this->load->model('menu_model');
            $this->load->model('user_model');

            $data['top']['administrator'] = $this->user_model->selectNameByID(/*$this->session->userdata('id')*/$_SESSION['id_admin_data']);
            $data['top']['menu'] = $this->menu_model->selectParent();

            $data['top']['order_round'] = $this->menu_model->getOR();
            $data['top']['message_round'] = $this->menu_model->getMR();

            $data['PAGE'] = $PAGE;

            $this->load->view('top_view.php', $data);
        }

        protected function generateFooter() {
            $this->load->view('footer_view.php');
        }
        //---end TOP FOOTER region

        //---LOGIN region

        //check if admin enter
        protected function checkEnter() {
            if (/*$this->session->userdata('id_admin_data')*/isset($_SESSION['id_admin_data']) && is_numeric($_SESSION['id_admin_data']) && $_SESSION['id_admin_data'] > 0) {
                //$id = $this->session->userdata('id_admin_data');
                //$this->session->set_userdata('id_admin_data', $id);
                return true;
            }

            redirect(base_url());
        }

        //login function
        public function login() {

            if (/*$this->session->userdata('id_admin_data')*/isset($_SESSION['id_admin_data']) && is_numeric($_SESSION['id_admin_data']) && $_SESSION['id_admin_data'] > 0) {
                //echo "<meta http-equiv='refresh' content='0; url=".base_url()."index'>";
                redirect(base_url().'index');
            }

            $data = array();

            if (isset($_POST['username']) && isset($_POST['password'])) {

                $_POST['username'] = addslashes(mb_strtolower($_POST['username']));

                $this->load->library('security/password_lib');

                $this->load->model("user_model");

                if (!empty($_POST['username']) && $this->password_lib->tryPass($_POST['password'])) $userid = $this->user_model->checkUser($_POST['username'], $this->password_lib->createPass($_POST['password']));
                else $userid = false;

                if ($userid !== false) {
                    $_SESSION = array();
                    $_SESSION['id_admin_data'] = $userid;
                    //$this->session->set_userdata('id_admin_data', $userid);
                    //echo "<meta http-equiv='refresh' content='0; url=".base_url()."index'>";

                    redirect(base_url().'index');

                }

                $data['error'] = true;

            }

            $this->load->view('login_view.php', $data);
        }

        public function logout() {
            $_SESSION = array();
            //$this->session->sess_destroy();
            redirect(base_url());
        }
        //---end LOGIN region


        private function editBreadcrumbs($thisid = 0, $parent_id = false, $parent_name = false) {
            $data = array();

            $this->load->model('security/module_model', 'module_bread');

            $data[0]['name'] = $this->module_bread->getByLink($this->uri->segment(1), true);
            $data[0]['link'] = $this->uri->segment(1);

            $data[1]['name'] = $this->module_bread->getByLink($this->uri->segment(2));
            $data[1]['link'] = $this->uri->segment(2).'/'.$this->uri->segment(2);

            if ($parent_id && $parent_name) {

                $i = 2;

                $par_cat = $this->module_bread->getCat($parent_id);

                if (is_array($par_cat) && isset($par_cat['id']) && isset($par_cat['name'])) {

                    $data[$i]['name'] = $par_cat['name'];
                    $data[$i]['link'] = "catalog/object/0/1/{$par_cat['id']}/0";

                    $i++;

                }

                $data[$i]['name'] = $parent_name;
                $data[$i]['link'] = 'edit/catalog/object/'.$parent_id;

            } else {

                $i = 2;

                $par_cat = $this->module_bread->getCat($thisid);

                if (is_array($par_cat) && isset($par_cat['id']) && isset($par_cat['name'])) {

                    $data[$i]['name'] = $par_cat['name'];
                    $data[$i]['link'] = "catalog/object/0/1/{$par_cat['id']}/0";

                    $i++;

                }

            }

            return $data;
        }

    }