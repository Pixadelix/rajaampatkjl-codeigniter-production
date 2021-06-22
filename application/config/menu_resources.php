<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci =& get_instance();
$ci->load->model('de/setting/AclResources', 'resources');

if ( ! function_exists('_ra') ) {
	function _ra($parent, $code, $label, $url, $icon, $menu_type = null, $groups = null) {
        if ( ! $menu_type ) {
			$ci =& get_instance();
            $menu_type = $ci->resources::TYPE_SIDEBAR;
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
}

$O      = array('operator');
$M      = array('manager');
$S      = array('supervisor');

$resources = array(
	_ra(null, 'root-sidebar', ' Application Menu', null, 'fa-bars', $ci->resources::TYPE_SIDEBAR, array_merge($O, $M, $S)),
		_ra('root-sidebar', 'dashboard', ' Dashboard', '/dashboard/main', 'fa-dashboard', $ci->resources::TYPE_SIDEBAR, array_merge($O, $M, $S)),
		_ra('root-sidebar', 'pricing', ' Pricing', '/ticket/pricing', 'fa-money', $ci->resources::TYPE_SIDEBAR),
		_ra('root-sidebar', 'orders', ' Orders', '/ticket/orders', 'fa-calendar-plus-o', $ci->resources::TYPE_SIDEBAR),
		_ra('root-sidebar', 'ticket', ' Ticket', '/ticket/sale', 'fa-ticket', $ci->resources::TYPE_SIDEBAR, array_merge($O, $M, $S)),

		_ra('root-sidebar', 'settings', ' System Settings', NULL, 'fa-wrench', $ci->resources::TYPE_SIDEBAR),
			//_ra('settings', 'users', 'Users', '/auth', 'fa-male'),
			_ra('settings', 'users-management', ' User Management', '/setting/user', 'fa-users'),
			
			_ra('settings', 'acl', ' Access Manager', '/setting/acl', 'fa-unlock-alt'),
			//_ra('settings', 'resource-editor', 'Menu Manager', '/setting/resources', 'fa-cube'),
			//_ra('settings', 'clients', 'Clients', '/setting/clients', 'fa-globe', $ci->resources::TYPE_SIDEBAR),
			//_ra('settings', 'projects', 'Projects', '/setting/projects', 'fa-briefcase', $ci->resources::TYPE_SIDEBAR),
			_ra('settings', 'cron-mgr', ' Cron Manager', '/cron', 'fa-microchip', $ci->resources::TYPE_SIDEBAR),
		
		//_ra('root-sidebar', 'data-master', 'Data Master', NULL, 'fa-database', $ci->resources::TYPE_SIDEBAR),
			//_ra('data-master', 'countries', ' Country', '/setting/country', 'fa-globe', $ci->resources::TYPE_SIDEBAR),
			//_ra('data-master', 'operators', ' Operator', '/setting/operator', 'fa-bus', $ci->resources::TYPE_SIDEBAR),
			//_ra('data-master', 'operator-categories', ' Operator Categories', '/setting/operator-category', 'fa-subway', $ci->resources::TYPE_SIDEBAR),
			//_ra('data-master', 'sales-offices', ' Sales Office', '/setting/office', 'fa-building-o', $ci->resources::TYPE_SIDEBAR),
			//_ra('data-master', 'sequences', ' Sequences', '/setting/sequence', 'fa-sort-numeric-asc', $ci->resources::TYPE_SIDEBAR),
			
		//_ra('root-sidebar', 'tools', 'Tools', NULL, 'fa-wrench', $ci->resources::TYPE_SIDEBAR),
			//_ra('tools', 'ticket-numbers', ' Ticket Numbers', '/tools/ticket-numbers', 'fa-file-pdf-o', $ci->resources::TYPE_SIDEBAR),
	
		//_ra('root-sidebar', 'visitor-report', 'Visitor Report', '/report/visitor-report', 'fa-plane', $ci->resources::TYPE_SIDEBAR, $S),
			//_ra('visitor-report', 'visitor-by-operator', 'By Operator', '/report/visitor-by-operator', 'fa-bar-chart', $ci->resources::TYPE_SIDEBAR, $S),
			//_ra('visitor-report', 'visitor-by-opr-category', 'By Operator Category', '/report/visitor-by-opr-category', 'fa-bar-chart', $ci->resources::TYPE_SIDEBAR, $S),
			//_ra('visitor-report', 'visitor-by-category', 'By Category', '/report/visitor-by-category', 'fa-bar-chart', $ci->resources::TYPE_SIDEBAR, $S),
			//_ra('visitor-report', 'visitor-by-gender', 'By Gender', '/report/visitor-by-gender', 'fa-bar-chart', $ci->resources::TYPE_SIDEBAR, $S),
			//_ra('visitor-report', 'visitor-by-location', 'By Location', '/report/visitor-by-location', 'fa-bar-chart', $ci->resources::TYPE_SIDEBAR, $S),
	
		//_ra('root-sidebar', 'sales-report', 'Sales Report', '/reports', 'fa-dollar', $ci->resources::TYPE_NAVBAR, $S),
			//_ra('sales-report', 'sales-summary', 'Summary', '/report/sales-summary', 'fa-bar-chart', $ci->resources::TYPE_NAVBAR, $S),
	
	//_ra(null, 'root-navbar', 'Navbar Menu', null, 'fa-bars', $ci->resources::TYPE_NAVBAR, $S),
	
	//_ra(null, 'web-services', 'Web Services', '', 'fa-gears', $ci->resources::TYPE_WEBSVC, array_merge($O, $M, $S)),
	
	//_ra(null, 'root-sidebar-common', 'Common Application Menu', null, 'fa fa-bars', $ci->resources::TYPE_SIDEBAR_COMMON),
		//_ra('root-sidebar-common', 'app-home', 'Home', '/apps/home', 'fa fa-home', $ci->resources::TYPE_SIDEBAR_COMMON),				
		//_ra('root-sidebar-common', 'app-buy-ticket', 'Buy Ticket', '/apps/products/ticket', 'fa fa-ticket', $ci->resources::TYPE_SIDEBAR_COMMON),
		//_ra('root-sidebar-common', 'app-news', 'News', '/apps/news', 'fa fa-newspaper-o', $ci->resources::TYPE_SIDEBAR_COMMON),
			//_ra('app-news', 'rubric-focus', 'Focus', '/apps/news/focus', 'fa fa-newspaper-o', $ci->resources::TYPE_SIDEBAR_COMMON),
			//_ra('app-news', 'rubric-profile', 'Profile', '/apps/news/profile', 'fa fa-newspaper-o', $ci->resources::TYPE_SIDEBAR_COMMON),
			
	//_ra('root-sidebar', 'contest', 'Contest', '/contest/dashboard', 'fa-trophy', $ci->resources::TYPE_SIDEBAR),
		//_ra('contest', 'contests-manager', 'Contest Manager', '/contest/dashboard/index', 'fa-trophy', $ci->resources::TYPE_SIDEBAR),
		//_ra('contest', 'contest-scoring', 'Scoring', '/contest/dashboard/scoring', 'fa-star', $ci->resources::TYPE_SIDEBAR),
		//_ra('contest', 'contest-score-summary', 'Score Summary', '/contest/dashboard/score-summary', 'fa-certificate', $ci->resources::TYPE_SIDEBAR),
);


$config['resources'] = $resources;