<?php
namespace Megaads\PhonenumberConverter\Service\Impl;

use Megaads\PhonenumberConverter\Service\IData;
use Illuminate\Support\Facades\DB as DB;

class IDataImpl implements IData {

    public function count($property) {
        return DB::table($property['table'])
                ->count();
    }

    public function retrieve($property) {
        return DB::table($property['table'])
                ->forPage($property['pageId'] + 1, $property['pageSize'])
                ->get($property['columns']);
    }

    public function update($property, $dataUpdate) {
        return DB::table($property['table'])
                    ->where('id', '=', $dataUpdate['id'])
                    ->update($dataUpdate);
    }

}
?>
