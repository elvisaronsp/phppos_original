<?php
require_once ("Report.php");
class Serial_numbers_sold extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getInputData()
	{
		$input_data = Report::get_common_report_input_data(TRUE);
		
		$input_params = array();

		if ($this->settings['display'] == 'tabular')
		{
			$input_params = array(
				array('view' => 'date_range', 'with_time' => TRUE),
				array('view' => 'dropdown','dropdown_label' =>lang('reports_sale_type'),'dropdown_name' => 'sale_type','dropdown_options' =>array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')),'dropdown_selected_value' => 'all'),
				array('view' => 'excel_export'),
				array('view' => 'locations'),
				array('view' => 'submit'),
			);
		}
		
		$input_data['input_report_title'] = lang('reports_report_options');
		$input_data['input_params'] = $input_params;
		return $input_data;
	}
	
	function getOutputData()
	{
		$tabular_data = array();
		$report_data = $this->getData();
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array(array('data'=>$row['serial_number'], 'align' => 'left'),array('data'=>to_quantity($row['count']), 'align' => 'center'));
		}
 		$data = array(
			'view' => 'tabular',
			"title" => lang('reports_serial_numbers_sold_report'),
			"subtitle" => date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date'])),
			"headers" => $this->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $this->getSummaryData(),
			"export_excel" => $this->params['export_excel'],
			"pagination" => ''
		);
		
	return $data;
		
	}
	
	
	public function getDataColumns()
	{
		$columns = array();
		
		$columns[] = array('data'=>lang('reports_sales_generator_selectField_2'), 'align'=> 'center');
		$columns[] = array('data'=>lang('common_count'), 'align'=> 'center');

		
		return $columns;		
	}
	
	function _item_level_query()
	{
		$location_ids = self::get_selected_location_ids();
		$this->db->select('sales_items.serialnumber as serial_number, count(DISTINCT('.$this->db->dbprefix('sales_items').'.sale_id)) as count', false);
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales.sale_id = sales_items.sale_id');
		$this->db->join('locations', 'sales.location_id = locations.location_id');

		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('total_quantity_purchased < 0');
		}
		
		$this->sale_time_where();
		$this->db->where('sales.deleted', 0);
		$this->db->where('serialnumber is NOT NULL');
		$this->db->where('serialnumber != ""');
		$this->db->where_in('sales.location_id', $location_ids);
		$this->db->group_by('sales_items.serialnumber');
		$this->db->order_by('sale_time', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
	}
	
	public function getData()
	{		
		$this->_item_level_query();
		$item_return = $this->db->get()->result_array();

		$return = array();
		foreach($item_return as $item_row)
		{
			$return[] = array('serial_number' => $item_row['serial_number'], 'count' => $item_row['count']);
		}

		return $return;
	}

	public function getTotalRows()
	{
		$this->_item_level_query();
		$item_return = $this->db->count_all_results();

		return $item_return;
		
	}
	public function getSummaryData()
	{
		return array();
	}
}

?>