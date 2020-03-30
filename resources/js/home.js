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
	$( ".sortable-lists" ).sortable({
		handle: ".fa-grip-horizontal"
	});

	$( ".sortable-lists" ).on( "sortdeactivate", function(event) {
		if (event.target.id === 'lists-container') {
			var sortedIDs = $( event.target ).sortable( "toArray" );
			var ids = sortedIDs.map(sortedID => parseInt(sortedID.split('_')[1]));
			ids = JSON.stringify(ids);

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

toggle = (id) => {
	$(id).toggle();
}

scrollToMore = () => {
	console.log("clicked to scroll");
	var el = document.getElementById('more');
	el.scrollIntoView({behavior: "smooth"});
}