<?php

// AJAX handler for form submission
function mailchimp_form_handler() {
  if (isset($_POST['honeypot']) && !empty($_POST['honeypot'])) {
    wp_send_json_error(['message' => 'Spam detected.']);
    wp_die();
  }

  if (isset($_POST['email'])) {
    $email = sanitize_email($_POST['email']);

    // Subscribe to Mailchimp list
    $response = mailchimp_subscribe($email);

    if (isset($response['success'])) {
      wp_send_json_success(['message' => $response['success']]);
    } else {
      wp_send_json_error(['message' => $response['error']]);
    }
  } else {
    wp_send_json_error(['message' => 'No email provided.']);
  }
  wp_die();
}
add_action('wp_ajax_mailchimp_subscribe', 'mailchimp_form_handler');
add_action('wp_ajax_nopriv_mailchimp_subscribe', 'mailchimp_form_handler');


// Function to subscribe email to Mailchimp
function mailchimp_subscribe($email) {
  $api_key = MAILCHIMP_API_KEY;
  $list_id = MAILCHIMP_LIST_ID;

  $data = [
    'email_address' => $email,
    'status'        => 'subscribed'
  ];

  $args = [
    'body'        => json_encode($data),
    'headers'     => [
      'Authorization' => 'apikey ' . $api_key,
      'Content-Type'  => 'application/json'
    ],
    'method'      => 'POST',
    'data_format' => 'body'
  ];

  $url = 'https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/';

  $response = wp_remote_post($url, $args);

  if (is_wp_error($response)) {
    return ['error' => 'There was an error subscribing.'];
  }

  $body = wp_remote_retrieve_body($response);
  $result = json_decode($body, true);

  if (isset($result['status']) && $result['status'] === 'subscribed') {
    return ['success' => 'Your email address has been added to our mailing list. Thank you for subscribing!'];
  } else {
    return ['error' => 'Something went wrong: ' . $result['detail']];
  }
}
