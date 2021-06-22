

(function ($, window, undefined) {
	
	debug('app/my/my-task.js loaded');
	
	$('#mark-as-done').on('click', function() {

		var taskId = $(this).data('task-id');
		
		$.confirm({
			icon: 'fa fa-check',
			title: 'Task Completion',
			theme: 'supervan green',
			content: function(){
				var self = this;
				
				return $.ajax({
					url: '/my/my_task/confirm_done/'+taskId,
					method: 'get'
				}).done(function (response) {
					self.setContentPrepend(response);
					self.buttons.Yes.enable();
				}).fail(function(response){
					debug(response);
					self.setContentPrepend('ERROR');
					self.buttons.Yes.disable();
				}).always(function(response){
					
				});
			},
			columnClass: 'medium',
			buttons: {
				Yes: {
					disabled: true,
					btnClass: 'btn-blue',
					action: function () {
						$form = this.$content.find('form');
						debug($form.serialize());
						$form.submit(function (e) {
							e.preventDefault();
							data = $form.serialize();
							$form.empty();
							$.ajax({
								type: $form.attr('method'),
								url: $form.attr('action'),
								data: data,
								success: function (response) {
									$form.empty();
									$.confirm({
										title: 'Success',
										theme: 'supervan green',
										content: 'Task updated successfull.',
										buttons: {
											Close: function() {
												location.reload();
											}
										}
									});
								},
								error: function (response, err_msg, err_code) {
									debug(response);
									$.confirm({
										title: err_code,
										content: response.responseJSON.err_msg,
										theme: 'supervan red',
										buttons: {
											Close: {
												
											}
										}
									});
								}
							});
							
						});
						$form.trigger('submit');
					}
				},
				No: {
					btnClass: 'btn-red',
				},
			}
		});
	});
	
	
	$('#mark-as-cancel').on('click', function() {

		var taskId = $(this).data('task-id');
		
		$.confirm({
			icon: 'fa fa-warning',
			title: 'Task Cancelation',
			theme: 'supervan red',
			content: function(){
				var self = this;
				return $.ajax({
					url: '/my/my_task/confirm_cancel/' + taskId,
					method: 'json',
				})
				.done(function (response) {
					self.setContentPrepend(response);
					self.buttons.Yes.disable();
				})
				.fail(function(response){
					if(response.responseJSON){
						self.setContentPrepend(response.responseJSON.err_msg);
					}else{
						self.setContentPrepend(response);
					}
					self.buttons.Yes.disable();
				})
				.always(function(response){

				})
				;
			},
			columnClass: 'medium',
			buttons: {
				Yes: {
					disabled: true,
					btnClass: 'btn-blue',
					action: function () {
						$form = this.$content.find('form');
						debug($form.serialize());
						$form.submit(function (e) {
							e.preventDefault();
							data = $form.serialize();
							$form.empty();
							$.ajax({
								type: $form.attr('method'),
								url: $form.attr('action'),
								data: data,
								success: function (response) {
									$form.empty();
									debug($form.serialize());
									$.confirm({
										title: 'Success',
										theme: 'supervan green',
										content: 'Task updated successfull.',
										buttons: {
											Close: function() {
												location.reload();
											}
										}
									});
								},
								error: function (response, err_msg, err_code) {
									debug(response);
									$.confirm({
										title: err_code,
										content: response.responseJSON.err_msg,
										theme: 'supervan red',
										buttons: {
											Close: {
												
											}
										}
									});
								}
							});
							
						});
						$form.trigger('submit');
					}
				},
				No: {
					btnClass: 'btn-red',
				},
			},
			onContentReady: function() {
				self = this;
				$required = this.$content.find('[required]').each(function() {
					$(this).on('change keyup', function() {
						if( $(this).val().trim() !== '' ) {
							self.buttons.Yes.enable();
						} else {
							self.buttons.Yes.disable();
						}
					});
				});
			}
		});
	});
	
	function openLocationPicker(element) {
		debug('openLocationPicker');
		
		$('#event-place-locationpicker')
			.toggle()
			.locationpicker({
				location: {
					latitude: -6.1744651,
					longitude: 106.82274499999994
				},
				radius: 300,
				inputBinding: {
					locationNameInput: $('#event-place'),
				},
				enableAutocomplete: true,
			})
			.width('100%')
			.height('200px');
			
	}
	
	$('#mark-as-postpone').on('click', function() {

		var taskId = $(this).data('task-id');
		
		$.confirm({
			icon: 'fa fa-hourglass-half',
			title: 'Postpone',
			theme: 'supervan purple',
			
			onContentReady: function(){
				self = this;
				$required = this.$content.find('[required]').each(function() {
					$(this).on('change keyup', function() {
						if( $(this).val().trim() !== '' ) {
							self.buttons.Yes.enable();
						} else {
							self.buttons.Yes.disable();
						}
					});
				});
				
                $('.datetimepicker').datetimepicker({
					keepOpen: true,
					showClear: true,
					showTodayButton: true,
					showClose: true,
					locale: 'id',
					ignoreReadonly: true,
				});
				$('#btn-locationpicker').on('click', openLocationPicker);
            },
            onClose: function(){
                $(".datepicker").datepicker("destroy");
            },
			content: function(){
				var self = this;
				
				return $.ajax({
					url: '/my/my_task/confirm_postpone/'+taskId,
					method: 'get'
				}).done(function (response) {
					self.setContentPrepend(response);
					self.buttons.Yes.disable();
				}).fail(function(response){
					debug(response);
					self.setContentPrepend('ERROR');
					self.buttons.Yes.disable();
				}).always(function(response){
					
				});
			},
			columnClass: 'medium',
			buttons: {
				Yes: {
					disabled: true,
					btnClass: 'btn-blue',
					action: function () {
						$form = this.$content.find('form');
						$form.submit(function (e) {
							e.preventDefault();
							data = $form.serialize();
							$form.empty();
							$.ajax({
								type: $form.attr('method'),
								url: $form.attr('action'),
								data: data,
								success: function (response) {
									$form.empty();
									$.confirm({
										title: 'Success',
										theme: 'supervan green',
										content: 'Task updated successfull.',
										buttons: {
											Close: function() {
												location.reload();
											}
										}
									});
								},
								error: function (response, err_msg, err_code) {
									$.confirm({
										title: err_code,
										content: response.responseJSON.err_msg,
										theme: 'supervan red',
										buttons: {
											Close: {
												
											}
										}
									});
								}
							});
							
						});
						$form.trigger('submit');
					}
				},
				No: {
					btnClass: 'btn-red',
				},
				Reset: {
					action: function() {
						$form = this.$content.find('form');
						$form.trigger('reset');
						return false;
					}
				}
			}
		});
	});
    
    $('#request-grab').on('click', function() {
        
        var taskId = $(this).data('task-id');
        
        $.confirm({
            icon: 'fa fa-motorcycle',
            title: 'Grab for Business',
            theme: 'supervan green',
            content: 'Are you sure want to request a Grab Voucher?',
            columnClass: 'medium',
            buttons: {
                OK: {
                    btnClass: 'btn-green',
                    action: function() {
                        $('form')
                            .attr('action', '/my/my_task/request_grab/'+taskId)
                            .submit();
                    }
                    
                },
                Cancel: {
                    btnClass: 'btn-red',
                    
                }
            }
            
        });
    });

  
})(jQuery, window);