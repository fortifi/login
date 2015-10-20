<?php
namespace Fortifi\Login;

abstract class AbstractCookieReader
{
  protected $_cookie;

  /**
   * @return string
   *
   * @throws \Exception
   */
  public static function cookieName()
  {
    throw new \Exception("Cookie name must be used");
  }

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
    if(isset($_COOKIE[static::cookieName()]))
    {
      $cookie = $_COOKIE[static::cookieName()];
    }
    return new static($cookie);
  }

  protected function _property($property, $default = null)
  {
    return isset($this->_cookie->$property) ?
      $this->_cookie->$property : $default;
  }

  public function isPresent()
  {
    return $this->_cookie !== null && array_key_exists('token', $this->_cookie);
  }
}
