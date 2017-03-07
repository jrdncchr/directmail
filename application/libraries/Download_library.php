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
                    ->setCellValue('A1', 'List ID')
                    ->setCellValue('B1', 'Funeral Home')
                    ->setCellValue('C1', 'Property First Name')
                    ->setCellValue('D1', 'Property Middle Name')
                    ->setCellValue('E1', 'Property Last Name')
                    ->setCellValue('F1', 'Property Address')
                    ->setCellValue('G1', 'Property City')
                    ->setCellValue('H1', 'Property State')
                    ->setCellValue('I1', 'Property Zipcode')
                    ->setCellValue('J1', 'PR First Name')
                    ->setCellValue('K1', 'PR Middle Name')
                    ->setCellValue('L1', 'PR Last Name')
                    ->setCellValue('M1', 'PR Address')
                    ->setCellValue('N1', 'PR City')
                    ->setCellValue('O1', 'PR State')
                    ->setCellValue('P1', 'PR Zipcode')
                    ->setCellValue('Q1', 'Attorney Name')
                    ->setCellValue('R1', 'Attroney Address')
                    ->setCellValue('S1', 'Attorney Address 2')
                    ->setCellValue('T1', 'Attorney City')
                    ->setCellValue('U1', 'Attorney State')
                    ->setCellValue('V1', 'Attorney Zipcode')
                    ->setCellValue('W1', 'Mail First Name')
                    ->setCellValue('X1', 'Mail Last Name')
                    ->setCellValue('Y1', 'Mail Address')
                    ->setCellValue('Z1', 'Mail City')
                    ->setCellValue('AA1', 'Mail State')
                    ->setCellValue('AB1', 'Mail Zip Code')
                    ->setCellValue('AC1', 'Status');

        // Add the data
        $row = 2;
        foreach ($properties as $property) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $row, $property->list_id)
                    ->setCellValue('B' . $row, $property->resource)
                    ->setCellValue('C' . $row, $property->property_first_name)
                    ->setCellValue('D' . $row, $property->property_middle_name)
                    ->setCellValue('E' . $row, $property->property_last_name)
                    ->setCellValue('F' . $row, $property->property_address)
                    ->setCellValue('G' . $row, $property->property_city)
                    ->setCellValue('H' . $row, $property->property_state)
                    ->setCellValue('I' . $row, $property->property_zipcode)
                    ->setCellValue('J' . $row, $property->pr_first_name)
                    ->setCellValue('K' . $row, $property->pr_middle_name)
                    ->setCellValue('L' . $row, $property->pr_last_name)
                    ->setCellValue('M' . $row, $property->pr_address)
                    ->setCellValue('N' . $row, $property->pr_city)
                    ->setCellValue('O' . $row, $property->pr_state)
                    ->setCellValue('P' . $row, $property->pr_zipcode)
                    ->setCellValue('Q' . $row, $property->attorney_name)
                    ->setCellValue('R' . $row, $property->attorney_first_address)
                    ->setCellValue('S' . $row, $property->attorney_second_address)
                    ->setCellValue('T' . $row, $property->attorney_city)
                    ->setCellValue('U' . $row, $property->attorney_state)
                    ->setCellValue('V' . $row, $property->attorney_zipcode)
                    ->setCellValue('W' . $row, $property->mail_first_name)
                    ->setCellValue('X' . $row, $property->mail_last_name)
                    ->setCellValue('Y' . $row, $property->mail_address)
                    ->setCellValue('Z' . $row, $property->mail_city)
                    ->setCellValue('AA' . $row, $property->mail_state)
                    ->setCellValue('AB' . $row, $property->mail_zipcode)
                    ->setCellValue('AC' . $row, $property->status);
            $row++;
        }

        // Rename worksheet
        // $objPHPExcel->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        // Redirect output to a client’s web browser (OpenDocument)
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="directmail_' . $type . '_' . date('Ymd') . '_' .  generate_random_str() . '.ods"');
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