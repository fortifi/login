<?php
namespace Fortifi\Login;

class TwoFactorCookie extends AbstractCookieReader
{
  /**
   * @return string
   */
  public static function cookieName()
  {
    return 'FRT2FA';
  }

  public function get2FaToken()
  {
    return $this->_property('token');
  }

  public function verifyCookie($secret, LoginCookie $login)
  {
    $check = md5(
      $login->getUserFid() .
      $secret .
      $this->_property('token') .
      $login->getSessionId()
    );
    return $check === $this->_property('verify');
  }
}
