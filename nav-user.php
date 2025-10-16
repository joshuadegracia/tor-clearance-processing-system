<nav class="navbar navbar-inverse navbar-static-top">
    <div class="navbar-header">
        <a class="navbar-left"><img src="<?php echo site_url('img/logo.jpg'); ?>" style="width: 50px; height: 40px; margin-top: 5px; margin-left: -15px; margin-right: -15px"></a>
        <a class="navbar-brand" href="<?php echo site_url('home.php?sid=' . session_id()); ?>" style="color: white">&nbsp; SPCF Online TOR Request System</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo site_url('userinfo.php?sid=' . session_id()); ?>" data-toggle="tooltip" title="Account Info"><span class="glyphicon glyphicon-user"></span> <?php echo ucwords($name) ?></a></li>
        <li><a href="<?php echo site_url('userupdate.php?sid=' . session_id()); ?>" data-toggle="tooltip" title="Change Password"><span style="margin-left: -30px" class="glyphicon glyphicon-cog"></span></a></li>
        <li><a href="<?php echo site_url('logout.php?action=out&who=user');?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
</nav>