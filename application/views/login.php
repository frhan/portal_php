
<?php 
$this->load->view('header');
?>
<div id="container">
	<div class="full-row">
		<h3>File Access Portal</h3>
	</div>
	<div class="full-row">
		<div class="file-menu">
			<a href="#">Create User</a>
		</div>		
	</div>

	<div class="full-row mt30">
		<table>
			<form name="file-upload" method="post"  action="<?php echo base_url();?>index.php/login/user_login" enctype="multipart/form-data">
				<tr>
				    <td>User Name</td>
				    <td>
				    	<input type="text" name="username" size="35">
				    </td>
				</tr>
				<tr>
				    <td>Password</td>
				    <td><input type="password" name="password" size="35" maxlength="50"></td>
				</tr>
				<tr>
				    <td>&nbsp;</td>
				    <td><input type="Submit" value="Login">&nbsp;</td>
				</tr>
				<tr>
				    <td>&nbsp;</td>
				    <td><a href="#">Register</a></td>
				</tr>
			</form>
		</table>
		
	</div>
</div>


<?php 
$this->load->view('footer');
?>

