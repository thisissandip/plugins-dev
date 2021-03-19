<div class="toast"><?php settings_errors();  ?>
</div> 

<h3>Custom Post Type Manager</h3>


<div class="dashboard-container-box">
<ul class="dashboard-menu">
    <li > <a class="menu-item <?php echo !isset($_POST["edit_post"]) ? "active" : "" ?>" href="#sandip-allcpt">All Custom Post Types</a> </li>
    <li ><a class="menu-item <?php echo isset($_POST["edit_post"]) ? "active" : "" ?>" href="#sandip-addcpt"> <?php echo isset($_POST["edit_post"]) ? "Edit" : "Add New" ?> Custom Post Type</a></li>
    <li ><a class="menu-item" href="#sandip-exportcpt">Export</a></li>
</ul>

<div class="dashboard-wrapper">
    <div class="dash-white-box <?php echo isset($_POST["edit_post"]) ? "active" : "" ?>" id="sandip-addcpt">

        <form action="options.php" method="post">
            <?php
                settings_fields( "sandip_cpt_OG" );
                do_settings_sections( "cpt_manager" );
                submit_button();  
            ?>
        </form>
  
    </div>


    <div class="dash-white-box <?php echo !isset($_POST["edit_post"]) ? "active" : "" ?>" id="sandip-allcpt">
       <?php
            $allcpts = get_option("all_cpts") ?: array();

            echo "<table class='all-cpt-table'>
            <tbody>
                <tr>
                    <th>Post ID</th>
                    <th>Singular Name</th>
                    <th>Plural Name</th>
                    <th>Public</th>
                    <th>Archive</th>
                    <th>Actions</th>
                </tr>
            ";

            foreach($allcpts as $cpt){
                $ispub = $cpt["is_public"]=="1" ? "TRUE" : "FALSE";
                $hasarchive = $cpt["has_archives"]=="1" ? "TRUE" : "FALSE";

                echo '
                <tr>
                    <td>'. $cpt["post_type"]. '</td>
                    <td>'. $cpt["singular_name"]. '</td>
                    <td>'. $cpt["plural_name"]. '</td>
                    <td>'.  $ispub. '</td>
                    <td>'. $hasarchive. '</td>
                    <td> 
            ';
            echo '<form action="" method="post" style="display: inline-block">';
            echo '<input type="hidden" name="edit_post" value ="'. $cpt["post_type"] .'"/>';
            submit_button( "Edit", $type="primary small", "submit", $wrap=false ) ;
            echo '</form> ';

            echo '<form action="options.php" method="post" style="display: inline-block">';
            settings_fields( "sandip_cpt_OG" );
            echo '<input type="hidden" name="remove" value ="'. $cpt["post_type"] .'"/>';
            submit_button( "Delete", $type="delete small", "submit", $wrap=false, array(
                "onclick" => 'return confirm("Are you Sure You want to delete this Custom Post Type?")'
            ) ) ;
            echo '</form> ';

            echo "</td>
                </tr>
            </tbody>";
            }

            

            echo "</table>";

       ?>
    </div>

    <div class="dash-white-box" id="sandip-exportcpt">
        Export CPT
    </div>

    
</div>

</div>