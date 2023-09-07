function prepareBackground() {
	let mbdy = document.getElementById('base_main_body');
	let div_dispatch_btn = document.getElementById('div_dispatch_btn');
	if (mbdy.offsetWidth > 1000) {
		div_dispatch_btn.style.marginLeft = '18px';
	} else {
		div_dispatch_btn.style.marginLeft = '-12px';
	}

	document.getElementById('base_main_body').style.backgroundColor = '#f0e68c';
}