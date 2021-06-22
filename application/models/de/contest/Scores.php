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
	
class Scores extends RA_Editor_Model {
	
	public $table = 'cts_scores';
	private $sys_users = 'sys_users';
	
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
				`user_id` int(11) UNSIGNED NOT NULL,
				`answer_id` int(11) UNSIGNED NOT NULL,
				`event_id` int(11) UNSIGNED NOT NULL,
				`s01` decimal(10,2) DEFAULT NULL,
				`s02` decimal(10,2) DEFAULT NULL,
				`s03` decimal(10,2) DEFAULT NULL,
				`s04` decimal(10,2) DEFAULT NULL,
				`s05` decimal(10,2) DEFAULT NULL,
				`s06` decimal(10,2) DEFAULT NULL,
				`s07` decimal(10,2) DEFAULT NULL,
				`s08` decimal(10,2) DEFAULT NULL,
				`s09` decimal(10,2) DEFAULT NULL,
				`s10` decimal(10,2) DEFAULT NULL,
				
				`s11` decimal(10,2) DEFAULT NULL,
				`s12` decimal(10,2) DEFAULT NULL,
				`s13` decimal(10,2) DEFAULT NULL,
				`s14` decimal(10,2) DEFAULT NULL,
				`s15` decimal(10,2) DEFAULT NULL,
				`s16` decimal(10,2) DEFAULT NULL,
				`s17` decimal(10,2) DEFAULT NULL,
				`s18` decimal(10,2) DEFAULT NULL,
				`s19` decimal(10,2) DEFAULT NULL,
				`s20` decimal(10,2) DEFAULT NULL,
				
				`s21` decimal(10,2) DEFAULT NULL,
				`s22` decimal(10,2) DEFAULT NULL,
				`s23` decimal(10,2) DEFAULT NULL,
				`s24` decimal(10,2) DEFAULT NULL,
				`s25` decimal(10,2) DEFAULT NULL,
				`s26` decimal(10,2) DEFAULT NULL,
				`s27` decimal(10,2) DEFAULT NULL,
				`s28` decimal(10,2) DEFAULT NULL,
				`s29` decimal(10,2) DEFAULT NULL,
				`s30` decimal(10,2) DEFAULT NULL,
				
				`s31` decimal(10,2) DEFAULT NULL,
				`s32` decimal(10,2) DEFAULT NULL,
				`s33` decimal(10,2) DEFAULT NULL,
				`s34` decimal(10,2) DEFAULT NULL,
				`s35` decimal(10,2) DEFAULT NULL,
				`s36` decimal(10,2) DEFAULT NULL,
				`s37` decimal(10,2) DEFAULT NULL,
				`s38` decimal(10,2) DEFAULT NULL,
				`s39` decimal(10,2) DEFAULT NULL,
				`s40` decimal(10,2) DEFAULT NULL,
				
				`s41` decimal(10,2) DEFAULT NULL,
				`s42` decimal(10,2) DEFAULT NULL,
				`s43` decimal(10,2) DEFAULT NULL,
				`s44` decimal(10,2) DEFAULT NULL,
				`s45` decimal(10,2) DEFAULT NULL,
				`s46` decimal(10,2) DEFAULT NULL,
				`s47` decimal(10,2) DEFAULT NULL,
				`s48` decimal(10,2) DEFAULT NULL,
				`s49` decimal(10,2) DEFAULT NULL,
				`s50` decimal(10,2) DEFAULT NULL,
				
				`s51` decimal(10,2) DEFAULT NULL,
				`s52` decimal(10,2) DEFAULT NULL,
				`s53` decimal(10,2) DEFAULT NULL,
				`s54` decimal(10,2) DEFAULT NULL,
				`s55` decimal(10,2) DEFAULT NULL,
				`s56` decimal(10,2) DEFAULT NULL,
				`s57` decimal(10,2) DEFAULT NULL,
				`s58` decimal(10,2) DEFAULT NULL,
				`s59` decimal(10,2) DEFAULT NULL,
				`s60` decimal(10,2) DEFAULT NULL,
				
