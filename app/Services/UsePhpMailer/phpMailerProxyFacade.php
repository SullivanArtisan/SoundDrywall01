<?php

namespace App\Services\UsePhpMailer;

use Illuminate\Support\Facades\Facade;

class PhpMailerProxyFacade extends Facade
{
   protected static function getFacadeAccessor()
   {
       return 'PhpMailerProxy';
   }
}

?>