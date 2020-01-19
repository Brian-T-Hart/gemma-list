// handle check box
handleCheck = () => {
	event.preventDefault();
	var checkboxLabel = event.target.nextElementSibling;
	var taskForm = event.target.parentElement;
    var url = taskForm.getAttribute('action');
    $(checkboxLabel).toggleClass('is-completed');
    
	$.ajax({
		url: url,
		type: 'post',
		data: $(taskForm).serialize(),
		dataType: 'json',
        success: function( _response ){
			console.log('update successful');
		},
        error: function( _response ){
		  alert('Something went wrong. Please try again!');
		  window.location.reload();
		}
	});
}//end handle check box

handleTaskEdit = (id) => {
    $('#edit-task-form-' + id).toggle();
    $('#task_' + id).toggle();
}

handleBtnCheck = () => {
	if (event.target.value.length > 0) {
		event.target.nextElementSibling.style.visibility = 'visible';
	}
	else {
		event.target.nextElementSibling.style.visibility = 'hidden';
	}
}

handleTaskEditCancel = (id) => {
	event.preventDefault();
	$('#task_' + id).toggle();
	$('#edit-task-form-' + id).toggle();
}

// edit task title
handleTaskEditSubmit = (id) => {
	event.preventDefault();
	const taskForm = (event.target);
	var data = $(taskForm).serialize();
	data = data + '&id=' + id;
	const url = taskForm.getAttribute('action');

	$.ajax({
		url: url,
		type: 'post',	
		data: data,
		dataType: 'json',
        success: function( _response ){
			console.log('update successful', _response);
			var label = document.getElementById('task-label-' + id);
			label.innerText = taskForm.title.value;
			handleTaskEdit(id);
		},
        error: function( _response ){
		  alert('Something went wrong. Please try again!');
		  window.location.reload();
		}
	});
} //end edit task title

// sortable tasks
$( function() {
	$( ".sortable-tasks" ).sortable();

	$( ".sortable-tasks" ).on( "sortdeactivate", function(event) {
		console.log(event.target.id.split('-')[0]);

		if (event.target.id.split('-')[0] === 'task') {
			var sortedTaskIDs = $( event.target ).sortable( "toArray" );
			var taskIds = sortedTaskIDs.map(sortedTaskID => parseInt(sortedTaskID.split('_')[1]));
			taskIds = JSON.stringify(taskIds);

			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/tasks/reorder',
				type: 'POST',
				traditional: true,
				data: {ids:taskIds},
				dataType: 'json',
				success: function(){
					console.log('task order successfully updated');
				},
				error: function(){
				alert('Something went wrong. Please try again!');
				window.location.reload();
				}
			}); //end Ajax
		} //end if
	}); //end sortdeactivate
	
	$( ".sortable-tasks" ).disableSelection();
}); //end sortable-tasks