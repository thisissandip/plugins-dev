document.addEventListener('DOMContentLoaded', () => {
	let form = document.querySelector('#sandip-plugin-auth-form');
	let loginshow = document.querySelector('.login-show');
	let closebtn = document.querySelector('.close-btn');

	let msg = document.querySelector('.msgofform');

	loginshow.addEventListener('click', () => {
		form.style.right = '30px';
		loginshow.style.right = '-100px';
	});

	closebtn.addEventListener('click', () => {
		form.style.right = '-100%';
		loginshow.style.right = '40px';
	});

	form.addEventListener('submit', (e) => {
		e.preventDefault();

		msg.innerHTML = '';

		let url = form.getAttribute('data-url');
		let data = {
			username: document.querySelector('#username').value,
			password: document.querySelector('#password').value,
			nonce: document.querySelector('#sandip_auth').value,
		};

		if (data.name == '' || data.password == '') {
			msg.innerHTML = 'Fields Are Required';
			return;
		}
		msg.innerHTML = '';

		let formdata = new URLSearchParams(new FormData(form));

		fetch(url, {
			method: 'POST',
			body: formdata,
		})
			.then((result) => result.json())
			.catch((err) => {
				msg.innerHTML = 'Incorrect Username Or Password';
			})
			.then((response) => {
				msg.innerHTML = `${response.message}`;
				form.reset();
				if (response.status) {
					msg.style.color = 'green';
					window.location.reload();
				}
			});
	});
});
