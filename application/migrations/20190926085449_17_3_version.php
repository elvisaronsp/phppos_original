<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_17_3_version extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20190926085449_17_3_version.sql'));
	    }

	    public function down() 
			{
	    }

	}