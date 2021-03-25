document.addEventListener('DOMContentLoaded', () => {
	let Form = document.querySelector('#sandip-testimonial-form');

	Form.addEventListener('submit', (e) => {
		e.preventDefault();

		resetERRMessages();

		let Url = Form.getAttribute('data-url');

		let data = {
			name: Form.querySelector('#name').value,
			email: Form.querySelector('#email').value,
			message: Form.querySelector('#message').value,
			nonce: Form.querySelector('#nonce').value,
		};

		if (!data.name) {
			document
				.querySelector("[data-error='invalidName']")
				.classList.add('show');
			return;
		}
		if (!validateEmail(data.email)) {
			document
				.querySelector("[data-error='invalidEmail']")
				.classList.add('show');
			return;
		}
		if (!data.message) {
			document
				.querySelector("[data-error='invalidMessage']")
				.classList.add('show');
			return;
		}

		document.querySelector('.js-form-submission').classList.add('show');

		let formData = new URLSearchParams(new FormData(Form));

		fetch(Url, {
			method: 'POST',
			body: formData,
		})
			.then((result) => result.json())
			.catch((err) => {
				resetERRMessages();
				Form.querySelector('.js-form-error').classList.add('show');
				console.log(err);
			})
			.then((response) => {
				resetERRMessages();

				if (response === 0 || response.status === 'error') {
					Form.querySelector('.js-form-error').classList.add('show');
					return;
				}

				Form.querySelector('.js-form-success').classList.add('show');
				Form.reset();
			});
	});
});

function resetERRMessages() {
	let allERRfields = document.querySelectorAll('.field-msg');
	allERRfields.forEach((i) => {
		i.classList.remove('show');
	});
}

function validateEmail(email) {
	let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}
