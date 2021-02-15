<?php
require_once (APPPATH.'libraries/PHPPOSSpreadsheet.php');
function array_to_spreadsheet($arr,$filename,$is_report=FALSE)
{	
	$spreadsheet = PHPPOSSpreadsheet::getSpreadsheetClass();
	$spreadsheet->arrayToSpreadsheet($arr,$filename, $is_report);
}

function file_to_spreadsheet($inputFileName,$type = 'xlsx')
{
	$spreadsheet = PHPPOSSpreadsheet::getSpreadsheetClass($inputFileName,$type);
	return $spreadsheet;
}

function get_spreadsheet_first_row($inputFileName,$type = 'xlsx')
{
		require_once APPPATH.'libraries/Spout/Autoloader/autoload.php';		
		require_once (APPPATH.'libraries/PHPPOSSpreadsheetSpout.php');
		return PHPPOSSpreadsheetSpout::getFirstRow($inputFileName,$type);	
}