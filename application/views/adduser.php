
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
			<form name="file-upload" method="post"  action="<?php echo base_url();?>index.php/admin/get_file_data" enctype="multipart/form-data">
				<tr>
				    <td>User Name</td>
				    <td>
				    	<input type="text" name="username" size="35">
				    </td>
				</tr>
				<tr>
				    <td>Password</td>
				    <td><input type="Text" name="password" size="35" maxlength="50"></td>
				</tr>
				<tr>
				    <td>Confirm Password</td>
				    <td><input type="Text" name="confPassword" size="35" maxlength="50"></td>
				</tr>
				
				<tr>
				    <td></td>
				    <td><input type="checkbox" name="can_upload_file" value="1">Upload File</td>
				</tr>
				<tr>
				    <td></td>
				    <td><input type="checkbox" name="can_upload_data" value="1">Upload Data File</td>
				</tr>
				<tr>
				    <td></td>
				    <td><input type="checkbox" name="can_view" value="1">View</td>
				</tr>
				<tr>
				    <td>&nbsp;</td>
				    <td><input type="Submit" value="Submit">&nbsp;<input type="Reset" value="Clear Form"></td>
				</tr>
			</form>
		</table>
	</div>
</div>


<?php 
$this->load->view('footer');
?>

