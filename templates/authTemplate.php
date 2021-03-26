<div class="container">
    <button class="login-show"> Login </button>

    <form id="sandip-plugin-auth-form" method="POST" action="#" data-url=<?php echo admin_url("admin-ajax.php") ?>>
    <div class="close-btn">X</div>
    <div class="form-field">
        <label for="username" >
            Username:
            <br />
            <input type="text" name="username" id="username" placeholder="Enter Your Username" />
        </label>
    </div>
    <div class="form-field">
        <label for="password" >
            Password:
            <br />
            <input type="password" name="password" id="password" placeholder="Enter Your Password" />
        </label>
    </div>
    <button type="submit" class="login-btn"> Login </button>

    <small class="msgofform"></small>

    <input type="hidden" id="action" name="action" value="sandip_auth_ajax">
    <!-- Here sandip_auth is the id and name of this field and ajax-login-nonce is the referer -->
    <?php wp_nonce_field( 'ajax-login-nonce', 'sandip_auth' ) ?>
</form> 
</div>

