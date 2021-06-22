//<script><?php restricted(array('contest-scoring', 'contest-score-summary')); ?>

$(document).ready(function() {
	debug('LOAD: <?php echo $path; ?>');
});

function br(d,t,r) { return 'display' === t && d ? '<span>'+d.split("\n").join("<br />")+'</span>' : d; }

function setSlider() {
	$('.slider').bootstrapSlider({
		tooltip_position: 'bottom',
		_rangeHighlights: [
			{ "start": '0',  "end": '50%',  "class": "category1" },
			{ "start": '50%', "end": '100%',  "class": "category2" },
		]
	});
}

function submitScore() {
	$("#submit-score").css('display', 'inline');
	$('#submit-score').on('click', function(e) {
		e.preventDefault();
		$.confirm({
			icon: 'fa fa-trophy',
			title: 'Submit Score',
			theme: 'material',
			backgroundDismiss: false,
			buttons: {
				Cancel: {
					btnClass: 'btn-secondary',
				},
				OK: {
					btnClass: 'btn-primary',
					action: function () {
						var f = $('#form-score');
						
						var request = $.ajax({
							type:'POST',
							url: f[0].action,
							cache: false,
							data: f.serializeArray(),
						});
						request.done(function (html) {
							$('#score').html(html);
							setSlider();
							$.alert({
								title: 'Thank You',
								content: 'Scores saved. Thank you.',
								backgroundDismiss: true,
							});
							Contestants.datatable.ajax.reload();
							submitScore();
						});

					}
				},
			},
			content: 'Are you sure ?',
		});
	});
}

var scoreBuff = '';

var Contestants;

