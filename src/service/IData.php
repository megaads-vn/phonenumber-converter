<?php
namespace Megaads\PhonenumberConverter\Service;

interface IData {

    function count($property);

    function retrieve($property);

    function update($property, $dataUpdate);

    function excecuteStatement($property, $data);

}


?>
