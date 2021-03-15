
handleShareList = (id) => {
	event.preventDefault();
	const shareForm = (event.target);
	var data = $(shareForm).serialize();
	const formId = shareForm.getAttribute('id');
	const url = shareForm.getAttribute('action');
	const method = shareForm.getAttribute('method');

	toggle(`#${formId} .btn-check`);
	toggle(`#${formId} .btn-cancel`);
	$(`#${formId} .spinner`).css('display', 'inline-block');

	$.ajax({
		url: url,
		type: method,	
		data: data,
		dataType: 'json',
        success: function( _response ){
			alert(_response.message);
			shareForm.email.value = '';
			toggle(`#share-list-${id}`);
			toggle(`#${formId} .btn-check`);
			toggle(`#${formId} .btn-cancel`);
			$(`#${formId} .spinner`).css('display', 'none');
		},
        error: function( _response ){
			// console.log('share successful error', _response);
			alert(_response.message);
		}
	});
}// handleShareList


handleShareLeave = (id) => {
	event.preventDefault();
	var confirmed = confirm('You are about to remove yourself from the shared list. The only way to access the list, once you are removed, is to be re-invited by the list owner. Are you sure you want to leave?');

	if (confirmed) {
		let leaveForm = event.target.parentElement;
		let url = leaveForm.getAttribute('action');
		let el = '#glist-container_' + id;
		toggle(el);

		$.ajax({
			url: url,
			type: 'post',
			data: $(leaveForm).serialize(),
			dataType: 'json',
			success: function(res){
				console.log('successfully left', res);
			},
			error: function(){
			  alert('Something went wrong. Please try again!');
			  window.location.reload();
			}
		});
	}
}//handleShareLeave