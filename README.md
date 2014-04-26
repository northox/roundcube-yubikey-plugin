# roundcube-yubikey-plugin
Use Yubico's YubiKey to authentication on [Roundcube webmail](http://roundcube.net/).

The plugin is known to be working in production with Roundcube version from 1.0 to 0.7.

##Features
- Support alternative API servers - see `yubikey_api_url`
- Validation of the token is done via HMAC-SHA1 authentication over HTTPS (with certificate and hostname validation)
- Usage enforcement or in other words disallow yubikey opt-out (disabled by default) - see `yubikey_disallow_user_changes`

## Requirements
- Curl PHP module with TLS support.

## Installation
1. Install the code in the plugin directory (i.e. roundcube/plugins/yubikey_authentication/).
2. Add the plugin name in the `plugins` array of config file (config/config.inc.php formely main.inc.php). In this case the plugin directory name is 'yubikey_authentication'

    ```php
    $config['plugins'] = array('yubikey_authentication');
    ```

3. Set your API keys in plugins/yubikey_authentication/config.inc.php by visiting https://upgrade.yubico.com/getapikey/

    ```php
    $rcmail_config['yubikey_api_id']  = 'ID HERE'; 
    $rcmail_config['yubikey_api_key'] = 'KEY HERE';
    ```

4. Login normally and configure your yubikey in "Settings/Server Settings" menu:
  1. Ensure "Require YubiKey OTP" is checked
  2. Set your "YubiKey ID" by simply pressing on your yubikey (only the first 12 chars will be used).

5. Test your installation. You're done!

## License
GPL2

## Source
https://github.com/northox/roundcube-yubikey-plugin

## Acknowledgements
This code is based on work done by Oliver Martin which was using patches from dirkm.

### Contributors
- Stuart Henderson - support alternative API servers and some cosmetic tweaks
- Peter Kahl - disallow yubikey opt-out

### Author
Danny Fullerton - Mantor Organization