				`s61` decimal(10,2) DEFAULT NULL,
				`s62` decimal(10,2) DEFAULT NULL,
				`s63` decimal(10,2) DEFAULT NULL,
				`s64` decimal(10,2) DEFAULT NULL,
				`s65` decimal(10,2) DEFAULT NULL,
				`s66` decimal(10,2) DEFAULT NULL,
				`s67` decimal(10,2) DEFAULT NULL,
				`s68` decimal(10,2) DEFAULT NULL,
				`s69` decimal(10,2) DEFAULT NULL,
				`s70` decimal(10,2) DEFAULT NULL,
				
				`s71` decimal(10,2) DEFAULT NULL,
				`s72` decimal(10,2) DEFAULT NULL,
				`s73` decimal(10,2) DEFAULT NULL,
				`s74` decimal(10,2) DEFAULT NULL,
				`s75` decimal(10,2) DEFAULT NULL,
				`s76` decimal(10,2) DEFAULT NULL,
				`s77` decimal(10,2) DEFAULT NULL,
				`s78` decimal(10,2) DEFAULT NULL,
				`s79` decimal(10,2) DEFAULT NULL,
				`s80` decimal(10,2) DEFAULT NULL,
				
				`s81` decimal(10,2) DEFAULT NULL,
				`s82` decimal(10,2) DEFAULT NULL,
				`s83` decimal(10,2) DEFAULT NULL,
				`s84` decimal(10,2) DEFAULT NULL,
				`s85` decimal(10,2) DEFAULT NULL,
				`s86` decimal(10,2) DEFAULT NULL,
				`s87` decimal(10,2) DEFAULT NULL,
				`s88` decimal(10,2) DEFAULT NULL,
				`s89` decimal(10,2) DEFAULT NULL,
				`s90` decimal(10,2) DEFAULT NULL,
				
				`s91` decimal(10,2) DEFAULT NULL,
				`s92` decimal(10,2) DEFAULT NULL,
				`s93` decimal(10,2) DEFAULT NULL,
				`s94` decimal(10,2) DEFAULT NULL,
				`s95` decimal(10,2) DEFAULT NULL,
				`s96` decimal(10,2) DEFAULT NULL,
				`s97` decimal(10,2) DEFAULT NULL,
				`s98` decimal(10,2) DEFAULT NULL,
				`s99` decimal(10,2) DEFAULT NULL,
				`s100` decimal(10,2) DEFAULT NULL,
				
				`s101` decimal(10,2) DEFAULT NULL,
				`s102` decimal(10,2) DEFAULT NULL,
				`s103` decimal(10,2) DEFAULT NULL,
				`s104` decimal(10,2) DEFAULT NULL,
				`s105` decimal(10,2) DEFAULT NULL,
				`s106` decimal(10,2) DEFAULT NULL,
				`s107` decimal(10,2) DEFAULT NULL,
				`s108` decimal(10,2) DEFAULT NULL,
				`s109` decimal(10,2) DEFAULT NULL,
				`s110` decimal(10,2) DEFAULT NULL,
				
				`s111` decimal(10,2) DEFAULT NULL,
				`s112` decimal(10,2) DEFAULT NULL,
				`s113` decimal(10,2) DEFAULT NULL,
				`s114` decimal(10,2) DEFAULT NULL,
				`s115` decimal(10,2) DEFAULT NULL,
				`s116` decimal(10,2) DEFAULT NULL,
				`s117` decimal(10,2) DEFAULT NULL,
				`s118` decimal(10,2) DEFAULT NULL,
				`s119` decimal(10,2) DEFAULT NULL,
				`s120` decimal(10,2) DEFAULT NULL,
				
				UNIQUE( `user_id`, `answer_id` ),

