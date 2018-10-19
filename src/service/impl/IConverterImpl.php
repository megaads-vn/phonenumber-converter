<?php
namespace Megaads\PhonenumberConverter\Service\Impl;

use Megaads\PhonenumberConverter\Service\IConverter;

class IConverterImpl implements IConverter {

    const MIGRATE_PATTERN = '~(\+?84|084|0)?(16[2-9]|12[0-9]|18[68]|199)(\d{7})~';
    const MIGRATE_MAP = [
        '162' => '32', '163' => '33', '164' => '34', '165' => '35', '166' => '36', '167' => '37',
        '168' => '38', '169' => '39', '120' => '70', '121' => '79', '122' => '77', '123' => '83',
        '124' => '84', '125' => '85', '126' => '76', '127' => '81', '128' => '78', '129' => '82',
        '186' => '56', '188' => '58', '199' => '59'
    ];

    public function converter($object) {
        $retVal = [];
        foreach ($object as $key => $value) {
            if ($key == 'id') {
                $retVal[$key] = $value;
            } else {
                $retVal[$key] = $this->convert($value);
            }
        }
        return $retVal;
    }

    protected function convert($phoneNumber) {
        return preg_replace_callback(self::MIGRATE_PATTERN, function ($matches) {
            $matches[2] = self::MIGRATE_MAP[$matches[2]];
            array_shift($matches);
            return implode('', $matches);
        }, $phoneNumber);
    }

}

?>
