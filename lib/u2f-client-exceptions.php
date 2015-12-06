<?php

/* Copyright (c) 2014 Yubico AB
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above
 *     copyright notice, this list of conditions and the following
 *     disclaimer in the documentation and/or other materials provided
 *     with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace U2fVal;

//Exceptions generated on the client.
class U2fValClientException extends \Exception {}

class ServerUnreachableException extends U2fValClientException {}
class BadAuthException extends U2fValClientException {}

//Exceptions sent from the U2FVAL server.
class U2fValException extends \Exception {
  private $errorData;

  public function __construct($message = null, $code = 0, $errorData = null) {
    parent::__construct($message, $code);
    $this->errorData = $errorData;
  }

  public function getData() {
    return $this->errorData;
  }

  public static function fromJson($response) {
    switch($response['errorCode']) {
      case 10:
        return new BadInputException($response['errorMessage'], $response['errorCode'], $response['errorData']);
      case 11:
        return new NoEligableDevicesException($response['errorMessage'], $response['errorCode'], $response['errorData']);
      case 12:
        return new DeviceCompromisedException($response['errorMessage'], $response['errorCode'], $response['errorData']);
      default:
        return new U2fValException($response['errorMessage'], $response['errorCode'], $response['errorData']);
    }
  }
}

class BadInputException extends U2fValException {}
class NoEligableDevicesException extends U2fValException {
  public function hasDevices() {
    return !empty($this->errorData);
  }
}
class DeviceCompromisedException extends U2fValException {}

?>
