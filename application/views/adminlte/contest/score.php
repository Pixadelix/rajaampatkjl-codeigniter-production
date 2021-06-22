<?php
if ( !isset($contestant) ) return;
//var_dump($scores);
?>

<style>
h5 {
	font-family: 'Open sans';
}
</style>

<div class="small-box bg-purple">
	<div class="inner">
	<?php
	$i = 1;
	foreach ( $contestant as $k => $v ) {
		//if ( !$v ) continue;
		if ( in_array($k, array('id', 'event_id', 'timestamp', 'status', 'hash') ) ) continue;
		$q = sprintf("q%02d", $i);
		if ( !$question[$q.'_scoring'] && $question[$q]) {
		?>
			<small><?php echo $question[$q]; ?>:</small><p><?php echo $v; ?></p>
		<?php
		}
		$i++;
	}
	?>
	</div>
	<div class="icon">
		<i class="fa fa-building"></i>
	</div>
	<span href="#" class="small-box-footer"><i class="fa fa-trophy"></i></span>
</div>

<form id="form-score" method="post" action="/contest/dashboard/get_score/<?php echo $contestant->id; ?>">	
<?php
$i = 1;
//var_dump($contestant); die;
$score_mid = ($question['score_max'] - $question['score_min']) / 2;
//var_dump($score_mid); die;
foreach ( $contestant as $k => $v ) {
	//if ( !$v ) continue;
	if ( in_array($k, array('id', 'event_id', 'timestamp', 'status', 'hash') ) ) continue;
	
	$q = sprintf("q%02d", $i);
	$s = sprintf("s%02d", $i);
?>
	
	
	<?php
	if ( $question[$q.'_scoring'] ) {
	?>
		<div class="box-comment">
			<span class="fa-stack fa-lg img-sm">
				<!--i class="fa fa-circle-o fa-stack-2x" style="color: darkred;"></i-->
				<i class="fa fa-star-o fa-stack-1x fa-inverse" style="color: grey;"></i>
			</span>
			<div class="comment-text">
				<span class="username">
					<h5 style="color: #a0a0a0;"><strong>Q:</strong> <?php echo $question[$q]; ?></h5>
					<?php if ( $i == 1 ) { ?><span class="text-muted pull-right"><?php echo $contestant->timestamp; ?></span><?php } ?>
				</span>
				<h5><strong>A:</strong>
				<?php
				if (filter_var($v, FILTER_VALIDATE_URL) === FALSE) {
					echo $v;
				} else {
					$atts = array(
						'width'       => 800,
						'height'      => 600,
						'scrollbars'  => 'yes',
						'status'      => 'yes',
						'resizable'   => 'yes',
						'screenx'     => 0,
						'screeny'     => 0,
						'window_name' => '_blank'
					);
					echo 'Uploaded file. Click '.anchor_popup($v, 'here', $atts).' to view.';
				}
				?>
				</h5>
			</div>
			
			<div class="comment-text">
				<center><br/>
					<input name="<?php echo $s; ?>" class="slider" type="text"
						style="width:50%;"
						data-slider-value="<?php echo isset($scores[$s]) ? $scores[$s] : 0; ?>"
						data-slider-min="<?php echo $question['score_min']; ?>"
						data-slider-max="<?php echo $question['score_max']; ?>"
						data-slider-step="<?php echo $question['score_step']; ?>"
						data-slider-tooltip="always"
						data-slider-tooptip-position="bottom"
						data-slider-handle="custom"
						data-slider-rangeHighlights='[{ "start": <?php echo $question['score_min']; ?>, "end": <?php echo $score_mid; ?>, "class": "category1" },
													  { "start": <?php echo $score_mid; ?>, "end": <?php echo $question['score_max']; ?>, "class": "category2" }]'
					>
				</center>
				<br/>
				<br/>
				<br/>
			</div>
		</div>
	<?php
	}
	?>
	

<?php
	$i++;
}
?>

	
	<input type="hidden" name="answer_id" value="<?php echo $contestant->id; ?>" >
</form>