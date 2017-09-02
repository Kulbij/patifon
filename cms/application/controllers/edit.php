<?php #@session_start();
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/main.php';
class Edit extends Main {

    private $b_array = array(
     'brand', 'c_color', 'k_desktop', 's_type', 's_cat', 's_textile', 'wr_type', 'wr_fasade', 'wr_corpus', 'wr_mirror', 'wr_size'
    );

    public function index() {

    }
    public function copy($submodule, $id){
        parent::checkEnter();
        $this->load->model('security/module_model', 'module_model');
        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());        
        switch($submodule){
            case 'object':{
                $this->load->model('catalog/catalog_object_model');
                $return = $this->catalog_object_model->copyObject($id);
            }break;
        }
        redirect('edit/catalog/object/'.$return);
    }    
    //---PAGE region
    public function page($submodule, $link = -1) {
        parent::checkEnter();

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        $module = 'page';

        parent::generateTop($module);
        $this->generateContent($module, $submodule, $link);
        parent::generateFooter();
    }

    public function indeximg($id = null) {
        parent::checkEnter();

        $this->load->model('security/module_model', 'module_model');

        $module = 'page';
        $submodule = 'indeximg';

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        parent::generateTop($module);
        $this->generatePageIndexImgContent($module, $submodule, $id);
        parent::generateFooter();
    }

    protected function generatePageIndexImgContent($module, $submodule, $id = null) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        if (!is_null($id)) {
            $data['content'] = $this->model->selectIndexImg($id);
            if (count($data['content']) > 0) $data['content'] = $data['content'][0];
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if (!is_null($id)) $data['ID'] = $id;
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }
    //---end PAGE region

    //---GALLERY region
    public function gallerycat($id = 0) {
        parent::checkEnter();

        $submodule = 'gallerycat';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        $module = 'gallery';

        parent::generateTop($module);
        $this->generateGalleryContent($module, $submodule, $id);
        parent::generateFooter();
    }

    protected function generateGalleryContent($module, $submodule, $id = null) {

        if (is_null($id)) redirect(base_url().'gallery');

        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        if ($id > 0) $data['content'] = $this->model->selectObject($id);

        $data['CATS'] = $this->model->selectPreviewAll();

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['ID'] = $id;
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }
    //---end GALLERY region

    //---CLIENTS region
    public function clients($id) {
        parent::checkEnter();

        $submodule = 'clients';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        $module = 'clients';

        parent::generateTop($module);
        $this->generateClientContent($module, $submodule, $id);
        parent::generateFooter();
    }

    protected function generateClientContent($module, $submodule, $id = null) {

        if (is_null($id)) redirect(base_url().'clients');

        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['content'] = $this->model->get_one($id);
        if (count($data['content']) > 0) $data['content'] = $data['content'][0];

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['ID'] = $id;
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }
    //---end CLIENTS region

    //---SETTING region
    public function setting($id = null) {

        parent::checkEnter();

        $submodule = 'scripts';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        $module = 'setting';

        parent::generateTop($module);
        $this->generateSettingScriptContent($module, $submodule, $id);
        parent::generateFooter();

    }

    protected function generateSettingScriptContent($module, $submodule, $id) {

        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        if (!is_null($id) && $id > 0) {
            $data['content'] = $this->model->selectScript($id);
            $data['content'] = $data['content'][0];
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['ID'] = $id;
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);

    }
    //---end SETTING region

    //---CATALOGTYPE region
    public function catalogtype($catid = null, $link = null) {
        parent::checkEnter();

        $submodule = 'catalogtype';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        $module = 'catalog';

        parent::generateTop($module);
        $this->generateCatalogTypeContent($module, $submodule, $link, $catid);
        parent::generateFooter();
    }

    protected function generateCatalogTypeContent($module, $submodule, $link, $catid) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['content'] = $this->model->selectPage($catid, $link);
        if (count($data['content']) > 0) $data['content'] = $data['content'][0];

        $data['catalog'] = $this->model->getCatalog();
        if (!is_null($catid)) $data['cataloglink'] = $this->model->getCatalogLink($catid);

        $data['breadcrumbs'] = $this->breadcrumbs();

        if (!is_null($link) && !is_null($catid)) $data['LINK'] = $this->model->getID($catid, $link);
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }

    //---end CATALOGTYPE region

    public function user($submodule, $username = null) {
        parent::checkEnter();

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        $module = 'setting';

        parent::generateTop($module);
        $this->generateContentUser($module, $submodule, $username);
        parent::generateFooter();
    }

    //---CATALOG region
    public function catalog($submodule, $id = null, $parent = 0, $parent_complect = 0) {

        parent::checkEnter();

        $module = 'catalog';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        parent::generateTop($module);
        if ($submodule == 'object' || $submodule == 'components') $this->generateObjectContent($module, $submodule, $id, $parent, $parent_complect);
        else $this->generateContent($module, $submodule, $id);
        parent::generateFooter();
    }

    protected function generateObjectContent($module, $submodule, $id, $parent = 0, $parent_complect = 0) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $this->load->model('page/page_page_model');
        $data['pages']= $this->page_page_model->selectPreviewAll(0, 0, false);

        $data['PARENT_PARENT'] = $parent;
        #$data['PARENT_COMPLECT'] = $parent_complect;

        if ($id > 0) {
            $data['filters'] = $this->model->getFilters($id);
            $data['filters_already'] = $this->model->getFiltersAlready($id);
        }

        $_catid = $this->model->getObjectParentMainCat($id);    
        $this->load->model('catalog/catalog_k_desktop_model');
        #$data['size_table'] = $this->catalog_k_desktop_model->selectPage($_catid);
        #$data['size_object'] = $this->model->getSizeTable($id);

        $data['CURRS'] = $this->model->getCurrs();
      
        $data['managers'] = $this->model->getManagers();
        $data['omanagers'] = $this->model->getManagersO($id);
        $data['IDIS_ITEM_MAN'] = $this->model->getManagersO($id, true);

        $data['cats'] = $this->model->getCats(); //+

        // --- my new connct DB get Acc

            $data['acc'] = $this->model->getAcc();
            $data['obj'] = $this->model->getObj($id);
            $data['colf'] = $this->model->getObj();

        // ---------- end
        
        $data['cats_o'] = $this->model->getCatsO($id); //+
        $data['acc_o'] = $this->model->getAccO($id); //+

        $data['obj_o'] = $this->model->getColorsF_color($id); //+
        

        $data['colf_o'] = $this->model->getCatalogCatalog($id); //+

        // delete this id for category for copy object
        foreach($data['colf'] as $key => $valie){
            if($valie['id'] == $id) unset($data['colf'][$key]);
        } unset($valie);
        // ----------------------------ebd -----------------

        //echo "<pre>"; print_r($data['acc_o']); die();
        $data['cats_oid'] = $this->model->getColorsfID($id); //+
        $data['acc_old'] = $this->model->getAccesuariesID($id); //+
        $data['color_old'] = $this->model->getColorsOldID($id); //+

        #$data['catalog'] = $this->model->getAllType($id); //+
        $data['produser'] = $this->model->getAllRegion(); //+
        #$data['mat_fasade'] = $this->model->getAllFasade(); //+
        #$data['mat_corpus'] = $this->model->getAllCorpus(); //+

        #$data['margin'] = $this->model->getAllLook(); //+
        $data['actions'] = $this->model->getActions(); //+

        $data['content'] = $this->model->getObjectE($id); //+
        if(empty($data['content'])) $data['content']['product-visible'] = 1;
        $data['OBJID'] = $id;

        #$data['prices'] = $this->model->getObjPrices($id);

        $data['colors'] = $this->model->getColors();

        $data['ocolors'] = $this->model->getGarOpt($id);
        $data['IDIS_ITEM'] = $this->model->getOnlyID($id);

        $data['colors1'] = $this->model->getItems($id);

        $data['shares'] = $this->model->getActions();

        #$data['ocolors_cor'] = $this->model->getGarOpt_cor($id);
        #$data['IDIS_ITEM_COR'] = $this->model->getOnlyID_cor($id);

        /*
        $data['colors_sty'] = $this->model->getGarOptStyle();
        $data['ocolors_sty'] = $this->model->getGarOpt_style($id);
        $data['IDIS_ITEM_STY'] = $this->model->getOnlyID_style($id);

        $data['colors_colors'] = $this->model->getNEWColors();
        $data['ocolors_colors'] = $this->model->getNEWColorsByID($id);
        $data['IDIS_ITEM_COLORS'] = $this->model->getNEWColorsByID($id, true);

        $data['colors_colors_c'] = $this->model->getNEWColors();
        $data['ocolors_colors_c'] = $this->model->getNEWColorsByID($id, false, true);
        $data['IDIS_ITEM_COLORS_C'] = $this->model->getNEWColorsByID($id, true, true);

        $data['colors_colors_tt'] = $this->model->getTextile();
        $data['ocolors_colors_tt'] = $this->model->getTextileByID($id, false);
        $data['IDIS_ITEM_COLORS_TT'] = $this->model->getTextileByID($id, true);
        */

        $data['images'] = $this->model->getObjImg($id);

        $data['components'] = $this->model->getComponents($id);
        $data['comp_idis'] = $this->model->getCompIdis($id);

        #$data['complects_'] = $this->model->getComplects($id);
        #$data['complect_idis'] = $this->model->getComplectIdis($id);

        $data['alltovar'] = $this->model->getAllT($id);

        $data['IDIS_ITEM_COLF'] = $this->model->getColorsfID($id);
        $data['ocolorsf'] = $this->model->getColorsF($id);

        $data['IDIS_ITEM_COLF_acc'] = $this->model->getColorsfID_acc($id);
        $data['ocolorsf_acc'] = $this->model->getColorsF_acc($id);

        $data['IDIS_ITEM_COLF_color'] = $this->model->getColorsfID_color($id);
        $data['ocolorsf_color'] = $this->model->getColorsF_color($id);

        /*
        $this->load->model('catalog/catalog_s_textile_model');
        $data['textiles'] = $this->catalog_s_textile_model->selectPreviewAll();
        */

        // ---------------- Paket_option -----------------
        $data['cat_paket'] = $this->model->getCategoryOption();
        $data['idis_option'] = $this->model->getIDisOption($id);

        //echo "<pre>"; print_r($data['idis_option']); die();

        // ------------------- Video -----------------------

        $data['video'] = $this->model->getVideo($id);

        // ----------------- end option -----------------

        $data['ID'] = $id;
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;

        if (isset($_SESSION['PARENT_']) && !$this->model->ifIs($id)) $data['breadcrumbs'] = $this->breadcrumbs($id, $this->model->getUParentI($_SESSION['PARENT_']), $this->model->getUParentN($_SESSION['PARENT_']));
        else $data['breadcrumbs'] = $this->breadcrumbs($id, $this->model->getParentI($id), $this->model->getParentN($id));

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }

    protected function generateContent($module, $submodule, $link) {
        $data = array();

        if ($submodule == 'comments') $module = 'comments';

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['content'] = $this->model->selectPage($link);
        if (count($data['content']) > 0) $data['content'] = $data['content'][0];

        $data['breadcrumbs'] = $this->breadcrumbs();

        if ($module == 'page' && (is_null($submodule) || $submodule == 'page')) {
         $data_id = 0;
         if (isset($data['content']['id'])) $data_id = (int)$data['content']['id'];
         $data['CATS'] = $this->model->selectPreviewAll(0, $data_id, false);
        }

        if (in_array($submodule, $this->b_array)) {
         $data['CATS'] = $this->model->getCats();
        }

        if ($module == 'page' && $submodule == 'share') {

            $data['CATS'] = $this->model->getCats();

        }

        if ($module == 'page' && $submodule == 'artical') {

            $data['CATS'] = $this->model->getCats();

        }

        if ($submodule == 'catalog') {
         $data['CATS'] = $this->model->selectPreviewAll(0, false, (int)$link);

         $this->load->model('catalog/catalog_brand_model');
         $data['filters'] = $this->catalog_brand_model->selectPreviewAll(0, true, true);

         $data['filters_already'] = $this->model->getFilters($link);
        }

        if ($submodule == 'group') {
         $data['CATS'] = $this->model->getCats();

         $this->load->model('catalog/catalog_object_model', 's_model');
         $data['allt'] = $this->s_model->getAllCatalog();
        }

        if ($submodule == 'color') {
         $data['FID'] = $this->model->getFID();
         $data['SID'] = $this->model->getSID();
        }

        if ($submodule == 's_type') {
            $this->load->model('catalog/catalog_object_model');
            $data['ALLT'] = $this->catalog_object_model->getAllT(0);

            $this->load->model('catalog/catalog_catalog_model');
            $data['ALLC'] = $this->catalog_catalog_model->selectPreviewAll();

            $data['ALLB'] = $this->model->getBrand();
        }
        if($submodule == 'paket_option'){
            $data['content'] = array();
            $data['content'] = $this->model->getOne($link);
            $data['cats'] = $this->model->getCategory();
            $data['option'] = $this->model->getOptions();
            $data['cat_true'] = $this->model->getOneCategory($link);
            $data['show_option'] = $this->model->getOptionID($link);
            // echo "<pre>"; print_r($data['show_option']); die();
            $data['option_oid'] = $this->model->getThisID($link);
        }
        if($submodule == 'cat_option'){
            $data['content'] = array();
            $data['content'] = $this->model->getOne($link);
        }
        if($submodule == 'brand'){
            $data['content']['image_big'] = $this->model->getImage($link);
        }
        if($submodule == 'pakets'){
            $data['content'] = array();
            $data['content'] = $this->model->getOne($link);
        }

        if (!is_null($link)) $data['LINK'] = $link;
        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;       
        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }

    protected function generateEditCatalogContent($module, $submodule, $id) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['content'] = $this->model->getWork($id);
        if (count($data['content']) > 0) $data['content'] = $data['content'][0];

        $data['catalog'] = $this->model->getCats();
        if (!is_null($id)) $data['sort'] = $this->model->getWorkSorts($id);
        $data['recomend'] = $this->model->getSortsFor($this->model->getCatalogWork($id));

        $data['images'] = $this->model->getWorkImage($id);

        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;
        if (!is_null($id)) $data['ID'] = $id;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }
    //---end CATALOG region

    //---ORDER region
    public function order($submodule, $id = null) {

        parent::checkEnter();

        if (is_null($id)) redirect(base_url().'order');

        $module = 'order';
        #$submodule = 'order';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        parent::generateTop($module);
        $this->generateEditOrderContent($module, $submodule, $id);
        parent::generateFooter();

    }
    public function gproject($id = null) {
        parent::checkEnter();

        if (is_null($id)) redirect(base_url().'order');

        $module = 'order';
        $submodule = 'project';

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        parent::generateTop($module);
        $this->generateEditOrderContent($module, $submodule, $id);
        parent::generateFooter();

    }

    public function message($sub = null, $id = null) {
        parent::checkEnter();

        if (is_null($sub) || is_null($id)) redirect(base_url().'message');

        $module = 'message';
        $submodule = $sub;

        $this->load->model('security/module_model', 'module_model');

        if (!$this->module_model->isSubmodule($submodule)) redirect(base_url());

        parent::generateTop($module);
        $this->generateEditOrderContent($module, $submodule, $id);
        parent::generateFooter();

    }

    protected function generateEditOrderContent($module, $submodule, $id) {
        $data = array();

        if($submodule == 'share') {
            $this->load->model('menu_model');
            $data['content']['modulename'] = $this->menu_model->selectMenuName('message');
            $data['content']['subs'] = $this->menu_model->selectAllChildrenByLink('message');
        }

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['breadcrumbs'] = $this->breadcrumbs();

        if($submodule == 'share') {
            $data['content']['data'] = $this->model->selectPreviewAll($id);
            $data['content']['subs'][3]['name'] = $this->model->selectObject($id);
        }
        else {
            $data['content'] = $this->model->getOrder($id);

            if(isset($data['content']['phone']) && !empty($data['content']['phone'])) {
                $data['content']['phone'] = $this->create_phone($data['content']['phone']);
                // $data['content']['paket'] = $this->create_paket($data['content']['paket']);
            }
            // Доповнення до коментарів, відповідь на коментарій.
            if(isset($submodule) && !empty($submodule) && $submodule == 'review')
                $data['content']['data'] = $this->model->getParentComments($id);

            if($submodule == 'order')
                $data['content']['statuses'] = $this->model->getOrderStatuses();
        }

        if($submodule == 'order') $data['content']['text'] = $this->model->getText($id);

        $data['MODULE'] = $module;
        $data['SUBMODULE'] = $submodule;
        $data['ID'] = $id;
        if($submodule == 'share') $this->load->view($module.'/'.$module.'_share_view.php', $data);
        else $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
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
    //---end ORDER region

    protected function generateEditCatalogProductContent($module, $submodule, $id) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['content'] = $this->model->getData($id);
        if (count($data['content']) > 0) $data['content'] = $data['content'][0];

        $data['menu'] = $this->model->getParentItems();
        $data['submenu'] = $this->model->getChildItems();

        $data['brand'] = $this->model->getBrands();

        $data['color'] = $this->model->getColor();

        $data['preference'] = $this->model->getPreference();

        if (!is_null($id) && $id > 0) $data['recomend'] = $this->model->getRecomend($id);
        else $data['recomend'] = $this->model->getRecomend(0);

        if (!is_null($id) && $id > 0) {
            $data['objpref'] = $this->model->getObjPreference($id);
            $data['objrec'] = $this->model->getObjRec($id);
            $data['objimg'] = $this->model->getObjImg($id);
        }

        $data['TABLE'] = $module;
        $data['SUBMODULE'] = $submodule;
        if (!is_null($id) && $id > 0) $data['ID'] = $id;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }

    protected function generateEditCatalogCatContent($module, $submodule, $id) {

        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['content'] = $this->model->getData($id);
        if (count($data['content']) > 0) $data['content'] = $data['content'][0];

        $data['menu'] = $this->model->getParentItems();
        $data['submenu'] = $this->model->getChildItems();

        $data['TABLE'] = $module;
        $data['SUBMODULE'] = $submodule;
        if (!is_null($id) && $id > 0) $data['ID'] = $id;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }

    protected function generateContentUser($module, $submodule, $username = null) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        if ($this->session->userdata('error')) {
            $data['ERROR'] = $this->session->userdata('error');
            $this->session->unset_userdata('error');
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['TABLE'] = $module;
        $data['SUBMODULE'] = $submodule;

        if (is_null($username)) {

        } else {

            if (!$this->model->isUser($username)) redirect(base_url().$module);

            $data['content']['username'] = $username;

            $data['USERNAME'] = $username;
            $data['LINK'] = $this->model->getUserID($username);
        }

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }

    protected function generateContentCat($module, $submodule, $id = null) {
        $data = array();

        $this->load->model($module.'/'.$module.'_'.$submodule.'_model', 'model');

        if (!is_null($id)) {
            $data['content'] = $this->model->selectCategory($id);
            $data['content'] = $data['content'][0];
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if (isset($id)) $data['LINK'] = $id;
        $data['TABLE'] = $module;
        $data['SUBMODULE'] = $submodule;

        $this->load->view($module.'/'.$module.'_'.$submodule.'_edit_view.php', $data);
    }


    //---BREAD region
    private function breadcrumbs($thisid = 0, $parent_id = false, $parent_name = false) {
        $data = array();

        $this->load->model('security/module_model', 'module_bread');

        $data[0]['name'] = $this->module_bread->getByLink($this->uri->segment(2), true);
        $data[0]['link'] = $this->uri->segment(2);

        $data[1]['name'] = $this->module_bread->getByLink($this->uri->segment(3));
        $data[1]['link'] = $this->uri->segment(2).'/'.$this->uri->segment(3);

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
    //---end BREAD region

    //---CHECK region
    public function setcheck($what, $id) {

        switch ($what) {

            case 'order':
            {
                $this->load->library('module/order_order_library');
                $this->order_order_library->setCheck($id);
            }
            break;

            case 'order_one_click': {
             $this->load->library('module/order_order_one_click_library');
             $this->order_order_one_click_library->setCheck($id);
            } break;

            case 'garagproject':
            {
                $this->load->library('module/order_project_library');
                $this->order_project_library->setCheck($id);
            }
            break;

            case 'feedback':
            {
                $this->load->library('module/message_feedback_library');
                $this->message_feedback_library->setCheck($id);
            }
            break;

            case 'feedphone':
            {
                $this->load->library('module/message_feedphone_library');
                $this->message_feedphone_library->setCheck($id);
            }
            break;

            case 'review':
            {
                $this->load->library('module/message_review_library');
                $this->message_review_library->setCheck($id);
            }
            break;

            case 'catalog':{
             $this->load->model('catalog/catalog_catalog_model');
             $this->catalog_catalog_model->setCheck($id);
            } break;

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }

    public function unsetcheck($what, $id) {

        switch ($what) {

            case 'order':
            {
                $this->load->library('module/order_order_library');
                $this->order_order_library->setUnCheck($id);
            }
            break;

            case 'order_one_click': {
             $this->load->library('module/order_order_one_click_library');
             $this->order_order_one_click_library->setUnCheck($id);
            } break;

            case 'garagproject':
            {
                $this->load->library('module/order_project_library');
                $this->order_project_library->setUnCheck($id);
            }
            break;

            case 'feedback':
            {
                $this->load->library('module/message_feedback_library');
                $this->message_feedback_library->setUnCheck($id);
            }
            break;

            case 'feedphone':
            {
                $this->load->library('module/message_feedphone_library');
                $this->message_feedphone_library->setUnCheck($id);
            }
            break;

            case 'review':
            {
                $this->load->library('module/message_review_library');
                $this->message_review_library->setUnCheck($id);
            }
            break;

            case 'catalog':{
             $this->load->model('catalog/catalog_catalog_model');
             $this->catalog_catalog_model->setUnCheck($id);
            } break;

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }
    //---end CHECK region

    //---VISIBLE region
    public function setvis($what, $id) {

        switch ($what) {
            case 'indeximage':{
                $this->load->model('page/page_indeximage_model');
                $this->page_indeximage_model->setVisible($id);
            }break;
            case 'review': {
             $this->load->model('message/message_review_model');
             $this->message_review_model->set_vis($id);
            } break;
            case 'order': {
             $this->load->model('order/order_order_model');
             $this->order_order_model->set_cancel($id, 1);
            } break;

            case 'page':
            {
                $this->load->library('module/page_library');
                $this->page_library->setPageVisible($id);
            }
            break;

            case 'harvis': {
                $this->load->model('message/message_review_model');
                $this->message_review_model->set_review_harvis($id);
                }
                break;

            case 'leftpage':
            {
                $this->load->library('module/page_leftpage_library');
                $this->page_leftpage_library->setPageVisible($id);
            }
            break;

            case 'catalog':
            {
                $this->load->library('module/catalog_catalog_library');
                $this->catalog_catalog_library->setVis($id);
            }
            break;

            case 'c_color':
            case 'k_desktop':
            case 's_type':
            case 's_cat':
            case 's_textile':
            case 'wr_type':
            case 'wr_fasade':
            case 'wr_corpus':
            case 'wr_mirror':
            case 'wr_size':
            case 'brand':
            {
                $this->load->library('module/catalog_'.$what.'_library', '', 'in_lib');
                $this->in_lib->setVis($id);
            }
            break;

            case 'group':
            {
                $this->load->library('module/catalog_group_library');
                $this->catalog_group_library->setVis($id);
            }
            break;

            case 'color':
            {
                $this->load->library('module/catalog_color_library');
                $this->catalog_color_library->setVis($id);
            }
            break;

            case 'artical':
            {
                $this->load->library('module/page_artical_library');
                $this->page_artical_library->setVis($id);
            }
            break;

            case 'share':
            {
                $this->load->library('module/page_share_library');
                $this->page_share_library->setVis($id);
            }
            break;

            case 'share_cat':
            {
                $this->load->library('module/page_share_cat_library');
                $this->page_share_cat_library->setVis($id);
            }
            break;

            case 'faq':
            {
                $this->load->library('module/page_faq_library');
                $this->page_faq_library->setVis($id);
            }
            break;

            case 'clients':
            {
                $this->load->library('module/clients_clients_library');
                $this->clients_clients_library->set_visible($id, true);
            }
            break;

            case 'object':
            {
                $this->load->library('module/catalog_object_library');
                $this->catalog_object_library->setVis($id);
            }
            break;

            case 'object_stock':
            {
                $this->load->library('module/catalog_object_library');
                $this->catalog_object_library->setVis($id, true);
            }
            break;

            case 'topphones':
            {
                $this->load->library('module/page_topphones_library');
                $this->page_topphones_library->setVis($id);
            }
            break;

            case 'gallery':
            {
                $this->load->library('module/gallery_gallery_library');
                $this->gallery_gallery_library->setVis($id);
            }
            break;

            case 'gallerycat':
            {
                $this->load->library('module/gallery_gallerycat_library');
                $this->gallery_gallerycat_library->setVis($id);
            }
            break;

            case 'paket_option':
            {
                $this->load->model('catalog/catalog_paket_option_model');
                $this->catalog_paket_option_model->setVis($id);
            } break;

            case 'pakets':
            {
                $this->load->library('module/catalog_pakets_library');
                $this->catalog_pakets_library->setVis($id);
            } break;

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }

    public function unsetvis($what, $id) {

        switch ($what) {
            case 'indeximage':{
                $this->load->model('page/page_indeximage_model');
                $this->page_indeximage_model->setUnVisible($id);
            }break;
        case 'review': {
             $this->load->model('message/message_review_model');
             $this->message_review_model->set_Unvis($id);
            } break;
            case 'order': {
             $this->load->model('order/order_order_model');
             $this->order_order_model->set_cancel($id, 0);
            } break;

            case 'har': {
                $this->load->model('message/message_review_model');
                $this->message_review_model->set_review_har($id);
            } break;

            case 'allharunvis': {
                echo "123"; die();
            } break;

            case 'page':
            {
                $this->load->library('module/page_library');
                $this->page_library->setPageUnVisible($id);
            }
            break;

            case 'leftpage':
            {
                $this->load->library('module/page_leftpage_library');
                $this->page_leftpage_library->setPageUnVisible($id);
            }
            break;

            case 'page_catalog':
            {
                $this->load->library('module/page_catalog_library');
                $this->page_catalog_library->setPageCatUnVisible($id);
            }
            break;

            case 'page_catalogtype':
            {
                $this->load->library('module/page_catalogtype_library');
                $this->page_catalogtype_library->setPageCatTypeUnVisible($id);
            }
            break;

            case 'artical':
            {
                $this->load->library('module/page_artical_library');
                $this->page_artical_library->setUnVis($id);
            }
            break;

            case 'share':
            {
                $this->load->library('module/page_share_library');
                $this->page_share_library->setUnVis($id);
            }
            break;

            case 'share_cat':
            {
                $this->load->library('module/page_share_cat_library');
                $this->page_share_cat_library->setUnVis($id);
            }
            break;

            case 'faq':
            {
                $this->load->library('module/page_faq_library');
                $this->page_faq_library->setUnVis($id);
            }
            break;

            case 'clients':
            {
                $this->load->library('module/clients_clients_library');
                $this->clients_clients_library->set_visible($id, false);
            }
            break;

            case 'object':
            {
                $this->load->library('module/catalog_object_library');
                $this->catalog_object_library->setUnVis($id);
            }
            break;

            case 'object_stock':
            {
                $this->load->library('module/catalog_object_library');
                $this->catalog_object_library->setUnVis($id, true);
            }
            break;

            case 'catalog':
            {
                $this->load->library('module/catalog_catalog_library');
                $this->catalog_catalog_library->setUnVis($id);
            }
            break;

            case 'c_color':
            case 'k_desktop':
            case 's_type':
            case 's_cat':
            case 's_textile':
            case 'wr_type':
            case 'wr_fasade':
            case 'wr_corpus':
            case 'wr_mirror':
            case 'wr_size':
            case 'brand':
            {
                $this->load->library('module/catalog_'.$what.'_library', '', 'in_lib');
                $this->in_lib->setUnVis($id);
            }
            break;

            case 'group':
            {
                $this->load->library('module/catalog_group_library');
                $this->catalog_group_library->setUnVis($id);
            }
            break;

            case 'color':
            {
                $this->load->library('module/catalog_color_library');
                $this->catalog_color_library->setUnVis($id);
            }
            break;

            case 'topphones':
            {
                $this->load->library('module/page_topphones_library');
                $this->page_topphones_library->setUnVis($id);
            }
            break;

            case 'gallery':
            {
                $this->load->library('module/gallery_gallery_library');
                $this->gallery_gallery_library->setUnVis($id);
            }
            break;

            case 'gallerycat':
            {
                $this->load->library('module/gallery_gallerycat_library');
                $this->gallery_gallerycat_library->setUnVis($id);
            }
            break;

            case 'paket_option':
            {
                $this->load->model('catalog/catalog_paket_option_model');
                $this->catalog_paket_option_model->setUnVis($id);
            } break;

            case 'paket_option':
            {
                $this->load->model('catalog/catalog_paket_option_model');
                $this->catalog_paket_option_model->setUnVis($id);
            } break;

            case 'pakets':
            {
                $this->load->library('module/catalog_pakets_library');
                $this->catalog_pakets_library->setUnVis($id);
            } break;

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }
    //---end VISIBLE region

    //---POSITION region
    public function setposition($where, $what, $id) {

        if (in_array($where, array('up', 'down'))) {

            switch ($what) {

                case 'page':
                {
                    $this->load->library('module/page_library');
                    $this->page_library->setPagePosition($where, $id);
                }
                break;

                case 'topphones':
                {
                    $this->load->library('module/page_topphones_library');
                    $this->page_topphones_library->setPosition($where, $id);
                }
                break;

                case 'leftpage':
                {
                    $this->load->library('module/page_leftpage_library');
                    $this->page_leftpage_library->setPagePosition($where, $id);
                }
                break;

                case 'garagtype':
                {
                    $this->load->library('module/catalog_garagtype_library');
                    $this->catalog_garagtype_library->setPos($where, $id);
                }
                break;

                case 'region':
                {
                    $this->load->library('module/catalog_region_library');
                    $this->catalog_region_library->setPos($where, $id);
                }
                break;

                case 'item':
                {
                    $this->load->library('module/catalog_options_library');
                    $this->catalog_options_library->setPos($where, $id);
                }
                break;

                case 'look':
                {
                    $this->load->library('module/catalog_look_library');
                    $this->catalog_look_library->setPos($where, $id);
                }
                break;

                case 'indeximage':
                {
                    $this->load->library('module/page_indeximage_library');
                    $this->page_indeximage_library->setPos($where, $id);
                }
                break;

                case 'catalog':
                {
                    $this->load->library('module/catalog_catalog_library');
                    $this->catalog_catalog_library->setPos($where, $id);
                }
                break;

                case 'c_color':
                case 'k_desktop':
                case 's_type':
                case 's_cat':
                case 's_textile':
                case 'wr_type':
                case 'wr_fasade':
                case 'wr_corpus':
                case 'wr_mirror':
                case 'wr_size':
                case 'brand':
                {
                    $this->load->library('module/catalog_'.$what.'_library', '', 'in_lib');
                    $this->in_lib->setPos($where, $id);
                }
                break;

                case 'group':
                {
                    $this->load->library('module/catalog_group_library');
                    $this->catalog_group_library->setPos($where, $id);
                }
                break;

                case 'color':
                {
                    $this->load->library('module/catalog_color_library');
                    $this->catalog_color_library->setPos($where, $id);
                }
                break;

                case 'share_cat':
                {
                    $this->load->library('module/page_share_cat_library');
                    $this->page_share_cat_library->setPos($where, $id);
                }
                break;

                case 'faq':
                {
                    $this->load->library('module/page_faq_library');
                    $this->page_faq_library->setPos($where, $id);
                }
                break;

                case 'gallery':
                {
                    $this->load->library('module/gallery_gallery_library');
                    $this->gallery_gallery_library->setPos($where, $id);
                }
                break;

                case 'gallerycat':
                {
                    $this->load->library('module/gallery_gallerycat_library');
                    $this->gallery_gallerycat_library->setPos($where, $id);
                }
                break;

            }

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }
    //---end POSITION region

    // Send 
        public function send($array = array()){
            $array = array(
                'email' => 'email@mail.ru'
                );
            $this->load->library('send_email');
            $this->send_email->send_email($array);
        }
    // end send

    //---SAVE region
    public function save($what, $catid= 0) {
        $return = 0;

        $array = $_POST;

        if (count($array) > 0) {

            switch ($what) {

                #auto region
                case 'order_status': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->saveOrderStatus($array);
                } break;

                // send order email ========================================================
                case 'order_status_email': {
                    if(isset($array['email']) && !empty($array['email'])){
                        if($array['status'] == 4){
                            $this->load->library('send_email');
                            $bool = $this->send_email->send_email($array);
                        }
                    }
                         $this->load->model('order/order_order_model');
                         $this->order_order_model->saveOrderStatusEmail($array);
                     
                } break;
                // end sand order email ====================================================

                case 'order_one_click_status':{
                    $this->load->model('order/order_order_model');
                    $this->order_order_model->saveOrderOneClickStatus($array);
                } break;
                case 'auto_price': {
                 $this->load->model('catalog/catalog_auto_model');
                 $this->catalog_auto_model->saveAutoPrice($array);
                } break;
                case 'auto_material': {
                 $this->load->model('catalog/catalog_auto_model');
                 $this->catalog_auto_model->saveAutoMaterial($array);
                } break;
                #end auto region

                #order move region
                case 'order_newuser': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->saveOrderNewUser($array);
                } break;
                case 'order_olduser': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->saveOrderOldUser($array);
                } break;
                case 'order_oldzakaz': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->saveOrderOldZakaz($array);
                } break;
                #end order move region

                case 'order': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->save($array);
                } break;

                case 'order_order': {
                 $this->load->model('order/order_order_model');
                 $return = $this->order_order_model->save($array);
                } break;

                case 'order_one_click': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->save($array);
                } break;

                case 'order_sms': {
                 $this->load->model('order/order_order_model');
                 $this->order_order_model->saveSMS($array);
                } break;

                case 'page':
                {
                    $this->load->library('module/page_library');
                    $return = $this->page_library->savePage($array);
                }
                break;

                case 'leftpage':
                {
                    $this->load->library('module/page_leftpage_library');
                    $this->page_leftpage_library->savePage($array);
                }
                break;

                case 'otherpage':
                {
                    $this->load->library('module/page_otherpage_library');
                    $this->page_otherpage_library->savePage($array);
                }
                break;

                case 'catalog':
                {
                    $this->load->library('module/catalog_catalog_library');
                    $return = $this->catalog_catalog_library->saveCatalog($array);
                }
                break;

                case 'garagtype':
                {
                    $this->load->library('module/catalog_garagtype_library');
                    $return = $this->catalog_garagtype_library->saveGarType($array);
                }
                break;

                case 'region':
                {
                    $this->load->library('module/catalog_region_library');
                    $return = $this->catalog_region_library->saveGarType($array);
                }
                break;

                case 'item':
                {
                    $this->load->library('module/catalog_options_library');
                    $return = $this->catalog_options_library->saveGarType($array);
                }
                break;

                case 'look':
                {
                    $this->load->library('module/catalog_look_library');
                    $return = $this->catalog_look_library->saveGarType($array);
                }
                break;

                case 'setting_scripts':
                {
                    $this->load->library('module/setting_scripts_library');
                    $return = $this->setting_scripts_library->saveOption($array);
                }
                break;

                case 'page_footer':
                {
                    $this->load->library('module/page_footer_library');
                    $this->page_footer_library->saveFooter($array);
                }
                break;

                case 'artical':
                {
                    $this->load->library('module/page_artical_library');
                    $return = $this->page_artical_library->saveArtical($array);
                }
                break;

                case 'share':
                {
                    $this->load->library('module/page_share_library');
                    $return = $this->page_share_library->saveArtical($array);
                }
                break;

                case 'share_cat':
                {
                    $this->load->library('module/page_share_cat_library');
                    $return = $this->page_share_cat_library->saveArtical($array);
                }
                break;

                case 'faq':
                {
                    $this->load->library('module/page_faq_library');
                    $return = $this->page_faq_library->saveArtical($array);
                }
                break;

                case 'client':
                {
                    $this->load->library('module/clients_clients_library');
                    $this->clients_clients_library->saveClient($array);
                }
                break;

                case 'comment':
                {
                    $this->load->library('module/comments_comments_library');
                    $return = $this->comments_comments_library->saveComment($array);
                }
                break;

                case 'object':
                {
                    $this->load->library('module/catalog_object_library');
                    $return = $this->catalog_object_library->saveGarag($array);
                }
                break;

                case 'paket_option':
                {
                    $this->load->library('module/catalog_paket_option_library');
                    $return = $this->catalog_paket_option_library->saveGarag($array);
                }
                break;

                case 'pakets':
                {
                    $this->load->library('module/catalog_pakets_library');
                    $return = $this->catalog_pakets_library->saveGarag($array);
                }
                break;

                case 'cat_option':
                {
                    $this->load->library('module/catalog_cat_option_library');
                    $return = $this->catalog_cat_option_library->saveGarag($array);
                }
                break;

                case 'topphones':
                {
                    $this->load->library('module/page_topphones_library');
                    $return = $this->page_topphones_library->saveFooter($array);
                }
                break;

                case 'indeximg':
                {
                    $this->load->library('module/page_indeximage_library');
                    $return = $this->page_indeximage_library->saveIndImg($array);
                }
                break;

                case 'indexban':
                {
                    $this->load->library('module/page_indexban_library');
                    $return = $this->page_indexban_library->saveIndImg($array);
                }
                break;

                case 'brand':
                case 'c_color':
                case 'k_desktop':
                case 's_type':
                case 's_cat':
                case 's_textile':
                case 'wr_type':
                case 'wr_fasade':
                case 'wr_corpus':
                case 'wr_mirror':
                case 'wr_size':
                {
                    $this->load->library('module/catalog_'.$what.'_library', '', 'in_lib');
                    $return = $this->in_lib->saveV($array);
                }
                break;

                case 'group':
                {
                    $this->load->library('module/catalog_group_library');
                    $return = $this->catalog_group_library->saveV($array);
                }
                break;

                case 'color':
                {
                    $this->load->library('module/catalog_color_library');
                    $return = $this->catalog_color_library->saveV($array);
                }
                break;

                case 'questiontheme':
                {
                    $this->load->library('module/page_questiontheme_library');
                    $return = $this->page_questiontheme_library->save($array);
                }
                break;

                case 'gallerycat':
                {

                    $this->load->library('module/gallery_gallerycat_library');
                    $return = $this->gallery_gallerycat_library->save($array);

                }
                break;

                case 'gallery':
                {

                    $this->load->library('module/gallery_gallery_library');
                    $this->gallery_gallery_library->save($array, $catid);

                    return true;

                }
                break;

                case 'review': {
                 $this->load->model('message/message_review_model');
                 $this->message_review_model->save($array);

                } break;

            }

        }

        if ($what == 'page' && is_numeric($return)) redirect(base_url().'edit/page/page/'.$return);
        elseif ($what == 'setting_scripts' && is_numeric($return)) redirect(base_url().'edit/setting/scripts/'.$return);
        elseif (in_array($what, $this->b_array) && is_numeric($return)) redirect(base_url().'edit/catalog/'.$what.'/'.$return);
        elseif (($what == 'brand' || $what == 'group' || $what == 'color') && $return != 'http') redirect(base_url().'edit/catalog/'.$what.'/'.$return);
        elseif ($what == 'catalog' && is_numeric($return)) redirect(base_url().'edit/catalog/catalog/'.$return);
        elseif ($what == 'comment' && is_numeric($return)) redirect(base_url().'edit/comments/comments/'.$return);
        elseif ($what == 'indeximg' && is_numeric($return)) redirect(base_url().'edit/page/indeximage/'.$return);
        elseif ($what == 'text_image') return true;
        elseif ($what == 'object' && is_numeric($return)) redirect(base_url().'edit/catalog/object/'.$return);
        elseif ($what == 'artical' && is_numeric($return)) redirect(base_url().'edit/page/artical/'.$return);
        elseif ($what == 'share' && is_numeric($return)) redirect(base_url().'edit/page/share/'.$return);
        elseif ($what == 'share_cat' && is_numeric($return)) redirect(base_url().'edit/page/share_cat/'.$return);
        elseif ($what == 'faq' && is_numeric($return)) redirect(base_url().'edit/page/faq/'.$return);
        elseif ($what == 'topphones' && is_numeric($return)) redirect(base_url().'edit/page/topphones/'.$return);
        elseif ($what == 'questiontheme' && is_numeric($return)) redirect(base_url().'edit/page/questiontheme/'.$return);
        elseif ($what == 'gallerycat' && is_numeric($return)) redirect(base_url().'edit/gallery/gallerycat/'.$return);
        elseif ($what == 'order_order' && is_numeric($return)) redirect(base_url().'edit/order/order/'.$return);
        elseif ($what == 'paket_option' && is_numeric($return)) redirect(base_url().'edit/catalog/paket_option/'.$return);
        elseif ($what == 'cat_option' && is_numeric($return)) redirect(base_url().'edit/catalog/cat_option/'.$return);
        elseif ($what == 'pakets' && is_numeric($return)) redirect(base_url().'edit/catalog/pakets/'.$return);
        else {
            if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
            else redirect(base_url().$what);
        }

    }
    //---end SAVE region

    //---AJAX region
    public function ajax($what) {

        $data = true;

        $array = $_POST;
        if (empty($_POST)) $array = $_GET;

        if (count($array) > 0) {

            switch ($what) {

                case 'ac-object': {

                 $res = $this->db->select('id, name_ru as name')->from('site_catalog')->like('name_ru', urldecode($this->input->get('query')), 'both')->where('id <> '.$this->db->escape($this->input->get('id')))->get();
                 if ($res->num_rows() <= 0) $data = array();
                 else {
                  $data = $res->result_array();
                 }

                 if (!$data) echo false;
                 else echo json_encode($data);
                 die();

                } break;

                case 'ac-acc': {

                 $res = $this->db->select('id, name_ru as name')->from('site_catalog')->like('name_ru', urldecode($this->input->get('query')), 'both')->where('id <> '.$this->db->escape($this->input->get('id')))->where('product-visible', 0)->get();
                 if ($res->num_rows() <= 0) $data = array();
                 else {
                  $data = $res->result_array();
                 }

                 if (!$data) echo false;
                 else echo json_encode($data);
                 die();

                } break;

                case 'page_catalogtype_link':
                {
                    $this->load->library('module/page_catalogtype_library');
                    $data = $this->page_catalogtype_library->getLink($array);
                } break;

                case 'auto_complect': {
                 $data = false;
                 $this->load->model('catalog/catalog_auto_model');
                 $data = $this->catalog_auto_model->recountComplect();
                } break;

                case 'az_otype': {
                 $data = false;
                 $this->load->model('catalog/catalog_object_model');
                 $data = $this->catalog_object_model->az_getMenu((int)$this->input->post('id'));
                 if (!$data) echo false;
                 else echo json_encode($data);
                 die();
                } break;

                case 'az_brand': {
                 $data = false;
                 $this->load->model('catalog/catalog_object_model');
                 $data = $this->catalog_object_model->az_getMarka((int)$this->input->post('id'));
                 if (!$data) echo false;
                 else echo json_encode($data);
                 die();
                } break;
                case 'sort':{
                    $data = true;
                    $img_data = $this->input->post(NULL, true);                    
                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->updateImgs($img_data);
                }break;

                case 'sorting':{ 
                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->sort_products($array);
                }break;

                case 'sorting_option':{ 
                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->sort_paket_option($array);
                }break;

                case 'sorting_pakets':{ 
                    $this->load->model('catalog/catalog_pakets_model');
                    $this->catalog_pakets_model->sort_paket_option($array);
                }break;

                // remove price ========================================================
                case 'remove_price': {
                    $array = array();
                    $array = $_POST;
                    $id = (int)$_POST['id'];
                    if($id <= 0) return false;

                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->remove_ajax_price_object($id, $_POST['price']);
                } break;
                // end remove price ====================================================

                case 'acc': {
                    $id = $_POST['id'];
                    $id = (int)$id;

                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->delAcc($id);
                } break;

                case 'cat': {
                    $id = $_POST['id'];
                    $id_obj = $_POST['id_obj'];
                    $id = (int)$id;
                    $id_obj = (int)$id_obj;

                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->delete_ajax_cat($id, $id_obj);
                } break;

                case 'pop': {
                    $id = $_POST['id'];
                    $id = (int)$id;

                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->delColf($id);
                } break;

                case 'color': {
                    $id = $_POST['id'];
                    $id = (int)$id;

                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->delObj($id);
                } break;

                case 'save_status_object': {
                    $status = $_POST['status'];
                    $id = $_POST['id'];

                    $this->load->model('catalog/catalog_object_model');
                    $this->catalog_object_model->removeStatusObject($status, $id);
                } break;

                case 'sor_pakets': {
                    $id = 0;
                    $id = (int)$_POST['id'];
                    $this->load->model('catalog/catalog_paket_option_model');
                    $this->catalog_paket_option_model->sortablePaketAjax($array, $id);
                } break;

            }

        }

        echo $data;

    }
    //---end AJAX region

    //---FANCYAJAX region
    public function fancyajax($what, $id) {

        $data = array();

        switch ($what) {

            case 'edit_image_text':
            {
                $this->load->library('module/catalog_work_library');
                $data['data'] = $this->catalog_work_library->getImgText($id);
                $this->load->view('catalog/catalog_work_editimage_view.php', $data);
            }
            break;

            case 'edit_main':
            {
                $this->load->library('module/catalog_work_library');
                $data['data'] = $this->catalog_work_library->getMainImage($id);
                $this->load->view('catalog/catalog_work_editmainimg_view.php', $data);
            }
            break;

        }

    }
    //---end FANCYAJAX region

    //---ACTIONS region
    public function actions($what) {
        $array = $_POST;

        if (count($array) > 0) {

            switch ($what) {

                case 'object':
                {
                    $this->load->library('module/catalog_object_library');
                    $this->catalog_object_library->setAction($array);
                }
                break;

                case 'order':
                {
                    $this->load->library('module/order_order_library');
                    $this->order_order_library->setAction($array);
                }
                break;

                case 'order_one_click':
                {
                    $this->load->library('module/order_order_one_click_library');
                    $this->order_order_one_click_library->setAction($array);
                }
                break;


                case 'garagproject':
                {
                    $this->load->library('module/order_project_library');
                    $this->order_project_library->setAction($array);
                }
                break;

                case 'feedback':
                {
                    $this->load->library('module/message_feedback_library');
                    $this->message_feedback_library->setAction($array);
                }
                break;

                case 'feedphone':
                {
                    $this->load->library('module/message_feedphone_library');
                    $this->message_feedphone_library->setAction($array);
                }
                break;

                case 'review':
                {
                    $this->load->library('module/message_review_library');
                    $this->message_review_library->setAction($array);
                }
                break;

            }

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }
    //---end ACTIONS region

    //---DEL region
    public function del($what, $id) {

        switch ($what) {

            case 'lb_image_1': {
             $this->load->model('catalog/catalog_group_model');
             $this->catalog_group_model->delPImage($id, 1);
            } break;

            case 'acc': {
             $this->load->model('catalog/catalog_object_model');
             $this->catalog_object_model->delAcc($id);
            } break;

            case 'obj': {
             $this->load->model('catalog/catalog_object_model');
             $this->catalog_object_model->delObj($id);
            } break;

            case 'colf': {
             $this->load->model('catalog/catalog_object_model');
             $this->catalog_object_model->delColf($id);
            } break;

            case 'lb_image_2': {
             $this->load->model('catalog/catalog_group_model');
             $this->catalog_group_model->delPImage($id, 2);
            } break;

            case 'page_image_1': {
             $this->load->model('page/page_page_model');
             $this->page_page_model->delPImage($id, 1);
            } break;

            case 'page_image_2': {
             $this->load->model('page/page_page_model');
             $this->page_page_model->delPImage($id, 2);
            } break;

            case 'object_item1': {
             $this->load->model('catalog/catalog_object_model');
             $this->catalog_object_model->delItem($id);
            } break;

            case 'object_prices': {
             $this->load->model('catalog/catalog_object_model');
             $this->catalog_object_model->delPrices($id);
            } break;

            case 'order':
            {
                $this->load->library('module/order_order_library');
                $this->order_order_library->delOrder($id);
            }
            break;

            case 'order_one_click':
            {
                $this->load->library('module/order_order_one_click_library');
                $this->order_order_one_click_library->delOrder($id);
            }
            break;

            case 'garagproject':
            {
                $this->load->library('module/order_project_library');
                $this->order_project_library->delOrder($id);
            }
            break;

            case 'feedback':
            {
                $this->load->library('module/message_feedback_library');
                $this->message_feedback_library->delOrder($id);
            }
            break;

            case 'feedphone':
            {
                $this->load->library('module/message_feedphone_library');
                $this->message_feedphone_library->delOrder($id);
            }
            break;

            case 'review':
            {
                $this->load->library('module/message_review_library');
                $this->message_review_library->delOrder($id);
            }
            break;

            case 'garagtype':
            {
                $this->load->library('module/catalog_garagtype_library');
                $this->catalog_garagtype_library->delGarType($id);
            }
            break;

            case 'region':
            {
                $this->load->library('module/catalog_region_library');
                $this->catalog_region_library->delGarType($id);
            }
            break;

            case 'item':
            {
                $this->load->library('module/catalog_options_library');
                $this->catalog_options_library->delGarType($id);
            }
            break;

            case 'comment':
            {
                $this->load->library('module/comments_comments_library');
                $this->comments_comments_library->delComment($id);
            }
            break;

            case 'setting_scripts':
            {
                $this->load->library('module/setting_scripts_library');
                $this->setting_scripts_library->delOption($id);
            }
            break;

            case 'client':
            {
                $this->load->library('module/clients_clients_library');
                $this->clients_clients_library->delClient($id);
            }
            break;

            case 'image':
            {
                $this->load->library('module/catalog_object_library');
                $this->catalog_object_library->delImage($id);
            }
            break;

            case 'object':
            {
                $this->load->library('module/catalog_object_library');
                $this->catalog_object_library->removeObj($id);
            }
            break;

            case 'object_component':
            {
                $this->load->model('catalog/catalog_object_model');
                $this->catalog_object_model->removeComponent($id);
            }
            break;

            case 'object_complect':
            {
                $this->load->model('catalog/catalog_object_model');
                $this->catalog_object_model->removeComplect($id);
            }
            break;

            case 'artical':
            {
                $this->load->library('module/page_artical_library');
                $this->page_artical_library->deleteArt($id);
            }
            break;

            case 'share':
            {
                $this->load->library('module/page_share_library');
                $this->page_share_library->deleteArt($id);
            }
            break;

            case 'share_cat':
            {
                $this->load->library('module/page_share_cat_library');
                $this->page_share_cat_library->deleteArt($id);
            }
            break;

            case 'faq':
            {
                $this->load->library('module/page_faq_library');
                $this->page_faq_library->deleteArt($id);
            }
            break;

            case 'indeximage':
            {
                $this->load->library('module/page_indeximage_library');
                $this->page_indeximage_library->deleteImage($id);
            }
            break;

            case 'c_color':
            case 'k_desktop':
            case 's_type':
            case 's_cat':
            case 's_textile':
            case 'wr_type':
            case 'wr_fasade':
            case 'wr_corpus':
            case 'wr_mirror':
            case 'wr_size':
            case 'brand':
            {
                $this->load->library('module/catalog_'.$what.'_library', '', 'in_lib');
                $this->in_lib->deleteV($id);
            }
            break;

            case 'group':
            {
                $this->load->library('module/catalog_group_library');
                $this->catalog_group_library->deleteV($id);
            }
            break;

            case 'color':
            {
                $this->load->library('module/catalog_color_library');
                $this->catalog_color_library->deleteV($id);
            }
            break;

            case 'catalog':
            {
                $this->load->library('module/catalog_catalog_library');
                $this->catalog_catalog_library->delMenu($id);
            }
            break;

            case 'topphones':
            {
                $this->load->library('module/page_topphones_library');
                $this->page_topphones_library->remove($id);
            }
            break;

            case 'questiontheme':
            {
                $this->load->library('module/page_questiontheme_library');
                $this->page_questiontheme_library->remove($id);
            }
            break;

            case 'gallery':
            {
                $this->load->library('module/gallery_gallery_library');
                $this->gallery_gallery_library->remove($id);
            }
            break;

            case 'gallerycat':
            {

                $this->load->library('module/gallery_gallerycat_library');
                $this->gallery_gallerycat_library->remove($id);

            }
            break;

            case 'page': {
             $this->load->model('page/page_page_model');
             $this->page_page_model->remove($id);
            } break;

            case 'paket_option': {
             $this->load->model('catalog/catalog_paket_option_model');
             $this->catalog_paket_option_model->remove($id);
            } break;

            case 'cat_option': {
             $this->load->model('catalog/catalog_cat_option_model');
             $this->catalog_cat_option_model->remove($id);
            } break;

            case 'pakets': {
             $this->load->library('module/catalog_pakets_library');
             $this->catalog_pakets_library->remove($id);
            } break;

        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
        else redirect(base_url().$what);

    }
    //---end DEL region

    // search
    public function search($what = array()){
        $array = $_POST;

            switch ($what) {

                case 'order': {
                 $this->load->model('catalog/catalog_object_model', 'model');
                 $search_query = $this->model->SearchOrder($array);
                 redirect(base_url().'order/order/search/'.$search_query);
                } break;

            }

    }
    // end search

    public function saveuser() {
        if (isset($_POST['login']) && isset($_POST['password']) && !empty($_POST['login']) && !empty($_POST['password'])) {

            $this->load->model($_POST['table'].'/'.$_POST['table'].'_'.$_POST['submodule'].'_model', 'model');

            if (isset($_POST['link']) && !empty($_POST['link']) && isset($_POST['username']) && !empty($_POST['username'])) {

                if ($this->model->isHotUser($_POST['login'], $_POST['link'])) {
                    $this->session->set_userdata('error', "Логін вже зайнятий");
                    redirect(base_url().'edit/setting/users/'.$_POST['username']);
                }

                $this->model->saveUser($_POST['link'], $_POST);

            } else {

                if ($this->model->isUser($_POST['login'])) {
                    $this->session->set_userdata('error', "Логін вже зайнятий");
                    redirect(base_url().'edit/setting/users/'.$_POST['login']);
                }

                $this->model->insertUser($_POST);

            }

            redirect(base_url().$_POST['table'].'/'.$_POST['submodule']);
        }

        $this->session->set_userdata('error', "Всі поля обов'язкові для заповнення");
        redirect(base_url().'edit/setting/users/'.$_POST['username']);
    }

    public function deluser($id = null) {
        $this->load->model('setting/setting_users_model', 'model');
        if ($this->model->isUserbyID($id)) {
            $this->model->delUser($id);
        }
        redirect(base_url().'setting');
    }

}