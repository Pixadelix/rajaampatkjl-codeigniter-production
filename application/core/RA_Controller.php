<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH.'third_party/telegram');
//include_once APPPATH.'third_party/telegram/autoloader.php';

//ini_set("xdebug.overload_var_dump", "off");

class RA_Controller extends CI_Controller {
    const MAINTENANCE = FALSE;
    
    const ICON_PDF = 'assets/static/img/pdf.png';
    const ICON_XLS = 'assets/static/img/xls.png';
    const ICON_DOC = 'assets/static/img/doc.png';
    const ICON_CSV = 'assets/static/img/csv.png';
    const ICON_ZIP = 'assets/static/img/zip.png';
    
    const APP_LOGO = "\033[31m".APP_LOGO.
"
\033[32mRelease: ".PROJECT_NAME." [".APP_VERSION.' '.ENVIRONMENT.' '.CI_VERSION.'-'.DE_VERSION.']'.PHP_EOL.PHP_EOL."\033[0m";
	
	public $user_id = null;
    public $user_profile = null;
    public $user_profile_photo = null;
	
	public $shop_id = null;
	
	public $css = array();
	public $js = array();
    public $style_resource = array();
    public $resource = array();
	
	public $data = array();
	
	protected $_user_groups           = null;
	protected $_user_resources        = null;
	protected $_user_menu_resources   = null;
    protected $_user_navbar_resources = null;
	
	private $_restricted_resources = array();
	
	public $LOGIN_URL = '/user/auth/login';
	
	public function __construct() {
		parent::__construct();
        
		$enable_profiler = ENVIRONMENT !== 'production' || $this->input->get('debug') == '1' ? true : false;
		$this->output->enable_profiler($enable_profiler);
		//$this->output->enable_profiler(false);
        
        if ( $this->is_cli_mode() ) {
            echo $this::APP_LOGO;
            $this->_required_cli_password();
        }
		
		$this->breadcrumbs->push('Home', '/', 'fa-dashboard');
		
		$this->load->library('pagination');
		
		$this->_init();
		
		$this->data['SITE_TITLE'] = PROJECT_NAME;
		$this->data['PAGE_TITLE'] = 'Dashboard';
		$this->data['DEFAULT_PAGE_TITLE'] = ucwords(strtolower(PROJECT_NAME));
		
		// include jQuery library on top
		$this->include_required_js();
        
        $this->maintenance();
	}
    
    public function maintenance() {
		if ( ! self::MAINTENANCE && ! $this->config->item('maintenance') ) return;
        
		$this->data['PAGE_TITLE'] = 'Maintenance';
		
        $o = $this->load->view('/adminlte/matrix/meta_header', $this->data, true);
		$o .= $this->load->view('/adminlte/matrix/maintenance', $this->data ,true);
		$o .= $this->load->view('/adminlte/matrix/meta_footer', $this->data, true);
        echo $o;
        exit();
    }
    
    public function __destruct() {
        if ( ! $this->is_cli_mode() ) {
            return;
        }
        
        echo "Good Bye.".PHP_EOL;
    }
	
	private function _init() {
		
		$this->user_id = $this->ion_auth->get_user_id();
		
		/*$shop = Model\Shop::limit(1)->find_by_user_id($this->user_id);
		if ( $shop && is_array($shop) ) {
			$this->shop_id = $shop[0]->id;
		}*/

		// if not logged in no further process
		if(!$this->user_id) return;
        
        // get user profile information and store it as profile properties
        $this->user_profile = Model\Setting\Users::find($this->user_id);
		if ($this->user_profile)
			$this->user_profile_photo = Model\Content\Posts::find($this->user_profile->profile_photo);
		
		// get user group and store it in array
		if ( !$this->_user_groups ) {
			$user_groups = Model\Setting\Users\Groups::result()->where_in('user_id', $this->user_id)->get()->to_array();
			if($user_groups){
				foreach($user_groups as $ug) {
					$this->_user_groups[] = $ug['group_id'];
				}
			}
		}
		
		$user_resources = array();
		for($i = 0; $i < count($this->_user_groups); $i++) {
			
			$this->load->model('de/setting/AclResource');
			$restricted_resources = Model\Setting\Acl_restricted_resource::result()->where_in('group_id', $this->_user_groups[$i])->get()->to_array();
			//var_dump($restricted_resources);
			if($restricted_resources) {
				$allowed_resources = Model\Setting\Acl_resource::result()
                    ->where(array('menu_type' => $this->AclResource::TYPE_SIDEBAR))
                    ->where_not_in('id', array_column($restricted_resources, 'resource_id'))
                    ->order_by('position asc')
                    ->get()
                    ->to_array();
				//var_dump($allowed_resources);
				$user_resources = array_merge($user_resources, $allowed_resources);
			} else {
				$allowed_resources = Model\Setting\Acl_resource::result()
                    ->where(array('menu_type' => $this->AclResource::TYPE_SIDEBAR))
                    ->order_by('position asc')
                    ->get()
                    ->to_array();
				$user_resources = array_merge($user_resources, $allowed_resources);
			}
			
			
		}
		//var_dump($user_resources); die;
		$tmp = array();
		foreach($user_resources as &$ur) 
			$tmp[] = $ur["position"];
		//array_multisort($tmp, $user_resources, SORT_DESC);
		array_multisort($user_resources);
		$this->_user_resources = $user_resources;

		// build menu tree from user resources
		if ( !$this->_user_menu_resources ) {
			$tree = build_tree($this->_user_resources);
            $tree = array_values($tree);
            //var_dump($tree); die;
            //var_dump($this->_user_resources); die;
			if ($tree) {
				$this->_user_menu_resources   = $tree[0];   // application menu index always at 0
                $this->_user_navbar_resources = isset($tree[1]) && $tree[1]['code'] == 'root-navbar' ? $tree[1] : array();   // navbar menu index always at 1
			} else {
				$this->_user_menu_resources   = array();
                $this->_user_navbar_resources = array();
			}
		}
		
	}
	
	public function user_resources($resource_code = null) {
		//var_dump($this->_user_resources); die;
		return array_search($resource_code, array_column($this->_user_resources, 'code'), true);
	}
	
	public function get_menu_resource() {
		//return $this->_menu_resource[1]['children'];
        if ( isset($this->_user_menu_resources['children'] ) ) {
		  return $this->_user_menu_resources['children'];
        }
        return null;
	}
    
    public function get_navbar_resource() {
        if ( $this->_user_navbar_resources) {
            return isset($this->_user_navbar_resources['children']) ? $this->_user_navbar_resources['children'] : null;
        }
        return $this->_user_navbar_resources;
    }
	
	public function restricted($resource = null, $blocking = true) {

		if( $this->ion_auth->is_admin() ) {
			return false;
		}

		$headers = apache_request_headers();
		//$is_ajax = (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] == 'XMLHttpRequest');
		
		if (!$this->ion_auth->logged_in())
		{
			if( !$this->input->is_ajax_request() ) {
				// redirect them to the login page
				//redirect($this->LOGIN_URL, 'refresh');
				redirect('/user/auth/login', 'refresh');
			} else {
				//echo json_encode(array('err_code' => 0, 'err_msg' => 'Restricted area'));
				$this->json_error(array('err_code' => 0, 'err_msg' => 'Restricted area'), 403);
			}
			exit;
		}

		$restricted = true;
		if($resource) {
			//var_dump($resource); die;
			
			if(is_array($resource)) {
				for($i = 0; $i < count($resource); $i++) {
					//var_dump(acl($resource[$i]));
					if(acl($resource[$i])){
						$restricted = false;
						break;
					}
				}
			} else {
				if(acl($resource)) {
					$restricted = false;
				}
			}
			
			if($restricted) {
				if ($blocking) {
					if( !$this->input->is_ajax_request() ) {
						show_error('Restricted Area', 403);
					} else {
						$this->json_error(array('err_code' => 0, 'err_msg' => 'Restricted area'), 403);
					}
					exit;
				}
			}
		}
		
		// return true for grant access
		return $restricted;
	}
	
	public function dashboard($view = 'adminlte/blank', $theme = 'adminlte', $return_as_data = false)
	{
		$this->data['bread'] = $this->breadcrumbs->show();
		
		$this->data['notif_task_total'] = $this->get_task_total();
		
		$this->data['message'] = get_info_message();
		
		// IMPORTANT: include default assets last so it will override any styles
		$this->include_default_assets();
		
		//$this->data['SHOPING_CART_CONTAINER'] = $this->load->view('/adminlte/dashboard/shoping_cart_container', $this->data, true);
		//$this->data['TASK_NOTIFICATION_CONTAINER'] = $this->load->view('/adminlte/dashboard/notification_container', $this->data, true);
        
        $this->data['NAVBAR'] = $this->load->view('/adminlte/common/navbar', $this->data, true);
		
		if($return_as_data) {
			$tpl_data  = $this->load->view("$theme/common/meta_header", $this->data, $return_as_data);
			$tpl_data .= $this->load->view("$theme/common/header", $this->data, $return_as_data);
			$tpl_data .= $this->load->view("$theme/common/sidebar", $this->data, $return_as_data);
			$tpl_data .= $this->load->view($view, $this->data, $return_as_data);
			$tpl_data .= $this->load->view("$theme/common/footer", $this->data, $return_as_data);
			$tpl_data .= $this->load->view("$theme/common/control_sidebar", $this->data, $return_as_data);
			$tpl_data .= $this->load->view("$theme/common/meta_footer", $this->data, $return_as_data);
			return $tpl_data;
		} else {
			$this->load->view("$theme/common/meta_header", $this->data, $return_as_data);
			$this->load->view("$theme/common/header", $this->data, $return_as_data);
			$this->load->view("$theme/common/sidebar", $this->data, $return_as_data);
			$this->load->view($view, $this->data, $return_as_data);
			$this->load->view("$theme/common/footer", $this->data, $return_as_data);
			$this->load->view("$theme/common/control_sidebar", $this->data, $return_as_data);
			$this->load->view("$theme/common/meta_footer", $this->data, $return_as_data);			
		}
	}
	
	public function json_response($arr = array('success' => true)) {
		$this->output->enable_profiler(false);
		//add the header here
		header('Content-Type: application/json');
		echo json_encode( $arr );
	}
	
	public function json_error($msg, $status_code = 500, $blocking = true) {
		$this->output->enable_profiler(false);
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		header("HTTP/1.1 $status_code");
		
		$arr = array(
			'status' => false,
			'err_code' => $status_code,
			'err_msg' => !is_array($msg) ? $msg : implode($msg, ', ')
		);
		echo json_encode( $arr );
		if( $blocking ) exit;
	}
	
	public function in_group($groups, $user_id = false) {
		return $this->ion_auth->in_group($groups, $user_id);
	}
	
	public function enqueue_style($css, $media = 'all') {
		if(!is_array($css)){
			$this->css[] = $css;
		} else {
			for ( $i = 0; $i < count($css); $i++ ) {
				$this->css[] = $css[$i];
			}
		}
	}
	
	public function enqueued_styles() {
		$css = array_values(array_unique($this->css));
		$styles = '';
		
		for ( $i = 0; $i < count($css); $i++) {
			$styles .= css($css[$i]);
		}
		return $styles;
	}
	
	public function enqueue_scripts($js) {
		if(!is_array($js)){
			$this->js[] = $js;
		} else {
			for ( $i = 0; $i < count($js); $i++ ) {
				$this->js[] = $js[$i];
			}
		}
	}
    
	public function enqueued_scripts() {
		$js = array_values(array_unique($this->js));
		$scripts = '';
		for ($i = 0; $i < count($js); $i++) {
			$j = $js[$i];
			$scripts .= js($j);
		}
		return $scripts;
	}
    
    public function enqueue_style_resource($resource) {
        if(!is_array($resource)){
            $this->style_resource[] = $resource;
        } else {
            for ( $i = 0; $i < count($resource); $i++ ) {
                $this->style_resource[] = $resource[$i];
            }
        }
    }

    public function enqueue_resource($resource) {
        if(!is_array($resource)){
            $this->resource[] = $resource;
        } else {
            for ( $i = 0; $i < count($resource); $i++ ) {
                $this->resource[] = $resource[$i];
            }
        }
    }
    
    public function enqueued_style_resources() {
        $resource = array_values(array_unique($this->style_resource));
        $resources = '';
        for ($i = 0; $i < count($resource); $i++ ) {
            $resources .= style_resources($resource[$i]);
        }
        return $resources;
    }
    
    public function enqueued_resources() {
        $resource = array_values(array_unique($this->resource));
        $resources = '';
        for ($i = 0; $i < count($resource); $i++ ) {
            $resources .= resources($resource[$i]);
        }
        return $resources;
    }
	
	private function include_default_assets() {
		// CSS
		$this->enqueue_style(
			array(
				'bootstrap.min.css',
                //'../../Bootstrap-3.3.7/css/bootstrap.min.css',

				//'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css',
//<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">			
			
				//'//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',

				//'../cdn/css/font-awesome.min.css',
				'../../css/font-awesome-4.7.0/css/font-awesome.min.css',
				//'//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
				'../cdn/css/ionicons.min.css',
				//'/fontawesome-iconpicker.min.css',
				'../../css/fontawesome-iconpicker-1.3.1/dist/css/fontawesome-iconpicker.min.css',
				//'../plugins/fullcalendar/fullcalendar.min.css',
				//'../plugins/select2/select2.min.css',
				'//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css',
				'../plugins/iCheck/all.css',
				'../plugins/pace/pace.min.css',
				
				'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
				
				'AdminLTE.min.css',
				'skins/_all-skins.min.css',
				
//				'../../js/fullcalendar-3.4.0/fullcalendar.min.css',
				
				'../../css/jquery-confirm.css',
				'../../css/bootstrap-datetimepicker.min.css',
				
				'../../css/icons.css',
				
				APP_CSS,
			)
		);
		
		// don't use this yet, need to fix media target for print only
		//$this->enqueue_style('../plugins/fullcalendar/fullcalendar.print.css', 'print');
		
	}
    
	private function include_required_js() {
		$this->enqueue_scripts(
			array(
                'jquery-2.2.4.min.js',

				'../cdn/js/moment-with-locales.min.js',
				
				'imgpreview.jquery.js',

				'bootstrap.min.js',
                //'../../Bootstrap-3.3.7/js/bootstrap.min.js',
				
				//'../plugins/select2/select2.full.min.js',
				'//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js',
				'../plugins/slimScroll/jquery.slimscroll.min.js',
				'../plugins/fastclick/fastclick.js',
				'../plugins/iCheck/icheck.min.js',
				'../plugins/pace/pace.min.js',
				
				'../../js/jquery-confirm.js',
				'../../js/bootstrap-datetimepicker.min.js',
				
				
				'../../css/fontawesome-iconpicker-1.3.1/dist/js/fontawesome-iconpicker.min.js',
				
				'../../js/jsrender.js',
				
				'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',
				//'//www.gstatic.com/charts/loader.js',

				'app.js',
				'demo.js',
				'engine.js',
				'app/common.js',
			)
		);
        
        //$this->enqueue_resource('/resource/script/adminlte/dashboard/js/notification.js');
	}
    
	public function include_datatables_assets($enable_editor = false) {
        //return $this->new_include_datatables_assets($enable_editor);
		/*
		if ( 'production' === ENVIRONMENT ) {
			$this->enqueue_style(array(
				'//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
                
				'//cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css',
				'//cdn.datatables.net/autofill/2.1.3/css/autoFill.bootstrap.css',
				'//cdn.datatables.net/buttons/1.2.4/css/buttons.bootstrap.min.css',
				
				'//cdn.datatables.net/colreorder/1.3.2/css/colReorder.bootstrap.min.css',
				'//cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.bootstrap.min.css',
				'//cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css',
				'//cdn.datatables.net/keytable/2.2.0/css/keyTable.bootstrap.min.css',
				'//cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css',
				'//cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.bootstrap.min.css',
				'//cdn.datatables.net/scroller/1.4.2/css/scroller.bootstrap.min.css',
				'//cdn.datatables.net/select/1.2.0/css/select.bootstrap.min.css'
			));
		} else {
			$this->enqueue_style(array(
                
				'../cdn/1.10.13/css/dataTables.bootstrap.min.css',
				'../cdn/autofill/2.1.3/css/autoFill.bootstrap.css',
				'../cdn/buttons/1.2.4/css/buttons.bootstrap.min.css',
				
				'../cdn/colreorder/1.3.2/css/colReorder.bootstrap.min.css',
				'../cdn/fixedcolumns/3.2.2/css/fixedColumns.bootstrap.min.css',
				'../cdn/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css',
				'../cdn/keytable/2.2.0/css/keyTable.bootstrap.min.css',
				'../cdn/responsive/2.1.0/css/responsive.bootstrap.min.css',
				'../cdn/rowreorder/1.2.0/css/rowReorder.bootstrap.min.css',
				'../cdn/scroller/1.4.2/css/scroller.bootstrap.min.css',
				'../cdn/select/1.2.0/css/select.bootstrap.min.css',
                
                
			));
		}
        $this->enqueue_style(array(
            //'//cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css',
            //'//cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css',
        ));
		*/
		
		/*

		if ( 'production' === ENVIRONMENT ) {
			$this->enqueue_scripts(array(
				//'//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
				'//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js',
				'//cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js',
				'//cdn.datatables.net/autofill/2.1.3/js/dataTables.autoFill.min.js',
				'//cdn.datatables.net/autofill/2.1.3/js/autoFill.bootstrap.min.js',
				'//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js',
				'//cdn.datatables.net/buttons/1.2.4/js/buttons.bootstrap.min.js',
				'//cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js',
				'//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js',
				'//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js',
				'//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js',
				'//cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js',
				'//cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js',
				'//cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js',
				'//cdn.datatables.net/keytable/2.2.0/js/dataTables.keyTable.min.js',
				'//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js',
				'//cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js',
				'//cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js',
				'//cdn.datatables.net/scroller/1.4.2/js/dataTables.scroller.min.js',
				'//cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js',
			));
		} else {
			$this->enqueue_scripts(array(
				'../cdn/1.10.13/js/jquery.dataTables.min.js',
				'../cdn/1.10.13/js/dataTables.bootstrap.min.js',
				'../cdn/autofill/2.1.3/js/dataTables.autoFill.min.js',
				'../cdn/autofill/2.1.3/js/autoFill.bootstrap.min.js',
				'../cdn/buttons/1.2.4/js/dataTables.buttons.min.js',
				'../cdn/buttons/1.2.4/js/buttons.bootstrap.min.js',
				'../cdn/buttons/1.2.4/js/buttons.colVis.min.js',
				'../cdn/buttons/1.2.4/js/buttons.flash.min.js',
				'../cdn/buttons/1.2.4/js/buttons.html5.min.js',
				'../cdn/buttons/1.2.4/js/buttons.print.min.js',
				'../cdn/colreorder/1.3.2/js/dataTables.colReorder.min.js',
				'../cdn/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js',
				'../cdn/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js',
				'../cdn/keytable/2.2.0/js/dataTables.keyTable.min.js',
				'../cdn/responsive/2.1.0/js/dataTables.responsive.min.js',
				'../cdn/responsive/2.1.0/js/responsive.bootstrap.min.js',
				'../cdn/rowreorder/1.2.0/js/dataTables.rowReorder.min.js',
				'../cdn/scroller/1.4.2/js/dataTables.scroller.min.js',
				'../cdn/select/1.2.0/js/dataTables.select.min.js',
			));
		}
		*/
		
		$this->enqueue_style(
			array(
				'//cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css'
			)
		);
 
		$this->enqueue_scripts(
			array(
				'//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js',
				'//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js',
				'//cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js'
			)
		);
		
		$this->enqueue_scripts(array(
			//'jquery.dataTables.min.js',
			//'dataTables.bootstrap.min.js',
			//'../../js/datatables.js',
			
            '//cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)',
            '//cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js',
		));
		
		if ( 'production' === ENVIRONMENT ) {
			$this->enqueue_scripts(array(
//				'//momentjs.com/downloads/moment-with-locales.min.js',
				'//cdn.datatables.net/plug-ins/1.10.13/dataRender/datetime.js',
			));
		} else {
			$this->enqueue_scripts(array(
//				'../cdn/js/moment-with-locales.min.js',
				'../cdn/datatables/plug-ins/1.10.13/dataRender/datetime.js',
			));			
		}
		
		if( $enable_editor) {
			//$this->enqueue_style('../plugins/datatables/extensions/Editor-1.6.2/css/editor.dataTables.min.css');
			
			$this->enqueue_style('../plugins/datatables/extensions/Editor-'.DE_VERSION.'/css/editor.bootstrap.css');
			$this->enqueue_style('../plugins/datatables/extensions/Editor-1.6.1/css/editor.title.css');

			//$this->enqueue_style('../plugins/datatables/extensions/Editor-1.6.2/css/editor.jqueryui.css');
			
			$this->enqueue_scripts('../plugins/datatables/extensions/Editor-'.DE_VERSION.'/js/dataTables.editor.js');
			
			$this->enqueue_scripts('../plugins/datatables/extensions/Editor-'.DE_VERSION.'/js/editor.bootstrap.js');
			
			$this->enqueue_scripts('../plugins/datatables/extensions/Editor-1.6.1/js/editor.title.js');
			$this->enqueue_scripts('../plugins/datatables/extensions/Editor-1.6.1/js/editor.select2.js');

			//$this->enqueue_scripts('../plugins/datatables/extensions/Editor-1.6.2/js/editor.jqueryui.js');
			
			$this->enqueue_scripts(array(
//				'//cloud.tinymce.com/stable/tinymce.min.js',
//				'//cdn.tinymce.com/4/tinymce.min.js',
//				'../cdn/tinymce/4/tinymce.min.js',
//                'https://cloud.tinymce.com/stable/tinymce.min.js',
                '//cdn.ckeditor.com/4.7.1/full/ckeditor.js',
//				'../plugins/datatables/extensions/Editor-1.6.1/js/editor.tinymce.js',
                '../plugins/datatables/extensions/Editor-1.6.1/js/editor.ckeditor.js',
//				'../plugins/ckeditor/ckeditor.js',
//				'//cdn.ckeditor.com/4.6.2/basic/ckeditor.js',
            ));
            
		}
        
        //rowGroup extensions requirement
        //$this->enqueue_style('//cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css');
        //$this->enqueue_scripts('//cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js');
        
        
	}

	
	public function get($id = null) {
		$this->output->enable_profiler(false);
	}
	
	
	
	/* DASHBOARD COMMON REQUEST */
	public function get_task_total($id = null) {
		if (!$this->restricted('user-web-services', false) ) {
            $rows = array();
			//$rows = $this->db->query($this->sql_task_notification, array($this->user_id))->result_array();
			//var_dump(count($rows)); die;
			return count($rows);
		}
	}
	public function get_task_notification($id = null) {
		if (!$this->restricted('user-web-services') ) {
            $rows = array();
			//$this->get();
			//$rows = $this->db->query($this->sql_task_notification, array($this->user_id))->result_array();

			echo json_encode($rows);
		}
	}
	
	public function db_value_now($modify = null, $format = 'Y-m-d H:i:s') {
		if ( $modify ) {
			return (new DateTime())->modify($modify)->format($format);
		}
		return (new DateTime())->format($format);
	}
    
    public function db_timestamp_now() {
        return time();
    }
	
	public function generate_reimburse_ref_code() {
		return '/REIM/MV.TMS/'.romanic_number(date('m')).'/'.date('Y');
	}
	
	public function resize_image($image) {
		
		$this->load->library('image_lib');
		
		$this->image_lib->clear();
		$imlib_thumb = $this->config->item('imlib_thumb');
		$imlib_thumb['source_image'] = $image;
		$this->image_lib->initialize($imlib_thumb);
		if ( ! $this->image_lib->resize()) {
			return false;
			echo $this->image_lib->display_errors();
		}
		
		$this->image_lib->clear();
		$imlib = $this->config->item('imlib');
		$imlib['source_image'] = $image;
		$this->image_lib->initialize($imlib);
		if( ! $this->image_lib->resize()) {
			return false;
			echo $this->image_lib->display_errors();
		}
		
		return true;
	}
    
    public function hash_password($new_password) {
        
        $this->load->model('Ion_auth_model', 'ion_auth_model');
        
        $new_password = $this->ion_auth_model->hash_password($new_password);
        return $new_password;
    }
	
	public function unzip($source, $dest) {
		$zip = new ZipArchive;
		if ( $zip->open($source) === true ) {
			$zip->extractTo($dest);
			$zip->close();
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Generates a string representation for the given byte count.
	 *
	 * @param $size
	 *   A size in bytes.
	 *
	 * @return
	 *   A string representation of the size.
	 */
	function format_size($size) {
		if ($size < 1024) {
			return $size . ' B';
		} else {
			$size = $size / 1024;
			$units = ['KB', 'MB', 'GB', 'TB'];
			foreach ($units as $unit) {
				if (round($size, 2) >= 1024) {
					$size = $size / 1024;
				} else {
					break;
				}
			}
			return round($size, 2) . ' ' . $unit;
		}
	}
	
	public static function show_progress_status($done, $total, $label, $size=15) {

    	static $start_time;

    	// if we go over our bound, just ignore it
    	if($done > $total) return;

    	if(empty($start_time)) $start_time=time();
    	$now = time();

    	$perc = (double)($done/$total);

    	$bar = floor($perc*$size);

    	$status_bar = "\r".sprintf('%-55s', $label)."[";
    	$status_bar .= str_repeat("=", $bar);
    	if($bar<$size){
        	$status_bar.=">";
        	$status_bar.=str_repeat(" ", $size-$bar);
    	} else {
	        $status_bar.="=";
	    }

	    $disp = sprintf('%3d', number_format($perc*100, 0));

    	$status_bar.="] $disp%  $done/$total";

    	$rate = ($now-$start_time)/$done;
    	$left = $total - $done;
    	$eta = round($rate * $left, 2);

    	$elapsed = $now - $start_time;
        $ci =& get_instance();

    	$status_bar.= " remain: ".number_format($eta)." sec. elap: ".number_format($elapsed)." sec. [RAM: ".$ci->format_size(memory_get_peak_usage(false)).']';

    	echo "$status_bar  ";

    	flush();

    	// when done, send a newline
    	if($done == $total) {
	        //echo "\n";
	    }

		//usleep(10000);
	}
	
	public function get_all_links($html) {
		$dom = new DOMDocument;
		
		//Parse the HTML. The @ is used to suppress any parsing errors
		//that will be thrown if the $html string isn't valid XHTML.
		@$dom->loadHTML($html);
		
		//Get all links. You could also use any other tag name here,
		//like 'img' or 'table', to extract other tags.
		$links = $dom->getElementsByTagName('a');
		
		return $links;
	}
	
	public function must_cli_mode() {
		$this->output->enable_profiler(false);
		if ( !$this->input->is_cli_request() ) {
			echo 'This module can only be running in CLI Mode';
			exit();
		}
	}
    
    public function is_cli_mode() {
        return $this->input->is_cli_request();
    }
    
    private function _required_cli_password() {
        $class  = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        if ( 'install' === $class && ('tables' === $method || 'baseline' === $method) ) {
            return;
        }
        echo "Please login\n";

		require(APPPATH.'libraries/getopts.php');
		$opts = getopts(array(
			'u' => array('switch' => 'u', 'type' => GETOPT_VAL, 'default' => ''),
			'p' => array('switch' => 'p', 'type' => GETOPT_VAL, 'default' => ''),
		), $_SERVER['argv']);
		
        $email    = ENVIRONMENT === 'development' ? 'admin' : ( $opts['u'] ? $opts['u'] : $this->prompt_silent("Enter Username/Email:") );
        $password = ENVIRONMENT === 'development' ? 'demo'  : ( $opts['p'] ? $opts['p'] : $this->prompt_silent("Enter Password:") );
        
        if ( !$this->ion_auth->login($email, $password) ) {
            echo "You're not authorized\n";
            exit(1);
        } else {
            echo "Permission granted\n";
        }
        
        $user = Model\Setting\Users::find_by_email($email);
        if ( $user ) {
            $this->user_id = $user[0]->id;
        }
    }
    
    public function prompt_silent($prompt = "Enter Password:") {
        if (preg_match('/^win/i', PHP_OS)) {
            $vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
            file_put_contents(
                $vbscript, 'wscript.echo(InputBox("'
                . addslashes($prompt)
                . '", "", "password here"))');
                $command = "cscript //nologo " . escapeshellarg($vbscript);
                $password = rtrim(shell_exec($command));
                unlink($vbscript);
                return $password;
            } else {
            $command = "/usr/bin/env bash -c 'echo OK'";
            if (rtrim(shell_exec($command)) !== 'OK') {
                trigger_error("Can't invoke bash");
                return;
            }
            $command = "/usr/bin/env bash -c 'read -s -p \""
                . addslashes($prompt)
                . "\" mypassword && echo \$mypassword'";
                $password = rtrim(shell_exec($command));
            echo "\n";
            return $password;
        }
    }
	
	public function curl_get_data($url, $opts = null) {

		if ( ! $url ) {
			return;
		}
		
		//echo "OPEN: $url\n";
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout+30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING , "");
	
		if ( $opts && is_array($opts) ) {
			curl_setopt_array($ch, $opts);
		}

		$raw = curl_exec($ch);
		$error = null;
		if ( false === $raw ) {
			$error = curl_error($ch);
			//echo "ERROR: $error\n";
		}
		
		$redirect_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL );
        $http_code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close($ch);
		
		$data = new StdClass();
		
		$data->url          = $url;
		$data->redirect_url = $redirect_url;
		$data->html         = $raw;
		$data->error        = $error;
        $data->http_code    = $http_code;

		//echo "CLOSED\n";
		return $data;
	}
	
	public function init_telegram() {
		if ( ! isset($this->telegram_manager) ) {
			$this->config->load('telegram');
			$telegram_config = $this->config->item('default', 'telegram');
			$this->load->library('telegram_manager', $telegram_config);
		}
	}
	
	public function telegram_send_message($chat_id, $text) {
		$this->init_telegram();
		if (is_numeric($chat_id)) {
			$this->telegram_manager->sendMessage($chat_id, $text);
		} else {
			$this->telegram_manager->sendMessageByUsername($chat_id, $text);
		}
	}
    
    public function toNumber($strVal) {
        $v = explode(' ', $strVal);
        $val = $v[0];
        $power = strtoupper($v[1]);
        
        switch ($power) {
            case 'JT':
                $val = $val * 1000000;
                break;
            case 'M':
                $val = $val * 1000000000;
                break;
            default:
                break;
        }
        return $val;
        
    }
	
	protected function _log_input($func_name = '_log_input') {
		$in = file_get_contents('php://input');
		//echo "\n<br/>";
		//var_dump($in);
		//$log = json_decode($in);
		log_message('info', $func_name.":\n".$in);
	}
	
	public function _get_csrf_nonce() {
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}
	
	public function _valid_csrf_nonce() {
		#var_dump($this->session->flashdata());
		#var_dump($this->input->post());
		#die;
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
