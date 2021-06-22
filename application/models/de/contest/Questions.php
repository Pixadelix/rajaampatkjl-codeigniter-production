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
	
class Questions extends RA_Editor_Model {
	
	public $table = 'cts_questions';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`event_id` int(11) UNSIGNED NOT NULL,
				`score_min` int(5) DEFAULT 0,
				`score_max` int(5) DEFAULT 100,
				`score_step` int(5) UNSIGNED DEFAULT 5,
				
				`q01` text DEFAULT NULL,
				`q02` text DEFAULT NULL,
				`q03` text DEFAULT NULL,
				`q04` text DEFAULT NULL,
				`q05` text DEFAULT NULL,
				`q06` text DEFAULT NULL,
				`q07` text DEFAULT NULL,
				`q08` text DEFAULT NULL,
				`q09` text DEFAULT NULL,
				`q10` text DEFAULT NULL,
				`q11` text DEFAULT NULL,
				`q12` text DEFAULT NULL,
				`q13` text DEFAULT NULL,
				`q14` text DEFAULT NULL,
				`q15` text DEFAULT NULL,
				`q16` text DEFAULT NULL,
				`q17` text DEFAULT NULL,
				`q18` text DEFAULT NULL,
				`q19` text DEFAULT NULL,
				`q20` text DEFAULT NULL,
				`q21` text DEFAULT NULL,
				`q22` text DEFAULT NULL,
				`q23` text DEFAULT NULL,
				`q24` text DEFAULT NULL,
				`q25` text DEFAULT NULL,
				`q26` text DEFAULT NULL,
				`q27` text DEFAULT NULL,
				`q28` text DEFAULT NULL,
				`q29` text DEFAULT NULL,
				`q30` text DEFAULT NULL,
				`q31` text DEFAULT NULL,
				`q32` text DEFAULT NULL,
				`q33` text DEFAULT NULL,
				`q34` text DEFAULT NULL,
				`q35` text DEFAULT NULL,
				`q36` text DEFAULT NULL,
				`q37` text DEFAULT NULL,
				`q38` text DEFAULT NULL,
				`q39` text DEFAULT NULL,
				`q40` text DEFAULT NULL,
				`q41` text DEFAULT NULL,
				`q42` text DEFAULT NULL,
				`q43` text DEFAULT NULL,
				`q44` text DEFAULT NULL,
				`q45` text DEFAULT NULL,
				`q46` text DEFAULT NULL,
				`q47` text DEFAULT NULL,
				`q48` text DEFAULT NULL,
				`q49` text DEFAULT NULL,
				`q50` text DEFAULT NULL,
				`q51` text DEFAULT NULL,
				`q52` text DEFAULT NULL,
				`q53` text DEFAULT NULL,
				`q54` text DEFAULT NULL,
				`q55` text DEFAULT NULL,
				`q56` text DEFAULT NULL,
				`q57` text DEFAULT NULL,
				`q58` text DEFAULT NULL,
				`q59` text DEFAULT NULL,
				`q60` text DEFAULT NULL,
				`q61` text DEFAULT NULL,
				`q62` text DEFAULT NULL,
				`q63` text DEFAULT NULL,
				`q64` text DEFAULT NULL,
				`q65` text DEFAULT NULL,
				`q66` text DEFAULT NULL,
				`q67` text DEFAULT NULL,
				`q68` text DEFAULT NULL,
				`q69` text DEFAULT NULL,
				`q70` text DEFAULT NULL,
				`q71` text DEFAULT NULL,
				`q72` text DEFAULT NULL,
				`q73` text DEFAULT NULL,
				`q74` text DEFAULT NULL,
				`q75` text DEFAULT NULL,
				`q76` text DEFAULT NULL,
				`q77` text DEFAULT NULL,
				`q78` text DEFAULT NULL,
				`q79` text DEFAULT NULL,
				`q80` text DEFAULT NULL,
				`q81` text DEFAULT NULL,
				`q82` text DEFAULT NULL,
				`q83` text DEFAULT NULL,
				`q84` text DEFAULT NULL,
				`q85` text DEFAULT NULL,
				`q86` text DEFAULT NULL,
				`q87` text DEFAULT NULL,
				`q88` text DEFAULT NULL,
				`q89` text DEFAULT NULL,
				`q90` text DEFAULT NULL,
				`q91` text DEFAULT NULL,
				`q92` text DEFAULT NULL,
				`q93` text DEFAULT NULL,
				`q94` text DEFAULT NULL,
				`q95` text DEFAULT NULL,
				`q96` text DEFAULT NULL,
				`q97` text DEFAULT NULL,
				`q98` text DEFAULT NULL,
				`q99` text DEFAULT NULL,
				`q100` text DEFAULT NULL,
				`q101` text DEFAULT NULL,
				`q102` text DEFAULT NULL,
				`q103` text DEFAULT NULL,
				`q104` text DEFAULT NULL,
				`q105` text DEFAULT NULL,
				`q106` text DEFAULT NULL,
				`q107` text DEFAULT NULL,
				`q108` text DEFAULT NULL,
				`q109` text DEFAULT NULL,
				`q110` text DEFAULT NULL,
				`q111` text DEFAULT NULL,
				`q112` text DEFAULT NULL,
				`q113` text DEFAULT NULL,
				`q114` text DEFAULT NULL,
				`q115` text DEFAULT NULL,
				`q116` text DEFAULT NULL,
				`q117` text DEFAULT NULL,
				`q118` text DEFAULT NULL,
				`q119` text DEFAULT NULL,
				`q120` text DEFAULT NULL,
				
