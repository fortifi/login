<?php
namespace Fortifi\Login;

class LoginCookie
{
  const COOKIE_NAME = 'FRTLGN';

  protected $_cookie;

  public function __construct($cookie = null)
  {
    if(!empty($cookie))
    {
      $this->_cookie = json_decode(base64_decode(rawurldecode($cookie)));
    }
  }

  public static function fromGlobals()
  {
    $cookie = null;
    if(isset($_COOKIE[static::COOKIE_NAME]))
    {
      $cookie = $_COOKIE[static::COOKIE_NAME];
    }
    return new static($cookie);
  }

  public function isPresent()
  {
    return $this->_cookie !== null && array_key_exists('token', $this->_cookie);
  }

  protected function _property($property, $default = null)
  {
    return isset($this->_cookie[$property]) ?
      $this->_cookie[$property] : $default;
  }

  public function getCustomerFid($default = null)
  {
    return $this->_property('customerFid', $default);
  }

  public function getUserFid($default = null)
  {
    return $this->_property('userFid', $default);
  }

  public function getUsername($default = null)
  {
    return $this->_property('username', $default);
  }

  public function getDisplayName($default = null)
  {
    return $this->_property('displayName', $default);
  }

  public function getUserType($default = null)
  {
    return $this->_property('userType', $default);
  }

  public function getAccessToken()
  {
    return $this->_property('token');
  }

  public function getRefreshToken()
  {
    return $this->_property('refresh');
  }

  public function getTokenExpiry()
  {
    return $this->_property('expiry');
  }

  public function isExpired()
  {
    return $this->getTokenExpiry() < time();
  }

  public function getAuthedIp()
  {
    return $this->_property('authIp');
  }

  public function isIpAuthed($ip)
  {
    return $this->getAuthedIp() == $ip;
  }

  public function verifyCookie($secret, $clientIp = null)
  {
    $verify = $this->_property('verify');
    $check = null;
    if(!empty($verify))
    {
      $check = md5(
        ($clientIp !== null ? $clientIp : $this->getAuthedIp()) .
        $this->getAccessToken() .
        $this->getUsername() .
        $this->getUserFid() .
        $this->getTokenExpiry() .
        $secret
      );
    }

    return $check !== null && $verify == $check;
  }
}
