<?php
	$users = get_users();
 ?>
 <h1><?= $args['plugin_name'] ?></h1>
<div id="Users">
	<?php foreach ($users as $key => $user) : 
		?>
		<div class="user-block" >
			<div><?= get_avatar($user->ID) ?></div>
			<div>
				<span class="sub">Login</span>
				<h3 class="login"><a href="<?= get_edit_user_link($user->ID) ?>"><?= $user->user_login ?></a></h3>
			</div>
			<div>
				<span class="sub">Name</span>
				<h3 class="name"><?= $user->display_name ?></h3>
			</div>
			<div>
				<span class="sub">E-mail</span>
				<h3 class="email"><a href="mailto:<?= $user->user_email ?>"><?= $user->user_email ?></a></h3>
			</div>
			<div>
				<span class="sub">Role</span>
				<h3 class="role"><?= $user->roles[0] ?></h3>
			</div>
		</div>
	<?php endforeach; ?>
	<p class="error"></p>
</div>