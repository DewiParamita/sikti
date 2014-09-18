<!DOCTYPE html>
<html lang="en">
<head>
	<title>SIKTI - File</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url();?>css/layout.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url();?>css/zerogrid.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url();?>css/responsive.css" type="text/css" media="all"> 
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.6.js" ></script>
	
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

	<script src="<?php echo base_url();?>codebase/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>codebase/skins/dhtmlxgantt_skyblue.css" type="text/css" media="screen" title="no title" charset="utf-8">

<script type="text/javascript" src="<?php echo base_url();?>common/testdata.js"></script>
	<style type="text/css">
		html, body{ height:100%; padding:0px; margin:0px; overflow: hidden;}
	</style>
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
									<li><a href="<?php echo site_url('display/display_gantt');?>" class="selected"><img src="<?php echo base_url();?>images/icon/chart.png" width="30px" alt="Gantt Charts">Gantt Charts</a></li>
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
			</div>
		</div>
	</div>
</body>
<body>
	
	<?php
		$data=array();
		$links=array();
		$i=0;
		foreach($project as $rows)
		{
			$i=$i+1;
			$p['id']		= $i;
			$p['text']		= $rows->nama;				
			$p['start_date']= date('d m Y', strtotime($rows->start_date));
			$p['duration']	= $rows->duration;
			$p['order']		= 10;
			$p['progress']	= 0.4;
			$p['open']		= true;
				
			$q['id']		= $i;
			$q['source']	= $i;
			$q['target']	= $i+1;
			$q['type']	= 1;
			array_push($data, $p);
			array_push($links, $q);
		}	
		$jsonData = json_encode($data);
		$jsonData2 = json_encode($links);
		//echo "var tasks ={data: ".$jsonData.", links: ".$jsonData2."};";
		//var_dump(JSON.stringify($jsonData));
			
		?>
		

		<div id="gantt_here" style='width:100%; height:60%;'></div>
			<script type="text/javascript">
			//var tasks ={data: $jsonData, links: $jsonData2};
			var tasks = {data: <?php echo $jsonData;?>, links: <?php echo $jsonData2;?>};
			//var tasks ={data: [{"id":1,"text":"Web Manajemen Proyek","start_date":"2014-08-10","duration":"5","order":10,"progress":0.4,"open":true},{"id":2,"text":"Sistem Informasi Penjualan","start_date":"2014-08-10","duration":"5","order":10,"progress":0.4,"open":true}], links: [{"id":1,"source":1,"target":2,"type":1},{"id":2,"source":2,"target":3,"type":1}]};
			/*var tasks =  {
            data:[
                {id:1, text:"Project #2", start_date:"01-04-2013", duration:18,order:10,
                    progress:0.4, open: true},
                {id:2, text:"Task #1", 	  start_date:"02-04-2013", duration:8, order:10,
                    progress:0.6, parent:1},
                {id:3, text:"Task #2",    start_date:"11-04-2013", duration:8, order:20,
                    progress:0.6, parent:2}
            ],
                    links:[
            { id:1, source:1, target:2, type:"1"},
            { id:2, source:2, target:3, type:"0"},
            { id:3, source:3, target:4, type:"0"},
            { id:4, source:2, target:5, type:"2"},
        ]
        };*/
			
			gantt.init("gantt_here");
			gantt.parse(tasks);
			
			</script>

			
	
</body>

		
</html>