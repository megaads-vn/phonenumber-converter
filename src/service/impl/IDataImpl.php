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

    public function excecuteStatement($property, $data) {
        $values = $this->buildValueList($property, $data);
        $condition = $this->buildCondition($property);
        $sql = $this->buildSqlStatement($property, $values, $condition);
        return DB::statement($sql);
    }


    private function buildSqlStatement($property, $value, $condition) {
        return 'INSERT INTO `' . $property['table'] . '` (' . implode(', ', $property['columns']) . ') VALUES '
        . $value . ' ON DUPLICATE KEY UPDATE ' . $condition . ';';
    }

    private function buildCondition($property) {
        $retVal = '';
        for ($i = 0; $i < count($property['columns']); $i++) {
            if ($i < count($property['columns']) - 1) {
                $retVal .= $property['columns'][$i] . ' = VALUES(' . $property['columns'][$i] . '), ';
            } else {
                $retVal .= $property['columns'][$i] . ' = VALUES(' . $property['columns'][$i] . ')';
            }
        }
        return $retVal;
    }

    private function buildValueList($property, $data) {
        $value = '';
        for ($j = 0; $j < count($data); $j++) {
            $value .= '(';
            for ($i = 0; $i < count($property['columns']); $i++) {
                $valueTarget = $data[$j][$property['columns'][$i]];
                if ($property['columns'][$i] != 'id') {
                    $valueTarget = '"' . $valueTarget . '"';
                }
                if ($i < count($property['columns']) - 1) {
                    $value .= $valueTarget . ', ';
                } else {
                    $value .= $valueTarget;
                }
            }
            if ($j < count($data) - 1) {
                $value .= '),';
            } else {
                $value .= ')';
            }
        }
        return $value;
    }

}
?>
