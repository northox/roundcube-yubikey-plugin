<?php
/**
* Roundcube-Yubikey-plugin
*
* This plugin enables Yubikey authentication within Roundcube webmail against 
* the Yubikey web service API.
*
* @author Danny Fullerton <northox@mantor.org>
* @license GPL2
*
* Acknowledgement: This code is based on work done by Oliver Martin which was
* using patches from dirkm.
*/

require_once('lib/Yubico.php');

class yubikey_authentication extends rcube_plugin
{
  private function is_enabled()
  {
    $use_yubikey = rcmail::get_instance()->config->get('yubikey');
    return (isset($use_yubikey) && $use_yubikey == true)
  } 

  function init()
  {
    $this->load_config();
    
    $this->add_texts('localization/', true);

    $this->add_hook('preferences_list', array($this, 'preferences_list'));
    $this->add_hook('preferences_save', array($this, 'preferences_save'));
    $this->add_hook('template_object_loginform', array($this, 'update_login_form'));
    $this->add_hook('login_after', array($this, 'login_after'));
  }

  function update_login_form($p)
  {
    if ($this->is_enabled())
      $this->include_script('yubikey.js');

    return $p;
  }

  function login_after($args)
  {
    if (!$this->is_enabled()) return $args;

    $yubikey_required = rcmail::get_instance()->config->get('yubikey_required');

    if (isset($yubikey_required) && $yubikey_required == true)
    {
      $yubikey_otp = get_input_value('_yubikey', RCUBE_INPUT_POST);
      $yubikey_id = rcmail::get_instance()->config->get('yubikey_id');

      // make sure that there is a Yubikey ID in the user's prefs
      // and that it matches the first 12 characters of the OTP
      if (empty($yubikey_id) || substr($yubikey_otp, 0, 12) !== $yubikey_id)
      {
        rcmail::get_instance()->logout_actions();
        rcmail::get_instance()->kill_session();
      }
      else
      {
        try
        {
          $yubi = new Auth_Yubico(rcmail::get_instance()->config->get('yubikey_api_id'), 
                                  rcmail::get_instance()->config->get('yubikey_api_key'), 
                                  true, 
                                  true);
          $auth = $yubi->verify($yubikey_otp);

          if (PEAR::isError($auth))
          {
            rcmail::get_instance()->logout_actions();
            rcmail::get_instance()->kill_session();
          }
        }
        catch (Exception $e)
        {
          rcmail::get_instance()->logout_actions();
          rcmail::get_instance()->kill_session();
        }
      }
    }

    return $args;
  }

  function preferences_list($args)
  {
    if ($args['section'] == 'server')
    {
      if ($this->is_enabled())
      {
        // add checkbox to enable/disable Yubikey auth for the current user
        $checked = rcmail::get_instance()->config->get('yubikey_required');
        $checked = (isset($checked) && $checked == true);
        $chk_yubikey = new html_checkbox(array(
          'name' => '_yubikey_required',
          'id' => 'rcmfd_yubikey_required',
          'value' => $checked));
        $args['blocks']['main']['options']['yubikey_required'] = array(
          'title' => html::label('rcmfd_yubikey_required', Q($this->gettext('yubikeyrequired'))), 
          'content' => $chk_yubikey->show($checked));

        // add inputfield for the Yubikey id
        $input_yubikey_id = new html_inputfield(array(
          'name' => '_yubikey_id', 
          'id' => 'rcmfd_yubikey_id', 
          'size' => 10));
        $args['blocks']['main']['options']['yubikey_id'] = array(
          'title' => html::label('rcmfd_yubikey_id', Q($this->gettext('yubikeyid'))),
          'content' => $input_yubikey_id->show(rcmail::get_instance()->config->get('yubikey_id')));
      }
    }

    return $args;
  }

  function preferences_save($args)
  {
    if ($this->is_enabled())
    {
      $args['prefs']['yubikey_required'] = isset($_POST['_yubikey_required']);
      $args['prefs']['yubikey_id'] = substr($_POST['_yubikey_id'], 0, 12);
    }

    return $args;
  }
}
?>
