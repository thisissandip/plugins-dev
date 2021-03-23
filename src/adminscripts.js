let allmenuitems = document.querySelectorAll('.menu-item');

allmenuitems.forEach((item) => {
	item.addEventListener('click', displayContainer);
});

function displayContainer(e) {
	document.querySelector('a.active').classList.remove('active');
	document.querySelector('div.active').classList.remove('active');

	let clicked = e.target;
	clicked.classList.add('active');
	let clickedTargetHref = clicked.getAttribute('href');
	let targetDiv = document.querySelector(`${clickedTargetHref}`);
	targetDiv.classList.add('active');
}

jQuery(document).ready(function ($) {
	$(document).on('click', '.js-img-upload', function (e) {
		e.preventDefault();

		var $button = $(this);

		var file_frame = (wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image', // mime type
			},
			button: {
				text: 'Select Image',
			},
			multiple: false,
		}));

		file_frame.on('select', function () {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.inp-img-upload').val(attachment.url);
		});

		file_frame.open();
	});
});
