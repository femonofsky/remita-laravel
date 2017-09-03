<?php
/**
 * Created by IntelliJ IDEA.
 * User: Femonofsky
 * Date: 9/2/17
 * Time: 10:00 PM
 */

namespace Femonofsky\Remita\Facade;

use Illuminate\Support\Facades\Facade;

class Remita extends Facade
{
    protected static function getFacadeAccessor() { return 'remita'; }

}