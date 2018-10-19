# Phone number converter for Laravel

##Installation:
**add in file composer.json**
```
"require": {
	"megaads/phonenumber-converter": "^1.0"
}
```
##Usage:
**Register Provider**
```
#/Config/app.php
'providers' => [
    Megaads\PhonenumberConverter\PhonenumberConverterServiceProvider::class
];

#/Config/phone_number_converter.php:
return [
    'target' => [
        'table1' => ['column1', 'column2'],
        'table2' => ['column1', 'column2']
    ]
]
```
****
```
http://domain/package/phonenumber-converter
```
