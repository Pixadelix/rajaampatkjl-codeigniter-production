<?php
include_once('meta-header.php');
return;
?>

<section class="menu cid-qOTKi1gC8V" once="menu" id="menu2-j">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top collapsed bg-color transparent">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span style="box-shadow: 1px 1px 5px rgba(0,0,0,.5);"></span>
                <span style="box-shadow: 1px 1px 5px rgba(0,0,0,.5);"></span>
                <span></span>
                <span style="box-shadow: 1px 1px 5px rgba(0,0,0,.5);"></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
					<a href="/booking"><img src="<?php echo $root_assets_path;?>assets/images/logo-mentawai-300x300.png" alt="Mentawai" title="Mentawai" style="height: 3.8rem;"></a>
                </span>
                <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-4" href="/booking" style="text-shadow: 1px 1px 8px rgba(0,0,0,.9);">MENTAWAI</a></span>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
			<?php
			if ( $user ) {
			?>
				<li class="nav-item">
                    <a class="nav-link link text-white display-4" href="/booking/history/<?php echo $event->code; ?>">
                        My Tickets
                    </a>
                </li>
			<?php
			}
			?>
			</ul>
        </div>
    </nav>
</section>
