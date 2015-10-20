<?php
namespace Fortifi\Login;

class LoginCookie extends AbstractCookieReader
{
  /**
   * @return string
   */
  public static function cookieName()
  {
    return 'FRTLGN';
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

  public function getSessionId()
  {
    return $this->_property('sessionId');
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