				PRIMARY KEY (`id`)
			)" 
		);
		
		$this->_create_view();
	}
	
	private function _create_view() {
		$sql = "
CREATE OR REPLACE VIEW `cts_results` AS
SELECT
	`answer_id`,
	`event_id`,
	avg(`s01`) as `avgs01`,
	avg(`s02`) as `avgs02`,
	avg(`s03`) as `avgs03`,
	avg(`s04`) as `avgs04`,
	avg(`s05`) as `avgs05`,
	avg(`s06`) as `avgs06`,
	avg(`s07`) as `avgs07`,
	avg(`s08`) as `avgs08`,
	avg(`s09`) as `avgs09`,
	
	avg(`s10`) as `avgs10`,
	avg(`s11`) as `avgs11`,
	avg(`s12`) as `avgs12`,
	avg(`s13`) as `avgs13`,
	avg(`s14`) as `avgs14`,
	avg(`s15`) as `avgs15`,
	avg(`s16`) as `avgs16`,
	avg(`s17`) as `avgs17`,
	avg(`s18`) as `avgs18`,
	avg(`s19`) as `avgs19`,
	
	avg(`s20`) as `avgs20`,
	avg(`s21`) as `avgs21`,
	avg(`s22`) as `avgs22`,
	avg(`s23`) as `avgs23`,
	avg(`s24`) as `avgs24`,
	avg(`s25`) as `avgs25`,
	avg(`s26`) as `avgs26`,
	avg(`s27`) as `avgs27`,
	avg(`s28`) as `avgs28`,
	avg(`s29`) as `avgs29`,
	
	avg(`s30`) as `avgs30`,
	avg(`s31`) as `avgs31`,
	avg(`s32`) as `avgs32`,
	avg(`s33`) as `avgs33`,
	avg(`s34`) as `avgs34`,
	avg(`s35`) as `avgs35`,
	avg(`s36`) as `avgs36`,
	avg(`s37`) as `avgs37`,
	avg(`s38`) as `avgs38`,
	avg(`s39`) as `avgs39`,
	
	avg(`s40`) as `avgs40`,
	avg(`s41`) as `avgs41`,
	avg(`s42`) as `avgs42`,
	avg(`s43`) as `avgs43`,
	avg(`s44`) as `avgs44`,
	avg(`s45`) as `avgs45`,
	avg(`s46`) as `avgs46`,
	avg(`s47`) as `avgs47`,
	avg(`s48`) as `avgs48`,
	avg(`s49`) as `avgs49`,
	
	avg(`s50`) as `avgs50`,
	avg(`s51`) as `avgs51`,
	avg(`s52`) as `avgs52`,
	avg(`s53`) as `avgs53`,
	avg(`s54`) as `avgs54`,
	avg(`s55`) as `avgs55`,
	avg(`s56`) as `avgs56`,
	avg(`s57`) as `avgs57`,
	avg(`s58`) as `avgs58`,
	avg(`s59`) as `avgs59`,
	
	avg(`s60`) as `avgs60`,
	avg(`s61`) as `avgs61`,
	avg(`s62`) as `avgs62`,
	avg(`s63`) as `avgs63`,
	avg(`s64`) as `avgs64`,
	avg(`s65`) as `avgs65`,
	avg(`s66`) as `avgs66`,
	avg(`s67`) as `avgs67`,
	avg(`s68`) as `avgs68`,
	avg(`s69`) as `avgs69`,
	
	avg(`s70`) as `avgs70`,
	avg(`s71`) as `avgs71`,
	avg(`s72`) as `avgs72`,
	avg(`s73`) as `avgs73`,
	avg(`s74`) as `avgs74`,
	avg(`s75`) as `avgs75`,
	avg(`s76`) as `avgs76`,
	avg(`s77`) as `avgs77`,
	avg(`s78`) as `avgs78`,
	avg(`s79`) as `avgs79`,
	
	avg(`s80`) as `avgs80`,
	avg(`s81`) as `avgs81`,
	avg(`s82`) as `avgs82`,
	avg(`s83`) as `avgs83`,
	avg(`s84`) as `avgs84`,
	avg(`s85`) as `avgs85`,
	avg(`s86`) as `avgs86`,
	avg(`s87`) as `avgs87`,
	avg(`s88`) as `avgs88`,
	avg(`s89`) as `avgs89`,
	
	avg(`s90`) as `avgs90`,
	avg(`s91`) as `avgs91`,
	avg(`s92`) as `avgs92`,
	avg(`s93`) as `avgs93`,
	avg(`s94`) as `avgs94`,
	avg(`s95`) as `avgs95`,
	avg(`s96`) as `avgs96`,
	avg(`s97`) as `avgs97`,
	avg(`s98`) as `avgs98`,
	avg(`s99`) as `avgs99`,
	
	avg(`s100`) as `avgs100`,
	avg(`s101`) as `avgs101`,
	avg(`s102`) as `avgs102`,
	avg(`s103`) as `avgs103`,
	avg(`s104`) as `avgs104`,
	avg(`s105`) as `avgs105`,
	avg(`s106`) as `avgs106`,
	avg(`s107`) as `avgs107`,
	avg(`s108`) as `avgs108`,
	avg(`s109`) as `avgs109`,
	
	avg(`s110`) as `avgs110`,
	avg(`s111`) as `avgs111`,
	avg(`s112`) as `avgs112`,
	avg(`s113`) as `avgs113`,
	avg(`s114`) as `avgs114`,
	avg(`s115`) as `avgs115`,
	avg(`s116`) as `avgs116`,
	avg(`s117`) as `avgs117`,
	avg(`s118`) as `avgs118`,
	avg(`s119`) as `avgs119`,
	
	avg(`s120`) as `avgs120`	
	
FROM
	`cts_scores`
GROUP BY `answer_id`, `event_id`
		";
		//echo $sql;
		$this->db_datatables->sql($sql);
		
		$sql = "
CREATE OR REPLACE VIEW `cts_results_summary` AS
SELECT
	answer_id,
	event_id,
	COALESCE(avgs01, 0) +
	COALESCE(avgs02, 0) +
	COALESCE(avgs03, 0) +
	COALESCE(avgs04, 0) +
	COALESCE(avgs05, 0) +
	COALESCE(avgs06, 0) +
	COALESCE(avgs07, 0) +
	COALESCE(avgs08, 0) +
	COALESCE(avgs09, 0) +
	
	COALESCE(avgs10, 0) +
	COALESCE(avgs11, 0) +
	COALESCE(avgs12, 0) +
	COALESCE(avgs13, 0) +
	COALESCE(avgs14, 0) +
	COALESCE(avgs15, 0) +
	COALESCE(avgs16, 0) +
	COALESCE(avgs17, 0) +
	COALESCE(avgs18, 0) +
	COALESCE(avgs19, 0) +
	
	COALESCE(avgs20, 0) +
	COALESCE(avgs21, 0) +
	COALESCE(avgs22, 0) +
	COALESCE(avgs23, 0) +
	COALESCE(avgs24, 0) +
	COALESCE(avgs25, 0) +
	COALESCE(avgs26, 0) +
	COALESCE(avgs27, 0) +
	COALESCE(avgs28, 0) +
	COALESCE(avgs29, 0) +
	
	COALESCE(avgs30, 0) +
	COALESCE(avgs31, 0) +
	COALESCE(avgs32, 0) +
	COALESCE(avgs33, 0) +
	COALESCE(avgs34, 0) +
	COALESCE(avgs35, 0) +
	COALESCE(avgs36, 0) +
	COALESCE(avgs37, 0) +
	COALESCE(avgs38, 0) +
	COALESCE(avgs39, 0) +
	
	COALESCE(avgs40, 0) +
	COALESCE(avgs41, 0) +
	COALESCE(avgs42, 0) +
	COALESCE(avgs43, 0) +
	COALESCE(avgs44, 0) +
	COALESCE(avgs45, 0) +
	COALESCE(avgs46, 0) +
	COALESCE(avgs47, 0) +
	COALESCE(avgs48, 0) +
	COALESCE(avgs49, 0) +
	
	COALESCE(avgs50, 0) +
	COALESCE(avgs51, 0) +
	COALESCE(avgs52, 0) +
	COALESCE(avgs53, 0) +
	COALESCE(avgs54, 0) +
	COALESCE(avgs55, 0) +
	COALESCE(avgs56, 0) +
	COALESCE(avgs57, 0) +
	COALESCE(avgs58, 0) +
	COALESCE(avgs59, 0) +
	
	COALESCE(avgs60, 0) +
	COALESCE(avgs61, 0) +
	COALESCE(avgs62, 0) +
	COALESCE(avgs63, 0) +
	COALESCE(avgs64, 0) +
	COALESCE(avgs65, 0) +
	COALESCE(avgs66, 0) +
	COALESCE(avgs67, 0) +
	COALESCE(avgs68, 0) +
	COALESCE(avgs69, 0) +
	
	COALESCE(avgs70, 0) +
	COALESCE(avgs71, 0) +
	COALESCE(avgs72, 0) +
	COALESCE(avgs73, 0) +
	COALESCE(avgs74, 0) +
	COALESCE(avgs75, 0) +
	COALESCE(avgs76, 0) +
	COALESCE(avgs77, 0) +
	COALESCE(avgs78, 0) +
	COALESCE(avgs79, 0) +
	
	COALESCE(avgs80, 0) +
	COALESCE(avgs81, 0) +
	COALESCE(avgs82, 0) +
	COALESCE(avgs83, 0) +
	COALESCE(avgs84, 0) +
	COALESCE(avgs85, 0) +
	COALESCE(avgs86, 0) +
	COALESCE(avgs87, 0) +
	COALESCE(avgs88, 0) +
	COALESCE(avgs89, 0) +
	
	COALESCE(avgs90, 0) +
	COALESCE(avgs91, 0) +
	COALESCE(avgs92, 0) +
	COALESCE(avgs93, 0) +
	COALESCE(avgs94, 0) +
	COALESCE(avgs95, 0) +
	COALESCE(avgs96, 0) +
	COALESCE(avgs97, 0) +
	COALESCE(avgs98, 0) +
	COALESCE(avgs99, 0) +
	
	COALESCE(avgs100, 0) +
	COALESCE(avgs101, 0) +
	COALESCE(avgs102, 0) +
	COALESCE(avgs103, 0) +
	COALESCE(avgs104, 0) +
	COALESCE(avgs105, 0) +
	COALESCE(avgs106, 0) +
	COALESCE(avgs107, 0) +
	COALESCE(avgs108, 0) +
	COALESCE(avgs109, 0) +
	
	COALESCE(avgs110, 0) +
	COALESCE(avgs111, 0) +
	COALESCE(avgs112, 0) +
	COALESCE(avgs113, 0) +
	COALESCE(avgs114, 0) +
	COALESCE(avgs115, 0) +
	COALESCE(avgs116, 0) +
	COALESCE(avgs117, 0) +
	COALESCE(avgs118, 0) +
	COALESCE(avgs119, 0) +
	
	COALESCE(avgs120, 0)
	
	
	AS score_total,
	
	(CASE WHEN avgs01 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs02 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs03 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs04 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs05 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs06 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs07 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs08 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs09 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs10 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs11 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs12 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs13 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs14 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs15 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs16 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs17 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs18 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs19 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs20 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs21 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs22 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs23 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs24 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs25 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs26 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs27 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs28 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs29 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs30 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs31 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs32 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs33 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs34 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs35 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs36 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs37 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs38 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs39 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs40 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs41 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs42 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs43 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs44 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs45 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs46 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs47 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs48 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs49 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs50 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs51 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs52 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs53 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs54 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs55 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs56 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs57 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs58 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs59 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs60 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs61 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs62 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs63 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs64 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs65 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs66 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs67 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs68 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs69 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs70 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs71 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs72 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs73 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs74 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs75 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs76 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs77 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs78 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs79 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs80 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs81 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs82 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs83 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs84 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs85 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs86 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs87 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs88 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs89 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs90 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs91 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs92 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs93 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs94 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs95 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs96 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs97 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs98 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs99 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs100 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs101 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs102 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs103 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs104 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs105 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs106 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs107 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs108 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs109 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs110 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs111 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs112 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs113 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs114 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs115 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs116 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs117 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs118 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs119 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs120 IS NULL THEN 0 ELSE  1 END) 	
	
	AS score_cnt,
	
	(
	COALESCE(avgs01, 0) +
	COALESCE(avgs02, 0) +
	COALESCE(avgs03, 0) +
	COALESCE(avgs04, 0) +
	COALESCE(avgs05, 0) +
	COALESCE(avgs06, 0) +
	COALESCE(avgs07, 0) +
	COALESCE(avgs08, 0) +
	COALESCE(avgs09, 0) +
	
	COALESCE(avgs10, 0) +
	COALESCE(avgs11, 0) +
	COALESCE(avgs12, 0) +
	COALESCE(avgs13, 0) +
	COALESCE(avgs14, 0) +
	COALESCE(avgs15, 0) +
	COALESCE(avgs16, 0) +
	COALESCE(avgs17, 0) +
	COALESCE(avgs18, 0) +
	COALESCE(avgs19, 0) +
	
	COALESCE(avgs20, 0) +
	COALESCE(avgs21, 0) +
	COALESCE(avgs22, 0) +
	COALESCE(avgs23, 0) +
	COALESCE(avgs24, 0) +
	COALESCE(avgs25, 0) +
	COALESCE(avgs26, 0) +
	COALESCE(avgs27, 0) +
	COALESCE(avgs28, 0) +
	COALESCE(avgs29, 0) +
	
	COALESCE(avgs30, 0) +
	COALESCE(avgs31, 0) +
	COALESCE(avgs32, 0) +
	COALESCE(avgs33, 0) +
	COALESCE(avgs34, 0) +
	COALESCE(avgs35, 0) +
	COALESCE(avgs36, 0) +
	COALESCE(avgs37, 0) +
	COALESCE(avgs38, 0) +
	COALESCE(avgs39, 0) +
	
	COALESCE(avgs40, 0) +
	COALESCE(avgs41, 0) +
	COALESCE(avgs42, 0) +
	COALESCE(avgs43, 0) +
	COALESCE(avgs44, 0) +
	COALESCE(avgs45, 0) +
	COALESCE(avgs46, 0) +
	COALESCE(avgs47, 0) +
	COALESCE(avgs48, 0) +
	COALESCE(avgs49, 0) +
	
	COALESCE(avgs50, 0) +
	COALESCE(avgs51, 0) +
	COALESCE(avgs52, 0) +
	COALESCE(avgs53, 0) +
	COALESCE(avgs54, 0) +
	COALESCE(avgs55, 0) +
	COALESCE(avgs56, 0) +
	COALESCE(avgs57, 0) +
	COALESCE(avgs58, 0) +
	COALESCE(avgs59, 0) +
	
	COALESCE(avgs60, 0) +
	COALESCE(avgs61, 0) +
	COALESCE(avgs62, 0) +
	COALESCE(avgs63, 0) +
	COALESCE(avgs64, 0) +
	COALESCE(avgs65, 0) +
	COALESCE(avgs66, 0) +
	COALESCE(avgs67, 0) +
	COALESCE(avgs68, 0) +
	COALESCE(avgs69, 0) +
	
	COALESCE(avgs70, 0) +
	COALESCE(avgs71, 0) +
	COALESCE(avgs72, 0) +
	COALESCE(avgs73, 0) +
	COALESCE(avgs74, 0) +
	COALESCE(avgs75, 0) +
	COALESCE(avgs76, 0) +
	COALESCE(avgs77, 0) +
	COALESCE(avgs78, 0) +
	COALESCE(avgs79, 0) +
	
	COALESCE(avgs80, 0) +
	COALESCE(avgs81, 0) +
	COALESCE(avgs82, 0) +
	COALESCE(avgs83, 0) +
	COALESCE(avgs84, 0) +
	COALESCE(avgs85, 0) +
	COALESCE(avgs86, 0) +
	COALESCE(avgs87, 0) +
	COALESCE(avgs88, 0) +
	COALESCE(avgs89, 0) +
	
	COALESCE(avgs90, 0) +
	COALESCE(avgs91, 0) +
	COALESCE(avgs92, 0) +
	COALESCE(avgs93, 0) +
	COALESCE(avgs94, 0) +
	COALESCE(avgs95, 0) +
	COALESCE(avgs96, 0) +
	COALESCE(avgs97, 0) +
	COALESCE(avgs98, 0) +
	COALESCE(avgs99, 0) +
	
	COALESCE(avgs100, 0) +
	COALESCE(avgs101, 0) +
	COALESCE(avgs102, 0) +
	COALESCE(avgs103, 0) +
	COALESCE(avgs104, 0) +
	COALESCE(avgs105, 0) +
	COALESCE(avgs106, 0) +
	COALESCE(avgs107, 0) +
	COALESCE(avgs108, 0) +
	COALESCE(avgs109, 0) +
	
	COALESCE(avgs110, 0) +
	COALESCE(avgs111, 0) +
	COALESCE(avgs112, 0) +
	COALESCE(avgs113, 0) +
	COALESCE(avgs114, 0) +
	COALESCE(avgs115, 0) +
	COALESCE(avgs116, 0) +
	COALESCE(avgs117, 0) +
	COALESCE(avgs118, 0) +
	COALESCE(avgs119, 0) +
	
	COALESCE(avgs120, 0)	
	
	)
	/
	(
	(CASE WHEN avgs01 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs02 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs03 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs04 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs05 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs06 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs07 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs08 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs09 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs10 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs11 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs12 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs13 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs14 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs15 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs16 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs17 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs18 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs19 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs20 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs21 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs22 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs23 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs24 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs25 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs26 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs27 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs28 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs29 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs30 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs31 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs32 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs33 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs34 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs35 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs36 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs37 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs38 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs39 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs40 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs41 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs42 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs43 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs44 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs45 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs46 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs47 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs48 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs49 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs50 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs51 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs52 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs53 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs54 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs55 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs56 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs57 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs58 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs59 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs60 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs61 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs62 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs63 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs64 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs65 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs66 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs67 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs68 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs69 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs70 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs71 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs72 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs73 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs74 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs75 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs76 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs77 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs78 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs79 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs80 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs81 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs82 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs83 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs84 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs85 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs86 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs87 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs88 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs89 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs90 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs91 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs92 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs93 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs94 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs95 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs96 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs97 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs98 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs99 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs100 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs101 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs102 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs103 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs104 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs105 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs106 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs107 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs108 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs109 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs110 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs111 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs112 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs113 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs114 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs115 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs116 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs117 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs118 IS NULL THEN 0 ELSE  1 END) +
	(CASE WHEN avgs119 IS NULL THEN 0 ELSE  1 END) +
	
	(CASE WHEN avgs120 IS NULL THEN 0 ELSE  1 END)
	
	)
	AS score
 FROM cts_results
GROUP BY answer_id, event_id
";

		//echo $sql;
		$this->db_datatables->sql($sql);
	}
	
	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.user_id" ),
				Field::inst( "$this->table.answer_id" ),
				Field::inst( "$this->table.event_id" ),
				
				Field::inst( "$this->table.s01" ),
				Field::inst( "$this->table.s02" ),
				Field::inst( "$this->table.s03" ),
				Field::inst( "$this->table.s04" ),
				Field::inst( "$this->table.s05" ),
				Field::inst( "$this->table.s06" ),
				Field::inst( "$this->table.s07" ),
				Field::inst( "$this->table.s08" ),
				Field::inst( "$this->table.s09" ),
				
				Field::inst( "$this->table.s10" ),				
				Field::inst( "$this->table.s11" ),
				Field::inst( "$this->table.s12" ),
				Field::inst( "$this->table.s13" ),
				Field::inst( "$this->table.s14" ),
				Field::inst( "$this->table.s15" ),
				Field::inst( "$this->table.s16" ),
				Field::inst( "$this->table.s17" ),
				Field::inst( "$this->table.s18" ),
				Field::inst( "$this->table.s19" ),
				
				Field::inst( "$this->table.s20" ),				
				Field::inst( "$this->table.s21" ),
				Field::inst( "$this->table.s22" ),
				Field::inst( "$this->table.s23" ),
				Field::inst( "$this->table.s24" ),
				Field::inst( "$this->table.s25" ),
				Field::inst( "$this->table.s26" ),
				Field::inst( "$this->table.s27" ),
				Field::inst( "$this->table.s28" ),
				Field::inst( "$this->table.s29" ),
				
				Field::inst( "$this->table.s30" ),				
				Field::inst( "$this->table.s31" ),
				Field::inst( "$this->table.s32" ),
				Field::inst( "$this->table.s33" ),
				Field::inst( "$this->table.s34" ),
				Field::inst( "$this->table.s35" ),
				Field::inst( "$this->table.s36" ),
				Field::inst( "$this->table.s37" ),
				Field::inst( "$this->table.s38" ),
				Field::inst( "$this->table.s39" ),
				
				Field::inst( "$this->table.s40" ),
				Field::inst( "$this->table.s41" ),
				Field::inst( "$this->table.s42" ),
				Field::inst( "$this->table.s43" ),
				Field::inst( "$this->table.s44" ),
				Field::inst( "$this->table.s45" ),
				Field::inst( "$this->table.s46" ),
				Field::inst( "$this->table.s47" ),
				Field::inst( "$this->table.s48" ),
				Field::inst( "$this->table.s49" ),
				
				Field::inst( "$this->table.s50" ),				
				Field::inst( "$this->table.s51" ),
				Field::inst( "$this->table.s52" ),
				Field::inst( "$this->table.s53" ),
				Field::inst( "$this->table.s54" ),
				Field::inst( "$this->table.s55" ),
				Field::inst( "$this->table.s56" ),
				Field::inst( "$this->table.s57" ),
				Field::inst( "$this->table.s58" ),
				Field::inst( "$this->table.s59" ),
				
				Field::inst( "$this->table.s60" ),				
				Field::inst( "$this->table.s61" ),
				Field::inst( "$this->table.s62" ),
				Field::inst( "$this->table.s63" ),
				Field::inst( "$this->table.s64" ),
				Field::inst( "$this->table.s65" ),
				Field::inst( "$this->table.s66" ),
				Field::inst( "$this->table.s67" ),
				Field::inst( "$this->table.s68" ),
				Field::inst( "$this->table.s69" ),
				
				Field::inst( "$this->table.s70" ),				
				Field::inst( "$this->table.s71" ),
				Field::inst( "$this->table.s72" ),
				Field::inst( "$this->table.s73" ),
				Field::inst( "$this->table.s74" ),
				Field::inst( "$this->table.s75" ),
				Field::inst( "$this->table.s76" ),
				Field::inst( "$this->table.s77" ),
				Field::inst( "$this->table.s78" ),
				Field::inst( "$this->table.s79" ),
				
				Field::inst( "$this->table.s80" ),				
				Field::inst( "$this->table.s81" ),
				Field::inst( "$this->table.s82" ),
				Field::inst( "$this->table.s83" ),
				Field::inst( "$this->table.s84" ),
				Field::inst( "$this->table.s85" ),
				Field::inst( "$this->table.s86" ),
				Field::inst( "$this->table.s87" ),
				Field::inst( "$this->table.s88" ),
				Field::inst( "$this->table.s89" ),
				
				Field::inst( "$this->table.s90" ),				
				Field::inst( "$this->table.s91" ),
				Field::inst( "$this->table.s92" ),
				Field::inst( "$this->table.s93" ),
				Field::inst( "$this->table.s94" ),
				Field::inst( "$this->table.s95" ),
				Field::inst( "$this->table.s96" ),
				Field::inst( "$this->table.s97" ),
				Field::inst( "$this->table.s98" ),
				Field::inst( "$this->table.s99" ),
				
				Field::inst( "$this->table.s100" ),
				Field::inst( "$this->table.s101" ),
				Field::inst( "$this->table.s102" ),
				Field::inst( "$this->table.s103" ),
				Field::inst( "$this->table.s104" ),
				Field::inst( "$this->table.s105" ),
				Field::inst( "$this->table.s106" ),
				Field::inst( "$this->table.s107" ),
				Field::inst( "$this->table.s108" ),
				Field::inst( "$this->table.s109" ),
				
				Field::inst( "$this->table.s110" ),				
				Field::inst( "$this->table.s111" ),
				Field::inst( "$this->table.s112" ),
				Field::inst( "$this->table.s113" ),
				Field::inst( "$this->table.s114" ),
				Field::inst( "$this->table.s115" ),
				Field::inst( "$this->table.s116" ),
				Field::inst( "$this->table.s117" ),
				Field::inst( "$this->table.s118" ),
				Field::inst( "$this->table.s119" ),
				
				Field::inst( "$this->table.s120" ),
				
				Field::inst( "$this->sys_users.first_name" )
			)
			->leftJoin( "$this->sys_users", "$this->sys_users.id", '=', "$this->table.user_id" )
		;
	}
	
}