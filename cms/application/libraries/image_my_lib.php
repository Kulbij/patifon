<?php

class Image_my_lib {

    private $ci;

    function __construct() {
        $this->ci = &get_instance();

        #FOR TEST
        $for_test_string = $this->ci->config->item('test_add');
        if (!empty($for_test_string) && ($pos = strpos($_SERVER['DOCUMENT_ROOT'], $for_test_string)) === false) $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].$for_test_string;
    }

    public function createDImage($in_array = array()) {
     if (
      !isset($in_array['file']) || empty($in_array['file']) ||
      !isset($in_array['where']) || empty($in_array['where']) ||
      !isset($in_array['width']) ||  $in_array['width'] <= 0 ||
      !isset($in_array['height']) ||  $in_array['height'] <= 0
      ) return false;

     if (count($_FILES) <= 0) return '';
     if (!isset($_FILES[$in_array['file']])) return '';
     $tempFile = $_FILES[$in_array['file']]['tmp_name'];
     if (empty($tempFile)) return '';

     $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/' . $in_array['where'] . '/';

     if (!is_dir($targetPath)) {
      @mkdir($targetPath, 0777);
     }

     if (isset($in_array['set_old_name']) && $in_array['set_old_name']) {
      $filename = $_FILES[$in_array['file']]['name'];
     } else {
      $filename = $this->generate($_FILES[$in_array['file']]['tmp_name']).'.'.$this->getExt($_FILES[$in_array['file']]['name']);
     }
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $img = 'images/data/'.$in_array['where'].'/'.$filename;

     $return = array();
     if (isset($in_array['big_width']) && $in_array['big_width'] > 0 && isset($in_array['big_height']) && $in_array['big_height'] > 0) {
      $return['image_big'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/'.$in_array['where'], true, '-big');
      $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$return['image_big'], $in_array['big_width'], $in_array['big_height']);
     }

     if (isset($in_array['obj_width']) && $in_array['obj_width'] > 0 && isset($in_array['obj_height']) && $in_array['obj_height'] > 0) {
      $return['image_obj'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/'.$in_array['where'], true, '-obj');
      $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$return['image_obj'], $in_array['obj_width'], $in_array['obj_height']);
     }

     $return['image'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/'.$in_array['where'], true, 'default');
     $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$return['image'], $in_array['width'], $in_array['height']);

     // if (!isset($in_array['set_old_name']) || !$in_array['set_old_name']) {
     //  @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$img);
     // }

     return $return;
    }

    public function createGalleryCatImage($falser = false) {

        if (empty($_FILES['gcat_image'])) return '';

        $tempFile = $_FILES['gcat_image']['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'].'/public/images/data/gallery/category/';

        $filename = $this->generate($_FILES['gcat_image']['tmp_name']).$this->getFExt($_FILES['gcat_image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $file = 'images/data/gallery/category/'.$filename;

        $result = array();
        /*
        if ($falser) {
         $result = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/gallery/category');
        } else {*/
         #$result = 'public/'.$this->createcreatecreate($file, 470, 324, 'data/gallery/category');
         $result = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/gallery/category');
         $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$result, 470, 324);
        #}

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$file);

        return $result;

    }

    public function createGalleryImage($img, $catid) {

        if (empty($img)) return '';

        #ini_set('memory_limit', '512M');

        #$filename = $this->generate($img).$this->getFExt($img);

        $result = array();
        /*
        if ($catid == 1) {
         $result['image'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/gallery');
         $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$result['image'], 146, 96);

         $result['image_big'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/gallery');
         $this->resizer_($_SERVER['DOCUMENT_ROOT'].'/'.$result['image_big'], 1024, 768);
        } else {*/
         $result['image_big'] = 'public/'.$this->createcreatecreate($img, 1024, 768, 'data/gallery/images');

         $result['image'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/gallery/images');
         $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$result['image'], 225, 155);
        #}

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$img);

        return $result;

    }

    public function createLeftBannerImage() {
     if (empty($_FILES['main_image'])) return null;
     $tempFile = $_FILES['main_image']['tmp_name'];
     if (empty($tempFile)) return null;

     $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/banner/';

     $filename = $this->generate($_FILES['main_image']['tmp_name']).$this->getFExt($_FILES['main_image']['name']);
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $file = 'public/images/data/banner/'.$filename;
     return $file;
    }

    public function createArticalImage() {
     if (empty($_FILES['artical_image'])) return '';
     $tempFile = $_FILES['artical_image']['tmp_name'];
     if (empty($tempFile)) return '';
     $targetPath = $_SERVER['DOCUMENT_ROOT'].'/public/images/data/articles/';
     $filename = $this->generate($_FILES['artical_image']['tmp_name']).'.'.$this->getExt($_FILES['artical_image']['name']);
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $file = 'images/data/articles/'.$filename;

     $result = array();

     $result['image'] = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/articles', true, 'default');
     $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$result['image'], 540, 280);

     #$result['image_big'] = 'public/'.$this->createcreatecreate($file, 225, 140, 'data/articles', true, '_big');
     #$result['image'] = 'public/'.$this->createcreatecreate($file, 225, 155, 'data/articles', true, 'default');
     #@unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$file);
     return $result;
    }

    public function updateFile($file = 'file') {
     if (empty($_FILES[$file])) return '';
     $tempFile = $_FILES[$file]['tmp_name'];
     if (empty($tempFile)) return '';
     $targetPath = $_SERVER['DOCUMENT_ROOT'].'/public/files/';
     $filename = $this->generate($_FILES[$file]['name']).'.'.$this->getExt($_FILES[$file]['name']);
     $targetFile = str_replace('//', '/', $targetPath) . $filename;
     move_uploaded_file($tempFile, $targetFile);
     $file = $filename;
     return $file;
    }

    public function createShareImage() {
     if (empty($_FILES['artical_image'])) return '';
     $tempFile = $_FILES['artical_image']['tmp_name'];
     if (empty($tempFile)) return '';
     $targetPath = $_SERVER['DOCUMENT_ROOT'].'/public/images/data/promo/';
     $filename = $this->generate($_FILES['artical_image']['tmp_name']).'.'.$this->getExt($_FILES['artical_image']['name']);
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $file = 'images/data/promo/'.$filename;

     $result = array();

     $result['image'] = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/promo', true, 'default');
     $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$result['image'], 540, 280);

     #$result['image_big'] = 'public/'.$this->createcreatecreate($file, 380, 266, 'data/share', true, '_big');
     #$result['image'] = 'public/'.$this->createcreatecreate($file, 460, 180, 'data/share', true, 'default');
     @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file);
     return $result;
    }

    public function createShareCatImage() {
     if (empty($_FILES['artical_image'])) return '';
     $tempFile = $_FILES['artical_image']['tmp_name'];
     if (empty($tempFile)) return '';
     $targetPath = $_SERVER['DOCUMENT_ROOT'].'/public/images/data/sharecat/';
     $filename = $this->generate($_FILES['artical_image']['tmp_name']).'.'.$this->getExt($_FILES['artical_image']['name']);
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $file = 'images/data/sharecat/'.$filename;

     $result = array();
     $result['image'] = 'public/'.$this->createcreatecreate($file, 460, 286, 'data/sharecat', true, 'default');
     @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file);
     return $result;
    }

    public function _createArticalImage() {

        if (count($_FILES) <= 0) return '';

        if (!isset($_FILES['artical_image'])) return '';

        $tempFile = $_FILES['artical_image']['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/images/articalimg/';

        $filename = $this->generate($_FILES['artical_image']['tmp_name']).'.'.$this->getExt($_FILES['artical_image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $img = 'images/articalimg/'.$filename;

        $image_r = array();

        $sizer = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$img);

        $width = 260;
        $height = 130;

        $big = 'images/articalimg/'.$this->generate($img).'.'.$this->getExt($img);

        if ($sizer[0] > $width || $sizer[1] > $height) {

            $config = array();
            $kof = $width / $height;

            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
            $config['maintain_ratio'] = false;

            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$big;

            if (($sizer[0] / $sizer[1]) > $kof) {

                $config['height'] = $sizer[1];
                $config['width'] = round($sizer[1] * $kof);
                $config['x_axis'] = round(($sizer[0] - $config['width']) / 2);
                $config['y_axis'] = 0;

            } else {

                $config['height'] = round($sizer[0] / $kof);
                $config['width'] = $sizer[0];
                $config['x_axis'] = 0;
                $config['y_axis'] = round(($sizer[1] - $config['height']) / 2);

            }

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->crop();

            $this->ci->image_lib->clear();

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$big;

            $config['width'] = $width;
            $config['height'] = $height;

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();

            $this->ci->image_lib->clear();

        } else {

            copy($_SERVER['DOCUMENT_ROOT'].'/'.$img, $_SERVER['DOCUMENT_ROOT'].'/'.$big);

        }

        $image_r['image'] = $big;

        $width = 156;
        $height = 78;

        $sm = 'images/articalimg/'.$this->generate($img).'.'.$this->getExt($img);

        if ($sizer[0] > $width || $sizer[1] > $height) {

            $config = array();
            $kof = $width / $height;

            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
            $config['maintain_ratio'] = false;

            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$sm;

            if (($sizer[0] / $sizer[1]) > $kof) {

                $config['height'] = $sizer[1];
                $config['width'] = round($sizer[1] * $kof);
                $config['x_axis'] = round(($sizer[0] - $config['width']) / 2);
                $config['y_axis'] = 0;

            } else {

                $config['height'] = round($sizer[0] / $kof);
                $config['width'] = $sizer[0];
                $config['x_axis'] = 0;
                $config['y_axis'] = round(($sizer[1] - $config['height']) / 2);

            }

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->crop();

            $this->ci->image_lib->clear();

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$sm;

            $config['width'] = $width;
            $config['height'] = $height;

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();

            $this->ci->image_lib->clear();

        } else {

            copy($_SERVER['DOCUMENT_ROOT'].'/'.$img, $_SERVER['DOCUMENT_ROOT'].'/'.$sm);

        }

        $image_r['imagesm'] = $sm;

        @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$img);

        return $image_r;

    }

    public function delArtImage($id) {

        $res = $this->ci->db->select('image, imagesm')->from('site_artical')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return false;

        @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$res[0]['image']);
        @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$res[0]['imagesm']);

        return true;

    }

    public function createPageImage($file = '', $where = 'page') {

        if (empty($_FILES[$file])) return '';

        $tempFile = $_FILES[$file]['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/'.$where.'/';

        $filename = $this->generate($_FILES[$file]['tmp_name']).$this->getFExt($_FILES[$file]['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $file = 'images/data/'.$where.'/'.$filename;

        $return = array();
        $return['image_big'] = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/'.$where);
        $this->resizer_($_SERVER['DOCUMENT_ROOT'].'/'.$return['image_big'], 1088, 328);

        $return['image'] = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/'.$where);
        $this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$return['image'], 508, 328);

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$file);

        return $return;

    }

    public function createColorImage() {

        if (count($_FILES) <= 0) return '';

        if (!isset($_FILES['color_image'])) return '';

        $tempFile = $_FILES['color_image']['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/color/';

        $filename = $this->generate($_FILES['color_image']['tmp_name']).'.'.$this->getExt($_FILES['color_image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $img = 'images/data/color/'.$filename;

        $return = array();
        #$return['image_big'] = 'public/'.$this->createcreatecreate($img, 120, 76, 'data/color');
        $return['image'] = 'public/'.$this->createcreatecreate($img, 150, 150, 'data/color');

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$img);

        return $return;

    }

    public function createBrandImage() {
        if(isset($_FILES['image']['size']) && $_FILES['image']['size'] >= 4000) return false;

        if (count($_FILES) <= 0) return '';

        if (!isset($_FILES['image'])) return '';

        $tempFile = $_FILES['image']['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/brand/';

        $filename = $this->generate($_FILES['image']['tmp_name']).'.'.$this->getExt($_FILES['image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $img = 'images/data/brand/'.$filename;
        return 'public/'.$img;

        $return = array();

        $return['image'] = 'public/'.$this->createcreatecreate($img, 9999, 9999, 'data/brand');

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$img);

        return $return;

    }

    public function createPakets() {

        if (count($_FILES) <= 0) return '';

        if (!isset($_FILES['image'])) return '';

        $tempFile = $_FILES['image']['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/pakets/';

        $filename = $this->generate($_FILES['image']['tmp_name']).'.'.$this->getExt($_FILES['image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $img = 'images/data/pakets/'.$filename;

        $return = array();

        $return['image'] = 'public/'.$this->createcreatecreate($img, 42, 42, 'data/pakets');

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$img);

        return $return['image'];

    }

    public function createPhoneImage() {

        if (empty($_FILES['image'])) return '';
        $tempFile = $_FILES['image']['tmp_name'];
        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/phone/';

        $filename = $this->generate($_FILES['image']['tmp_name']).$this->getFExt($_FILES['image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $file = 'images/data/phone/'.$filename;

        $return = '';
        $return = 'public/'.$this->createcreatecreate($file, 17, 17, 'data/phone');

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$file);

        return $return;

    }

    public function createCatalogImage() {

        if (empty($_FILES['cat_image'])) return '';

        $tempFile = $_FILES['cat_image']['tmp_name'];

        if (empty($tempFile)) return '';

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/menu/';

        $filename = $this->generate($_FILES['cat_image']['tmp_name']).$this->getFExt($_FILES['cat_image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $file = 'images/data/menu/'.$filename;

        $return = array();
        $return['image_big'] = 'public/'.$this->createcreatecreate($file, 9999, 9999, 'data/menu');
        $this->croper_new($_SERVER['DOCUMENT_ROOT'].'/'.$return['image_big'], 180, 180);
        #$return['image'] = $this->createcreatecreate($file, 152, 98, 'photogallery');

        @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$file);

        return $return;

    }

    function resizeJcroper_($parms = array(), $width = 0, $height = 0, $imagesname = array(), $ext = array()) {
        if(isset($parms) && !empty($parms) && !empty($ext) && isset($ext)){
             $w = $parms['w'];
            $h = $parms['h'];
            $x1 = $parms['x1'];
            $y1 = $parms['y1'];
            $x2 = $parms['x2'];
            $y2 = $parms['y2'];
            $width = $width;
            $height = $height;
            $crop = true;
            $zoom = false;
            $src = $parms['image_big'].$imagesname;
            $new_images = $parms['image_big'].$ext;

            $orig = imagecreatefromjpeg($src);
            $new = imagecreatetruecolor(230, 123);
            imagecopyresampled($new, $orig, 0, 0, $x1, $y1, 230, 123, 230, 123);

            imagejpeg($new, $new_images, 95);
            return true;
        }
    }

    public function removeObjHoverImages($objid, $image) {
     if ($objid <= 0) return false;
     @unlink($_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/mainimg/'.$image);
    }
    public function removeObjImages($objid, $image) {
     if ($objid <= 0) return false;
     $dendy_array = array('_big', '_obj', '_top', '_dis', '_cat', '_pop', '_sm', '_list');
     foreach ($dendy_array as $value) {
      @unlink($_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/mainimg/'.$this->getFilename(end(explode('/', $image))).$value.'.'.$this->getExt($image));
     }
     @unlink($_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/mainimg/'.$image);
    }
    public function removeObjDodImages($objid, $image) {
     if ($objid <= 0) return false;
     $dendy_array = array('_sm');
     foreach ($dendy_array as $value) {
      @unlink($_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/moreimg/'.$this->getFilename(end(explode('/', $image))).$value.'.'.$this->getExt($image));
     }
     @unlink($_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/moreimg/'.$image);
    }

    public function createMainImage($objid, $oldimage = array()) {
     if (empty($_FILES['main_image'])) return '';
     $tempFile = $_FILES['main_image']['tmp_name'];
     if (empty($tempFile)) return '';
     $targetPath = $_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/';
     if(isset($oldimage) && !empty($oldimage)){
        $filename = $oldimage;
     } else {
        $filename = $this->generate($_FILES['main_image']['tmp_name']).$this->getFExt($_FILES['main_image']['name']); #$_FILES['main_image']['name'];
     }
     $targetFile = str_replace('//','/',$targetPath) . $filename;


     #copy($tempFile,$targetFile);
     move_uploaded_file($tempFile,$targetFile);

     $file = 'images/'.$objid.'/'.$filename;

     $result = array();
     $result['image'] = $filename;
     #$this->createcreatecreate($file, 1024, 768, $objid.'/mainimg', false, 'default');
     #$result['image'] = $this->getJustFilename($result['image']).'.'.$this->getExt($result['image']);
     #1425, 1067
     #$this->createcreatecreate($file, 650, 488, $objid.'/mainimg', false, '_big', true);

     $this->createcreatecreate($file, 580, 580, $objid.'/mainimg', false, 'default', true);

     $t_image = $this->createcreatecreate($file, 380, 380, $objid.'/mainimg', false, '_obj', true);

     #$t_image = $this->createcreatecreate($file, 336, 251, $objid.'/mainimg', false, '_list', true);

     #$t_image = $this->createcreatecreate($file, 320, 239, $objid.'/mainimg', false, '_dis', true);
     #$this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$t_image, 300, 225);

     $t_image = $this->createcreatecreate($file, 220, 220, $objid.'/mainimg', false, '_cat', true);
     #$this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$t_image, 176, 272);

     #$this->createcreatecreate($file, 200, 149, $objid.'/mainimg', false, '_top', true);

     #$this->createcreatecreate($file, 100, 75, $objid.'/mainimg', false, '_pop', true);

     $this->createcreatecreate($file, 60, 60, $objid.'/mainimg', false, '_sm', true);

     @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file);
     return $result;
    }

    public function createMainHoverImage($objid) {
     if (empty($_FILES['hover_image'])) return '';
     $tempFile = $_FILES['hover_image']['tmp_name'];
     if (empty($tempFile)) return '';
     $targetPath = $_SERVER['DOCUMENT_ROOT'].'/images/'.$objid.'/';
     $filename = $this->generate($_FILES['hover_image']['tmp_name']).$this->getFExt($_FILES['hover_image']['name']); #$_FILES['main_image']['name'];
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $file = 'images/'.$objid.'/'.$filename;

     $result = array();
     $result['image'] = $filename;
     $this->createcreatecreate($file, 220, 165, $objid.'/mainimg', false, 'default', true);

     @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file);
     return $result;
    }

    public function createImgs($objid, $imgs) {
     $imagesa = array();
     $imgs = explode(',', $imgs);
     $count_ = count($imgs);
     for ($i = 0; $i < $count_; ++$i) {
      $imgs[$i] = trim($imgs[$i]);
      if (!empty($imgs[$i])) {
       $imagesa[$i]['image'] = $this->getFilename(end(explode('/', $imgs[$i]))).'.'.$this->getExt($imgs[$i]);
       $this->createcreatecreate($imgs[$i], 580, 580, $objid.'/moreimg', false, 'default', true);

       $t_image = $this->createcreatecreate($imgs[$i], 60, 60, $objid.'/moreimg', false, '_sm', true);
       #$this->croper_($_SERVER['DOCUMENT_ROOT'].'/'.$t_image, 106, 106);

       @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$imgs[$i]);
      }
     }
     return $imagesa;
    }

    public function createBannerImage() {

        if (empty($_FILES['main_image'])) return null;

        $tempFile = $_FILES['main_image']['tmp_name'];

        if (empty($tempFile)) return null;

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/main/';

        $filename = $this->generate($_FILES['main_image']['tmp_name']).$this->getFExt($_FILES['main_image']['name']);
        $targetFile = str_replace('//','/',$targetPath) . $filename;
        move_uploaded_file($tempFile,$targetFile);

        $file = 'public/images/data/main/'.$filename;
        return $file;
        #return $this->createBI($file);

    }

    public function createBanImage() {
     if (empty($_FILES['main_image'])) return null;

     $tempFile = $_FILES['main_image']['tmp_name'];

     if (empty($tempFile)) return null;

     $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/public/images/data/banner/';

     $filename = $this->generate($_FILES['main_image']['tmp_name']).$this->getFExt($_FILES['main_image']['name']);
     $targetFile = str_replace('//','/',$targetPath) . $filename;
     move_uploaded_file($tempFile,$targetFile);

     $file = 'public/images/data/banner/'.$filename;
     return $file;
     #return $this->createBI($file);
    }

    public function createBI($img) {

        $tempconf = array();
        $tempconf['width'] = 548;
        $tempconf['height'] = 262;
        $tempconf['image_library'] = 'gd2';
        $tempconf['maintain_ratio'] = TRUE;
        $tempconf['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
        $this->ci->image_lib->initialize($tempconf);
        $this->ci->image_lib->resize();

        $this->ci->image_lib->clear();

        return $img;

    }

    public function generate($tf) {
     return md5(md5(date("l dS of F Y h:I:s A").$this->__generate()).md5($tf));

    }

    private function __generate() {

        $vowels = 'aeuyAEUY';
        $consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ23456789';
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < 7; $i++) {
        if ($alt == 1) {
        $password .= $consonants[(rand() % strlen($consonants))];
        $alt = 0;
              } else {
               $password .= $vowels[(rand() % strlen($vowels))];
               $alt = 1;
              }
             }
        return $password;

    }

    public function getFilename ($file) {

        if (($pos = strrpos($file, '.')) !== false) {

            return substr($file, 0, $pos);

        }

    }

    public function getJustFilename ($file) {
     if (($ppos = strrpos($file, "/")) !== false && ($pos = strrpos($file, '.')) !== false) {
      return substr($file, $ppos + 1, $pos);
     }
    }

    public function getExt ($file) {
     return end(explode('.', $file));
    }

    protected function getFExt($name) {
        $p = '';
        $ext = strtolower(substr(strrchr($name,'.'), 1));

        switch (true)
        {
            case in_array($ext, array('jpeg','jpe','jpg')):
            {
                $p = 'jpeg';
                break;
            }
            case ($ext=='gif'):
            {
                $p = 'gif';
                break;
            }
            case ($ext=='png'):
            {
                $p = 'png';
                break;
            }
        }

        return  '.' .$p;
    }

    public function resizeBig($img) {

        $sizer = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$img);

        $width = 1030;
        $height = 768;

        if (is_array($sizer) && isset($sizer) && isset($sizer) &&
           ($sizer[0] > $width && $sizer[1] > $height)
           ) {

            $config = array();
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = TRUE;

            $config['width'] = $width;
            $config['height'] = $height;

            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();

            $this->ci->image_lib->clear();

        }

        return $img;

    }

    public function createMiddle($img) {

        $sizer = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$img);

        $width = 224;
        $height = 164;

        if ($sizer[0] > $width || $sizer[1] > $height) {

            /*$config = array();
            $kof = $width / $height;

            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
            $config['maintain_ratio'] = false;
            */
            $middle = $this->getFilename($img).'_middle.'.$this->getExt($img);
            /*
            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$middle;

            if (($sizer[0] / $sizer[1]) > $kof) {

                $config['height'] = $sizer[1];
                $config['width'] = round($sizer[1] * $kof);
                $config['x_axis'] = round(($sizer[0] - $config['width']) / 2);
                $config['y_axis'] = 0;

            } else {

                $config['height'] = round($sizer[0] / $kof);
                $config['width'] = $sizer[0];
                $config['x_axis'] = 0;
                $config['y_axis'] = round(($sizer[1] - $config['height']) / 2);

            }

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->crop();

            $this->ci->image_lib->clear();

            $img = $middle;*/

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;

            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$middle;

            $config['width'] = $width;
            $config['height'] = $height;

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();

            $this->ci->image_lib->clear();

            $img = $this->water('images/middle_fon.jpg', 0, 0, $middle, 0, 0);

        } else {

            $middle = $this->getFilename($img).'_middle.'.$this->getExt($img);

            copy($_SERVER['DOCUMENT_ROOT'].'/'.$img, $_SERVER['DOCUMENT_ROOT'].'/'.$middle);

            $img = $middle;

        }

        return $img;

        //my code
        //sorry, but i must comment you and copy genial Sasha's code
        /*$tempcrop = $_SERVER['DOCUMENT_ROOT'].'/'.$this->getFilename($img).'_temp.'.$this->getExt($img);

        $tempconf = array();
        $tempconf['width'] = 274;
        $tempconf['height'] = 208;
        $tempconf['image_library'] = 'gd2';
        $tempconf['maintain_ratio'] = FALSE;
        $tempconf['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
        $tempconf['new_image'] = $tempcrop;
        $this->ci->image_lib->initialize($tempconf);
        $this->ci->image_lib->resize();

        $this->ci->image_lib->clear();

        $temp = $this->getFilename($img).'_middle.'.$this->getExt($img);

        $config1 = array();
        $config1['x_axis'] = 20;
        $config1['y_axis'] = 17;
        $config1['width'] = 234;
        $config1['height'] = 174;
        $config1['image_library'] = 'gd2';
        $config1['source_image'] = $tempcrop;
        $config1['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$temp;
        $this->ci->image_lib->initialize($config1);
        $this->ci->image_lib->crop();

        $this->ci->image_lib->clear();

        unlink($tempcrop);

        return $temp;*/

    }

    public function createSmall($img, $main = false) {

        $sizer = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$img);

        $width = 45;
        $height = 34;
        $fone = 'images/small_sm_fon.jpg';

        if ($main) {

            $width = 111;
            $height = 85;
            $fone = 'images/small_fon.jpg';

        }

        if ($sizer[0] > $width || $sizer[1] > $height) {
            /*
            $config = array();
            $kof = $width / $height;

            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
            $config['maintain_ratio'] = false;
            */
            $small = $this->getFilename($img).'_sm.'.$this->getExt($img);
            /*
            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$small;

            if (($sizer[0] / $sizer[1]) > $kof) {

                $config['height'] = $sizer[1];
                $config['width'] = round($sizer[1] * $kof);
                $config['x_axis'] = round(($sizer[0] - $config['width']) / 2);
                $config['y_axis'] = 0;

            } else {

                $config['height'] = round($sizer[0] / $kof);
                $config['width'] = $sizer[0];
                $config['x_axis'] = 0;
                $config['y_axis'] = round(($sizer[1] - $config['height']) / 2);

            }

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->crop();

            $this->ci->image_lib->clear();

            $img = $small;*/

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;

            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$small;

            $config['width'] = $width;
            $config['height'] = $height;

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();

            $this->ci->image_lib->clear();

            $img = $this->water($fone, 0, 0, $small, 0, 0);

        } else {

            $small = $this->getFilename($img).'_sm.'.$this->getExt($img);

            copy($_SERVER['DOCUMENT_ROOT'].'/'.$img, $_SERVER['DOCUMENT_ROOT'].'/'.$small);

            $img = $small;

        }

        return $img;

        /*$tempcrop = $_SERVER['DOCUMENT_ROOT'].'/'.$this->getFilename($img).'_temp.'.$this->getExt($img);

        $tempconf = array();

        if ($main) {
            $tempconf['width'] = 172;
            $tempconf['height'] = 135;
        } else {
            $tempconf['width'] = 98;
            $tempconf['height'] = 74;
        }
        $tempconf['image_library'] = 'gd2';
        $tempconf['maintain_ratio'] = FALSE;
        $tempconf['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
        $tempconf['new_image'] = $tempcrop;
        $this->ci->image_lib->initialize($tempconf);
        $this->ci->image_lib->resize();

        $this->ci->image_lib->clear();


        $temp = $this->getFilename($img).'_sm.'.$this->getExt($img);

        $config1 = array();
        if ($main) {
            $config1['x_axis'] = 25;
            $config1['y_axis'] = 20;
            $config1['width'] = 121;
            $config1['height'] = 95;
        } else {
            $config1['x_axis'] = 26;
            $config1['y_axis'] = 20;
            $config1['width'] = 45;
            $config1['height'] = 34;
        }
        $config1['image_library'] = 'gd2';
        $config1['source_image'] = $tempcrop;
        $config1['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$temp;
        $this->ci->image_lib->initialize($config1);
        $this->ci->image_lib->crop();

        $this->ci->image_lib->clear();

        unlink($tempcrop);

        return $temp;
       */

    }

function water($bg, $w_bg, $h_bg, $img, $img_w, $img_h) {

        /*$size = getimagesize($img);
        if (isset($size[0])) $img_w = $size[0];
        if (isset($size[1])) $img_h = $size[1];*/

        $config = array();
        //$config['image_library'] = 'ImageMagick';
        $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$bg;
        $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
        $config['wm_opacity'] = '100';
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'center';
        $config['quality'] = '100';
        //$config['wm_x_transp'] = $img_w - 1;
        //$config['wm_y_transp'] = $img_h - 1;
        $config['dynamic_output'] = FALSE;

        $this->ci->image_lib->initialize($config);
        $this->ci->image_lib->watermark();
        $this->ci->image_lib->clear();

     return $img;

 }

    function delImage($image) {

        if (is_null($image) || empty($image)) return false;

        unlink($_SERVER['DOCUMENT_ROOT'].'/'.$image);

        return true;

    }

    function _filesize($file) {
     $size = filesize($_SERVER['DOCUMENT_ROOT'].'/'.$file);
     if ($size === false) return '0';
     $size = round($size/1000000, 2).' MB';
     return $size;
    }

    public function croper_($src, $width = 1024, $height = 768)
  {

    $this->ci->load->library("image_lib");
    $this->ci->image_lib->clear();
    $imgsize=getimagesize($src);

    if ( ($imgsize[0]>$width) and ($imgsize[1]>$height) and ($width != 1024) and ($height != 768) )
    {
        $image_size=0;
        $k_image=($width/$height);

        if(($imgsize[0]/$imgsize[1]) > $k_image )
        {
            $crop_size_height=$imgsize[1];
            $crop_size_width=round($imgsize[1]*$k_image);
            $image_x_axis = round(($imgsize[0]-$crop_size_width)/2);
            $image_y_axis=0;
        }
        else
        {
            $crop_size_height=round($imgsize[0]/$k_image);
            $crop_size_width=$imgsize[0];
            $image_size=$imgsize[0];
            $image_x_axis = 0;
            $image_y_axis=round(($imgsize[1]-$crop_size_height)/2);
        }

        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $src;

        $config['x_axis'] = $image_x_axis;
        $config['y_axis'] = $image_y_axis;

        $config['maintain_ratio'] = FALSE; //TRUE

        $config['new_image'] = $src;
        $config['width'] = $crop_size_width;
        $config['height'] = $crop_size_height;


        $this->ci->image_lib->initialize($config);

        if (!$this->ci->image_lib->crop())
        {
            echo $this->ci->image_lib->display_errors();
        }

        $this->ci->image_lib->clear();

    }


    $config = array();
    $config['image_library'] = 'gd2';
    $config['source_image'] = $src;
    $config['maintain_ratio'] = TRUE;

    $config['width'] = $width;
    $config['height'] = $height;

    $this->ci->image_lib->initialize($config);

    $this->ci->image_lib->resize();

    $this->ci->image_lib->clear();

    return true;
  }

  public function croper_new($src, $width = 1024, $height = 768)
  {
    $this->ci->load->library("image_lib");
    $this->ci->image_lib->clear();
    $imgsize=getimagesize($src);
    $config = array();
    
    $config['source_image'] = $src;
    $config['maintain_ratio'] = TRUE;

    $config['width'] = 180;
    $config['height'] = 180;

    $this->ci->image_lib->initialize($config);

    $this->ci->image_lib->resize();

    $this->ci->image_lib->clear();

    return true;
  }

  public function resizer_($src, $width = 1024, $height = 768)
  {

    $this->ci->load->library('image_lib');
    $this->ci->image_lib->clear();
    $imgsize = getimagesize($src);

    $height = $imgsize[1];

    $config = array();
    $config['image_library'] = 'gd2';
    $config['source_image'] = $src;
    $config['maintain_ratio'] = TRUE;

    $config['width'] = $width;
    $config['height'] = $height;

    $this->ci->image_lib->initialize($config);

    $this->ci->image_lib->resize();

    $this->ci->image_lib->clear();

    return true;
  }

    function createcreatecreate($img, $width, $height, $where, $public = true, $dendy = '', $_public = false) {
        return $this->imgresize($img, $width, $height, $where, $public, $dendy, $_public);

    }

    function img_resize($src, $dest, $width, $height, $rgb=0xffffff, $quality=100)
{
  if (!file_exists($src)) return false;

  $size = getimagesize($src);

  if ($size === false) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);

  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0,
    $new_width, $new_height, $size[0], $size[1]);

  imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return true;
}

    public function imgresize($src, $width = 1024, $height = 768, $where = '', $public = true, $dendy = '', $_public = false) {

    $this->ci->image_lib->clear();

    $pristavka = '/';
    if (!$_public && ($pos = strpos($src, 'public/')) === false) $pristavka = '/public/';

    $new_img = '';

    if (!empty($dendy)) {
     if ($dendy == 'default') $dendy = '';
     $new_img = 'images/'.$where.'/'.$this->getFilename(end(explode('/', $src))).$dendy.'.'.$this->getExt($src);
    } else {
     $new_img = 'images/'.$where.'/'.$this->generate($src).'.'.$this->getExt($src);
    }
    $imgsize = getimagesize($_SERVER['DOCUMENT_ROOT'].$pristavka.$src);
    #TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    if ($public) {
     if (($imgsize[0] > $width || $imgsize[1] > $height) /*|| ($width != 1024 && $height != 768)*/) {
      $this->img_resize($_SERVER['DOCUMENT_ROOT'].$pristavka.$src, $_SERVER['DOCUMENT_ROOT'].'/public/'.$new_img, $width, $height);
     } else {
      copy($_SERVER['DOCUMENT_ROOT'].$pristavka.$src, $_SERVER['DOCUMENT_ROOT'].'/public/'.$new_img);
     }
    } else {
     #$new_img = 'images/'.$where.'/'.$this->generate($src).'.'.$this->getExt($src);
     if (($imgsize[0] > $width || $imgsize[1] > $height) /*|| ($width != 1024 && $height != 768)*/) {
      $this->img_resize($_SERVER['DOCUMENT_ROOT'].$pristavka.$src, $_SERVER['DOCUMENT_ROOT'].'/'.$new_img, $width, $height);
     } else {
      copy($_SERVER['DOCUMENT_ROOT'].$pristavka.$src, $_SERVER['DOCUMENT_ROOT'].'/'.$new_img);
     }
    }

    return $new_img;
  }

    /*function createcreatecreate($img, $width, $height, $where) {

        $sizer = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$img);

        $new_img = 'public/images/'.$where.'/'.$this->generate($img).'.'.$this->getExt($img);

        if ($sizer[0] > $width || $sizer[1] > $height) {

            $config = array();
            $kof = $width / $height;

            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$img;
            $config['maintain_ratio'] = false;

            $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$new_img;

            if (($sizer[0] / $sizer[1]) > $kof) {

                $config['height'] = $sizer[1];
                $config['width'] = round($sizer[1] * $kof);
                $config['x_axis'] = round(($sizer[0] - $config['width']) / 2);
                $config['y_axis'] = 0;

            } else {

                $config['height'] = round($sizer[0] / $kof);
                $config['width'] = $sizer[0];
                $config['x_axis'] = 0;
                $config['y_axis'] = round(($sizer[1] - $config['height']) / 2);

            }

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->crop();

            $this->ci->image_lib->clear();

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/'.$new_img;

            $config['width'] = $width;
            $config['height'] = $height;

            $this->ci->image_lib->initialize($config);
            $this->ci->image_lib->resize();

            $this->ci->image_lib->clear();

        } else {

            copy($_SERVER['DOCUMENT_ROOT'].'/'.$img, $_SERVER['DOCUMENT_ROOT'].'/'.$new_img);

        }

        return $new_img;

    }*/

}