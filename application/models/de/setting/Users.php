<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'models/de/content/Posts.php';

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

class Users extends RA_Editor_Model {
	
	public $table = 'sys_users';
	
    // file upload info
	protected $_photo = array(
        'post_type'           => null,
        'post_mime_type'      => null,
        'media_filename'      => null,
        'media_filesize'      => null,
        'media_system_path'   => null,
        'media_web_path'      => null,
        'media_thumbnail_path'=> null,
        'media_file_extn'     => null,
        'media_content_type'  => null,
        'comment_status'      => null
    );
	protected $profile_photo_cfg = null;
	
	public function __construct() {
		error_reporting(0);
		parent::__construct();
		$this->create_table();
        
        $this->ci =& get_instance();
        $this->profile_photo_cfg = $this->ci->config->item('profile_photo');
        $this->_process_upload();
        $this->init_editor();
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`ip_address` varchar(15) NOT NULL DEFAULT '',
				`username` varchar(100) DEFAULT NULL,
				`password` varchar(255) NOT NULL,
				`salt` varchar(255) DEFAULT NULL,
				`email` varchar(100) NOT NULL,
				`activation_code` varchar(40) DEFAULT NULL,
				`forgotten_password_code` varchar(40) DEFAULT NULL,
				`forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
				`remember_code` varchar(40) DEFAULT NULL,
				`created_on` int(11) UNSIGNED NOT NULL,
				`last_login` int(11) UNSIGNED DEFAULT NULL,
				`active` tinyint(1) UNSIGNED DEFAULT NULL,
				`first_name` varchar(50) DEFAULT NULL,
				`last_name` varchar(50) DEFAULT NULL,
				`company` varchar(100) DEFAULT NULL,
				`phone` varchar(20) DEFAULT NULL,
                `telegram_username` varchar(50) DEFAULT NULL,
                `profile_photo` int(11) UNSIGNED NULL DEFAULT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `email` (`email`),
				UNIQUE KEY `username` (`username`)
			)" 
		);
        
	}
	
	
	
	public function baseline_values() {
		
		if ( $this->production() ) return;
        //return;
		
		//printf("Generating baseline: %30s", $this->table);

		$ci =& get_instance();
		
		$id_group_admin     = 1;
		$id_group_operator  = 2;

		$ci->ion_auth->register('admin', 'demo', 'admin@localhost', array('first_name' => 'Administrator'), array($id_group_admin));
        $ci->ion_auth->register('antasuanta', 'RajaAmpat', 'antasuanta@outlook.com', array('first_name' => 'Anta Suanta'), array($id_group_admin));
        $ci->ion_auth->register('user', 'demo', 'user@mentawai-island.com', array('first_name' => 'User Ajah'), array($id_group_operator));
        $ci->ion_auth->register('adrian', 'demo', 'adriankaiba@gmail.com', array('first_name' => 'Adrian Kaiba'), array($id_group_operator));
        
		
		//printf("%30s".PHP_EOL, 'done');
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
                Field::inst( "$this->table.username" ),
				Field::inst( "$this->table.first_name" ),
				Field::inst( "$this->table.last_name" ),
				Field::inst( "$this->table.password" )
                    //->Validator( 'Validate::notEmpty' )
                    ->set(Field::SET_BOTH)
                    ->getFormatter( function() { return ''; } ),
                Field::inst( "$this->table.salt" ),
				Field::inst( "$this->table.email" ),
				Field::inst( "$this->table.active" ),
				Field::inst( "$this->table.company" ),
				Field::inst( "$this->table.phone" ),
				Field::inst( "$this->table.telegram_username" ),
				Field::inst( "$this->table.last_login" ),
                Field::inst( "$this->table.ip_address" ),
                Field::inst( "$this->table.created_on" )
                    ->set(Field::SET_CREATE),
				Field::inst( "$this->table.profile_photo" )
                    ->setFormatter( 'Format::ifEmpty', null )
                    ->upload(
                        Upload::inst( function( $file, $id ) {
                            return $id;
                        } )
                        ->db ( 'sys_posts', 'id', $this->_photo )
						->where( function($q) {

							$q->where('post_type', Posts::TYPE_USER_PROFILE, '=');
				
							if ( ! $_POST['action'] == 'upload' ) {
								$q->where(' exists ', " ( select u.profile_photo from sys_users u where u.profile_photo = sys_posts.id ) ", '', false);
							}
							
						} )
                        ->validator( function ( $file ) {
							return $this->validator_max_size($file, $this->profile_photo_cfg['max_size']);
                        })
                        ->allowedExtensions( explode('|', $this->profile_photo_cfg['allowed_types']), "Please upload an image" )
                    )
			)
			->join(
				Mjoin::inst( 'sys_groups' )
					->link( 'sys_users.id', 'sys_users_groups.user_id' )
					->link( 'sys_groups.id', 'sys_users_groups.group_id' )
					->order( 'name asc' )
					->fields(
						Field::inst( 'id' )
							->validator( 'Validate::required' )
							->options( Options::inst()
								->table( 'sys_groups' )
								->value( 'id' )
								->label( 'description' )
							),
						Field::inst( 'name' ),
						Field::inst( 'description' )
					)
			)
			
			->leftJoin( 'sys_posts', 'sys_posts.id', '=', 'sys_users.profile_photo' )
			
            ->on( 'preCreate', function ( $editor, $values ) {
                $editor
                    ->field( "$this->table.ip_address" )
                    ->setValue( '' );
                
                $ci =& get_instance();
                
                $salt = $editor->field( "$this->table.salt" )->getValue();
                
				if ( isset($values['sys_users']['password']) ) {
                	$new_password = $ci->hash_password( $values['sys_users']['password'], $salt );

                	$editor
	                    ->field( 'sys_users.password' )
	                    ->setValue( $new_password );
				}
                
                $editor
                    ->field( "$this->table.created_on" )
                    ->setValue( $ci->db_timestamp_now() );
                
            })
            
            ->on( 'preEdit', function ( $editor, $id, $values ) {

				if ( isset($values['sys_users']['password']) ) {
                	// check whether new password is set ?
                	if ( '' === $values['sys_users']['password'] ) {
	                    $editor->field('sys_users.password')->set(false);
	                } else {
	                    $ci =& get_instance();
	                    $new_password = $ci->hash_password( $values['sys_users']['password'] );
	                    $editor
	                        ->field( 'sys_users.password' )
	                        ->setValue( $new_password );
	                }
				}
                
                // skip edit for blank profile_photo
                if ( isset($values['sys_users']['profile_photo']) ) {
                    if ( !$values['sys_users']['profile_photo'] ) {
                        $editor->field('sys_users.profile_photo')->set(false);
                    }
                }
            })
		;
	}
    
    private function _process_upload () {
        //var_dump($_FILES); die;
        if ( ! $_FILES ) {
            return;
        }

        $this->ci->load->library('upload');
		$this->ci->upload->initialize($this->profile_photo_cfg);
				
		$upload_path = $this->profile_photo_cfg['upload_path'];

		if ( !file_exists( $upload_path ) ) {
			//error_reporting(E_ALL);
			if ( !mkdir ( $upload_path, 0755, true ) ) {
				show_error('Failed to create folders: '.$upload_path);
			}
		}
		
		if ( $this->ci->upload->do_upload('upload') ) {
			$upload_data    = $this->ci->upload->data();
			$system_path    = $upload_data['full_path'];
			$web_path       = $upload_path.$upload_data['file_name'];
			$thumbnail_path = $upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
            
            $this->ci->resize_image($system_path);
				
			$this->_photo = [
				'post_type'            => Posts::TYPE_USER_PROFILE, //'user-profile',
				'post_mime_type'       => $upload_data['file_type'],
				'media_filename'       => $upload_data['file_name'],
				'media_filesize'       => $upload_data['file_size'],
				'media_system_path'    => $upload_data['full_path'],
				'media_web_path'       => $upload_path.$upload_data['file_name'],
				'media_thumbnail_path' => $upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'],
				'media_file_extn'      => $upload_data['file_ext'],
				'media_content_type'   => $upload_data['image_type'],
				'comment_status'       => 'closed',
			];
		} else {
			var_dump($this->ci->upload->data());
			echo $this->ci->upload->display_errors(); die;
		}
    }
	
	public function get($id = null, $id2 = null) {
        if ( $id ) {
            $this->editor
                ->where('sys_users.id', $id, '=');
        }
        //var_dump($id);
		parent::get();
		
	}
	
}