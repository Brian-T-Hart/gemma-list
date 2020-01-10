//edit glist event listener
var editGlistBtn = document.querySelectorAll('.edit-glist-btn');

for (var i = 0; i < editGlistBtn.length; i++) {

	editGlistBtn[i].addEventListener('click', function() {

		var glistId = this.getAttribute('data-id');

		var headerId = 'glist-header-' + glistId;

		var formId = 'edit-glist-' + glistId;

		var cancelBtnId = 'close-edit-' + glistId;

		var glistHeader = document.getElementById(headerId);

		var formElement = document.getElementById(formId);

		var cancelBtn = document.getElementById(cancelBtnId);

		glistHeader.classList.add('hidden');

		formElement.classList.remove('hidden');

		cancelBtn.addEventListener('click', function() {

			event.preventDefault();

			formElement.classList.add('hidden');

			glistHeader.classList.remove('hidden');

		})

	})

}//end edit glist


// check box
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
	
}//end check box

handleTaskEdit = (id) => {
	$('#edit-task-form-' + id).toggle();
	$('#task_' + id).toggle();
}

handleTaskEditCancel = (id) => {
	event.preventDefault();
	$('#task_' + id).toggle();
	$('#edit-task-form-' + id).toggle();
}

handleTaskEditSubmit = (id) => {

	event.preventDefault();

	const taskForm = (event.target);

	var data = $(taskForm).serialize();

	data = data + '&id=' + id;
	console.log('data', data);

	const url = taskForm.getAttribute('action');
	console.log('url', url);

	$.ajax({

		url: url,

		type: 'post',
		
		data: data,
		
		dataType: 'json',
		
        success: function( _response ){

			console.log('update successful', _response);

			window.location.reload();

		},
		
        error: function( _response ){

		  alert('Something went wrong. Please try again!');

		  window.location.reload();

		}
		
	});
} 


// Delete a list
handleDelete = (id) => {

	event.preventDefault();

	var deleteForm = event.target.parentElement;

	var url = deleteForm.getAttribute('action');

	var confirmed = confirm('You are about to permanently delete this list.');

	if (confirmed) {

		var el = '#glist-container_' + id;

		toggle(el);

		$.ajax({

			url: url,

			type: 'post',

			data: $(deleteForm).serialize(),

			dataType: 'json',

			success: function(){

				console.log('successfully deleted');

			},

			error: function(){

			  alert('Something went wrong. Please try again!');

			  window.location.reload();
			}
		});
	}
} //end delete a list

// sortable lists
$( function() {

	$( ".sortable-lists" ).sortable();

	$( ".sortable-lists" ).on( "sortdeactivate", function(event) {

		console.log('list event.target', event.target);

		if (event.target.id === 'lists-container') {

			var sortedIDs = $( event.target ).sortable( "toArray" );

			var ids = sortedIDs.map(sortedID => parseInt(sortedID.split('_')[1]));

			ids.pop();

			ids = JSON.stringify(ids);

			console.log(ids);

			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/glists/reorder',
				type: 'POST',
				traditional: true,
				data: {ids:ids},
				dataType: 'json',
				success: function(){
					console.log('list successfully updated');
				},
				error: function(){
				alert('Something went wrong. Please try again!');
				window.location.reload();
				}
			}); //end Ajax
		} //end if
	}); //end sortdeactivate
	
	$( ".sortable-lists" ).disableSelection();
}); //end sortable-lists

// sortable tasks
$( function() {

	$( ".sortable-tasks" ).sortable();

	$( ".sortable-tasks" ).on( "sortdeactivate", function(event) {

		console.log(event.target);

		if (event.target.id === 'tasks-container') {

			var sortedTaskIDs = $( event.target ).sortable( "toArray" );

			var taskIds = sortedTaskIDs.map(sortedTaskID => parseInt(sortedTaskID.split('_')[1]));

			taskIds = JSON.stringify(taskIds);

			console.log(taskIds);

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

toggle = (id) => {
	$(id).toggle();
}