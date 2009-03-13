<?php include "inc/head.php" ?>


<!-- ! Buttons -->
<div id="buttons" class="corners">
	<span id="btnShowLogin" class="button corners">Login</span>
	<span id="btnFilters" class="button corners">Filters</span>
	<span id="btnLogout" class="button corners">Logout</span>
	<span id="btnPDX" class="button corners">PDX</span>
	<span id="btnAUS" class="button corners">SXSW</span>
	<span class="curparams">
		<span id="status">
		<?php 
		if (!empty($_SESSION['u'])) {
				$u = $_SESSION['u'];
		} ?>You are logged in as <?php echo $u; ?></span>
	</span>
</div>


<!-- ! Login Form -->
<div id="login">
<form id="frmLogin" action="" method="post">
	<div class="fieldset">
	<fieldset>
		<label for="username">Your Shizzow ID: </label><input type="text" name="username" id="username" />
		<label for="password">Your Shizzow Password: </label><input type="password" name="password" id="password" />		
		<input type="submit" value="Login" name="btnLogin" id="btnLogin" />
		<input type="hidden" name="f" id="f" value="shizzeeps" />
	</fieldset>
	</div>
</form>
</div><!-- // login -->

<!-- ! Filters Form -->
<div id="filters">
<form id="frmFilters" action="" method="post">
	<div class="fieldset">
	<fieldset>
		<label for="city">City: </label><input type="text" name="city" id="city" size="12" 
				value="<?php if (!empty($_SESSION['city'])){echo $_SESSION['city'];} ?>" />
		<label for="st">State: </label><select name="st" id="st"><?php include "inc/states-iso.inc" ?></select>
		<input type="submit" value="Set Filters" name="btnSetFilters" id="btnSetFilters" />
		<input type="button" value="Clear Filters" name="btnClearFilters" id="btnClearFilters" />
	</fieldset>
	</div>
</form>
</div><!-- // filters -->


<!--

<div id="qotd">
If you got a strong brain and your mind is broad <br />
You're gonna have more friends than a train can hold -
- <a href="http://www.hoffsten.com/texter/blues/weakbrain.html">Willie Dixon</a>
</div>
-->




<!-- ! Content -->
<h2 id="explanation"></h2>
(Refreshes every 15 minutes.)

<div id="dataout"></div>


<!-- ! Put Message Form -->
<div id="putmsg" class="popup corners">
<form id="frmPutMsg" action="" method="post">
	<div class="fieldset">
		<fieldset>
			<label for="txtMsg">Message: </label><input type="text" id="txtMsg" maxlength="150" />
		</fieldset>	
	</div>
</form>
</div><!-- // putmsg -->

<?php include 'inc/foot.php' ?>
