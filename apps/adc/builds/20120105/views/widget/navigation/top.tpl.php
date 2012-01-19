<?php
$account_home = $this->route->url('account-home', array('vmarket' => $vmarket));
$support_home = $this->route->url('support-home', array('vmarket' => $vmarket));

$links = array(
	'home' => array('url' => $this->route->url('home'), 'label' => 'Home'),
	'real-estate' => array('url' => $this->route->url('vmarket-home', array('vmarket' => 'real-estate')), 'label' => 'Real Estate'),
	'vehicles' => array('url' => $this->route->url('vmarket-home', array('vmarket' => 'vehicles')), 'label' => 'Vehicles'),
	'boats' => array('url' => $this->route->url('vmarket-home', array('vmarket' => 'boats')), 'label' => 'Boats'),
	'industrial' => array('url' => $this->route->url('vmarket-home', array('vmarket' => 'industrial')), 'label' => 'Industrial'),
);
?>


	<ul class="nav">

<?php foreach ( $links as $name => $info ):
	$class = ($vmarket == $name) ? 'active' : '';
	?>
		<li class="<?=$class?>"><a href="<?=$info['url']?>"><?=$info['label']?></a></li>
<?php endforeach; ?>

	</ul>

	<ul class="nav secondary-nav">


		<li class="dropdown" data-dropdown="dropdown"><a class="dropdown-toggle" href="<?= $account_home ?>">Welcome colynb</a>
			<ul class="dropdown-menu">
				<li><a href="<?= $account_home ?>">My Account</a></li>
				<li><a href="<?= $account_home ?>/dashboard">My Dashboard</a></li>
				<li><a href="<?= $account_home ?>/dashboard/activity:alerts#activity">My Alerts</a></li>
				<li class="divider"></li>
				<li><a href="?logout=true">Logout</a></li>

			</ul>
		</li>

		<li><a href="#about">Licensing</a></li>

		<li class="dropdown" data-dropdown="dropdown"><a class="dropdown-toggle" href="<?= $support_home ?>">Customer Support</a>
			<ul class="dropdown-menu align-right">
				<li><a href="<?= $support_home ?>">Main</a></li>
				<li><a href="<?= $support_home ?>/faq">FAQ</a></li>
				<li><a href="<?= $support_home ?>/how-to">How To Videos</a></li>

			</ul>
		</li>

	</ul>
