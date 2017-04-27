<html>
<head>
<title>My Form</title>
</head>
<body>

<?= validation_errors();
  $data = ['name'=>'xyz','contact'=>9999999999, 'email'=>'xyz@gmail.com', 'skype'=>'xyz@skype.com'];

 ?>

 <form method="post">
    <?php if($this->uri->segment(3) == '') {  ?>
     
    <h5>Username</h5>
      <input type="text" name="name" value="<?= set_value('name'); ?>" size="50" />

    <h5>Contact</h5>
      <input type="text" name="contact" value="<?= set_value('contact'); ?>" size="50" />

    <h5>email</h5>
     <input type="text" name="email" value="<?= set_value('email'); ?>" size="50" />

    <h5>Skype</h5>
       <input type="text" name="skype" value="<?= set_value('skype'); ?>" size="50" />
   
    <?php  } else {  ?> 
      <input type="hidden" name="id" value="<?= $this->uri->segment(3); ?>">
      <h5>Username</h5>
      <input type="text" name="name" value="<?= $data['name']; ?>" size="50" />

    <h5>Contact</h5>
      <input type="text" name="contact" value="<?= $data['contact']; ?>" size="50" />

    <h5>email</h5>
      <input type="text" name="email" value="<?= $data['email']; ?>" size="50" />

    <h5>Skype</h5>
       <input type="text" name="skype" value="<?= $data['skype']; ?>" size="50" />

   <?php } ?>


<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
      