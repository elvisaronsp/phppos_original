<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_17_6_version extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20200408123358_17_6_version.sql'));
	    }

	    public function down() 
			{
	    }

	}