				`q01_scoring` tinyint(1) DEFAULT 0,
				`q02_scoring` tinyint(1) DEFAULT 0,
				`q03_scoring` tinyint(1) DEFAULT 0,
				`q04_scoring` tinyint(1) DEFAULT 0,
				`q05_scoring` tinyint(1) DEFAULT 0,
				`q06_scoring` tinyint(1) DEFAULT 0,
				`q07_scoring` tinyint(1) DEFAULT 0,
				`q08_scoring` tinyint(1) DEFAULT 0,
				`q09_scoring` tinyint(1) DEFAULT 0,
				`q10_scoring` tinyint(1) DEFAULT 0,
				`q11_scoring` tinyint(1) DEFAULT 0,
				`q12_scoring` tinyint(1) DEFAULT 0,
				`q13_scoring` tinyint(1) DEFAULT 0,
				`q14_scoring` tinyint(1) DEFAULT 0,
				`q15_scoring` tinyint(1) DEFAULT 0,
				`q16_scoring` tinyint(1) DEFAULT 0,
				`q17_scoring` tinyint(1) DEFAULT 0,
				`q18_scoring` tinyint(1) DEFAULT 0,
				`q19_scoring` tinyint(1) DEFAULT 0,
				`q20_scoring` tinyint(1) DEFAULT 0,
				`q21_scoring` tinyint(1) DEFAULT 0,
				`q22_scoring` tinyint(1) DEFAULT 0,
				`q23_scoring` tinyint(1) DEFAULT 0,
				`q24_scoring` tinyint(1) DEFAULT 0,
				`q25_scoring` tinyint(1) DEFAULT 0,
				`q26_scoring` tinyint(1) DEFAULT 0,
				`q27_scoring` tinyint(1) DEFAULT 0,
				`q28_scoring` tinyint(1) DEFAULT 0,
				`q29_scoring` tinyint(1) DEFAULT 0,
				`q30_scoring` tinyint(1) DEFAULT 0,
				`q31_scoring` tinyint(1) DEFAULT 0,
				`q32_scoring` tinyint(1) DEFAULT 0,
				`q33_scoring` tinyint(1) DEFAULT 0,
				`q34_scoring` tinyint(1) DEFAULT 0,
				`q35_scoring` tinyint(1) DEFAULT 0,
				`q36_scoring` tinyint(1) DEFAULT 0,
				`q37_scoring` tinyint(1) DEFAULT 0,
				`q38_scoring` tinyint(1) DEFAULT 0,
				`q39_scoring` tinyint(1) DEFAULT 0,
				`q40_scoring` tinyint(1) DEFAULT 0,
				`q41_scoring` tinyint(1) DEFAULT 0,
				`q42_scoring` tinyint(1) DEFAULT 0,
				`q43_scoring` tinyint(1) DEFAULT 0,
				`q44_scoring` tinyint(1) DEFAULT 0,
				`q45_scoring` tinyint(1) DEFAULT 0,
				`q46_scoring` tinyint(1) DEFAULT 0,
				`q47_scoring` tinyint(1) DEFAULT 0,
				`q48_scoring` tinyint(1) DEFAULT 0,
				`q49_scoring` tinyint(1) DEFAULT 0,
				`q50_scoring` tinyint(1) DEFAULT 0,
				`q51_scoring` tinyint(1) DEFAULT 0,
				`q52_scoring` tinyint(1) DEFAULT 0,
				`q53_scoring` tinyint(1) DEFAULT 0,
				`q54_scoring` tinyint(1) DEFAULT 0,
				`q55_scoring` tinyint(1) DEFAULT 0,
				`q56_scoring` tinyint(1) DEFAULT 0,
				`q57_scoring` tinyint(1) DEFAULT 0,
				`q58_scoring` tinyint(1) DEFAULT 0,
				`q59_scoring` tinyint(1) DEFAULT 0,
				`q60_scoring` tinyint(1) DEFAULT 0,
				`q61_scoring` tinyint(1) DEFAULT 0,
				`q62_scoring` tinyint(1) DEFAULT 0,
				`q63_scoring` tinyint(1) DEFAULT 0,
				`q64_scoring` tinyint(1) DEFAULT 0,
				`q65_scoring` tinyint(1) DEFAULT 0,
				`q66_scoring` tinyint(1) DEFAULT 0,
				`q67_scoring` tinyint(1) DEFAULT 0,
				`q68_scoring` tinyint(1) DEFAULT 0,
				`q69_scoring` tinyint(1) DEFAULT 0,
				`q70_scoring` tinyint(1) DEFAULT 0,
				`q71_scoring` tinyint(1) DEFAULT 0,
				`q72_scoring` tinyint(1) DEFAULT 0,
				`q73_scoring` tinyint(1) DEFAULT 0,
				`q74_scoring` tinyint(1) DEFAULT 0,
				`q75_scoring` tinyint(1) DEFAULT 0,
				`q76_scoring` tinyint(1) DEFAULT 0,
				`q77_scoring` tinyint(1) DEFAULT 0,
				`q78_scoring` tinyint(1) DEFAULT 0,
				`q79_scoring` tinyint(1) DEFAULT 0,
				`q80_scoring` tinyint(1) DEFAULT 0,
				`q81_scoring` tinyint(1) DEFAULT 0,
				`q82_scoring` tinyint(1) DEFAULT 0,
				`q83_scoring` tinyint(1) DEFAULT 0,
				`q84_scoring` tinyint(1) DEFAULT 0,
				`q85_scoring` tinyint(1) DEFAULT 0,
				`q86_scoring` tinyint(1) DEFAULT 0,
				`q87_scoring` tinyint(1) DEFAULT 0,
				`q88_scoring` tinyint(1) DEFAULT 0,
				`q89_scoring` tinyint(1) DEFAULT 0,
				`q90_scoring` tinyint(1) DEFAULT 0,
				`q91_scoring` tinyint(1) DEFAULT 0,
				`q92_scoring` tinyint(1) DEFAULT 0,
				`q93_scoring` tinyint(1) DEFAULT 0,
				`q94_scoring` tinyint(1) DEFAULT 0,
				`q95_scoring` tinyint(1) DEFAULT 0,
				`q96_scoring` tinyint(1) DEFAULT 0,
				`q97_scoring` tinyint(1) DEFAULT 0,
				`q98_scoring` tinyint(1) DEFAULT 0,
				`q99_scoring` tinyint(1) DEFAULT 0,
				`q100_scoring` tinyint(1) DEFAULT 0,
				`q101_scoring` tinyint(1) DEFAULT 0,
				`q102_scoring` tinyint(1) DEFAULT 0,
				`q103_scoring` tinyint(1) DEFAULT 0,
				`q104_scoring` tinyint(1) DEFAULT 0,
				`q105_scoring` tinyint(1) DEFAULT 0,
				`q106_scoring` tinyint(1) DEFAULT 0,
				`q107_scoring` tinyint(1) DEFAULT 0,
				`q108_scoring` tinyint(1) DEFAULT 0,
				`q109_scoring` tinyint(1) DEFAULT 0,
				`q110_scoring` tinyint(1) DEFAULT 0,
				`q111_scoring` tinyint(1) DEFAULT 0,
				`q112_scoring` tinyint(1) DEFAULT 0,
				`q113_scoring` tinyint(1) DEFAULT 0,
				`q114_scoring` tinyint(1) DEFAULT 0,
				`q115_scoring` tinyint(1) DEFAULT 0,
				`q116_scoring` tinyint(1) DEFAULT 0,
				`q117_scoring` tinyint(1) DEFAULT 0,
				`q118_scoring` tinyint(1) DEFAULT 0,
				`q119_scoring` tinyint(1) DEFAULT 0,
				`q120_scoring` tinyint(1) DEFAULT 0,
				
