<style>

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
    
</style>

<?php

ini_set('xdebug.var_display_max_depth', 1024);
ini_set('xdebug.var_display_max_children', 1024);
ini_set('xdebug.var_display_max_data', 1024);

if ( !function_exists( 'render_navbar' ) ) {
    function render_navbar($navbars) {
?>
<!--div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
        
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
            </ul>
        </li>
    </ul>
    <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
        </div>
    </form>
</div-->

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">NavBar</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="https://github.com/fontenele/bootstrap-navbar-dropdowns" target="_blank">GitHub Project</a></li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 1 <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">One more separated link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 2 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">One more separated link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">
    <div class="navbar-template text-center">
        <h1>Bootstrap NavBar</h1>
        <p class="lead text-info">NavBar with too many childs.</p>
        <a target="_blank" href="https://bootsnipp.com/snippets/featured/multi-level-dropdown-menu-bs3">Thanks to msurguy (Multi level dropdown menu BS3)</a>
    </div>
</div>
<?php
    }
}

$CI =& get_instance();
$navbars = $CI->get_navbar_resource();
$root = $navbars ? array_values($navbars) : null;

if ( ! function_exists( 'render_tree_subnavbar' ) ) {
    function render_tree_subnavbar($items) {
        //var_dump($items);die;
        //echo '<li class="dropdown">';
        //echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa '.$items['icon'].'"></i> '.$items['label'].' <span class="caret"></span></a>';
        //echo '<ul class="dropdown-menu" role="menu">';
        $childrens = $items['children'];
        foreach ( $childrens as $children ) {
            //var_dump($children);die;
            if ( '-' !== $children['label'] ) {
                
                if ( isset($children['children']) ) {
                    //var_dump($children['children']);die;
                    echo '<li class="dropdown-submenu">';
                    echo '<a href="'.$children['url'].'" class="dropdown-toggle" data-toggle="dropdown"><i class="fa '.$children['icon'].'"></i>'.$children['label'].'</a>';
                    echo '<ul class="dropdown-menu" role="">';
                    render_tree_subnavbar($children);
                    echo '</ul>';
                    echo '</li>';
                } else {
                    echo '<li class=""><a href="'.$children['url'].'"><i class="fa '.$children['icon'].'"></i>'.$children['label']."</a></li>";
                }
            } else
                echo '<li class="divider"></li>';
        }
        
    }
}

if ( ! function_exists( 'render_tree_navbar' ) ) {
    function render_tree_navbar($items) {
        //var_dump($items); die;
        if ( !$items ) return;
        echo '<div class="collapse navbar-collapse pull-left" id="navbar-collapse">';
        echo '<ul class="nav navbar-nav">';
        foreach ( $items as $i ) {
            if ( isset($i['children']) ) {
                echo '<li class="dropdown">';
                echo '<a href="'.$i['url'].'" class="dropdown-toggle" data-toggle="dropdown"><i class="fa '.$i['icon'].'"></i> '.$i['label'].' <span class="caret"></span></a>';
                echo '<ul class="dropdown-menu multi-level" role="menu">';
                render_tree_subnavbar($i);
                echo '</ul>';
                echo '</li>';
            } else {
                //var_dump($i);die;
                echo '<li class=""><a href="'.$i['url'].'"><i class="fa '.$i['icon'].'"></i> '.$i['label'].'</a></li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    }
}


if ( $navbars ) {
    render_tree_navbar($root);
}

?>


