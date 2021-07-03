<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Participants</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'} 
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
  <div class="inner">  
		<h2>Manage Participants</h2>
		<div class="section">
		<a href="/administration/participants/view/" title="Manage Participants"><img src="/administration/images/users.gif" alt="Manage  Participants" height="50" width="50" /></a>
		<a href="/administration/participants/view/" title="Manage Participants" class="title">Manage  Participants</a>
		</div>
		<div class="section mrg_left_50">
		<a href="/administration/participants/categories/" title="Manage Categories"><img src="/administration/images/projects.gif" alt="Manage Categories" height="50" width="50" /></a>
		<a href="/administration/participants/categories/" title="Manage Categories" class="title">Manage Categories</a>
		</div>
		<div class="section mrg_left_50">
		<a href="/administration/participants/participanttickets/" title="Manage Tickets"><img src="/administration/images/projects.gif" alt="Manage Tickets" height="50" width="50" /></a>
		<a href="/administration/participants/participanttickets/" title="Manage Tickets" class="title">Manage Tickets</a>
		</div>		
		<div class="clearer"><!-- --></div>		
    </div><!--inner-->
  </div><!-- End Content Section -->
{include_php file='administration/includes/footer.php'}
</div>
<!-- End Main Container -->
</body>
</html>
