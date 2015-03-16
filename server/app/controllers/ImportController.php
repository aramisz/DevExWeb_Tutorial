<?php

class ImportController extends ControllerBase
{

    public function indexAction()
    {
        $file = __DIR__ . "/../../../../data/" . "roadmap.xlsx";

        if (file_exists($file)) {

            $import_feature = new \VNDR\Logic\Roadmap\Feature\ImportFeature();
            $result = $import_feature->importData($file);
            $roadmap_id = 1;

            $import_feature->pushData($result, $roadmap_id);

            //\ART\Debug::file($result);
        }
//
//        $excel = new PHPExcel();
//
//        $br = rand(0,1000000);
//        $naziv = $br.".xls";
//        $objWriter = new PHPExcel_Writer_Excel2007($excel);
//        $objWriter->save('../tmp/'.$naziv);
    }

}

