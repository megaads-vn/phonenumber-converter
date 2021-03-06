<?php
namespace Megaads\PhonenumberConverter\Controller;


use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Config as Config;
use Illuminate\Support\Facades\View as View;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response as Response;

use Megaads\PhonenumberConverter\Service\Impl\IDataImpl;
use Megaads\PhonenumberConverter\Service\Impl\IConverterImpl;

class ConverterController extends Controller {

    private $iData;
    private $iConverter;
    private $pageSize = 500;

    public function __construct() {
        $this->iData = new IDataImpl();
        $this->iConverter = new IConverterImpl();
        View::addNamespace('phonenumber-converter', base_path('workbench') . '/megaads/phonenumber-converter/src/views');
  }

    public function convertPhoneNumber() {
        $properties = Config::get("phone_number_converter.tables", []);
        return View::make('phonenumber-converter::index', ['properties' => $properties]);
    }

    public function serviceConvert() {
        ini_set('max_execution_time', 3000);
        $table = Input::get('table', null);
        $response = [
            'status' => 'failed',
            'numberOfRecordUpdate' => 0
        ];
        try {
            if ($table != null) {
                $properties = Config::get("phone_number_converter.tables");
                if (isset($properties[$table])) {
                    $property['table'] = $table;
                    $properties[$table][] = 'id';
                    $property['columns'] = $properties[$table];
                    $count = $this->iData->count($property);
                    $property['pageSize'] = $this->pageSize;
                    $pageCount = $this->calculatePagesCount($count);
                    for ($i = 0; $i <= $pageCount; $i++) {
                        $property['pageId'] = $i;
                        $data = $this->iData->retrieve($property);
                        if (count($data) > 0) {
                            $dataUpdate = [];
                            foreach ($data as $item) {
                                $newData = $this->iConverter->converter($item);
                                if (isset($newData['isUpdate']) && $newData['isUpdate']) {
                                    unset($newData['isUpdate']);
                                    $dataUpdate[] = $newData;
                                }
                            }
                            if (count($dataUpdate) > 0) {
                                $response['numberOfRecordUpdate'] += count($dataUpdate);
                                $this->iData->excecuteStatement($property, $dataUpdate);
                            }
                        }
                    }
                }
            }
            $response['status'] = 'successfuly';
            $response['message'] = 'Convert success';
        } catch(Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return Response::json($response);
    }

    private function calculatePagesCount($count) {
        return round($count/$this->pageSize, 0);
    }
}
?>
