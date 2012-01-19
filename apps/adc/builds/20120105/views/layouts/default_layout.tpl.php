<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>jetstream</title>

		{COMPILE:__widget:html::js}
		{COMPILE:__widget:html::css}

	</head>

	<body>
		<div class="container">
			<nav class="clear span-25 last"><?= $this->widget('navigation::top') ?></nav>
			<div class="clear span-25 last" id="header">
				<div class="span-25 last">
					<div class="span-5"><?= $this->widget('site::logo') ?></div>
					<div class="span-10" id="header_promo"><?= $this->widget('site::headerpromo') ?></div>
					<div class="span-10 last" id="cust_service_container"><?= $this->widget('site::chat') ?></div>
				</div>
				<div class="clear span-25 last" id="top-nav"><?= $this->widget('navigation::main') ?></div>
				<div class="clear span-25 last"><?= $this->widget('navigation::search') ?></div>
			</div>
			<div class="clear span-25 last"><?= $this->buffer('template') ?></div>
			<div class="clear span-25 last"><?= $this->widget('site::footer') ?></div>

			<div class="clear span-25 last">{COMPILE:__widget:profiler::report}</div>
			<div class="clear span-25 last">{COMPILE:__widget:console::view}</div>


		</div>


	</body>


</html>




