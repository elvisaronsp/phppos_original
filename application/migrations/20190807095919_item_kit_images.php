<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_item_kit_images extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20190807095919_item_kit_images.sql'));
	    }

	    public function down() 
			{
	    }

	}