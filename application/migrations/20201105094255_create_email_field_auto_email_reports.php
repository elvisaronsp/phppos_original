<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_create_email_field_auto_email_reports extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20201105094255_create_email_field_auto_email_reports.sql'));
	    }

	    public function down() 
			{
	    }

	}