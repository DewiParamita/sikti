<!DOCTYPE html>
<html lang="en">
<head>
<title>SIKTI - Add Task</title>
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
									<li><a href="<?php echo site_url('display/display_project');?>"><img src="<?php echo base_url();?>images/icon/project.png" width="30px" alt="Project">Project</a></li>
									<li><a href="<?php echo site_url('display/display_task');?>" class="selected"><img src="<?php echo base_url();?>images/icon/task.png" width="30px" alt="Task">Task</a></li>
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
					<section class="col-1-2"><div class="wrap-col1">
					<div class="box">
						<div>
							<center><h2 class="letter_spacing">Add Task <span>Form</span></h2></center>
							<?php
							 $attributes = array('id' => 'ContactForm');
							 echo form_open('task_ctrl/add_task', $attributes); ?> 
							<?php if(isset($message))
								echo $message; ?>	
								<div>
									
									
					
									<br>
									<div class="wrapper">
										<span>Task Name:</span>
										<input type="text" class="input" id="task_name" name="task_name" 
										value="<?php if(isset($task_name)) echo $task_name;?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Description:</span>
										<?php
										if(isset($deskripsi))
										{
											$data = array(
												'name'		=> 'deskripsi',
												'id'		=> 'deskripsi',
												'value'		=>	$deskripsi,
												'maxlength'	=>	'100',
												'size'		=>	'50',
												'class'		=>	'input'
											);
											
											echo form_textarea($data); 
										}
										else
										{
											$data = array(
												'name'		=> 'deskripsi',
												'id'		=> 'deskripsi',
												'value'		=>	'',
												'maxlength'	=>	'100',
												'size'		=>	'50',
												'class'		=>	'input'
											);
											
											echo form_textarea($data); 
										}?>
									</div>
									<br>
									<div class="wrapper">
										<span>Start Date:</span>
										<input type="date" class="input" name="start_date" id="start_date"
										value="<?php if(isset($start_date)) echo $start_date;?>">
									</div>
									<br>
									<div class="wrapper">
										<span>Duration: <br>(in days)</span>
										<input type="number" class="input"  id="duration" name="duration" 
										value="<?php if(isset($duration)) 
													 { echo $duration; }
													 else 
													 { echo set_value('duration', '0');}?>"/>
									</div>
									<br>
									<div class="wrapper">
										<span>Select person who responsible to this task : </span>
										<select class="input" id="select_people"  name="select_people">
										<?php 
											if(isset($people))
											{
												foreach($people as $rows)
												{ 
												?>
													<option value="<?php echo $rows->id_people;?>" 
													<?php 
													if(isset($id_people))
													{
														if($id_people == $rows->id_people)
															echo set_select('select_people',$rows->id_people, TRUE); 
													}
													?>>
													<?php echo $rows->nama;?></option>
											<?php
												}
											}	
										?>
										</select>
									</div>
								</div>
								<center>
									<?php echo validation_errors(); ?>
									<a><input type="submit" class="button2" value="Send"></a>
									<a><input type="reset" class="button2" value="Clear"></a>
		
								</center>
								</form>
							</div>
							
						</div>
					</div>				
					</section>	
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