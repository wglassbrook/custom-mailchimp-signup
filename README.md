# Custom Mailchimp Signup

## Why?

The purpose of this plugin is to allow administrators to embed a simple Mailchimp newsletter signup form anywhere on their website. I wanted to be able to customize the form code to my liking for usage in a specific theme. In it's current form, this plugin includes...

- Bootstrap 5 classes
- Bootstrap form validation
- Honeypot

## Installation

1. Copy the `custom-mailchimp-signup` folder into your `wp-content/plugins` folder
2. Activate the Custom Mailchimp Signup plugin via the plugins admin page

## Setup

The plugin requires a Mailchimp API Key and a List ID. Follow these links from MailChimp Knowledge Base to [retrieve your account’s API](http://kb.mailchimp.com/accounts/management/about-api-keys#Finding-or-generating-your-API-key) key and [find your list ID](http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id). At the top of the custom-mailchimp-signup.php file, replace the values for these two items.

## Usage

Place the `[mailchimp-form]` shortcode within the content areas of your pages or posts. The shortcode also allows for a `style="small"` attribute which will format the form output differently. Refer to the inc/_shortcodes.php file for specifics and to make changes.

