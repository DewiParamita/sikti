<!DOCTYPE html>
<html lang="en">
<head>
<title>SIKTI - Home</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/zerogrid.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url();?>css/responsive.css" type="text/css" media="all"> 
<link rel="stylesheet" href="<?php echo base_url();?>css/responsiveslides.css" /> 

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
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.6.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/cufon-replace.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>js/Forum_400.font.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/tms-0.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/tms_presets.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/atooltip.jquery.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>js/css3-mediaqueries.js"></script>
<script src="<?php echo base_url();?>js/responsiveslides.js"></script>
<script>
	$(function () {
	  $("#slidez").responsiveSlides({
		auto: true,
		pager: false,
		nav: true,
		speed: 500,
		maxwidth: 960,
		namespace: "centered-btns"
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
<body id="page1">

<div class="body6">
	<div class="body1">
		<div class="body5">
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
							<li class="active"><a href="<?php echo site_url('display');?>">Home</a></li>
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
					<div class="slider_bg">
						<div class="slider">
							<ul class="items">
								<li>
									<img src="<?php echo base_url();?>images/img1.jpg" alt="">
									<div class="banner">
										<strong>Project<span>Management</span></strong>
										<b>Manage project easier</b>
										<p>
											<span>Stay connected and in control of <br>Project from anywhere!<br>
											Sikti is an online project management tool that keeps your team and clients working together</span>
										</p>
									</div>
								</li>
								<li>
									<img src="<?php echo base_url();?>images/img2.jpg" alt="">
									<div class="banner">
										<strong>Work<span>Together</span></strong>
										<b>Share & Collaborate</b>
										<p>
											<span>Using Sikti, your team will know<br>
											what they have to do, when it must be done<br>
											and who needs to do it</span>
										</p>
									</div>
								</li>
								<li>
									<img src="<?php echo base_url();?>images/img3.jpg" alt="">
									<div class="banner">
										<strong>Complete <span>Control</span></strong>
										<b>Quick over-view of all your projects</b>
										<p>
											<span>Sikti shows everything you need <br>to know at a glance,
											keeping you up to date wth everthing about your projects</span>
										</p>
									</div>
								</li>
							</ul>
						</div>
						<div class="slider-response">
							<div class="rslides_container">
								<ul class="rslides" id="slidez">
									<li><img src="<?php echo base_url();?>images/img1.jpg" alt=""></li>
									<li><img src="<?php echo base_url();?>images/img2.jpg" alt=""></li>
									<li><img src="<?php echo base_url();?>images/img3.jpg" alt=""></li>
								</ul>
							</div>
	                    </div>
					</div>
					<div class="wrap">
						<section class="col-1-3"><div class="wrap-col">
							<div class="box">
								<div>
									<h2>Welcome <span>to Us!</span></h2>
									<figure><img src="<?php echo base_url();?>images/page1_img1.jpg" alt="" ></figure>
									<p class="pad_bot1">SIKTI is the most simple and easy way to manage Information Technology projects. </p>								
								</div>
							</div>
						</div></section>
						<section class="col-1-3"><div class="wrap-col">
							<div class="box">
								<div>
									<h2>About <span>Us</span></h2>
									<figure><img src="<?php echo base_url();?>images/page1_img2.jpg" alt="" ></figure>
									<p class="pad_bot1">With SIKTI, you can launch, collaborate, and collect information, all in one place.</p>
								</div>
							</div>
						</div></section>
						<section class="col-1-3"><div class="wrap-col">
							<div class="box">
								<div>
									<h2>Our <span>Features</span></h2>
									<figure><img src="<?php echo base_url();?>images/page1_img3.jpg" alt="" ></figure>
									<ul class="list1 pad_bot1">
										<li>Features : Project, Task Management, People & Contacts, File Management, Discussion, and Calendar</li>
									</ul>
								</div>
							</div>
						</div></section>
					</div>
				</article>
			</div>
		</div>
	</div>
</div>
<div class="body2">
	<div class="main zerogrid">
		<article id="content2">
			<div class="wrapper">
				<section class="col-full">
					<h2>Advantages</h2>
					<div class="wrapper">
						<div class="col-1-2"><div class="wrap-col">
							<div class="wrapper pad_bot2">
								<figure class="left marg_right1"><img src="<?php echo base_url();?>images/page1_img4.png" width="102px" height="102px" alt=""></figure>
								<p>
									<a href="#"><strong>Share And Collaborate</strong></a><br>
									Share ideas, information, file & more about your projects with your team & clients.
								</p>
							</div>
							<div class="wrapper">
								<figure class="left marg_right1"><img src="<?php echo base_url();?>images/page1_img5.png" width="102px" height="102px"  alt=""></figure>
								<p>
									<a href="#"><strong>Access Anywhere</strong></a><br>
									Sikti is web based do you will be able to login from anywhere.
								</p>
							</div>
						</div></div>
						<div class="col-1-2"><div class="wrap-col">
							<div class="wrapper pad_bot2">
								<figure class="left marg_right1"><img src="<?php echo base_url();?>images/page1_img6.png" width="102px" height="102px" alt=""></figure>
								<p>
									<a href="#"><strong>Stay on Track</strong></a><br>
									Sikti helps you manage your projects, teams & clients.
									
								</p>
							</div>
							<div class="wrapper">
								<figure class="left marg_right1"><img src="<?php echo base_url();?>images/page1_img7.png" width="102px" height="102px" alt=""></figure>
								<p>
									<a href="#"><strong>Work Faster</strong></a><br>
									Help your team stay focused, plan effectively & meet deadlines.
								</p>
							</div>
						</div></div>
					</div>
				</section>
			</div>
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