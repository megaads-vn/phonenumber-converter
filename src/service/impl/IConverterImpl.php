<?php
namespace Megaads\PhonenumberConverter\Service\Impl;

use Megaads\PhonenumberConverter\Service\IConverter;

class IConverterImpl implements IConverter {

    const PATTERN = '~(\+?84|084|0)?(16[2-9]|12[0-9]|18[68]|199)(\d{7})~';
    const MAP = [
        '162' => '32', '163' => '33', '164' => '34', '165' => '35', '166' => '36', '167' => '37',
        '168' => '38', '169' => '39', '120' => '70', '121' => '79', '122' => '77', '123' => '83',
        '124' => '84', '125' => '85', '126' => '76', '127' => '81', '128' => '78', '129' => '82',
        '186' => '56', '188' => '58', '199' => '59'
    ];

    public function converter($object) {
        $retVal = [];
        $retVal['isUpdate'] = false;
        foreach ($object as $key => $value) {
            if ($key == 'id') {
                $retVal[$key] = $value;
            } else {
                $newValue = $this->convertString($value);
                if (strcmp($value, $newValue)) {
                    $retVal[$key] = $newValue;
                    $retVal['isUpdate'] = true;
                }
            }
        }
        return $retVal;
    }

    protected function convertString($string) {
        preg_match_all(self::PATTERN, $string, $matches, PREG_PATTERN_ORDER);
        if (isset($matches[3])) {
            foreach($matches[0] as $k => $v) {
                $map = self::MAP;
                if (array_key_exists($matches[2][$k], $map)) {
                    $newPhone = $matches[1][$k] . $map[$matches[2][$k]] . $matches[3][$k];
                    $string = str_replace($v, $newPhone, $string);
                }
            }
        }
        return $string;
    }

}

?>