function OpenContestants(event_id, status = '', opts = null) {

	var questionCnt = 0;
	var CONTESTANTS_COLUMNS = [
/*
		{
			data: 'cts_contestants.status',
			title: 'Status',
			sClass: 'exportable',
			render: function ( d, t, r ) {
				if ( 'display' === t ) {
					return ucwords(d);
				}
				return d;
			},
			visible: false,
		},
*/
		{
			data: 'cts_contestants.timestamp',
			title: 'Date',
			sClass: 'exportable',
		},

		{ data: 'cts_contestants.a01', title: 'Field 1',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
/*		{ data: 'cts_contestants.a02', title: 'Field 2',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a03', title: 'Field 3',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a04', title: 'Field 4',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a05', title: 'Field 5',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a06', title: 'Field 6',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a07', title: 'Field 7',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a08', title: 'Field 8',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a09', title: 'Field 9',  sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a10', title: 'Field 10', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a11', title: 'Field 11', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a12', title: 'Field 12', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a13', title: 'Field 13', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a14', title: 'Field 14', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a15', title: 'Field 15', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a16', title: 'Field 16', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); } },
		{ data: 'cts_contestants.a17', title: 'Field 17', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a18', title: 'Field 18', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a19', title: 'Field 19', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a20', title: 'Field 20', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a21', title: 'Field 21', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a22', title: 'Field 22', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a23', title: 'Field 23', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a24', title: 'Field 24', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a25', title: 'Field 25', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a26', title: 'Field 26', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a27', title: 'Field 27', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a28', title: 'Field 28', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a29', title: 'Field 29', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },
		{ data: 'cts_contestants.a30', title: 'Field 30', sClass: 'exportable', render: function(d,t,r) { return br(d,t,r); }, visible: false },

		{
			data: 'cts_contestants.hash',
			title: 'Hash',
			sClass: 'exportable',
			visible: false,
		},
*/
		{
			data: null,
			title: 'Progress',
			sClass: 'roboto-mono ext-center',
			render: function ( d, t, r ) {
				if ( 'display' === t ) {
					var scoreCnt = 0;
					if ( 0 == questionCnt ) {
						for(q in r.cts_questions) {
							if ( 1 == r.cts_questions[q] ) {
								questionCnt++;
							}
						}
					}
					for(s in r.cts_scores) {
						if ( 'id' == s ) continue;
						if ( null != r.cts_scores[s] && 0 != r.cts_scores[s] ) {
							scoreCnt++;
						}
					}
					var complete = 0;
					if ( scoreCnt && questionCnt ) {
						complete = parseInt(scoreCnt/questionCnt*100);
					}
				}
				return (complete == 100 ? '<i class="fa fa-check text-green"></i> ' : '<i class="fa fa-spinner fa-spin text-green"></i> ') + complete+'%';
			},
			sortable: false,
		},
		{
			data: null,
			title: 'Score Total',
			sClass: 'roboto-mono text-right',
			render: function ( d, t, r ) {
				if ( 'display' === t ) {
					var scoreTotal = 0;
					/*
					if ( 0 == questionCnt ) {
						for(q in r.cts_questions) {
							if ( 1 == r.cts_questions[q] ) {
								questionCnt++;
							}
						}
					}
					*/
					for(s in r.cts_scores) {
						if ( 'id' == s ) continue;
						if ( null != r.cts_scores[s] && 0 != r.cts_scores[s] ) {
							scoreTotal += parseInt(r.cts_scores[s]);
						}
					}
					//var scoreAvg = scoreTotal/questionCnt;
					//scoreAvg = scoreAvg ? scoreAvg : 0;
					
					return ('******'+scoreTotal).slice(-5).replace(/\*/g, '&nbsp;')+' pts';
				}
				return d;
			},
			sortable: false
		},
		{
			data: null,
			title: 'Score Avg.',
			sClass: 'roboto-mono text-right',
			render: function ( d, t, r ) {
				if ( 'display' === t ) {
					var scoreTotal = 0;
					for(s in r.cts_scores) {
						if ( 'id' == s ) continue;
						if ( null != r.cts_scores[s] && 0 != r.cts_scores[s] ) {
							scoreTotal += parseInt(r.cts_scores[s]);
						}
					}
					var scoreAvg = scoreTotal/questionCnt;
					scoreAvg = scoreAvg ? scoreAvg : 0;
					
					return ('******'+parseInt(scoreAvg)).slice(-5).replace(/\*/g, '&nbsp;')+' pts';
				}
				return d;
			},
			sortable: false
		}
	];

	var Contestants_CONTAINER_SELECTOR = '#contestants-editor';
	var Contestants_Config = {
		CONTAINER_SELECTOR: Contestants_CONTAINER_SELECTOR,

		EDITOR_CONFIG: {
			ajax: { url: '/contest/dashboard/get_contestants/'+event_id+'/'+status, type: 'POST' },
			table: Contestants_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Status <sup>*</sup>',
					name: 'cts_contestants.status',
					attr: {
						required: true,
					},
					type:  "radio",
					options: [
						{ label: "Approved", value: 'approved' },
						{ label: "Declined",  value: 'declined' }
					],
					def: 'approved'
				},
			],
			canRemove: false,
		},

		DATATABLE_CONFIG: {
			editTitle: 'Edit Contestants',
			ajax: { url: '/contest/dashboard/get_contestants/'+event_id+'/'+status, type: 'POST' },
			order: [[ 1, 'asc' ]],
			scroller: true,
			responsive: true,
			columns: CONTESTANTS_COLUMNS,
			createdRow: function( row, data, dataIndex ) {
				//debug(data.cts_contestants.status);
				if ( data.cts_contestants.status == "declined" ) {
					$(row).addClass( 'danger' );
				}
			},
			canCreate: false,
		},
		
	};
	
	if ( opts && ! opts.canEdit ) Contestants_Config.EDITOR_CONFIG = null;
	
	Contestants = InitDatatableEditor( Contestants_Config );
	
	Contestants.datatable.on('select', function(e, dt, node, config) {
		if ( ! dt ) return;
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		contestantId = rows[0].cts_contestants.id;
		scoreBuff = $("#score").html();
		$("#score").load("/contest/dashboard/get_score/"+contestantId, function() {
			setSlider();
			submitScore();
		});
	});
	Contestants.datatable.on('deselect', function(e, dt, node, config) {
		$("#score").empty().html('Please specify a contestant');
		$('#submit-score').unbind('click');
		$("#submit-score").css('display', 'none');
	});
}

