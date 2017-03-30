<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Download_Library {

    private $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    public function download_list($type, $properties, $user)
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator($user->first_name . " " . "$user->last_name")
            ->setLastModifiedBy($user->first_name . " " . "$user->last_name")
            ->setTitle("Direct Mail Property List")
            ->setSubject("Direct Mail Property List")
            ->setKeywords("Direct Mail")
            ->setCategory("Property List");

        // Set Headers
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'List ID')
                    ->setCellValue('B1', 'List Name')
                    ->setCellValue('C1', 'Funeral Home')
                    ->setCellValue('D1', 'Property First Name')
                    ->setCellValue('E1', 'Property Middle Name')
                    ->setCellValue('F1', 'Property Last Name')
                    ->setCellValue('G1', 'Property Address')
                    ->setCellValue('H1', 'Property City')
                    ->setCellValue('I1', 'Property State')
                    ->setCellValue('J1', 'Property Zipcode')
                    ->setCellValue('K1', 'PR First Name')
                    ->setCellValue('L1', 'PR Middle Name')
                    ->setCellValue('M1', 'PR Last Name')
                    ->setCellValue('N1', 'PR Address')
                    ->setCellValue('O1', 'PR City')
                    ->setCellValue('P1', 'PR State')
                    ->setCellValue('Q1', 'PR Zipcode')
                    ->setCellValue('R1', 'Attorney Name')
                    ->setCellValue('S1', 'Attroney Address')
                    ->setCellValue('T1', 'Attorney Address 2')
                    ->setCellValue('U1', 'Attorney City')
                    ->setCellValue('V1', 'Attorney State')
                    ->setCellValue('W1', 'Attorney Zipcode')
                    ->setCellValue('X1', 'Mail First Name')
                    ->setCellValue('Y1', 'Mail Last Name')
                    ->setCellValue('Z1', 'Mail Address')
                    ->setCellValue('AA1', 'Mail City')
                    ->setCellValue('AB1', 'Mail State')
                    ->setCellValue('AC1', 'Mail Zip Code')
                    ->setCellValue('AD1', 'Status');

        if ($type == 'downloads_letters') {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('AE1', 'Letter No.');
        }

        // Add the data
        $row = 2;
        foreach ($properties as $property) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $row, $property->list_id)
                    ->setCellValue('B' . $row, $property->list_name)
                    ->setCellValue('C' . $row, $property->resource)
                    ->setCellValue('D' . $row, $property->property_first_name)
                    ->setCellValue('E' . $row, $property->property_middle_name)
                    ->setCellValue('F' . $row, $property->property_last_name)
                    ->setCellValue('G' . $row, $property->property_address)
                    ->setCellValue('H' . $row, $property->property_city)
                    ->setCellValue('I' . $row, $property->property_state)
                    ->setCellValue('J' . $row, $property->property_zipcode)
                    ->setCellValue('K' . $row, $property->pr_first_name)
                    ->setCellValue('L' . $row, $property->pr_middle_name)
                    ->setCellValue('M' . $row, $property->pr_last_name)
                    ->setCellValue('N' . $row, $property->pr_address)
                    ->setCellValue('O' . $row, $property->pr_city)
                    ->setCellValue('P' . $row, $property->pr_state)
                    ->setCellValue('Q' . $row, $property->pr_zipcode)
                    ->setCellValue('R' . $row, $property->attorney_name)
                    ->setCellValue('S' . $row, $property->attorney_first_address)
                    ->setCellValue('T' . $row, $property->attorney_second_address)
                    ->setCellValue('U' . $row, $property->attorney_city)
                    ->setCellValue('V' . $row, $property->attorney_state)
                    ->setCellValue('W' . $row, $property->attorney_zipcode)
                    ->setCellValue('X' . $row, $property->mail_first_name)
                    ->setCellValue('Y' . $row, $property->mail_last_name)
                    ->setCellValue('Z' . $row, $property->mail_address)
                    ->setCellValue('AA' . $row, $property->mail_city)
                    ->setCellValue('AB' . $row, $property->mail_state)
                    ->setCellValue('AC' . $row, $property->mail_zipcode)
                    ->setCellValue('AD' . $row, $property->status);
            if ($type == 'downloads_letters') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('AE' . $row, $property->letter_no);
            }
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
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
        $objWriter->save('php://output');
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