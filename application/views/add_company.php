<!DOCTYPE html>
<html lang="en">
<head>
<title>SIKTI - Add Company</title>
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

<!----Untuk check password strength------>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/script_pass.js"></script>	

<!-------Menu Scroll------->
<link rel="stylesheet" href="<?php echo base_url();?>css/sticky-navigation.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

<script>
$(function() {

	// grab the initial top offset of the navigation 
	var sticky_navigation_offset_top = $('#sticky_navigation').offset().top;
	
	// our function that decides weather the navigation bar should have "fixed" css position or not.
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); // our current vertical position from the top
		
		// if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
		if (scroll_top > sticky_navigation_offset_top) { 
			$('#sticky_navigation').css({ 'position': 'fixed', 'top':0, 'left':0 });
		} else {
			$('#sticky_navigation').css({ 'position': 'relative' }); 
		}   
	};
	
	// run our function on load
	sticky_navigation();
	
	// and run it again every time you scroll
	$(window).scroll(function() {
		 sticky_navigation();
	});
	
	// NOT required:
	// for this demo disable all links that point to "#"
	$('a[href="#"]').click(function(event){ 
		event.preventDefault(); 
	});
	
});
</script>
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
			<?php
			if(isset($username))
			{
				if(isset($id_project))
				{
					if(!$id_project=='')
					{?>
					<div id="demo_top_wrapper">
					<div id="sticky_navigation_wrapper">
						<div id="sticky_navigation">
							<div class="demo_container">
							<div><a class="project_title" href="<?php echo site_url('project_ctrl/detil_project');?>?id=<?php echo $id_project;?>"><?php echo $nama;?></a></div>
								<ul>
									<li><a href="<?php echo site_url('display/display_project');?>" class="selected"><img src="<?php echo base_url();?>images/icon/project.png" width="30px" alt="Project">Project</a></li>
									<li><a href="<?php echo site_url('display/display_task');?>"><img src="<?php echo base_url();?>images/icon/task.png" width="30px" alt="Task">Task</a></li>
									<li><a href="<?php echo site_url('display/display_gantt');?>"><img src="<?php echo base_url();?>images/icon/chart.png" width="30px" alt="Gantt Charts">Gantt Charts</a></li>
									<li><a href="<?php echo site_url('display/display_people');?>"><img src="<?php echo base_url();?>images/icon/people.png" width="30px" alt="People & Contacts">People</a></li>
									<li><a href="<?php echo site_url('display/display_file');?>"><img src="<?php echo base_url();?>images/icon/file.png" width="30px" alt="File">File</a></li>
									<li><a href="<?php echo site_url('display/display_discussion');?>"><img src="<?php echo base_url();?>images/icon/discussions.png" width="30px" alt="Discussion">Discussion</a></li>
									<li><a href="<?php echo site_url('calendar_ctrl/notes');?>"><img src="<?php echo base_url();?>images/icon/calendar.png" width="30px" alt="Calendar">Calendar</a></li>
								</ul>
							</div>
						</div>
					</div>
					</div>
					<?php
					}
				}
				else
				{?>
					
					<div id="demo_top_wrapper">
					<div id="sticky_navigation_wrapper">
						<div id="sticky_navigation">
							<div class="demo_container">
								<ul>
									<li><a href="<?php echo site_url('display/display_project');?>" ><img src="<?php echo base_url();?>images/icon/project.png" width="30px" alt="Project">Project</a></li>
								</ul>
							</div>
						</div>
					</div>
					</div>
				<?php	
				}
			}?>
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
					<section class="col-full"><div class="wrap-col">
					<div class="box">
						<div>
							<center><h2 class="letter_spacing">Add Company <span>Form</span></h2></center>
							<?php
							 $attributes = array('id' => 'ContactForm');
							 echo form_open_multipart('project_ctrl/add_company', $attributes); ?> 
								<div>
									<!--	Register as what? (choose one)
									<div class="wrapper">	
										<input type="radio" name="role" value="2" 
										<?php if(isset($role))
										{
											if($role==2)
											{
												echo set_radio('role','2', TRUE);
												
											}
										}?>> Customer</input>
										<input type="radio" name="role" value="3" 
										<?php if(isset($role))
										{
											if($role==3)
											{
												echo set_radio('role','3', TRUE);
												
											}
										}?>> IT Consultant</input>
									
									</div>-->
									
									<?php if(isset($message))
										echo $message; ?>	
									<section class="col-1-2">
									<br>
									<div class="wrapper">
										<span>Company Name:</span>
										<input type="text" class="input" id="company_name" name="company_name" 
										value="<?php if(isset($company_name)) echo set_value('company_name', $company_name);?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Category*:</span>
										<input type="text" class="input" id="kategori" name="kategori"
										value="<?php if(isset($kategori)) echo set_value('kategori', $kategori);?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Address:</span>
										<input name="alamat" class="input" id="alamat"
										value="<?php if(isset($alamat)) echo set_value('alamat', $alamat);?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Phone Number:</span>
										<input type="text" class="input" id="phone" name="phone"
										value="<?php if(isset($phone)) echo set_value('phone', $phone);?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Email:</span>
										<input type="email" class="input" id="email" name="email"
										value="<?php if(isset($email)) echo set_value('email', $email);?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Website*:</span>
										<input type="text" class="input" id="website" name="website"
										value="<?php if(isset($website)) echo set_value('website', $website);?>">
									</div>
									<br>
									
									<div class="wrapper">
										<span>Photo*:</span>
										<input class="login" type="file" id="userfile" name="userfile" size="20">
									</div>
									<br>
									</section>
									<section class="col-1-2">
									<br>
									<div class="wrapper">
										<span>Username:</span>
										<input type="text" class="input" id="company_username" name="company_username"
										value="<?php if(isset($company_username)) echo set_value('company_username', $company_username);?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Password:</span>
										<input type="password" class="input" id="password" name="password"
										value="<?php if(isset($password)) echo set_value('password', $password);?>">
										<br><span id="result"></span>										
									<br>
									</div>
										<div class="wrapper">
										<span>Confirm Password:</span>
										<input type="password" class="input" id="password2" name="password2"
										value="<?php if(isset($password2)) echo set_value('password2', $password2);?>">
										<br><span id="result"></span>										
									</div>
									<br>
								
									<?php echo '* is optional';?>
									</section>
									
									<?php echo validation_errors(); ?>
									<center>
									<br><br>
									<a><input type="submit" class="button2" value="Send"></a>
									<a><input type="reset" class="button2" value="Clear"></a>
									
									<!--<a href="#" class="button1" onClick="document.getElementById('ContactForm').submit()">Send</a>
									<a href="#" class="button1" onClick="document.getElementById('ContactForm').reset()">Clear</a>-->		
									</center>
								</div>
							</form>
						</div>
					</div>
					</div>
					</section>
		
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