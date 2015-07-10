<?php
session_start();
$theme = isset($_SESSION['theme'])?$_SESSION['theme']:false;

?>
<html manifest="manifest.php">
<head>
	<title>Themeable manifest and master POC</title>
	<style>@media(min-width:30em){.row{display:-webkit-flex;-webkit-flex-wrap:nowrap;display:flex;flex-wrap:nowrap}.col{-webkit-flex-grow:1;flex-grow:1}}</style>
	<style>@media(min-width:30em){.row.vertical{-webkit-flex-direction:column;flex-direction:column;}}</style>
	<link href="<?= $theme?'theme/'.$theme:'theme' ?>.css" type="text/css" rel="stylesheet">
</head>
<body class="row vertical">
		<h1 class="col">Themeable manifest and master POC</h1>
		<p class="col">The loaded theme is <code><?= $theme?:'default' ?></code>. <button id="fetch" type="button">Fetch API</button></p>
		<div id="target" class="col">Not fetched yet</div>
		<div class="row col">
		<?php foreach(array('default', 'green', 'blue',) as $i_theme) { ?>
			<button class="col switch-theme" data-theme="<?= $i_theme ?>" type="button"><?= $i_theme ?></button>
		<?php } ?>
<script>
	/**
	 * This code is triggered when the theme is switched and a manifest update is done
	 */
	applicationCache.addEventListener('updateready', function() {
		window.location.reload();
	}, false);
	
	var $fetchBtn = document.getElementById('fetch');
	var $target = document.getElementById('target');
	$fetchBtn.addEventListener('click', function() {
		var json = false;
		var r = new XMLHttpRequest();
		r.open('GET', 'api.php', true);
		r.onreadystatechange = function () {
			if (r.readyState != 4 || r.status != 200) return;
			if( (json = JSON.parse(r.responseText)) ) {
				$target.textContent = json.data;
			}
		};
		r.send(null);
	}, false);

	var $switchBtns = document.querySelectorAll('.switch-theme');
	for(var i=0;i<$switchBtns.length;++i) {
		$switchBtns[i].addEventListener('click', function() {
			var r = new XMLHttpRequest();
			r.open('GET', 'api.php?theme='+this.getAttribute('data-theme'), true);
			r.onreadystatechange = function () {
				if (r.readyState != 4 || r.status != 200) return;
				if(JSON.parse(r.responseText).success) {
					applicationCache.update();
				}
				else {
					$target.textContent = 'Can\'t switch theme while offline';
				}
			};
			r.send(null);
		}, false);
	}
</script>
</body>
</html>
