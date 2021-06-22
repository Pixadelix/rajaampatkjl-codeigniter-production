<?php
include_once('meta-header.php');
?>

  <section class="menu cid-qOTKi1gC8V" once="menu" id="menu2-t">

    

    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top collapsed bg-color transparent">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="/booking/<?php echo isset($event) ? $event->code : ''; ?>">
                        <img src="<?php echo $root_assets_path; ?>assets/images/logo-RGB-MV-Final-425x144.png" alt="MEDIAVISTA" title="" style="height: 5.8rem;">
                    </a>
                </span>
                
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
			<?php
			if ( isset($user) && $user ) {
			?>
				<li class="nav-item">
                    <a class="nav-link link text-black display-4" href="/booking/history/<?php echo isset($event) ? $event->code : ''; ?>">
                        My Tickets
                    </a>
                </li>
			<?php
			}
			?>
				<!--li class="nav-item">
                    <a class="nav-link link text-black display-4" href="/about-us">
                        About Us
                    </a>
                </li-->
			</ul>
            <!--div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="tel:+1-234-567-8901">
                    <span class="btn-icon mbri-mobile mbr-iconfont mbr-iconfont-btn">
                    </span>
                    +62 21 1234567890</a></div-->
        </div>
    </nav>
</section>
