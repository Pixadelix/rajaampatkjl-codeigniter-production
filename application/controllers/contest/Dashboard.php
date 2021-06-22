<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends RA_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted();
		$this->breadcrumbs->push('Contest', '/contest/dashboard');
	}
	
	public function index() {
		$this->restricted('admin');
		$this->data['PAGE_TITLE'] = 'Contest Manager';
		$this->breadcrumbs->push('Contest Manager', '/contest/dashboard/index');
		$this->include_datatables_assets(true);
		$this->enqueue_resource('/resource/script/adminlte/contest/js/contests.php');
		$this->enqueue_resource('/resource/script/adminlte/contest/js/questions.php');
		$this->dashboard('/adminlte/contest/contest-manager');
	}
	
	public function upload() {
		$this->restricted('admin');
		$cfg = $this->config->item('contest_upload');
		$upload_path = $cfg['upload_path'];
		if ( !file_exists( $upload_path ) ) {
			mkdir ( $upload_path, 0755, true );
		}

		$this->load->library('upload', $cfg);
		if ( ! $this->upload->do_upload('csv')) {
			$this->data['upload_status'] = $this->upload->display_errors();
		} else {
			$this->data['upload_status'] = $this->upload->data();
			$this->load->model('de/contest/Questions');
			$this->Questions->import($this->data['upload_status']['full_path']);
		}
		redirect('/contest/dashboard/index');
	}
	
	/*
	public function contestants() {
		$this->restricted('admin');
		$this->data['PAGE_TITLE'] = 'Contestants';
		$this->breadcrumbs->push('Contestants', '/contest/dashboard/contestants');
		$this->include_datatables_assets(true);
		$this->enqueue_resource('/resource/script/adminlte/contest/js/contests.php');
		$this->enqueue_resource('/resource/script/adminlte/contest/js/contestants.php');
		$this->dashboard('/adminlte/contest/contestants');
	}
	*/
	
	public function scoring() {
		$this->restricted('contest-scoring');
		$this->data['PAGE_TITLE'] = 'Scoring';
		$this->breadcrumbs->push('Scoring', '/contest/dashboard/scoring');
		$this->include_datatables_assets(true);
		
		$this->enqueue_style(array(
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css',
		));
		$this->enqueue_scripts(array(
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js'
		));
		
		$this->enqueue_resource('/resource/script/adminlte/contest/js/scoring.php');
		$this->enqueue_resource('/resource/script/adminlte/contest/js/questions.php');
		$this->enqueue_resource('/resource/script/adminlte/contest/js/contestants.php');
		$this->dashboard('/adminlte/contest/scoring');
	}
	
	public function score_summary() {
		$this->restricted('contest-score-summary');
		$this->data['PAGE_TITLE'] = 'Score Summary';
		$this->breadcrumbs->push('Result', '/contest/dashboard/score-summary');
		$this->include_datatables_assets(true);
	
		$this->enqueue_resource('/resource/script/adminlte/contest/js/score-summary.php');
		$this->dashboard('/adminlte/contest/score-summary');
	}
	
	public function get_contests($id = null, $id2 = null) {
		$this->restricted(array('contest-scoring', 'contest-score-summary'));
		parent::get($id, $id2);
		$this->load->model('de/ticket/ProductEvents');
		$this->ProductEvents->editor->where('event_type', 'contest');
		if ( $id ) {
			$this->ProductEvents->editor->where('status', $id);
		}
		$this->ProductEvents->get($id, $id2);
	}
	
	public function get_questions($id = null, $id2 = null) {
		$this->restricted(array('contest-scoring', 'contest-score-summary'));
		parent::get($id, $id2);
		$this->load->model('de/contest/Questions');
		$this->Questions->editor->where('event_id', $id);
		$this->Questions->get($id, $id2);
	}
	
	public function get_contestants($id = null, $id2 = null) {
		$this->restricted(array('contest-scoring', 'contest-score-summary'));
		parent::get($id, $id2);
		$this->load->model('de/contest/Contestants');
		$this->Contestants->init_editor_minimal();
		$this->Contestants->get($id, $id2);
	}
	
	public function get_score($id) {
		$this->restricted(array('contest-scoring', 'contest-score-summary'));
		$this->output->enable_profiler(false);
		
		$q = $this->db
			->get_where('cts_contestants', array('id' => $id));
			
		$contestant = $q->result();
		
		if ( ! $contestant ) show_404();
		
		$contestant = $contestant[0];
		
		if ( $_POST ) {
			$scores = $this->input->post();
			$scores['user_id'] = $this->user_id;
			$scores['event_id'] = $contestant->event_id;
			$this->db->replace('cts_scores', $scores);
		}
		
		$scores = $this->db->get_where('cts_scores', array(
			'answer_id' => $id,
			'user_id' => $this->user_id,
			'event_id' => $contestant->event_id
		))->result_array();
		
		//var_dump($contestant); die;
		//die(var_dump($scores));
		
		$q = $this->db
		->get_where('cts_questions',
			array(
				'event_id' => $contestant->event_id,
			)
		);
		
		$question = $q->result_array();

		$this->data['question']   = $question[0];
		$this->data['contestant'] = $contestant;
		$this->data['scores']     = $scores ? $scores[0] : $scores;
		
		$this->load->view('/adminlte/contest/score', $this->data);
	}
	
	public function get_score_breakdown($id) {
		$this->load->model('de/contest/Scores');
		$this->Scores->editor
			->where('answer_id', $id)
		;
		$this->Scores->get();
	}
	
	public function delete() {
		$this->restricted('admin');
		$event_id = $this->input->post('id');
		
		$contest = Model\Ticket\Product_events::where(array('id' => $event_id, 'event_type' => 'contest'))->get();
		if ( ! $contest ) show_404();
		
		$contest->deleteContest();
		
		redirect('/contest/dashboard');
	}

}