<div id="header">
    <!-- Start Heading -->
        
    <div id="heading">
        <!-- <div id="ct_logo"> </div> -->
       
    </div><!-- End Heading -->
	 {if isset($admin)}
    <!-- Start Top Nav -->
    <div id="topnav"> 
            <ul>
                <li><a href="/administration/" title="Home" {if $page eq 'default.php' or $page eq ''} class="active"{/if}>Home</a></li>
				<li><a href="/administration/participants/" title="Participants" {if $page eq 'participants'} class="active"{/if}>Participants</a></li>
				<li><a href="/administration/events/" title="Events" {if $page eq 'events'} class="active"{/if}>Events</a></li>
				<li><a href="/administration/tickets/" title="Tickets" {if $page eq 'tickets'} class="active"{/if}>Tickets</a></li>
				<li><a href="/administration/mailers/" title="Mailers" {if $page eq 'mailers'} class="active"{/if}>Mailers</a></li>
				<li><a href="/administration/gallery/" title="Gallery" {if $page eq 'gallery'} class="active"{/if}>Gallery</a></li>
				<li><a href="/administration/profiles/" title="Profiles" {if $page eq 'profiles'} class="active"{/if}>Profiles</a></li>
				<li><a href="/administration/enquiry/" title="Enquiry" {if $page eq 'enquiry'} class="active"{/if}>Enquiry</a></li>
            </ul>
    </div><!-- End Top Nav -->
  <div class="clearer"><!-- --></div>
  {/if}
</div><!--header-->
{if isset($admin)}
    <div class="logged_in">
        <ul>
            <li><a href="/administration/logout.php" title="Logout">Logout</a></li>
        </ul>
    </div><!--logged_in-->
	{/if}
  	<br />