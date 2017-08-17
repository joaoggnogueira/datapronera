<?php $this->load->view('include/header.php'); ?>

<header id="header">
	<div class="navbar navbar-fixed-top">
		<div class="container">
			<!--<a id="logo" class="navbar-brand" href="index.php"></a>-->
		  	<div class="overflow-menu">
				<ul class="nav navbar-nav pull-right scrollable selectable" id="top_menu">

					<?php $this->load->view($top_menu); ?>

				</ul>
  			</div>
		</div>
	</div>
</header>

<div id="course_info">
	
	<?php $this->load->view($course_info); ?>

</div>

<div id="status"></div>

<div id="middle">			
	<div id="content">

		<?php $this->load->view($content,$data); ?>

	</div>
</div>		

<?php $this->load->view('include/footer.php'); ?>