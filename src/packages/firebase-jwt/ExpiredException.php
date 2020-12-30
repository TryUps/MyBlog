<?php
namespace Firebase\JWT;

class ExpiredException extends \UnexpectedValueException
{
  public $getMessage = 'Session Expired!';
}
