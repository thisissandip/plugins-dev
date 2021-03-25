<h4>Add a New Testimonial Using this Form</h4>

<form id="sandip-testimonial-form" action="#" data-url="<?php echo admin_url("admin-ajax.php") ?>" >

    <div class="field-container">
        <label for="name" >
            Name: 
            <input type="text" id="name" name="name"  />
        </label> <br />
        <small class="field-msg error" data-error="invalidName">Your Name is Required</small>
    </div>

    <div class="field-container">
        <label for="email" >
            Email:
            <input type="email" id="email" name="email"  />
        </label> <br />
        <small class="field-msg error" data-error="invalidEmail">The Email address is not valid</small>
    </div>

    <div class="field-container">
        <label for="message" >
            Message:
            <textarea type="textarea" id="message" name="message" ></textarea>
        </label> <br />
        <small class="field-msg error" data-error="invalidMessage">A Message is Required</small>

    </div>

    <div class="field-container">
        <button type="submit" class="btn btn-default btn-lg btn-submit"> 
            Submit
        </button>
        <small class="field-msg js-form-submission">Submission in process, please wait&hellip;</small>
		<small class="field-msg success js-form-success">Message Successfully submitted, thank you!</small>
		<small class="field-msg error js-form-error">There was a problem with the Contact Form, please try again!</small>
    </div>

    <input id="action" type="hidden" name="action" value="testimonial_form" />
    <input id="nonce" type="hidden" name="nonce" value="<?php echo wp_create_nonce( "testimonial-nonce" ) ?>" />

</form>