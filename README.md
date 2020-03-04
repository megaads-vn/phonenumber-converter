# Phone number converter for Laravel 4
vd: 0165 -> 035, 0120 -> 070, ...

## Installation:
**add in file composer.json**
```
"require": {
	"megaads/phonenumber-converter": "^1.0"
}
```
## Usage:
**Register Provider**
```
# /Config/app.php
'providers' => [
    Megaads\PhonenumberConverter\PhonenumberConverterServiceProvider
];

# /Config/phone_number_converter.php:
return [
    'tables' => [
        'table1' => ['column1_contain_phone_number', 'column2_contain_phone_number',...],
        'table2' => ['column1_contain_phone_number', 'column2_contain_phone_number',...]
    ]
];
```
****
```
Go http://domain/package/phonenumber-converter
```
