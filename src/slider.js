document.addEventListener('DOMContentLoaded', () => {
	let slider = document.querySelector('.slider');
	let allSlides = document.querySelectorAll('.single-slide-container');

	let leftBtn = document.querySelector('.arrow-left');
	let rightBtn = document.querySelector('.arrow-right');

	rightBtn.addEventListener('click', () => beforeSliding(1));
	leftBtn.addEventListener('click', () => beforeSliding(-1));

	const beforeSliding = (i) => {
		let theactiveItem = document.querySelector(
			'.single-slide-container.is-active'
		);
		let indexOfActive = Array.from(allSlides).indexOf(theactiveItem);
		let indexOfnextItem = indexOfActive + i;

		let nextItem = allSlides[indexOfnextItem];
		if (nextItem) {
			theactiveItem.classList.remove('is-active');
			nextItem.classList.add('is-active');

			let slideamount = nextItem.offsetLeft;

			slider.style.transform = `translateX(-${slideamount}px)`;
		}
	};
});
