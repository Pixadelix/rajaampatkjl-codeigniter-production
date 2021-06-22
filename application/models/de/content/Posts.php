<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;
	
class Posts extends RA_Editor_Model {

	public $table = 'sys_posts';
	
	const TYPE_POST                                    = 'post';
	const TYPE_PAGE                                    = 'page';
	const TYPE_POST_ATTACHMENT                         = 'post-attachment';
	const TYPE_USER_PROFILE                            = 'user-profile';
		
    const DEFAULT_STATUS         = 'default';
	const PUBLISHED              = 'published';
	const PENDING_REVIEW         = 'pending-review';
	const DRAFT                  = 'draft';
    const ATTACHMENT             = 'attachment';

	// file upload info 
    protected $_attachment = array(
        'post_type'           => null,
        'post_mime_type'      => null,
        'media_filename'      => null,
        'media_filesize'      => null,
        'media_system_path'   => null,
        'media_web_path'      => null,
        'media_thumbnail_path'=> null,
        'media_file_extn'     => null,
        'media_content_type'  => null,
        'comment_status'      => null,
        'post_status'         => null,
        'post_title'          => null,
        'post_name'           => null,
        'post_author'         => null,
        'post_date'           => null,
        'post_content'        => null,
        'post_excerpt'        => null,
    );
	
	public function __construct() {
		
		parent::__construct();
        $this->ci =& get_instance();
        $this->create_table();
		$this->init_editor();
		
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;

		$this->db_datatables->sql(
			sprintf("CREATE TABLE IF NOT EXISTS `$this->table` (
			  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `post_content` longtext DEFAULT NULL,
			  `post_title` text DEFAULT NULL,
			  `post_excerpt` text DEFAULT NULL,
			  `post_status` varchar(100) NOT NULL DEFAULT '%s',
			  `post_name` varchar(200) DEFAULT NULL,
			  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			  `post_type` varchar(100) NOT NULL DEFAULT 'post',
			  `post_mime_type` varchar(100) DEFAULT NULL,
			  `post_password` varchar(20) DEFAULT NULL,
              `menu_order` int(11) NOT NULL DEFAULT 0,
              `front_page` int(11) NOT NULL DEFAULT 0,
			  `media_filename` varchar(255) DEFAULT NULL,
              `media_file_extn` varchar(10) DEFAULT NULL,
			  `media_filesize` int unsigned DEFAULT NULL,
              `media_content_type` varchar(100) DEFAULT NULL,
			  `media_system_path` varchar(255) DEFAULT NULL,
			  `media_web_path`  varchar(255) DEFAULT NULL,
              `media_thumbnail_path` varchar(255) DEFAULT NULL,
			  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
			  `comment_count` bigint(20) NOT NULL DEFAULT 0,
			  `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
			  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
			  `update_at` datetime DEFAULT NULL,
			  
			  PRIMARY KEY( `id` )
			)
			;", self::DEFAULT_STATUS)
		);
    }
	
	protected function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id"                        ),
				Field::inst( "$this->table.post_author"               )
					->set(Field::SET_BOTH)
					//->validator( 'Validate::required' )
					->options( Options::inst()
						->table( 'sys_users' )
						->value( 'sys_users.id' )
						->label( 'sys_users.first_name, sys_users.last_name' )
						->order( 'sys_users.first_name' )
						->where( function ( $q ) {
							//$q->where( 'id', 2, '>' );
							$q->where( 'first_name', null, 'is not');
							$q->where( 'first_name', '', '!=');
						})
						->render( function ( $row ) {
							return $row['sys_users.first_name'].' '.$row['sys_users.last_name'];
						})
					)
				,
				Field::inst( "$this->table.post_date"                 )->set(Field::SET_BOTH)
					->validator( 'Validate::dateFormat', Format::DATE_ISO_8601 )
					->getFormatter( function ( $val, $data, $opts ) {
						//return $val;
						
						if ( $val != '0000-00-00 00:00:00' ) {
							$dt = date( 'Y-m-d', strtotime( $val ) );
							return $dt;
						} else
							return null;
						//return date( 'Y-m-d', strtotime( $val ) );
					} )
				,
				Field::inst( "$this->table.post_content"              ),
				Field::inst( "$this->table.post_title"                )
					->validator( 'Validate::required' )
				,
				Field::inst( "$this->table.post_excerpt"              ),
				Field::inst( "$this->table.post_status"               )
                    ->set(Field::SET_BOTH)
					->options(function() {
						return array(
							array('value' => self::PUBLISHED,       'label' => ucwords(self::PUBLISHED)),
							array('value' => self::PENDING_REVIEW, 'label' => ucwords(str_replace('-', ' ', self::PENDING_REVIEW))),
							array('value' => self::DRAFT,          'label' => ucwords(self::DRAFT)),
						);
					})
				,
				Field::inst( "$this->table.post_name"                 )->set(Field::SET_BOTH),
				Field::inst( "$this->table.post_parent"               ),
				Field::inst( "$this->table.post_type"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.post_mime_type"            ),
				Field::inst( "$this->table.post_password"             ),
				Field::inst( "$this->table.menu_order"                ),
				Field::inst( "$this->table.front_page"                ),
				Field::inst( "$this->table.media_filename"            ),
				Field::inst( "$this->table.media_filesize"            ),
				Field::inst( "$this->table.media_system_path"         ),
				Field::inst( "$this->table.media_web_path"            ),
				Field::inst( "$this->table.media_thumbnail_path"      ),
				Field::inst( "$this->table.comment_status"            ),
				Field::inst( "$this->table.comment_count"             ),
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT),
				Field::inst( 'sys_users.first_name' ),
				Field::inst( 'sys_users.last_name' )
				
			)
			->leftJoin( 'sys_users', 'sys_users.id', '=', 'sys_posts.post_author' )

			->on( 'preCreate', function ( $editor, $values ) {
                $this->default_create_log();
				
				$post_title = isset($values[$this->table]['post_title']) ? $values[$this->table]['post_title'] : null;
				if ( $post_title ) {
					$post_title = strtolower(str_replace(array('  ', ' '), '-', preg_replace('/[^a-zA-Z0-9 s]/', '', trim($post_title))));
    				
					$editor->field("$this->table.post_name")->setValue( strtolower(trim($post_title) ));
				}
				
				$this->editor
					->field("$this->table.post_author")
					->setValue( $this->ci->user_id );
			} )
            ->on( 'preEdit', function ( $editor, $id, $values ) {
				//var_dump($values);
				$post_title = isset($values[$this->table]['post_title']) ? $values[$this->table]['post_title'] : null;
				if ( $post_title ) {
					$post_title = strtolower(str_replace(array('  ', ' '), '-', preg_replace('/[^a-zA-Z0-9 s]/', '', trim($post_title))));
    				
					$editor->field("$this->table.post_name")->setValue( strtolower(trim($post_title) ));
				}

                $this->default_edit_log();
            } )
		;
	}
	
	
}