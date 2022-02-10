<?php
/* Change to the correct path if you copy this example! */
require __DIR__ . './autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

// IP of printers
//$connector = new WindowsPrintConnector("172.16.32.133/EPSON TM-T82 Receipt");
//$connector = new NetworkPrintConnector('172.16.34.115', 9100);
$connector = new NetworkPrintConnector('172.16.32.23', 9100);

$printer = new Printer($connector);

try {
    $printer = new Printer($connector);
    $printer->pulse();
    $printer->close();
} catch (Exception $e) {
    $this->output->set_content_type('application/json')->set_output(json_encode(array("status" => "danger", "message" => 'Something went wrong, please contact IT!.')));
}
