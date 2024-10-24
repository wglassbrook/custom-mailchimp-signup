<?php

// Shortcode to display the Mailchimp form
function mailchimp_form_shortcode($atts) {
  // Parse shortcode attributes
  $atts = shortcode_atts([
      'style' => 'default'
  ], $atts);

  // Generate a unique ID for the form
  $unique_id = 'mailchimp-signup-form-' . uniqid();

  // Form class based on style attribute
  $form_class = ($atts['style'] == 'small') ? 'form-small' : 'form-default';

  ob_start(); ?>

  <?php if($atts['style'] == 'small'){ ?>
    
    <?php /** This is the "Small" sized form for the site footer **/ ?>

    <form id="<?php echo esc_attr($unique_id); ?>" class="row g-2 align-items-center needs-validation <?php echo esc_attr($form_class); ?>" novalidate>
      <div class="col-12">
        <label for="email-<?php echo esc_attr($unique_id); ?>" class="visually-hidden form-label">Email address</label>
        <input type="email" class="form-control rounded-2 border border-2 border-excellence-green required email" id="email-<?php echo esc_attr($unique_id); ?>" name="email" placeholder="Enter your email" required>
        <div class="invalid-feedback">
          Please enter a valid email address.
        </div>
        <?php /** This is the honeypot **/ ?>
        <div style="display:none;">
          <label for="extension-<?php echo esc_attr($unique_id); ?>">Leave this field empty</label>
          <input type="text" id="extension-<?php echo esc_attr($unique_id); ?>" name="extension">
        </div>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-excellence-green d-block w-100">Sign Me Up</button>
      </div>
    </form>

    <div id="form-response-<?php echo esc_attr($unique_id); ?>" class="mt-3"></div>

  <?php }else{ ?>

    <?php /** This is the "Default" sized form for the front page **/ ?>

    <form id="<?php echo esc_attr($unique_id); ?>" class="row g-2 gy-md-0 align-items-center needs-validation <?php echo esc_attr($form_class); ?>" novalidate>
      <div class="col-12 col-md-8 col-lg-9">
        <label for="email-<?php echo esc_attr($unique_id); ?>" class="visually-hidden form-label">Email address</label>
        <input type="email" class="form-control rounded-2 border border-2 border-excellence-green required email" id="email-<?php echo esc_attr($unique_id); ?>" name="email" placeholder="Enter your email" required>
        <div class="invalid-feedback">
          Please enter a valid email address.
        </div>

        <?php /** This is the honeypot **/ ?>
        <div style="display:none;">
          <label for="extension-<?php echo esc_attr($unique_id); ?>">Leave this field empty</label>
          <input type="text" id="extension-<?php echo esc_attr($unique_id); ?>" name="extension">
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-3">
        <button type="submit" class="btn btn-excellence-green d-block w-100">Sign Me Up</button>
      </div>
    </form>

    <div id="form-response-<?php echo esc_attr($unique_id); ?>" class="mt-3"></div>

  <?php }; ?>

  <script>
    (function() {
      'use strict';

      var form = document.getElementById('<?php echo esc_js($unique_id); ?>');

      form.addEventListener('submit', function(event) {
        var honeypot = document.getElementById('extension-<?php echo esc_js($unique_id); ?>').value;
        if (honeypot) {
          // If honeypot is filled, it's a bot
          event.preventDefault();
          return;
        }

        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');

        // AJAX form submission
        if (form.checkValidity() && !honeypot) {
          event.preventDefault();
          
          var email = document.getElementById('email-<?php echo esc_js($unique_id); ?>').value;

          jQuery.ajax({
              url: mailchimp_ajax.ajax_url,
              type: 'POST',
              data: {
                action: 'mailchimp_subscribe',
                email: email
              },
              success: function(response) {
                var formResponse = document.getElementById('form-response-<?php echo esc_js($unique_id); ?>');
                if (response.success) {
                  formResponse.innerHTML = '<div class="alert alert-success mb-sm-n4">' + response.data.message + '</div>';
                } else {
                  formResponse.innerHTML = '<div class="alert alert-danger mb-sm-n4">' + response.data.message + '</div>';
                }
              }
          });
        }
      }, false);
    })();
  </script>

  <?php return ob_get_clean();
}
add_shortcode('mailchimp-form', 'mailchimp_form_shortcode');
