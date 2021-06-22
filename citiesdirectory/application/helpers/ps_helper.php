<?php 
/**
 * transform 'added date' display
 *
 * @param      integer  $time   The time
 *
 * @return     string   ( description_of_the_return_value )
 */
if ( ! function_exists( 'ago' ))
{
	function ago( $time )
	{
		if ( empty( $time )) return "Today";

		// get ci instance
		$CI =& get_instance();
		
		$time = mysql_to_unix( $time );
		$now = $CI->db->query('SELECT NOW( ) as now')->row()->now;
		$now = mysql_to_unix( $now );

		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");

		$difference = $now - $time;
		$tense = "ago";

		for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if ($difference != 1) {
			$periods[$j].= "s";
		}

		if ($difference==0) {
			return "Just Now";
		} else {
			return "$difference $periods[$j] ago";
		}
	}
}