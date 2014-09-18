<?php
if(isset($username))
$_SESSION['username'] = $username; // Must be already set
?>
<!DOCTYPE html>

<html lang="en">
<head>
<title>SIKTI - Projects Offers</title>
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

<!-----------Chat------------>
<script type="text/javascript" src="<?php echo base_url();?>chat/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>chat/js/chat.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_url();?>chat/css/chat.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_url();?>chat/css/screen.css" />

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
</head>
<body id="page2">
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
							<li class="active"><a href="<?php echo site_url('display/display_projects_offers');?>">Projects Offers</a></li>
							<li><a href="<?php echo site_url('display/display_features');?>">Features</a></li>
							<li><a href="<?php echo site_url('display/display_contacts');?>">Contacts</a></li>
						</ul>
					</nav>
			</header>
			<?php 
				if(isset($jml_offers))
				{
					if($jml_offers==0)
					{?>
				<article id="content">
					<div class="wrap">
						<section class="col-1-2"><div class="wrap-col1">
							<div class="box">
								<div>
									<center><h2>No <span>Projects Offers!</span></h2>
									<figure><img src="<?php echo base_url();?>images/icon/projects_offers.png" alt="" ></figure></center>
									<p class="pad_bot1">There's no projects offers yet. Create new projects offers by click the button below.</p>
									<center><a href="<?php echo site_url('offers_ctrl/display_add_offers');?>" class="button1">Create new project offers</a></center>
									
								</div>
							</div>
						</div></section>
						
					</div>
				</article>
				<?php
					}
				}?>

		</div>
	</div>
</div>
<div class="body2">
	<div class="main zerogrid">
		<article id="content2">
			<div class="wrapper">
			<?php if(isset($jml_offers))
			{
				if($jml_offers>0)
				{?>
				<section class="col-4-5"><div class="wrap-col">
					<h3>Projects Offers</h3>
					<p>Here are projects offers. 
					You (IT consultants) can get this project offers by register to this website and use this chat fungsionality to contact the company.</p>
										
					<?php 
						if($jml_offers>8)
						{
							echo $jml_offers.'Page : '.$this->pagination->create_links(); 
						}?>
						
					<?php if(isset($tipe))
					{
						if($tipe=='konsultan')
						{
							if($id_role=='2')
							{
							?>
							<a href="<?php echo site_url('offers_ctrl/display_add_offers');?>"><img src="<?php echo base_url();?>images/icon/add.png" width="20px" alt="">Add Project Offers</a>
							<?php
							}
						}
					}?>
					
					<?php
					if(!empty($offers))
					{	
					?>
						<div class="tab" >
							<table >
								<tr>
									<td>No</td>
									<td>Name </td>
									<td>Start Date</td>
									<td>Duration</td>
									<td>Budget</td>
								</tr>					
								<?php 
								$x=0;
								foreach($offers as $rows)
								{
									$x=$x+1;
									?>
								<tr>
									<td><center><?php echo $x;?></center></td>
									<td><strong><?php echo $rows->nama;?></strong>
									<?php if(isset($id_user))
									{
										if($id_user==$rows->id_company)
										{?>
											<a onClick="var r=confirm('Are you sure want to delete this project offers?'); 
												if (r==true){
													return true;
												}else{
													return false;
												}" 
											href="<?php echo site_url('offers_ctrl/delete_offers');?>?id=<?php echo $rows->id_offers;?>">Delete</a>
									<?php		
										}
									}?>
									<br>
									<?php echo $rows->deskripsi;?><br>
									<?php $posted=$this->user_model->get_user_by_id($rows->id_company); 
										foreach($posted as $row)
										{
											$date= date("d F Y h:i:s A", strtotime($rows->posted_date));
											echo '<div class="abu">Posted by : ' . '<strong>' . $row->nama. '</strong>' . ' on '. $date. '</div>';
										}
									?>
									<?php
										if(isset($id_user))
										{
											if($id_user==$rows->id_company)
											{?>
												Give this project offers to : 
												<?php
													echo form_open('offers_ctrl/edit_offers'); ?> 
												<div style="display:none">
												<input type="text" class="input" id="id_offers" name="id_offers" 
													value="<?php if(isset($rows->id_offers)) echo $rows->id_offers;?>">
												</div>
												<select class="input" id="select_consultant"  name="select_consultant">
												<option value="">--- Choose one ---</option>
												<?php 
													if($jml_consultant>0)
													{
														foreach($consultant as $row)
														{ 
														?>
															<option value="<?php echo $row->id_user;?>"><?php echo $row->nama;?></option>
													<?php
														}
													}	?>
												</select>
												
												<a onClick="var r=confirm('Are you sure want to give this project offers to that IT Consultant?. If you press 'OK', this project offers will automatically send to your projects page.'); 
												if (r==true){
													return true;
												}else{
													return false;
												}" 
												><input type="submit" class="button3" value="Save"></a>
												
												<?php		
													
											}
										}
									?>
									</td>
									<td><center><?php 
										$start = date("d F Y", strtotime($rows->start_date));
										echo $start;?></center></td>
									<td><center><?php echo $rows->duration . ' days';?></center></td>
									<td>
									<?php $a=(string)$rows->budget; 
										$len=strlen($a); 
										if ( $len <= 12 )
										{
											$rajut=$len-3-1; //untuk mengecek apakah ada nilai ratusan juta (9angka dari belakang)
											$juta=$len-6-1; //untuk mengecek apakah ada nilai jutaan (6angka belakang)
											$ribu=$len-9-1; //untuk mengecek apakah ada nilai ribuan (3angka belakang)

											$angka='';
											for ($i=0;$i<$len;$i++)
											{
												if ( $i == $rajut )
												{
												$angka=$angka.$a[$i].'.'; //meletakkan tanda titik setelah 3angka dari depan
												}
												else if ( $i == $juta )
												{
												$angka=$angka.$a[$i].'.'; //meletakkan tanda titik setelah 6angka dari depan
												}
												else if ( $i == $ribu )
												{
												$angka=$angka.$a[$i].'.'; //meletakkan tanda titik setelah 9angka dari depan
												}
												else
												{
												$angka=$angka.$a[$i];
												}
											}
										}?>
									<?php echo 'Rp ' . $angka;?></td>
								</tr>
								<?php
								}			
								?>
										</table>
									</div>
							
						<?php	
					}
						
					?>
					</div>
				</section>
				<?php
				}
			}?>
				<?php 
				if(!empty($tipe))
				{
					if($tipe=='konsultan')
					{?>
					<section class="col-1-5"><div class="wrap-col mag-1">
					<h3>Chat
					<img src="<?php echo base_url();?>images/icon/chat.png" width="40px"></h3>
					
					<?php
						if($id_role=='2' && $jml_consultant>0)
						{?>
							<center><strong>IT Consultant</strong></center>
							<?php
							foreach($consultant as $rows)
							{
							?>
								<!--<a href=""><?php echo $rows->nama;?></a><br>-->
								<a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $rows->username;?>')">Chat With <?php echo $rows->nama;?></a><br>
							<?php
							}
						}
						else if($id_role=='3' && $jml_customer>0)
						{?>
							<center><strong>Company</strong></center>
							<?php
							foreach($customer as $rows)
							{
							?>
								<!--<a href=""><?php echo $rows->nama;?></a><br>-->
								<a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $rows->username;?>')">Chat With <?php echo $rows->nama;?></a><br>
							<?php
							}
						}
						?>
						</div>
					</section>
				<?php
					}
				}?>
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