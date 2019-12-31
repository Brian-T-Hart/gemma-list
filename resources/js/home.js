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

	var checkboxLabel = event.target.parentElement;

	var taskForm = event.target.parentElement.parentElement;

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


// Delete a list
handleDelete = (id) => {

	event.preventDefault();

	var deleteForm = event.target.parentElement;

	var url = deleteForm.getAttribute('action');

	var confirmed = confirm('You are about to permanently delete this list.');

	if (confirmed) {

		var el = '#glist-container-' + id;

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

// sortable tasks
$( function() {

	$( ".sortable" ).sortable();

	$( ".sortable" ).on( "sortdeactivate", function(event, ui) {

		console.log(event.target);

		var sortedIDs = $( event.target ).sortable( "toArray" );

		var ids = sortedIDs.map(sortedID => parseInt(sortedID.split('_')[1]));

		ids = JSON.stringify(ids);

		console.log(ids);

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/tasks/reorder',
			type: 'POST',
			traditional: true,
			data: {ids:ids},
			dataType: 'json',
			success: function(data){
				console.log('data: ' + data);
				// console.log('successfully updated');
			},
			error: function(err){
				console.log(err);
			//   alert('Something went wrong. Please try again!');
			//   window.location.reload();
			}
		}); //end Ajax
	});
	
	$( ".sortable" ).disableSelection();
}); //end sortable

toggle = (id) => {
	$(id).toggle();
}