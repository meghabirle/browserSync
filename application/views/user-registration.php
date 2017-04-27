<html>
<head>
<title>My Form</title>
</head>
<body>

<?php echo validation_errors(); 

  $data = [ 'username' => 'test123','password'=>'Anp#12345', 'email'=> 'test@gmail.com'];
  
?>

 <form method="post">

 <?php if($this->uri->segment(3) == '') {  ?>
<h5>Username</h5>
<input type="text" name="username" value="<?= set_value('username'); ?>" size="50" />

<h5>Password</h5>
<input type="text" name="password" value="<?= set_value('password'); ?>" size="50" />


<h5>Email Address</h5>
<input type="text" name="email" value="<?= set_value('email'); ?>" size="50" />
  <?php  } else {  ?> 
  <input type="hidden" name="id" value="<?= $this->uri->segment(3);?>">
  <h5>Username</h5>
<input type="text" name="username" value="<?= $data['username']; ?>" size="50" />

<h5>Password</h5>
<input type="text" name="password" value="<?= $data['password']; ?>" size="50" />

<h5>Email Address</h5>
<input type="text" name="email" value="<?= $data['email']; ?>" size="50" />

<?php } ?>

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>