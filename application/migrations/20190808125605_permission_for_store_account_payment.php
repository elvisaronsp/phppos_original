<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_permission_for_store_account_payment extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20190808125605_permission_for_store_account_payment.sql'));
	    }

	    public function down() 
			{
	    }

	}