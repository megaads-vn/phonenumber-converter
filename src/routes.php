<?php
Route::group(array('namespace' => 'Megaads\PhonenumberConverter\Controller'), function() {
    Route::get("/package/phonenumber-converter", "ConverterController@convertPhoneNumber");
    Route::post("/service/phonenumber-converter", "ConverterController@serviceConvert");
});
?>
