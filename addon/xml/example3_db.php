<?php
/**
 * Example using built in MYSQL DB functions
 * @package ExcelWriterXML
 * @subpackage examples
 * @filesource
 */

include('ExcelWriterXML.php');
$xml = new ExcelWriterXML('my file.xls');
$xml->showErrorSheet(true);
/*****************  ADD multiple tables all at once ***********/
$tables = array( 'master_user', 'master_setting',);
$xml->mysqlTableDump('localhost:3318','root','merdeka170845','sb_dagang',$tables);

/*****************  ADD one table at a time ***********/
//$xml->mysqlTableDump('surveys.web.alcatel-lucent.com','ghdweb','ghdweb','ghdweb_survey','test','test2');
//$xml->mysqlTableDump('surveys.web.alcatel-lucent.com','ghdweb','ghdweb','ghdweb_survey','desks','desk2');

/*****************  ADD a sheet, execute a query against that sheet ***********/

$qSheet = $xml->addSheet('My Query');
$query = 'SELECT * FROM master_user';
$qSheet->mysqlQueryToTable('localhost:3318','root','merdeka170845',$query);
$xml->sendHeaders();
$xml->writeData();
?>
