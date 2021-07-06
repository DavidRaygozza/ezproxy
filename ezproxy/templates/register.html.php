<?php if (!empty($errors)): ?>
	<div class="errors">
		<p>Your account could not be created, please check the following:</p>
		<ul>
		<?php foreach ($errors as $error): ?>
			<li><?= $error ?></li>
		<?php endforeach; 	?>
		</ul>
	</div>
<?php endif; ?>
<form action="" method="post">
    <label for="email">Your email address</label>
    <input name="author[email]" id="email" type="text" value="<?=$author['email'] ?? ''?>">
    
<!--
5/27/20 DavidR NEW/MOD 7L: Updated fname textbox entry when registering and added last name text box which will both be bassed to the database author table
-->
    <label for="fname">Your name</label>
    <input name="author[fname]" id="fname" type="text" value="<?=$author['fname'] ?? ''?>">

<label for="lname">Your name</label>
   <input name="author[lname]" id="lname" type="text" value="<?=$author['lname'] ?? ''?>">

    <label for="password">Password</label>
    <input name="author[password]" id="password" type="password" value="<?=$author['password'] ?? ''?>">
 
    <input type="submit" name="submit" value="Register account">
</form>
