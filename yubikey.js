if (window.rcmail) {
  rcmail.addEventListener('init', function(evt) {
    otp_row = '<tr> \
                 <td class="title"> \
                   <label for="rcmloginyubikey">' + rcmail.get_label('yubikey_authentication.yubikey') + '</label> \
                 </td> \
                 <td class="input"> \
                   <input name="_yubikey" style="width: 200px;" id="rcmloginyubikey" autocomplete="off" type="text"> \
                 </td> \
               </tr>';
    document.getElementsByName('form')[0].getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].innerHTML += otp_row;
  });
}
