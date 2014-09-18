<!DOCTYPE html>
<html lang="en">
<head>
<title>SIKTI - Reset Password</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/zerogrid.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/responsive.css" type="text/css" media="all"> 
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.6.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/cufon-replace.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>js/Forum_400.font.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/atooltip.jquery.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>js/css3-mediaqueries.js"></script>
	
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/html5.js"></script>
	<style type="text/css">
		.slider_bg {behavior:url(js/PIE.htc)}
	</style>
<![endif]-->
<!--[if lt IE 7]>
	<div style='clear:both;text-align:center;position:relative'>
		<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" alt="" /></a>
	</div>
<![endif]-->


</head>
<body id="page5">
<div class="body6">
	<div class="body1">
		<div class="main zerogrid">
<!-- header -->
			<header>
				<h1><a href="<?php echo site_url('display/index');?>" id="logo"><img src="<?php echo base_url();?>images/logo.png"/></a></h1>
					<nav>
						<ul id="top_nav">
						<?php
						if(isset($username))
						{
							if(!$username=='')
							{?>
								<li class="login" >Welcome <?php echo $username; ?>!</li><br>
								<li><a class="login" href="<?php echo site_url('user_ctrl/logout');?>">Logout</a></li>
							<?php
							}
						}else
						{?>
								<li><a class="login" href="<?php echo site_url('display/display_login');?>">Login</a></li>
								<li><a class="login" href="<?php echo site_url('display/display_register');?>">Register</a></li>
								
						<?php
						}?>
						</ul>
					</nav>
					
					<nav>
						<ul id="menu">
							<li><a href="<?php echo site_url('display');?>">Home</a></li>
							<li><a href="<?php echo site_url('display/display_client_list');?>">Clients</a></li>
							<li><a href="<?php echo site_url('display/display_projects_offers');?>">Projects Offers</a></li>
							<li><a href="<?php echo site_url('display/display_features');?>">Features</a></li>
							<li><a href="<?php echo site_url('display/display_contacts');?>">Contacts</a></li>
						</ul>
					</nav>
			</header>
<!-- / header -->
<!-- content -->
			<article id="content">
				<div class="wrap">
					<section class="col-1-2"><div class="wrap-col1">
					<div class="box">
						<div>
							<center><h2 class="letter_spacing">Reset <span>Password</span></h2></center>
							
							<?php
							 $attributes = array('id' => 'ContactForm');
							 echo form_open('user_ctrl/reset_password', $attributes); ?> 
				
								<div>
									<br>
									We can help you reset your password using your Sikti username or email address.<br>
									<br>Enter your email or username.
									<div class="wrapper">
										
										<?php  
										$data= array(
											'name'		=> 'input',
											'id'		=> 'input',
											'class'		=> 'input',
											'maxlength'	=> '50'
											);
										echo form_input($data);
										?>
									</div>
																					
									<br><?php echo validation_errors(); ?>
									<?php echo $message; ?>
									<center>
									<a><?php
										$data= array(
											'class'		=> 'button1',
											'value'		=> 'Reset'
											);
										echo form_submit($data);
										?>
									</a>
										
									</center>
								</div>
							</form>
							
						</div>
					</div>
					</div>
					</section>
					
					
					<!--<section class="col-1-3"><div class="wrap-col">
					<div class="box">
						<div>
							<h2 class="letter_spacing">Contact <span>Form</span></h2>
							<form id="ContactForm">
								<div>
									<div class="wrapper">
										<span>Your Name:</span>
										<input type="text" class="input" >
									</div>
									<div class="wrapper">
										<span>Your E-mail:</span>
										<input type="text" class="input" >								
									</div>
									<div class="textarea_box">
										<span>Your Message:</span>
										<textarea name="textarea" cols="1" rows="1"></textarea>								
									</div>
									<center>
									<a href="#" class="button1" onClick="document.getElementById('ContactForm').submit()">Send</a>
									<a href="#" class="button1" onClick="document.getElementById('ContactForm').reset()">Clear</a>		
									</center>
								</div>
							</form>
						</div>
					</div>
					</div>
					</section>-->
				</div>
			</article>
		</div>
	</div>
</div>
<div class="body2">
	<div class="main zerogrid">
		<article id="content2">
		
			<section>
				<div class="wrapper">
					<div class="col-1-3"><div class="wrap-col">
						<h2>Our Contacts</h2>
						<div class="wrapper pad_bot1">
							<p>Sed ut perspiciatis unde omnis iunatus doloremque laudantium.</p>
							<p class="address">
								Marmora Road, Glasgow, D04 89GR.<br>
								<span>Freephone:</span>    +1 800 559 6580<br>
								<span>Telephone:</span>    +1 959 603 6035<br>
								<span>E-mail:</span>             <a href="mailto:">mail@demolink.org</a>
							</p>
						</div>
					</div></div>
					<div class="col-2-3"><div class="wrap-col mag-1">	
						<h2>Miscellaneous Info</h2>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
						</p>
						Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error.
					</div></div>
				</div>
			</section>
		</article>
<!-- / content -->
	</div>
</div>
<div class="body3">

		<div class="main zerogrid">
<!-- footer -->
			<footer>
				<div class="wrapper">
					<section class="col-2-3"><div class="wrap-col">
						<br><br><br><br>
						©2014 Dewi Paramita. All Rights Reserved.
					</div></section>
					<section class="col-1-3"><div class="wrap-col">
						<h3>Follow Us </h3>
						<ul id="icons">
							<li><a href="https://www.facebook.com/dewi.paramita.50" class="normaltip" title="Facebook"><img src="<?php echo base_url();?>images/icon1.gif" alt=""></a></li>
							<li><a href="https://www.linkedin.com/pub/dewi-paramita/a3/6b1/220" class="normaltip" title="Linkedin"><img src="<?php echo base_url();?>images/icon2.gif" alt=""></a></li>
							<li><a href="https://twitter.com/dewiparamita_" class="normaltip" title="Twitter"><img src="<?php echo base_url();?>images/icon3.gif" alt=""></a></li>
							<li><a href="http://instagram.com/dewiparamita_" class="normaltip" title="Instagram"><img src="<?php echo base_url();?>images/icon4.png" alt="" width="31px" height="31px"></a></li>
						</ul>
					</div></section>
				</div>
				<!-- {%FOOTER_LINK} -->
			</footer>
<!-- / footer -->
		</div>

</div>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>