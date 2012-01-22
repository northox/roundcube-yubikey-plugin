# Description
Use Yubico's Yubikey to authentication to Roundcube webmail.

The plugin is known to be working in production with Roundcube version 0.7.x.

PEAR and Curl module are required.

# Installation
1. Install the code in the plugin directory (i.e. roundcube/plugins/yubikey_authentication/).
2. Add the plugin in your config file (config/main.inc.php). In this case the plugin directory name is 'yubikey_authentication':

    `$rcmail_config['plugins'] = array('yubikey_authentication');`
3. Set your API keys by visiting https://api.yubico.com/get-api-key/

    `$rcmail_config['yubikey_api_id'] = '';  
    $rcmail_config['yubikey_api_key'] = '';`

4. Login normally and configure your yubikey using "Settings/Server Settings"
  1. Ensure "Require Yubikey OTP" is checked
  2. Set your "Yubikey ID" by simply pressing on your yubikey (only the first 12 chars will be used).

5. Test your installation

# Security
Validation of the token is done via HMAC authentication (SHA1).

# License
GPL2

# Acknowledgement
This code is based on work done by Oliver Martin which was using patches from dirkm.
