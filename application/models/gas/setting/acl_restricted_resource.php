<?php

namespace Model\Setting;

use \Gas\Core;
use \Gas\ORM;

class Acl_restricted_resource extends ORM {
	
	public $table = 'sys_acl_restricted_resource';
	
	public $primary_key = array('resource_id', 'group_id');
    
    public $foreign_key = array(
        '\\model\\setting\\acl_resource' => 'resource_id',
        '\\model\\setting\\groups' => 'group_id',
    );
	
	function _init() {
        
        self::$relationships = array(
            'resource' => ORM::belongs_to('\\Model\\Setting\\Acl_resource'),
            'group'    => ORM::belongs_to('\\Model\\Setting\\Groups'),
        );
		
		self::$fields = array(
			'resource_id' => ORM::field('int'),
			'group_id' => ORM::field('mediumint')
		);
	}
    
    static function restrict_resource($code, $enabled_groups) {

        $resource = Acl_resource::find_by_code($code);
        
        // restrice new menu to all groups except for admin
		$all_groups = Groups::where_not_in('id', 1)->get();
        //var_dump($all_groups); die;
        $all_groups = is_array($all_groups) ? $all_groups : array($all_groups);
				
		for($i=0; $i<count($all_groups); $i++){
            
            if ( $enabled_groups && false !== array_search($all_groups[$i]->name, $enabled_groups) ) {
            //if ( $enabled_groups ) {
                echo "\033[32mEnabling:\033[0m ".$resource[0]->code.' to '.$all_groups[$i]->name.PHP_EOL;
                continue;
            }
            
            $data = array(
				'resource_id' => $resource[0]->id,
				'group_id' => $all_groups[$i]->id,
			);
            echo "\033[31mRestricting:\033[0m ".$resource[0]->code.' to '.$all_groups[$i]->name.PHP_EOL;
			$acl_restricted_resource = self::make($data)->save();
			//var_dump($acl_restricted_resource);
			
		}
    }

}