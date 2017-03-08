<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Download_Library {

    private $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    public function download_mailings($filter)
    {
        $user = $this->CI->session->userdata('user');
        $filter['company_id'] = $user->company_id;

        // get data
        $this->CI->load->model('download_model');
        $mailings = $this->CI->download_model->generate_mailings($filter);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator($user->first_name . " " . "$user->last_name")
            ->setLastModifiedBy($user->first_name . " " . "$user->last_name")
            ->setTitle("Direct Mail - Download -> Mailings")
            ->setSubject("Direct Mail - Download -> Mailings")
            ->setKeywords("Direct Mail")
            ->setCategory("Mailings");

        // Set Headers
        $objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells('A1:B1')->setCellValue('A1', $filter['report_type'])
                    ->mergeCells('C1:D1')->setCellValue('C1', $filter['from'])
                    ->mergeCells('E1:F1')->setCellValue('E1', $filter['to']);


         $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C2', 'Mail Qty')
                    ->setCellValue('D2', 'Leads')
                    ->setCellValue('E2', 'Buys')
                    ->setCellValue('F2', 'Costs');

        // Add the data
        $row = 3;
        foreach ($mailings as $mailing) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $mailing['list']);
            $row++;
            foreach ($mailing['letters'] as $letter) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $row, 'Letter ' . $letter['number'])
                    ->setCellValue('C' . $row, $letter['mail_qty'])
                    ->setCellValue('D' . $row, $letter['leads'])
                    ->setCellValue('E' . $row, $letter['buys'])
                    ->setCellValue('F' . $row, $letter['costs']);
                $row++;
            }
        }

        // Rename worksheet
        // $objPHPExcel->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        // Redirect output to a client’s web browser (OpenDocument)
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="directmail_mailings_' . date('Ymd') . '_' .  generate_random_str() . '.ods"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
        $objWriter->save('php://output');
    }

}