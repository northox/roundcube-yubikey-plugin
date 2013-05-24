<?php
// enable / disable YubiKey authentication
$rcmail_config['yubikey'] = true;

// YubiKey API key & ID needed to access the web service API.
// see: http://www.yubico.com/faq/api-key-yubikey-development/
$rcmail_config['yubikey_api_id'] = '';
$rcmail_config['yubikey_api_key'] = '';

// YubiKey API URL, defaulting to YubiCloud servers if not specified.
$rcmail_config['yubikey_api_url'] = '';

$rcmail_config['debug_logger']['yubikey'] = 'yubikey';
?>
