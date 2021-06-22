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
	
class Contestants extends RA_Editor_Model {
	
	public $table = 'cts_contestants';
	private $cts_questions = 'cts_questions';
	private $cts_scores = 'cts_scores';
	private $cts_results = 'cts_results';
	private $cts_results_summary = 'cts_results_summary';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		//$this->init_editor();
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`event_id` int(11) UNSIGNED NOT NULL,
				`timestamp` datetime default CURRENT_TIMESTAMP,
				`a01` text DEFAULT NULL,
				`a02` text DEFAULT NULL,
				`a03` text DEFAULT NULL,
				`a04` text DEFAULT NULL,
				`a05` text DEFAULT NULL,
				`a06` text DEFAULT NULL,
				`a07` text DEFAULT NULL,
				`a08` text DEFAULT NULL,
				`a09` text DEFAULT NULL,
				`a10` text DEFAULT NULL,
				`a11` text DEFAULT NULL,
				`a12` text DEFAULT NULL,
				`a13` text DEFAULT NULL,
				`a14` text DEFAULT NULL,
				`a15` text DEFAULT NULL,
				`a16` text DEFAULT NULL,
				`a17` text DEFAULT NULL,
				`a18` text DEFAULT NULL,
				`a19` text DEFAULT NULL,
				`a20` text DEFAULT NULL,
				`a21` text DEFAULT NULL,
				`a22` text DEFAULT NULL,
				`a23` text DEFAULT NULL,
				`a24` text DEFAULT NULL,
				`a25` text DEFAULT NULL,
				`a26` text DEFAULT NULL,
				`a27` text DEFAULT NULL,
				`a28` text DEFAULT NULL,
				`a29` text DEFAULT NULL,
				`a30` text DEFAULT NULL,
				
				`a31` text DEFAULT NULL,
				`a32` text DEFAULT NULL,
				`a33` text DEFAULT NULL,
				`a34` text DEFAULT NULL,
				`a35` text DEFAULT NULL,
				`a36` text DEFAULT NULL,
				`a37` text DEFAULT NULL,
				`a38` text DEFAULT NULL,
				`a39` text DEFAULT NULL,
				`a40` text DEFAULT NULL,
				
				`a41` text DEFAULT NULL,
				`a42` text DEFAULT NULL,
				`a43` text DEFAULT NULL,
				`a44` text DEFAULT NULL,
				`a45` text DEFAULT NULL,
				`a46` text DEFAULT NULL,
				`a47` text DEFAULT NULL,
				`a48` text DEFAULT NULL,
				`a49` text DEFAULT NULL,
				`a50` text DEFAULT NULL,
				
				`a51` text DEFAULT NULL,
				`a52` text DEFAULT NULL,
				`a53` text DEFAULT NULL,
				`a54` text DEFAULT NULL,
				`a55` text DEFAULT NULL,
				`a56` text DEFAULT NULL,
				`a57` text DEFAULT NULL,
				`a58` text DEFAULT NULL,
				`a59` text DEFAULT NULL,
				`a60` text DEFAULT NULL,
				
				`a61` text DEFAULT NULL,
				`a62` text DEFAULT NULL,
				`a63` text DEFAULT NULL,
				`a64` text DEFAULT NULL,
				`a65` text DEFAULT NULL,
				`a66` text DEFAULT NULL,
				`a67` text DEFAULT NULL,
				`a68` text DEFAULT NULL,
				`a69` text DEFAULT NULL,
				`a70` text DEFAULT NULL,
				
				`a71` text DEFAULT NULL,
				`a72` text DEFAULT NULL,
				`a73` text DEFAULT NULL,
				`a74` text DEFAULT NULL,
				`a75` text DEFAULT NULL,
				`a76` text DEFAULT NULL,
				`a77` text DEFAULT NULL,
				`a78` text DEFAULT NULL,
				`a79` text DEFAULT NULL,
				`a80` text DEFAULT NULL,
				
				`a81` text DEFAULT NULL,
				`a82` text DEFAULT NULL,
				`a83` text DEFAULT NULL,
				`a84` text DEFAULT NULL,
				`a85` text DEFAULT NULL,
				`a86` text DEFAULT NULL,
				`a87` text DEFAULT NULL,
				`a88` text DEFAULT NULL,
				`a89` text DEFAULT NULL,
				`a90` text DEFAULT NULL,
				
				`a91` text DEFAULT NULL,
				`a92` text DEFAULT NULL,
				`a93` text DEFAULT NULL,
				`a94` text DEFAULT NULL,
				`a95` text DEFAULT NULL,
				`a96` text DEFAULT NULL,
				`a97` text DEFAULT NULL,
				`a98` text DEFAULT NULL,
				`a99` text DEFAULT NULL,
				`a100` text DEFAULT NULL,
				
