<?php


namespace App\Http\Controllers\Traits;


trait PagesTrait
{
  public function getPagesConfig($request) {
      $take = (int) $request->input('rowsPerPage');
      $skip = ((int) $request->input('page') -1 ) * $take;
      return [$take, $skip];
  }
}
