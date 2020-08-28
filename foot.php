<script>
	function updateTheme(dark) {
		var nav = document.querySelector('.navbar')
		if (dark) {
			document.body.classList.remove('bootstrap')
			document.body.classList.add('bootstrap-dark')
			nav.classList.remove('navbar-light')
			nav.classList.add('navbar-dark')
			nav.classList.remove('bg-light')
		} else {
			document.body.classList.add('bootstrap')
			document.body.classList.remove('bootstrap-dark')
			nav.classList.add('navbar-light')
			nav.classList.remove('navbar-dark')
			nav.classList.add('bg-light')
		}
	}
	window.matchMedia('(prefers-color-scheme: dark)').addListener(e => updateTheme(e.matches))
	updateTheme(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
</script>