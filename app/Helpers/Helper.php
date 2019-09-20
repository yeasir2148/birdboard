<?php

if(!function_exists('isRequestAjaxOrTesting')) {
   function isRequestAjaxOrTesting() {
      return request()->ajax() || app()->runningUnitTests();
   }
}
