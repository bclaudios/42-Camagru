document.addEventListener('click', function (event) {
	if (event.target.matches('#burger')) {
        const menu = document.getElementById('menu');
        const burger = document.getElementById('burger');
        menu.classList.toggle('is-active');
        burger.classList.toggle('is-active');
	}
}, false);