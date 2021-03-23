<h3>Sandip Dashboard</h3>

<div class="dashboard-container-box">
<ul class="dashboard-menu">
    <li > <a class="menu-item active" href="#sandip-manage">Manage</a> </li>
    <li ><a class="menu-item" href="#sandip-about">About</a></li>
    <li ><a class="menu-item" href="#sandip-dummy">Dummy</a></li>
</ul>


    <div class="dashboard-wrapper">

    <div class="dash-white-box" id="sandip-about">
                About
            </div>

            <div class="dash-white-box" id="sandip-dummy">
                Dummy
            </div>
            <div class="dash-white-box active" id="sandip-manage">
                <form action="options.php" method="post">
                            <?php
                                settings_fields( "sandip_plugins_manager" );
                                do_settings_sections( "sandip-plugin" );
                                submit_button();
                            ?>
                </form>
            </div>

       
        
    </div>

</div>