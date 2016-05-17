<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
    
    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
         
        if ($params == NULL)
        {

            // Use one of these - the last one in your case
            $param = '"","A4","","",0,0,0,55,6,3,"L"'; // Landscape

            // '', '',
            // 10, // margin_left
            // 10, // margin right
            // 10, // margin top
            // 10, // margin bottom
            // 6,  // margin header
            // 3); // margin footer

        }
         
        return new mPDF($param);
    }
}


