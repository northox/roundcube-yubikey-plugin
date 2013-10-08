<?php

// enable / disable YubiKey authentication
$rcmail_config['yubikey'] = true;

// YubiKey API key & ID needed to access the web service API.
// see: http://www.yubico.com/faq/api-key-yubikey-development/
$rcmail_config['yubikey_api_id']  = '';
$rcmail_config['yubikey_api_key'] = '';

// Once a user enters and saves his YubiKey ID, he will not
// be able to make changes to YubiKey ID or disable the
// YubiKey OTP requirement.
// This is *useful* when users don't fully understand the benefits
// of 2-factor authentication.
$rcmail_config['yubikey_disallow_user_changes'] = true; // bool

// YubiKey API URL, defaulting to YubiCloud servers if not specified.
$rcmail_config['yubikey_api_url'] = '';

$rcmail_config['debug_logger']['yubikey'] = 'yubikey';



