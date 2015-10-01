<?php $active=$_GET['active']; ?>

    <aside class="sidebar">
        <nav class="sidebar-nav">
            <div class="img-stack">
                <img class="profile-back" src="img/image.jpg">
                <img class="profile img-circle" src="img/user.png">
            </div>


            <ul class="metismenu" id="menu">
                <li class="active">
                    <a href="index.php" <?php if ($active==1){ echo "class='sidebar-active'";}?> >
                        <span class="fa fa-home" class="sidebar-active"></span>
                        <span class="sidebar-nav-item">Overview</span>

                    </a>
                </li>
                <li>
                    <a href="stocks.php" <?php if ($active==2){ echo "class='sidebar-active'";}?> >
                        <span class="fa fa-line-chart"></span>
                        <span class="sidebar-nav-item">Stocks</span>

                    </a>
                </li>
                <li>
                    <a href="weather.php" <?php if ($active==3){ echo "class='sidebar-active'";}?> >
                        <span class="fa fa-bolt"></span>
                        <span class="sidebar-nav-item">Weather</span>

                    </a>
                </li>
                <li class="logout">
                    <a href="#">
                        <span class="fa fa-sign-out"></span>
                        <span class="sidebar-nav-item">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>