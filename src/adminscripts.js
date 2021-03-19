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
