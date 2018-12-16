var editGlistBtn = document.querySelectorAll('.edit-glist-btn');

for (var i = 0; i < editGlistBtn.length; i++) {
	editGlistBtn[i].addEventListener('click', function() {
		var glistId = this.getAttribute('data-id');
		var headerId = 'glist-header-' + glistId;
		var glistHeader = document.getElementById(headerId);
		glistHeader.classList.add('hidden');

		var formId = 'edit-glist-' + glistId;
		var formElement = document.getElementById(formId);
		formElement.classList.remove('hidden');
	})
}