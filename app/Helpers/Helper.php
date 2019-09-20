<?php

if(!function_exists('isRequestAjaxOrTesting')) {
   function isRequestAjaxOrTesting() {
      return request()->ajax() || app()->runningUnitTests();
   }
}

if(!function_exists('seedDb')) {
   function seedDb($model, $quantity, $method = 'create') {
      return factory($model, $quantity)->$method();
   }
}
