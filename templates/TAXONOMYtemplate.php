<h3>Sandip Taxonomies</h3>

<div class="dashboard-container-box">
<ul class="dashboard-menu">
    <li > <a class="menu-item <?php echo !isset($_POST["edit_tax"]) ? "active" : "" ?>" href="#sandip-allcpt">All Taxonomies</a> </li>
    <li ><a class="menu-item <?php echo isset($_POST["edit_tax"]) ? "active" : "" ?>" href="#sandip-addcpt"> <?php echo isset($_POST["edit_tax"]) ? "Edit" : "Add New" ?> Taxonomy</a></li>
</ul>


<div class="dashboard-wrapper">
    <div class="dash-white-box <?php echo isset($_POST["edit_tax"]) ? "active" : "" ?>" id="sandip-addcpt">

        <form action="options.php" method="post">
            <?php
                settings_fields( "sandip_TAX_OG" );
                do_settings_sections( "taxonomy_manager" );
                submit_button();     
            ?>
        </form>
  
    </div>


    <div class="dash-white-box <?php echo !isset($_POST["edit_tax"]) ? "active" : "" ?>" id="sandip-allcpt">
    <?php
            $alltax = get_option("all_taxonomy") ?: array();

            echo "<table class='all-cpt-table'>
            <tbody>
                <tr>
                    <th>Taxonomy ID</th>
                    <th>Singular Name</th>
                    <th>Hierarchical</th>
                    <th>Actions</th>
                </tr>
            ";

            foreach($alltax as $tax){
                $ishierar = $tax["hierarchical"]=="1" ? "TRUE" : "FALSE";

                echo '
                <tr>
                    <td>'. $tax["tax_id"]. '</td>
                    <td>'. $tax["singular_name"]. '</td>
                    <td>'. $ishierar. '</td>
                    <td> 
            ';
            echo '<form action="" method="post" style="display: inline-block">';
            echo '<input type="hidden" name="edit_tax" value ="'. $tax["tax_id"] .'"/>';
            submit_button( "Edit", $type="primary small", "submit", $wrap=false ) ;
            echo '</form> ';

            echo '<form action="options.php" method="post" style="display: inline-block">';
            settings_fields( "sandip_TAX_OG" );
            echo '<input type="hidden" name="remove" value ="'.  $tax["tax_id"] .'"/>';
            submit_button( "Delete", $type="delete small", "submit", $wrap=false, array(
                "onclick" => 'return confirm("Are you Sure You want to delete this Taxonomy?")'
            ) ) ;
            echo '</form> ';

            echo "</td>
                </tr>
            </tbody>";
            }

            

            echo "</table>";
            ?>
    </div>

    
</div>

</div>