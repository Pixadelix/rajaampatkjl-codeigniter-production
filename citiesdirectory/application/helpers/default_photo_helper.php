<?php 
/**
 * default photos base path
 */
// base path
define( 'DEFAULT_PHOTO_PATH', '/images/default_photos/' );
// default city photo
define( 'DEFAULT_CITY_PHOTO', 'city.png' );
// default about photo
define( 'DEFAULT_ABOUT_PHOTO', 'about.png' );
// default cover photo
define( 'DEFAULT_COVER_PHOTO', 'cover.png' );
// default item photo
define( 'DEFAULT_ITEM_PHOTO', 'item.png' );
// default profile photo
define( 'DEFAULT_PROFILE_PHOTO', 'profile.png' );
// default feed photo
define( 'DEFAULT_FEED_PHOTO', 'feed.png' );

/**
 * Validate photo and return default photo if image not exists
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists( 'validate_photos')) {
	function validate_photos( &$photo, $type = 'city' )
	{
		if ( empty( $photo )) {
		// if photo is empty, 
		
			// get the default photo
			$obj = new stdClass;
			$obj->path = get_default_photo( $type );
		 	$photo[] = $obj;
		} else {
		// if photo array is not empty
		
			// modify the path for each photo
			foreach ( $photo as &$p ) {
				$tmp = $p->path;
				$p->path = base_url( '/uploads/'. $tmp );
				$p->thumbnail = base_url( '/uploads/thumbnail/'. $tmp );
			}
		}
	}
}

/**
 * Validate photo and return default photo if image not exists
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists( 'validate_photo')) {
	function validate_photo( $photo, $type = 'city' )
	{
		if ( empty( $photo )) {
		// if photo is empty, 
		
			// return default photo				
			return get_default_photo( $type );
		}
		
		// just return the full path of that image
		if ( is_object( $photo )) {
			return base_url( '/uploads/'. $photo->path );
		}

		return base_url( '/uploads/'. $photo );
	}
}

/**
 * Gets the defaulty photo by type
 *
 * @param      <type>  $type   The type
 */
function get_default_photo( $type )
{
	switch ( $type ) {
		// return city default photo
		case 'city':
			$photo = city_default_photo();
			break;

		// return about default photo
		case 'about':
			$photo = about_default_photo();
			break;

		// return cover default photo
		case 'cover':
			$photo = cover_default_photo();
			break;

		// return item default photo
		case 'item':
			$photo = item_default_photo();
			break;

		// return profile default photo
		case 'profile':
			$photo = profile_default_photo();
			break;

		// return feed default photo
		case 'feed':
			$photo = feed_default_photo();
			break;
	}

	return $photo;
}

/**
 * Gets city default city photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('city_default_photo'))
{
    function city_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_CITY_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_CITY_PHOTO;
    }   
}

/**
 * Gets city default aboutus photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('about_default_photo'))
{
    function about_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_ABOUT_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_ABOUT_PHOTO;
    }   
}

/**
 * Gets city default cover photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('cover_default_photo'))
{
    function cover_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_COVER_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_COVER_PHOTO;
    }   
}

/**
 * Gets city default item photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('item_default_photo'))
{
    function item_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_ITEM_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_ITEM_PHOTO;
    }   
}

/**
 * Gets city default profile photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('profile_default_photo'))
{
    function profile_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_PROFILE_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_PROFILE_PHOTO;
    }   
}

/**
 * Gets city default feed photo
 *
 * @param      string  $var    The variable
 *
 * @return     <type>  ( description_of_the_return_value )
 */
if ( ! function_exists('feed_default_photo'))
{
    function feed_default_photo( $is_full_path = true )
    {
    	if ( $is_full_path )
    		return base_url( DEFAULT_PHOTO_PATH . DEFAULT_FEED_PHOTO );

        return DEFAULT_PHOTO_PATH . DEFAULT_FEED_PHOTO;
    }   
}