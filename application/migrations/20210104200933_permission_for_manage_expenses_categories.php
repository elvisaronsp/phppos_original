<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_permission_for_manage_expenses_categories extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20210104200933_permission_for_manage_expenses_categories.sql'));
	    }

	    public function down() 
			{
	    }

	}