				UNIQUE (`event_id`),

				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	private function init_editor_minimal() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.event_id" )
			)
		;
	}
	
	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.event_id" ),
				Field::inst( "$this->table.score_min" ),
				Field::inst( "$this->table.score_max" ),
				Field::inst( "$this->table.score_step" ),
				
				Field::inst( "$this->table.q01" ),
				Field::inst( "$this->table.q02" ),
				Field::inst( "$this->table.q03" ),
				Field::inst( "$this->table.q04" ),
				Field::inst( "$this->table.q05" ),
				Field::inst( "$this->table.q06" ),
				Field::inst( "$this->table.q07" ),
				Field::inst( "$this->table.q08" ),
				Field::inst( "$this->table.q09" ),
				Field::inst( "$this->table.q10" ),
				Field::inst( "$this->table.q11" ),
				Field::inst( "$this->table.q12" ),
				Field::inst( "$this->table.q13" ),
				Field::inst( "$this->table.q14" ),
				Field::inst( "$this->table.q15" ),
				Field::inst( "$this->table.q16" ),
				Field::inst( "$this->table.q17" ),
				Field::inst( "$this->table.q18" ),
				Field::inst( "$this->table.q19" ),
				Field::inst( "$this->table.q20" ),
				Field::inst( "$this->table.q21" ),
				Field::inst( "$this->table.q22" ),
				Field::inst( "$this->table.q23" ),
				Field::inst( "$this->table.q24" ),
				Field::inst( "$this->table.q25" ),
				Field::inst( "$this->table.q26" ),
				Field::inst( "$this->table.q27" ),
				Field::inst( "$this->table.q28" ),
				Field::inst( "$this->table.q29" ),
				Field::inst( "$this->table.q30" ),
				Field::inst( "$this->table.q31" ),
				Field::inst( "$this->table.q32" ),
				Field::inst( "$this->table.q33" ),
				Field::inst( "$this->table.q34" ),
				Field::inst( "$this->table.q35" ),
				Field::inst( "$this->table.q36" ),
				Field::inst( "$this->table.q37" ),
				Field::inst( "$this->table.q38" ),
				Field::inst( "$this->table.q39" ),
				Field::inst( "$this->table.q40" ),
				Field::inst( "$this->table.q41" ),
				Field::inst( "$this->table.q42" ),
				Field::inst( "$this->table.q43" ),
				Field::inst( "$this->table.q44" ),
				Field::inst( "$this->table.q45" ),
				Field::inst( "$this->table.q46" ),
				Field::inst( "$this->table.q47" ),
				Field::inst( "$this->table.q48" ),
				Field::inst( "$this->table.q49" ),
				Field::inst( "$this->table.q50" ),
				Field::inst( "$this->table.q51" ),
				Field::inst( "$this->table.q52" ),
				Field::inst( "$this->table.q53" ),
				Field::inst( "$this->table.q54" ),
				Field::inst( "$this->table.q55" ),
				Field::inst( "$this->table.q56" ),
				Field::inst( "$this->table.q57" ),
				Field::inst( "$this->table.q58" ),
				Field::inst( "$this->table.q59" ),
				Field::inst( "$this->table.q60" ),
				Field::inst( "$this->table.q61" ),
				Field::inst( "$this->table.q62" ),
				Field::inst( "$this->table.q63" ),
				Field::inst( "$this->table.q64" ),
				Field::inst( "$this->table.q65" ),
				Field::inst( "$this->table.q66" ),
				Field::inst( "$this->table.q67" ),
				Field::inst( "$this->table.q68" ),
				Field::inst( "$this->table.q69" ),
				Field::inst( "$this->table.q70" ),
				Field::inst( "$this->table.q71" ),
				Field::inst( "$this->table.q72" ),
				Field::inst( "$this->table.q73" ),
				Field::inst( "$this->table.q74" ),
				Field::inst( "$this->table.q75" ),
				Field::inst( "$this->table.q76" ),
				Field::inst( "$this->table.q77" ),
				Field::inst( "$this->table.q78" ),
				Field::inst( "$this->table.q79" ),
				Field::inst( "$this->table.q80" ),
				Field::inst( "$this->table.q81" ),
				Field::inst( "$this->table.q82" ),
				Field::inst( "$this->table.q83" ),
				Field::inst( "$this->table.q84" ),
				Field::inst( "$this->table.q85" ),
				Field::inst( "$this->table.q86" ),
				Field::inst( "$this->table.q87" ),
				Field::inst( "$this->table.q88" ),
				Field::inst( "$this->table.q89" ),
				Field::inst( "$this->table.q90" ),
				Field::inst( "$this->table.q91" ),
				Field::inst( "$this->table.q92" ),
				Field::inst( "$this->table.q93" ),
				Field::inst( "$this->table.q94" ),
				Field::inst( "$this->table.q95" ),
				Field::inst( "$this->table.q96" ),
				Field::inst( "$this->table.q97" ),
				Field::inst( "$this->table.q98" ),
				Field::inst( "$this->table.q99" ),
				Field::inst( "$this->table.q100" ),
				Field::inst( "$this->table.q101" ),
				Field::inst( "$this->table.q102" ),
				Field::inst( "$this->table.q103" ),
				Field::inst( "$this->table.q104" ),
				Field::inst( "$this->table.q105" ),
				Field::inst( "$this->table.q106" ),
				Field::inst( "$this->table.q107" ),
				Field::inst( "$this->table.q108" ),
				Field::inst( "$this->table.q109" ),
				Field::inst( "$this->table.q110" ),
				Field::inst( "$this->table.q111" ),
				Field::inst( "$this->table.q112" ),
				Field::inst( "$this->table.q113" ),
				Field::inst( "$this->table.q114" ),
				Field::inst( "$this->table.q115" ),
				Field::inst( "$this->table.q116" ),
				Field::inst( "$this->table.q117" ),
				Field::inst( "$this->table.q118" ),
				Field::inst( "$this->table.q119" ),
				Field::inst( "$this->table.q120" ),
				
				Field::inst( "$this->table.q01_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q02_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q03_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q04_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q05_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q06_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q07_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q08_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q09_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q10_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q11_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q12_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q13_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q14_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q15_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q16_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q17_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q18_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q19_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q20_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q21_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q22_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q23_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q24_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q25_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q26_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q27_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q28_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q29_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q30_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q31_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q32_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q33_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q34_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q35_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q36_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q37_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q38_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q39_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q40_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q41_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q42_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q43_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q44_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q45_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q46_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q47_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q48_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q49_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q50_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q51_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q52_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q53_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q54_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q55_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q56_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q57_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q58_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q59_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q60_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q61_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q62_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q63_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q64_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q65_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q66_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q67_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q68_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q69_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q70_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q71_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q72_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q73_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q74_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q75_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q76_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q77_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q78_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q79_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q80_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q81_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q82_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q83_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q84_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q85_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q86_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q87_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q88_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q89_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q90_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q91_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q92_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q93_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q94_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q95_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q96_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q97_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q98_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q99_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q100_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				
				Field::inst( "$this->table.q101_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q102_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q103_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q104_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q105_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q106_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q107_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q108_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q109_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q110_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q111_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q112_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q113_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q114_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q115_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q116_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q117_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q118_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q119_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } ),
				Field::inst( "$this->table.q120_scoring" )->setFormatter( function ( $val, $data, $opts ) { return ! $val ? 0 : 1; } )
			)
		;
	}
	
	function csv_to_array($filename, $delimiter=',', $enclosure='"', $escape = '\\')
	{
		if(!file_exists($filename) || !is_readable($filename)) return false;

		$arr = array();
		if (($handle = fopen($filename, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
				$arr[] = $data;
			}
			fclose($handle);
			return $arr;
		}
	}

	public function import($csv) {

		$buff = explode('.', $csv);
		$ext = end($buff);
		$event_name = ucwords(basename(str_replace("_", " ", $csv), '.' . $ext));
		
		$event = Model\Ticket\Product_events::where(array('name' => $event_name))->get();
		$event_id = null;
		if ( ! $event ) {
			$event = Model\Ticket\Product_events::make(array(
				'name' => ucwords($event_name),
				'code' => strtolower(str_replace(" ", "-", $event_name)),
				'event_type' => 'contest',
			));
			$event->save();
			$event_id = Model\Ticket\Product_events::last_created()->id;
		} else {
			$event_id = $event->id;
		}
		
		//echo "<pre>";
		//echo PHP_EOL."Proccessing ../data/Contest/$csv".PHP_EOL;
		//echo PHP_EOL."Proccessing $csv".PHP_EOL;
		
		//$data = $this->csv_to_array("../data/Contest/$csv");
		$data = $this->csv_to_array($csv);
		//die(var_dump($data));
		
		//$data = array_map('str_getcsv', file("../data/Contest/$csv"));
		//die(var_dump($data));
		//$questions = $data;
		$questions = array_shift($data);
		//die(var_dump($questions));
		
		array_shift($questions); // remove the timestamp column
		array_unshift($questions, $event_id); // add the event id column
		$keys = array('event_id');
		for($i=1;$i<count($questions);$i++){
			$keys[] = sprintf("q%02d", $i);
		}
		$questions = array_combine($keys, $questions);
		//die(var_dump($questions));
		
		$ci =& get_instance();
		$ci->db->replace($this->table, $questions);

		
		//var_dump($data);
		
		$keys = array('event_id', 'timestamp');
		for($i=1;$i<count($questions);$i++){
			$keys[] = sprintf("a%02d", $i);
		}
		
		//die(var_dump($keys));
		
		//delete all rows with event_id its better approach
		
		//$answers = array();
		
		$db_debug = $ci->db->db_debug;
		$ci->db->db_debug = false;
		$i = 1;
		foreach( $data as $answer ) {
			
			array_unshift($answer, $event_id);
			
			$a = array_combine($keys, $answer);
			
			if ( ! $a ) {
				var_dump($keys);
				die(var_dump($answer));
			}
			//$ci->show_progress_status($i++, count($data), sprintf('Importing: %-35s', $a['a01']));
			
			$hash = array_slice($a, 2);
			$hash = md5(serialize($hash));
			
			$a['hash'] = $hash;
			
			$ci->db->insert('cts_contestants', $a);
		}
		$ci->db->db_debug = $db_debug;
		
	}
}