				`a101` text DEFAULT NULL,
				`a102` text DEFAULT NULL,
				`a103` text DEFAULT NULL,
				`a104` text DEFAULT NULL,
				`a105` text DEFAULT NULL,
				`a106` text DEFAULT NULL,
				`a107` text DEFAULT NULL,
				`a108` text DEFAULT NULL,
				`a109` text DEFAULT NULL,
				`a110` text DEFAULT NULL,
				`a111` text DEFAULT NULL,
				`a112` text DEFAULT NULL,
				`a113` text DEFAULT NULL,
				`a114` text DEFAULT NULL,
				`a115` text DEFAULT NULL,
				`a116` text DEFAULT NULL,
				`a117` text DEFAULT NULL,
				`a118` text DEFAULT NULL,
				`a119` text DEFAULT NULL,
				`a120` text DEFAULT NULL,
				
				
				`status` varchar(100) NOT NULL DEFAULT 'approved',
				`hash` varchar(255) DEFAULT NULL,
				
				UNIQUE( `hash` ),
				
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function init_editor_minimal() {
		$user_id = $this->ci->user_id;

		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" )
				,Field::inst( "$this->table.event_id" )
				,Field::inst( "$this->table.timestamp" )
				,Field::inst( "$this->table.a01" )
				//,Field::inst( "$this->table.a02" )
				//,Field::inst( "$this->table.a03" )
				//,Field::inst( "$this->table.a04" )
				//,Field::inst( "$this->table.a05" )
				
				,Field::inst( "$this->cts_scores.id" )
				,Field::inst( "$this->cts_scores.s01" )
				,Field::inst( "$this->cts_scores.s02" )
				,Field::inst( "$this->cts_scores.s03" )
				,Field::inst( "$this->cts_scores.s04" )
				,Field::inst( "$this->cts_scores.s05" )
				,Field::inst( "$this->cts_scores.s06" )
				,Field::inst( "$this->cts_scores.s07" )
				,Field::inst( "$this->cts_scores.s08" )
				,Field::inst( "$this->cts_scores.s09" )
				,Field::inst( "$this->cts_scores.s10" )
				,Field::inst( "$this->cts_scores.s11" )
				,Field::inst( "$this->cts_scores.s12" )
				,Field::inst( "$this->cts_scores.s13" )
				,Field::inst( "$this->cts_scores.s14" )
				,Field::inst( "$this->cts_scores.s15" )
				,Field::inst( "$this->cts_scores.s16" )
				,Field::inst( "$this->cts_scores.s17" )
				,Field::inst( "$this->cts_scores.s18" )
				,Field::inst( "$this->cts_scores.s19" )
				,Field::inst( "$this->cts_scores.s20" )
				,Field::inst( "$this->cts_scores.s21" )
				,Field::inst( "$this->cts_scores.s22" )
				,Field::inst( "$this->cts_scores.s23" )
				,Field::inst( "$this->cts_scores.s24" )
				,Field::inst( "$this->cts_scores.s25" )
				,Field::inst( "$this->cts_scores.s26" )
				,Field::inst( "$this->cts_scores.s27" )
				,Field::inst( "$this->cts_scores.s28" )
				,Field::inst( "$this->cts_scores.s29" )
				,Field::inst( "$this->cts_scores.s30" )
				
				,Field::inst( "$this->cts_questions.q01_scoring" )
				,Field::inst( "$this->cts_questions.q02_scoring" )
				,Field::inst( "$this->cts_questions.q03_scoring" )
				,Field::inst( "$this->cts_questions.q04_scoring" )
				,Field::inst( "$this->cts_questions.q05_scoring" )
				,Field::inst( "$this->cts_questions.q06_scoring" )
				,Field::inst( "$this->cts_questions.q07_scoring" )
				,Field::inst( "$this->cts_questions.q08_scoring" )
				,Field::inst( "$this->cts_questions.q09_scoring" )
				,Field::inst( "$this->cts_questions.q10_scoring" )
				,Field::inst( "$this->cts_questions.q11_scoring" )
				,Field::inst( "$this->cts_questions.q12_scoring" )
				,Field::inst( "$this->cts_questions.q13_scoring" )
				,Field::inst( "$this->cts_questions.q14_scoring" )
				,Field::inst( "$this->cts_questions.q15_scoring" )
				,Field::inst( "$this->cts_questions.q16_scoring" )
				,Field::inst( "$this->cts_questions.q17_scoring" )
				,Field::inst( "$this->cts_questions.q18_scoring" )
				,Field::inst( "$this->cts_questions.q19_scoring" )
				,Field::inst( "$this->cts_questions.q20_scoring" )
				,Field::inst( "$this->cts_questions.q21_scoring" )
				,Field::inst( "$this->cts_questions.q22_scoring" )
				,Field::inst( "$this->cts_questions.q23_scoring" )
				,Field::inst( "$this->cts_questions.q24_scoring" )
				,Field::inst( "$this->cts_questions.q25_scoring" )
				,Field::inst( "$this->cts_questions.q26_scoring" )
				,Field::inst( "$this->cts_questions.q27_scoring" )
				,Field::inst( "$this->cts_questions.q28_scoring" )
				,Field::inst( "$this->cts_questions.q29_scoring" )
				,Field::inst( "$this->cts_questions.q30_scoring" )
				
				
				,Field::inst( "$this->cts_results.avgs01" )
				,Field::inst( "$this->cts_results.avgs02" )
				,Field::inst( "$this->cts_results.avgs03" )
				,Field::inst( "$this->cts_results.avgs04" )
				,Field::inst( "$this->cts_results.avgs05" )
				,Field::inst( "$this->cts_results.avgs06" )
				,Field::inst( "$this->cts_results.avgs07" )
				,Field::inst( "$this->cts_results.avgs08" )
				,Field::inst( "$this->cts_results.avgs09" )
				,Field::inst( "$this->cts_results.avgs10" )
				,Field::inst( "$this->cts_results.avgs11" )
				,Field::inst( "$this->cts_results.avgs12" )
				,Field::inst( "$this->cts_results.avgs13" )
				,Field::inst( "$this->cts_results.avgs14" )
				,Field::inst( "$this->cts_results.avgs15" )
				,Field::inst( "$this->cts_results.avgs16" )
				,Field::inst( "$this->cts_results.avgs17" )
				,Field::inst( "$this->cts_results.avgs18" )
				,Field::inst( "$this->cts_results.avgs19" )
				,Field::inst( "$this->cts_results.avgs20" )
				,Field::inst( "$this->cts_results.avgs21" )
				,Field::inst( "$this->cts_results.avgs22" )
				,Field::inst( "$this->cts_results.avgs23" )
				,Field::inst( "$this->cts_results.avgs24" )
				,Field::inst( "$this->cts_results.avgs25" )
				,Field::inst( "$this->cts_results.avgs26" )
				,Field::inst( "$this->cts_results.avgs27" )
				,Field::inst( "$this->cts_results.avgs28" )
				,Field::inst( "$this->cts_results.avgs29" )
				,Field::inst( "$this->cts_results.avgs30" )
				
				
				,Field::inst( "$this->cts_results_summary.score_total" )
				,Field::inst( "$this->cts_results_summary.score" )
			)
			->leftJoin( "$this->cts_questions", "$this->cts_questions.event_id", '=', "$this->table.event_id" )
			->leftJoin( "$this->cts_scores", "$this->cts_scores.answer_id", '=', "$this->table.id AND $this->cts_scores.user_id = $user_id" )
			->leftJoin( "$this->cts_results", "$this->cts_results.answer_id", '=', "$this->table.id" )
			->leftJoin( "$this->cts_results_summary", "$this->cts_results_summary.answer_id", '=', "$this->table.id" )
		;
	}
	
	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.event_id" ),
				Field::inst( "$this->table.timestamp" ),
				Field::inst( "$this->table.a01" ),
				Field::inst( "$this->table.a02" ),
				Field::inst( "$this->table.a03" ),
				Field::inst( "$this->table.a04" ),
				Field::inst( "$this->table.a05" ),
				Field::inst( "$this->table.a06" ),
				Field::inst( "$this->table.a07" ),
				Field::inst( "$this->table.a08" ),
				Field::inst( "$this->table.a09" ),
				Field::inst( "$this->table.a10" ),
				Field::inst( "$this->table.a11" ),
				Field::inst( "$this->table.a12" ),
				Field::inst( "$this->table.a13" ),
				Field::inst( "$this->table.a14" ),
				Field::inst( "$this->table.a15" ),
				Field::inst( "$this->table.a16" ),
				Field::inst( "$this->table.a17" ),
				Field::inst( "$this->table.a18" ),
				Field::inst( "$this->table.a19" ),
				Field::inst( "$this->table.a20" ),
				Field::inst( "$this->table.a21" ),
				Field::inst( "$this->table.a22" ),
				Field::inst( "$this->table.a23" ),
				Field::inst( "$this->table.a24" ),
				Field::inst( "$this->table.a25" ),
				Field::inst( "$this->table.a26" ),
				Field::inst( "$this->table.a27" ),
				Field::inst( "$this->table.a28" ),
				Field::inst( "$this->table.a29" ),
				Field::inst( "$this->table.a30" ),
				
				Field::inst( "$this->table.a31" ),
				Field::inst( "$this->table.a32" ),
				Field::inst( "$this->table.a33" ),
				Field::inst( "$this->table.a34" ),
				Field::inst( "$this->table.a35" ),
				Field::inst( "$this->table.a36" ),
				Field::inst( "$this->table.a37" ),
				Field::inst( "$this->table.a38" ),
				Field::inst( "$this->table.a39" ),
				Field::inst( "$this->table.a40" ),
				
				Field::inst( "$this->table.a41" ),
				Field::inst( "$this->table.a42" ),
				Field::inst( "$this->table.a43" ),
				Field::inst( "$this->table.a44" ),
				Field::inst( "$this->table.a45" ),
				Field::inst( "$this->table.a46" ),
				Field::inst( "$this->table.a47" ),
				Field::inst( "$this->table.a48" ),
				Field::inst( "$this->table.a49" ),
				Field::inst( "$this->table.a50" ),
				
				Field::inst( "$this->table.a51" ),
				Field::inst( "$this->table.a52" ),
				Field::inst( "$this->table.a53" ),
				Field::inst( "$this->table.a54" ),
				Field::inst( "$this->table.a55" ),
				Field::inst( "$this->table.a56" ),
				Field::inst( "$this->table.a57" ),
				Field::inst( "$this->table.a58" ),
				Field::inst( "$this->table.a59" ),
				Field::inst( "$this->table.a60" ),
				
				Field::inst( "$this->table.a61" ),
				Field::inst( "$this->table.a62" ),
				Field::inst( "$this->table.a63" ),
				Field::inst( "$this->table.a64" ),
				Field::inst( "$this->table.a65" ),
				Field::inst( "$this->table.a66" ),
				Field::inst( "$this->table.a67" ),
				Field::inst( "$this->table.a68" ),
				Field::inst( "$this->table.a69" ),
				Field::inst( "$this->table.a70" ),
				
				Field::inst( "$this->table.a71" ),
				Field::inst( "$this->table.a72" ),
				Field::inst( "$this->table.a73" ),
				Field::inst( "$this->table.a74" ),
				Field::inst( "$this->table.a75" ),
				Field::inst( "$this->table.a76" ),
				Field::inst( "$this->table.a77" ),
				Field::inst( "$this->table.a78" ),
				Field::inst( "$this->table.a79" ),
				Field::inst( "$this->table.a80" ),
				
				Field::inst( "$this->table.a81" ),
				Field::inst( "$this->table.a82" ),
				Field::inst( "$this->table.a83" ),
				Field::inst( "$this->table.a84" ),
				Field::inst( "$this->table.a85" ),
				Field::inst( "$this->table.a86" ),
				Field::inst( "$this->table.a87" ),
				Field::inst( "$this->table.a88" ),
				Field::inst( "$this->table.a89" ),
				Field::inst( "$this->table.a90" ),
				
				Field::inst( "$this->table.a91" ),
				Field::inst( "$this->table.a92" ),
				Field::inst( "$this->table.a93" ),
				Field::inst( "$this->table.a94" ),
				Field::inst( "$this->table.a95" ),
				Field::inst( "$this->table.a96" ),
				Field::inst( "$this->table.a97" ),
				Field::inst( "$this->table.a98" ),
				Field::inst( "$this->table.a99" ),
				Field::inst( "$this->table.a100" ),
				
				Field::inst( "$this->table.a101" ),
				Field::inst( "$this->table.a102" ),
				Field::inst( "$this->table.a103" ),
				Field::inst( "$this->table.a104" ),
				Field::inst( "$this->table.a105" ),
				Field::inst( "$this->table.a106" ),
				Field::inst( "$this->table.a107" ),
				Field::inst( "$this->table.a108" ),
				Field::inst( "$this->table.a109" ),
				Field::inst( "$this->table.a110" ),
				Field::inst( "$this->table.a111" ),
				Field::inst( "$this->table.a112" ),
				Field::inst( "$this->table.a113" ),
				Field::inst( "$this->table.a114" ),
				Field::inst( "$this->table.a115" ),
				Field::inst( "$this->table.a116" ),
				Field::inst( "$this->table.a117" ),
				Field::inst( "$this->table.a118" ),
				Field::inst( "$this->table.a119" ),
				Field::inst( "$this->table.a120" ),
				
				Field::inst( "$this->table.status" ),
				Field::inst( "$this->table.hash" )
			)
		;
	}
	
	public function get($id = null, $id2 = null) {
		if ( $id )
			$this->editor->where("$this->table.event_id", $id);
		if ( $id2 )
			$this->editor->where("$this->table.status", $id2);
		parent::get();
	}

}