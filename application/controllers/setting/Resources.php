<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources extends RA_Controller {
    
	public function __construct() {
		parent::__construct();
		
		$this->data['PAGE_TITLE'] = 'Menu Editor';
		
		//$this->restricted(array('menu-editor', 'insert'));

		$this->breadcrumbs->push('Resources Editor', '/setting/menu');
        
        $this->load->model('de/setting/AclResource', 'resources');

	}
	
		
	public function index()
	{
		$acl_resource = Model\Setting\Acl_resource::result()->order_by('position asc')->all()->to_array();
		
		$this->data['acl_resource'] = $acl_resource;
		$this->dashboard('adminlte/setting/resources/index');
	}
	
	public function search()
	{
		$needle = $this->input->get('table_search');
		if(!$needle) {
			redirect('/setting/menu', 'refresh');
		}
		$acl_resource = Model\Setting\Acl_resource::result()
			->like('label', $needle)
			->or_like('code', $needle)
			->or_like('url', $needle)
			->order_by('position asc')
			->get()
			->to_array();
		
		$this->data['acl_resource'] = $acl_resource;
		$this->dashboard('adminlte/setting/resources/index');
	}
	
	public function create_menu() {
		$this->breadcrumbs->push('Add new Resource', "/setting/resources/create_menu");
		
		
		if ( isset($_POST) && !empty($_POST) ) {
			$acl_resource = Model\Setting\Acl_resource::make($_POST);
			$last_menu = Model\Setting\Acl_resource::last('position');
			$acl_resource->position = $last_menu->position + 1;
			if ($acl_resource->save(true) ) {
				$last_acl_resource_id = Model\Setting\Acl_resource::last_created()->id;
				// restrice new menu to all groups except for admin
				$all_groups = Model\Setting\Groups::where_not_in('id', 1)->get();
				
				for($i=0; $i<count($all_groups); $i++){
					$data = array(
						'resource_id' => $last_acl_resource_id,
						'group_id' => $all_groups[$i]->id,
					);
					$acl_restricted_resource = Model\Setting\Acl_restricted_resource::make($data)->save(true);
					//var_dump($acl_restricted_resource);
					
				}
				//die;
				redirect('/setting/resources', 'refresh');
			};
		}
		
		$this->dashboard('/adminlte/setting/resources/create_menu');
	}
	
	public function edit($id) {
		$this->breadcrumbs->push('Edit Resource', "/setting/resources/edit/$id");
		
		if ( isset($_POST) && !empty($_POST) ) {
			if($id != $this->input->post('id')) {
				show_error('Invalid request.');
				return;
			}
		}
		
		$acl_resource = Model\Setting\Acl_resource::find($id);
		if ( !$acl_resource ) {
			show_404();
			exit();
		}
		
		if (isset($_POST) && !empty($_POST)) {
			//var_dump($_POST); die;
			$acl_resource->parent_id = $_POST['parent_id'];
			$acl_resource->code      = $_POST['code'];
			$acl_resource->label     = $_POST['label'];
			$acl_resource->url       = $_POST['url'];
			$acl_resource->menu_type = $_POST['menu_type'];
			$acl_resource->icon      = $_POST['icon'];
			
			
			if ( $acl_resource->save(true) ) {
				set_message_success('Record saved');
				redirect('/setting/resources', 'refresh');
			}else{
				set_message_error($acl_resource->errors);
			}
		}

		$this->data['acl_resource'] = $acl_resource;
		$this->dashboard('/adminlte/setting/resources/edit');
	}
	
	public function rearrange() {
		$acl_resource = Model\Setting\Acl_resource::order_by('position', 'asc')->get();
		
		if(!$acl_resource) {
			redirect('/setting/resources', 'refresh');
			return;
		}
		
		$i = 0;
		foreach($acl_resource as $acl):
			$acl->position = $i;
			$acl->save();
			$i++;
		endforeach;
		
		redirect('setting/resources', 'refresh');
	}
	
	public function move($menu_id, $direction) {
		$acl_resource = Model\Setting\Acl_resource::find($menu_id);
		
		if( !$acl_resource ) {
			show_404();
			return;
		}
		
		if(-1 == $direction && $acl_resource->position <= 0 ) {
			// position already at bottom
			redirect('/setting/resources', 'refresh');
			return;
		}
		
		$swap = Model\Setting\Acl_resource::where(array('position' => $acl_resource->position + $direction))->first();
		
		if(!$swap) {
			// no swap found, skipping
			redirect('/setting/resources', 'refresh');
			return;
		}
		
		$buffer_pos = $acl_resource->position;
		$acl_resource->position = $swap->position;
		$swap->position = $buffer_pos;
		
		$acl_resource->save();
		$swap->save();
		
		redirect('/setting/resources', 'refresh');
	}
	
	public function up($menu_id) {
		$this->move($menu_id, -1);
	}
	
	
	public function down($menu_id) {
		$this->move($menu_id, 1);
	}
	
	public function delete($menu_id) {
		$acl_resource = Model\Setting\Acl_resource::find($menu_id);
		$acl_resource->delete();
		redirect('/setting/resources', 'refresh');
	}
    
    private function _ra($parent, $code, $label, $url, $icon, $menu_type = null, $groups = null) {
        if ( ! $menu_type ) {
            $menu_type = $this->resources::TYPE_SIDEBAR;
        }
        return array(
            'parent'         => $parent,
            'code'           => $code,
            'label'          => $label,
            'url'            => $url,
            'icon'           => $icon,
            'menu_type'      => $menu_type,
            'enabled_groups' => $groups,
        );
    }
    
    public function register() {
		
		
		$this->config->load('menu_resources', true);
        $this->must_cli_mode();
        $this->restricted('admin');
        echo "Registering Resources\n";
		
		$resources = $this->config->item('resources', 'menu_resources');
        
        $this->db->query("TRUNCATE TABLE `sys_acl_resource`");
        $this->db->query("TRUNCATE TABLE `sys_acl_restricted_resource`");
    
		/*
        $O      = array('operator');
		$M      = array('manager');
        $S      = array('supervisor');

        $resources = array(
            $this->_ra(null, 'root-sidebar', 'Application Menu', null, 'fa-bars', $this->resources::TYPE_SIDEBAR, array_merge($O, $M, $S)),
                $this->_ra('root-sidebar', 'dashboard', 'Dashboard', '/dashboard/main', 'fa-dashboard', $this->resources::TYPE_SIDEBAR, array_merge($O, $M, $S)),
				$this->_ra('root-sidebar', 'pricing', 'Pricing', '/ticket/pricing', 'fa-calendar-check-o', $this->resources::TYPE_SIDEBAR),
				$this->_ra('root-sidebar', 'orders', 'Orders', '/ticket/orders', 'fa-calendar-plus-o', $this->resources::TYPE_SIDEBAR),
                $this->_ra('root-sidebar', 'ticket', 'Ticket', '/ticket/sale', 'fa-ticket', $this->resources::TYPE_SIDEBAR, array_merge($O, $M, $S)),

                $this->_ra('root-sidebar', 'settings', 'System Settings', NULL, 'fa-wrench', $this->resources::TYPE_SIDEBAR),
                    //$this->_ra('settings', 'users', 'Users', '/auth', 'fa-male'),
                    $this->_ra('settings', 'users-management', 'User Management', '/setting/user', 'fa-users'),
                    
					$this->_ra('settings', 'acl', 'Access Manager', '/setting/acl', 'fa-unlock-alt'),
                    $this->_ra('settings', 'resource-editor', 'Menu Manager', '/setting/resources', 'fa-cube'),
                    $this->_ra('settings', 'clients', 'Clients', '/setting/clients', 'fa-globe', $this->resources::TYPE_SIDEBAR),
                    $this->_ra('settings', 'projects', 'Projects', '/setting/projects', 'fa-briefcase', $this->resources::TYPE_SIDEBAR),
				
				$this->_ra('root-sidebar', 'data-master', 'Data Master', NULL, 'fa-database', $this->resources::TYPE_SIDEBAR),
                    $this->_ra('data-master', 'countries', ' Country', '/setting/country', 'fa-globe', $this->resources::TYPE_SIDEBAR),
                    $this->_ra('data-master', 'operators', ' Operator', '/setting/operator', 'fa-bus', $this->resources::TYPE_SIDEBAR),
                    $this->_ra('data-master', 'operator-categories', ' Operator Categories', '/setting/operator-category', 'fa-subway', $this->resources::TYPE_SIDEBAR),
                    $this->_ra('data-master', 'sales-offices', ' Sales Office', '/setting/office', 'fa-building-o', $this->resources::TYPE_SIDEBAR),
					$this->_ra('data-master', 'sequences', ' Sequences', '/setting/sequence', 'fa-sort-numeric-asc', $this->resources::TYPE_SIDEBAR),
					
				$this->_ra('root-sidebar', 'tools', 'Tools', NULL, 'fa-wrench', $this->resources::TYPE_SIDEBAR),
					$this->_ra('tools', 'ticket-numbers', ' Ticket Numbers', '/tools/ticket-numbers', 'fa-file-pdf-o', $this->resources::TYPE_SIDEBAR),
            
				$this->_ra('root-sidebar', 'visitor-report', 'Visitor Report', '/report/visitor-report', 'fa-plane', $this->resources::TYPE_SIDEBAR, $S),
                    $this->_ra('visitor-report', 'visitor-by-operator', 'By Operator', '/report/visitor-by-operator', 'fa-bar-chart', $this->resources::TYPE_SIDEBAR, $S),
            		$this->_ra('visitor-report', 'visitor-by-opr-category', 'By Operator Category', '/report/visitor-by-opr-category', 'fa-bar-chart', $this->resources::TYPE_SIDEBAR, $S),
					$this->_ra('visitor-report', 'visitor-by-category', 'By Category', '/report/visitor-by-category', 'fa-bar-chart', $this->resources::TYPE_SIDEBAR, $S),
					$this->_ra('visitor-report', 'visitor-by-gender', 'By Gender', '/report/visitor-by-gender', 'fa-bar-chart', $this->resources::TYPE_SIDEBAR, $S),
					$this->_ra('visitor-report', 'visitor-by-location', 'By Location', '/report/visitor-by-location', 'fa-bar-chart', $this->resources::TYPE_SIDEBAR, $S),
			
				$this->_ra('root-sidebar', 'sales-report', 'Sales Report', '/reports', 'fa-dollar', $this->resources::TYPE_NAVBAR, $S),
					$this->_ra('sales-report', 'sales-summary', 'Summary', '/report/sales-summary', 'fa-bar-chart', $this->resources::TYPE_NAVBAR, $S),
            
            $this->_ra(null, 'root-navbar', 'Navbar Menu', null, 'fa-bars', $this->resources::TYPE_NAVBAR, $S),
            
            $this->_ra(null, 'web-services', 'Web Services', '', 'fa-gears', $this->resources::TYPE_WEBSVC, array_merge($O, $M, $S)),
			
			$this->_ra(null, 'root-sidebar-common', 'Common Application Menu', null, 'fa fa-bars', $this->resources::TYPE_SIDEBAR_COMMON),
				$this->_ra('root-sidebar-common', 'app-home', 'Home', '/apps/home', 'fa fa-home', $this->resources::TYPE_SIDEBAR_COMMON),				
				$this->_ra('root-sidebar-common', 'app-buy-ticket', 'Buy Ticket', '/apps/products/ticket', 'fa fa-ticket', $this->resources::TYPE_SIDEBAR_COMMON),
				$this->_ra('root-sidebar-common', 'app-news', 'News', '/apps/news', 'fa fa-newspaper-o', $this->resources::TYPE_SIDEBAR_COMMON),
					$this->_ra('app-news', 'rubric-focus', 'Focus', '/apps/news/focus', 'fa fa-newspaper-o', $this->resources::TYPE_SIDEBAR_COMMON),
					$this->_ra('app-news', 'rubric-profile', 'Profile', '/apps/news/profile', 'fa fa-newspaper-o', $this->resources::TYPE_SIDEBAR_COMMON),
					
			$this->_ra('root-sidebar', 'contest', 'Contest', '/contest/dashboard', 'fa-trophy', $this->resources::TYPE_SIDEBAR),
				$this->_ra('contest', 'contests-manager', 'Contest Manager', '/contest/dashboard/index', 'fa-trophy', $this->resources::TYPE_SIDEBAR),
				$this->_ra('contest', 'contest-scoring', 'Scoring', '/contest/dashboard/scoring', 'fa-star', $this->resources::TYPE_SIDEBAR),
				$this->_ra('contest', 'contest-score-summary', 'Score Summary', '/contest/dashboard/score-summary', 'fa-certificate', $this->resources::TYPE_SIDEBAR),
        );
		*/
        
        //die(var_dump($resources));
        
        foreach ( $resources as $resource ) {
            Model\Setting\Acl_resource::register($resource);
        }
    }
    
    public function acl_check($first_name = null) {
        $this->must_cli_mode();

        $users = null;
        if ( $first_name ) {
            $users = Model\Setting\Users::find_by_first_name($first_name);
        } else {
            $users = Model\Setting\Users::where(array('active' => 1))->get();
        }
        
        if ( ! $users ) {
            return;
        }

        foreach( $users as $user ) {
            
            /*
            $groups = null;
            if ( !$group_name ) {
                $groups = Model\Groups::all();
            } else {
                $groups = Model\Groups::find_by_name($group_name);
            }
            */
            
            $groups = $user->groups();

            $resources = Model\Setting\Acl_resource::all();

            //var_dump($resources); die;

            foreach ( $groups as $group ) {

                //var_dump($group->restricted_resources());
                //continue;

                //echo sprintf("%-s:", $group->name).PHP_EOL;

                $restricted_resources = Model\Setting\Acl_restricted_resource::where(array('group_id' => $group->id))
                    ->get()
                    ;

                if ( ! $restricted_resources ) {
                    continue;
                }

                foreach( $resources as $r ) {
                    $access = true;
                    foreach( $restricted_resources as $restricted_resource ) {
                        if ( $restricted_resource->resource()->id == $r->id ) {
                            $access = false;
                            break;
                        }
                    }
                    echo sprintf("[%s][%s][%s]", $user->first_name, $group->name, ($access ? "\033[32m".$r->code."\033[0m" : "\033[31m".$r->code."\033[0m")).PHP_EOL;
                    //usleep(100000);
                }

                echo PHP_EOL;

            }
        }
    }
	
}