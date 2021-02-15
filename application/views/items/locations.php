<?php $this->load->view("partial/header"); ?>

<?php $query = http_build_query(array('redirect' => $redirect, 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>

	<div class="spinner" id="grid-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>

<div class="manage_buttons">
	<div class="row">
		<div class="<?php echo isset($redirect) ? 'col-xs-9 col-sm-10 col-md-10 col-lg-10': 'col-xs-12 col-sm-12 col-md-12' ?> margin-top-10">
			<div class="modal-item-info padding-left-10">
				<div class="modal-item-details margin-bottom-10">
					<?php if(!$item_info->item_id) { ?>
			    <span class="modal-item-name new"><?php echo lang('items_new'); ?></span>
					<?php } else { ?>
		    	<span class="modal-item-name"><?php echo H($item_info->name).' ['.lang('common_id').': '.$item_info->item_id.']'; ?></span>
					<span class="modal-item-category"><?php echo H($category); ?></span>
					<?php } ?>
				</div>
			</div>	
		</div>
		<?php if(isset($redirect) && !$progression) { ?>
		<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 margin-top-10">
			<div class="buttons-list">
				<div class="pull-right-btn">
				<?php echo 
					anchor(site_url($redirect), ' ' . lang('common_done'), array('class'=>'outbound_link btn btn-primary btn-lg ion-android-exit', 'title'=>''));
				?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
	
<?php if(!$quick_edit) { ?>
<?php $this->load->view('partial/nav', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
<?php } ?>

<?php echo form_open('items/save_item_location/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal')); ?>
<div class="row <?php echo $redirect ? 'manage-table' :''; ?>">
	<div class="col-md-12">
		<?php foreach($locations as $location) {  ?>
			
		<div class="panel panel-piluku">
			<div class="panel-heading pricing-widget">
	      <h3 class="panel-title"><i class="ion-location"></i> <?php echo $location->name; ?> <small>(<?php echo lang('common_fields_required_message'); ?>)</small></h3>
				
				<div class="panel-options custom pagination pagination-top hidden-print text-center" id="pagination_top">
					<?php
					if (isset($prev_item_id) && $prev_item_id)
					{
							echo anchor('items/location_settings/'.$prev_item_id, '<span class="hidden-xs ion-chevron-left"> '.lang('items_prev_item').'</span>');
					}
					if (isset($next_item_id) && $next_item_id)
					{
							echo anchor('items/location_settings/'.$next_item_id,'<span class="hidden-xs">'.lang('items_next_item').' <span class="ion-chevron-right"></span</span>');
					}
					?>
	  		</div>
			</div>
			<div class="panel-body">
		
			<div class="form-group">
				<?php echo form_label(lang('items_location_at_store').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo form_input(array(
						'name'=>'locations['.$location->location_id.'][location]',
						'class'=>'form-control form-inps',
						'value'=> $location_items[$location->location_id]->item_id !== '' ? $location_items[$location->location_id]->location: ''
					));?>
				</div>
			</div>

				<div class="form-group is-service-toggle <?php if ($item_info->is_service){echo 'hidden';} ?>">
						<?php echo form_label(lang('items_reorder_level').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'locations['.$location->location_id.'][reorder_level]',
								'value'=> $location_items[$location->location_id]->item_id !== '' &&  $location_items[$location->location_id]->reorder_level !== NULL ? to_quantity($location_items[$location->location_id]->reorder_level): '',
									'class'=>'form-control form-inps',
							));?>
					</div>
				</div>
				
				<div class="form-group is-service-toggle <?php if ($item_info->is_service){echo 'hidden';} ?>">
					<?php echo form_label(lang('common_replenish_level').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'locations['.$location->location_id.'][replenish_level]',
							'value'=> $location_items[$location->location_id]->item_id !== '' &&  $location_items[$location->location_id]->replenish_level !== NULL ? to_quantity($location_items[$location->location_id]->replenish_level): '',
								'class'=>'form-control form-inps',
						));?>
					</div>
				</div>
				
					
				<div class="form-group">
					<?php echo form_label(lang('common_hide_from_grid').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'locations['.$location->location_id.'][hide_from_grid]',
							'id'=>'locations['.$location->location_id.'][hide_from_grid]',
							'class' => 'hide_from_grid_checkbox delete-checkbox',
							'value'=>1,
							'checked'=> $this->Item->is_item_hidden($item_info->item_id,$location->location_id)));
						?>
						<label for="<?php echo 'locations['.$location->location_id.'][hide_from_grid]' ?>"><span></span></label>
					</div>
				</div>
				<div class="form-group override-prices-container">
					<?php echo form_label(lang('common_items_override_prices').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'locations['.$location->location_id.'][override_prices]',
							'id'=>'locations['.$location->location_id.'][override_prices]',
							'class' => 'override_prices_checkbox delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)isset($location_items[$location->location_id]) && is_object($location_items[$location->location_id]) && $location_items[$location->location_id]->is_overwritten));
						?>
						<label for="<?php echo 'locations['.$location->location_id.'][override_prices]' ?>"><span></span></label>
					</div>
				</div>
				
				<div class="item-location-price-container <?php if ($location_items[$location->location_id] === FALSE || !$location_items[$location->location_id]->is_overwritten){echo 'hidden';} ?>">	
					<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
						<div class="form-group">
							<?php echo form_label(lang('common_cost_price').' ('.lang('common_without_tax').'):', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
							
								<?php 
								$cost_price_input = array(
									'name'=>'locations['.$location->location_id.'][cost_price]',
									'size'=>'8',
									'class'=>'form-control form-inps',
									'value'=> $location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->cost_price ? to_currency_no_money($location_items[$location->location_id]->cost_price, 10): ''
								);
								
								if (!$this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id))
								{
									$cost_price_input['readonly'] = TRUE;
								}
								
								echo form_input($cost_price_input);
								?>
							</div>
						</div>
					<?php 
					}
					else
					{
						echo form_hidden('locations['.$location->location_id.'][cost_price]', $location_items[$location->location_id]->item_id !== '' ? $location_items[$location->location_id]->cost_price: '');
					}
					?>

					<div class="form-group">
						<?php echo form_label(lang('common_unit_price').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php 
							
							$unit_price_input = array(
								'name'=>'locations['.$location->location_id.'][unit_price]',
								'size'=>'8',
								'class'=>'form-control form-inps',
								'value'=>$location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->unit_price ? to_currency_no_money($location_items[$location->location_id]->unit_price, 10) : ''
								);
							
							if (!$this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id))
							{
								$unit_price_input['readonly'] = TRUE;
							}
							
							
							echo form_input($unit_price_input);?>
						</div>
					</div>

					<?php foreach($tiers as $tier) { 
						
						$selected_location_tier_type_option = '';
						$tier_price_value = '';
				
						if ($location_tier_prices[$location->location_id][$tier->id] !== FALSE)
						{
							if ($location_tier_prices[$location->location_id][$tier->id]->unit_price !== NULL)
							{
								$selected_location_tier_type_option = 'unit_price';
								$tier_price_value = to_currency_no_money($location_tier_prices[$location->location_id][$tier->id]->unit_price);
							}
							elseif($location_tier_prices[$location->location_id][$tier->id]->percent_off !== NULL)
							{
								$selected_location_tier_type_option = 'percent_off';	
								$tier_price_value = to_quantity($location_tier_prices[$location->location_id][$tier->id]->percent_off,false);						
																
							}
							elseif($location_tier_prices[$location->location_id][$tier->id]->cost_plus_percent !== NULL)
							{
								$selected_location_tier_type_option = 'cost_plus_percent';		
								$tier_price_value = to_quantity($location_tier_prices[$location->location_id][$tier->id]->cost_plus_percent,false);						
															
							}
							elseif($location_tier_prices[$location->location_id][$tier->id]->cost_plus_fixed_amount !== NULL)
							{
								$selected_location_tier_type_option = 'cost_plus_fixed_amount';	
								$tier_price_value = to_currency_no_money($location_tier_prices[$location->location_id][$tier->id]->cost_plus_fixed_amount);						
							}
		
						}
						
						?>	
						<div class="form-group">
							<?php echo form_label($tier->name.':', $tier->id,array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class='col-sm-9 col-md-9 col-lg-10'>
							<?php 
							
							$tier_price_input = array(
								'name'=>'locations['.$location->location_id.'][item_tier]['.$tier->id.']',
								'size'=>'8',
								'id'=>$tier->id,
								'class'=>'form-control margin10 form-inps', 
								'value'=> $tier_price_value,
							);
							
							if (!$this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id))
							{
								$tier_price_input['readonly'] = TRUE;
							}
							
							
							echo form_input($tier_price_input);
							
							?>
							
							<?php 
							
							$tier_type_html_options = array('class' => 'form-control');
							if (!$this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id))
							{
								$tier_type_html_options['readonly'] = TRUE;
							}
							
							
							echo form_dropdown('locations['.$location->location_id.'][tier_type]['.$tier->id.']', $tier_type_options, $selected_location_tier_type_option, $tier_type_html_options);?>
							</div>
						</div>

					<?php } ?>

					<div class="form-group">
						<?php echo form_label(lang('items_promo_price').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					    <div class="col-sm-9 col-md-9 col-lg-10">
						    <?php 
								
								$promo_price_input = array(
								'name'=>'locations['.$location->location_id.'][promo_price]',
						    'size'=>'8',
							  'class'=>'form-control form-inps',
							  'value'=> $location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->promo_price ? to_currency_no_money($location_items[$location->location_id]->promo_price, 10): ''
							);
								
								if (!$this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id))
								{
									$promo_price_input['readonly'] = TRUE;
								}
								
								echo form_input($promo_price_input);?>
					    </div>
					</div>

					<div class="form-group offset1">
						<?php echo form_label(lang('items_promo_start_date').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label text-info wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group date" data-date="<?php echo $location_items[$location->location_id]->item_id !== '' &&  $location_items[$location->location_id]->start_date ? date(get_date_format(), strtotime($location_items[$location->location_id]->start_date)): ''; ?>" >
									<span class="input-group-addon"><i class="ion-calendar"></i></span>
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][start_date]',
							        'size'=>'8',
								'class'=>'form-control form-inps datepicker',
									 'value'=> $location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->start_date ? date(get_date_format(), strtotime($location_items[$location->location_id]->start_date)): ''
									)
								);?>       
			    			</div>
						</div>
					</div>

					<div class="form-group offset1">
						<?php echo form_label(lang('items_promo_end_date').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label text-info wide')); ?>
					    <div class="col-sm-9 col-md-9 col-lg-10">
					    	<div class="input-group date" data-date="<?php echo $location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->end_date ? date(get_date_format(), strtotime($location_items[$location->location_id]->end_date)): ''; ?>" >
  								<span class="input-group-addon"><i class="ion-calendar"></i></span>

							    <?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][end_date]',
							        'size'=>'8',
									'class'=>'form-control form-inps datepicker',
									 'value'=> $location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->end_date ? date(get_date_format(), strtotime($location_items[$location->location_id]->end_date)): ''
							    	));
								?> 
						    </div>
						</div>
					</div>
				</div><!-- /item-location-price-container -->

				<div class="form-group override-taxes-container">
					<?php echo form_label(lang('common_override_default_tax').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>

					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'locations['.$location->location_id.'][override_default_tax]',
							'id'=>'locations['.$location->location_id.'][override_default_tax]',
							'class' => 'override_default_tax_checkbox  delete-checkbox',
							'value'=>1,
							'checked'=> $location_items[$location->location_id]->item_id !== '' ? (boolean)$location_items[$location->location_id]->override_default_tax: FALSE
							));
						?>
						<label for="<?php echo 'locations['.$location->location_id.'][override_default_tax]' ?>"><span></span></label>
					</div>
				</div>

				<div class="tax-container <?php if ($location_items[$location->location_id] === FALSE || !$location_items[$location->location_id]->override_default_tax){echo 'hidden';} ?>">	
					
					<div class="form-group">	
						<?php echo form_label(lang('common_tax_class').': ', 'tax_class',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('locations['.$location->location_id.'][tax_class]', $tax_classes, $location_items[$location->location_id]->tax_class_id, array('class' => 'form-control tax_class'));?>
						</div>
					</div>
			
					<div class="form-group">
						<h4 class="text-center"><?php echo lang('common_or') ?></h4>
					</div>
					
					<div class="form-group">
						<?php echo form_label(lang('common_tax_1').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'locations['.$location->location_id.'][tax_names][]',
								'size'=>'8',
								'class'=>'form-control form-inps margin10',
								'placeholder' => lang('common_tax_name'),
								'value' => isset($location_taxes[$location->location_id][0]['name']) ? $location_taxes[$location->location_id][0]['name'] : ($this->Location->get_info_for_key('default_tax_1_name') ? $this->Location->get_info_for_key('default_tax_1_name') : $this->config->item('default_tax_1_name'))
							));?>
						</div>
           	<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'locations['.$location->location_id.'][tax_percents][]',
								'size'=>'3',
								'class'=>'form-control form-inps-tax margin10',
								'placeholder' => lang('common_tax_percent'),
								'value' => isset($location_taxes[$location->location_id][0]['percent']) ? $location_taxes[$location->location_id][0]['percent'] : ''
							));?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('locations['.$location->location_id.'][tax_cumulatives][]', '0'); ?>
						</div>
					</div>

					<div class="form-group">
						<?php echo form_label(lang('common_tax_2').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'locations['.$location->location_id.'][tax_names][]',
								'size'=>'8',
								'class'=>'form-control form-inps margin10',
								'placeholder' => lang('common_tax_name'),
								'value' => isset($location_taxes[$location->location_id][1]['name']) ? $location_taxes[$location->location_id][1]['name'] : ($this->Location->get_info_for_key('default_tax_1_name') ? $this->Location->get_info_for_key('default_tax_1_name') : $this->config->item('default_tax_1_name'))
								)
							);?>
						</div>
                          <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'locations['.$location->location_id.'][tax_percents][]', 
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('common_tax_percent'),
								'value' => isset($location_taxes[$location->location_id][1]['percent']) ? $location_taxes[$location->location_id][1]['percent'] : ''
								)
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_checkbox('locations['.$location->location_id.'][tax_cumulatives][]', '1', isset($location_taxes[$location->location_id][1]['cumulative']) ? (boolean)$location_taxes[$location->location_id][1]['cumulative'] : ($this->Location->get_info_for_key('default_tax_2_cumulative') ? (boolean)$this->Location->get_info_for_key('default_tax_2_cumulative') : (boolean)$this->config->item('default_tax_2_cumulative')), 'class="cumulative_checkbox" id="locations['.$location->location_id.'][tax_cumulatives]"'); ?>
							<label for="<?php echo 'locations['.$location->location_id.'][tax_cumulatives]' ?>"><span></span></label>
						    <span class="cumulative_label">
								 <?php echo lang('common_cumulative'); ?>
						    </span>
						</div> <!-- end col-sm-9...-->
					</div><!--End form-group-->
				
					<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3" style="visibility: <?php echo isset($location_taxes[$location->location_id][2]['name']) ? 'hidden' : 'visible';?>">
						<a href="javascript:void(0);" class="show_more_taxes"><?php echo lang('common_show_more');?> &raquo;</a>
					</div>
				
					<div class="more_taxes_container"  style="display: <?php echo isset($location_taxes[$location->location_id][2]['name']) ? 'block' : 'none';?>">
						<div class="form-group">
							<?php echo form_label(lang('common_tax_3').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][tax_names][]',
									'size'=>'8',
									'class'=>'form-control form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value' => isset($location_taxes[$location->location_id][2]['name']) ? $location_taxes[$location->location_id][2]['name'] : ($this->Location->get_info_for_key('default_tax_3_name') ? $this->Location->get_info_for_key('default_tax_3_name') : $this->config->item('default_tax_3_name'))
								));?>
							</div>
                            	<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][tax_percents][]',
									'size'=>'3',
									'class'=>'form-control form-inps-tax',
									'placeholder' => lang('common_tax_percent'),
									'value' => isset($location_taxes[$location->location_id][2]['percent']) ? $location_taxes[$location->location_id][2]['percent'] : ''
								));?>
								<div class="tax-percent-icon">%</div>
								<div class="clear"></div>
								<?php echo form_hidden('locations['.$location->location_id.'][tax_cumulatives][]', '0'); ?>
							</div>
						</div>
					
						<div class="form-group">
							<?php echo form_label(lang('common_tax_4').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][tax_names][]',
									'size'=>'8',
									'class'=>'form-control form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value' => isset($location_taxes[$location->location_id][3]['name']) ? $location_taxes[$location->location_id][3]['name'] : ($this->Location->get_info_for_key('default_tax_4_name') ? $this->Location->get_info_for_key('default_tax_4_name') : $this->config->item('default_tax_4_name'))
								));?>
							</div>
                              <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][tax_percents][]',
									'size'=>'3',
									'class'=>'form-control form-inps-tax',
									'placeholder' => lang('common_tax_percent'),
									'value' => isset($location_taxes[$location->location_id][3]['percent']) ? $location_taxes[$location->location_id][3]['percent'] : ''
								));?>
								<div class="tax-percent-icon">%</div>
								<div class="clear"></div>
								<?php echo form_hidden('locations['.$location->location_id.'][tax_cumulatives][]', '0'); ?>
							</div>
						</div>
					
						<div class="form-group">
							<?php echo form_label(lang('common_tax_5').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][tax_names][]',
									'size'=>'8',
									'class'=>'form-control form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value' => isset($location_taxes[$location->location_id][4]['name']) ? $location_taxes[$location->location_id][4]['name'] : ($this->Location->get_info_for_key('default_tax_5_name') ? $this->Location->get_info_for_key('default_tax_5_name') : $this->config->item('default_tax_5_name'))
								));?>
							</div>
                              <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'locations['.$location->location_id.'][tax_percents][]',
									'size'=>'3',
									'class'=>'form-control form-inps-tax',
									'placeholder' => lang('common_tax_percent'),
									'value' => isset($location_taxes[$location->location_id][4]['percent']) ? $location_taxes[$location->location_id][4]['percent'] : ''
								));?>
								<div class="tax-percent-icon">%</div>
								<div class="clear"></div>
								<?php echo form_hidden('locations['.$location->location_id.'][tax_cumulatives][]', '0'); ?>
							</div>
						</div>
					</div><!-- End more taxes container-->
                    	<div class="clear"></div>
				</div> <!-- End tax-container-->
		
		<?php if (isset($item_variations) && $item_variations) { ?>
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo lang('common_item_variations').':' ?></label>
			<div class="col-sm-9 col-md-9 col-lg-10">
				<table id="item_variations" class="table">
					<thead>
						<tr>
							<th></th>
							<th><?php echo lang('common_cost_price'); ?></th>
							<th><?php echo lang('common_unit_price'); ?></th>
							<th class="is-service-toggle <?php if ($item_info->is_service){ echo 'hidden'; } ?>"><?php echo lang('items_reorder_level'); ?></th>
							<th class="is-service-toggle <?php if ($item_info->is_service){ echo 'hidden'; } ?>"><?php echo lang('common_replenish_level'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($item_variations as $item_variation_id => $item_variation) { ?>
								<tr>
									<td><?php echo $item_variation['name'] ? H($item_variation['name']) : H(implode(', ',array_column($item_variation['attributes'],'label'))); ?></td>

									<td><input type="text" class="form-control form-inps" size="5" name="locations[<?php echo $location->location_id;?>][item_variations][<?php echo $item_variation_id; ?>][cost_price]" value='<?php echo isset($location_variations[$location->location_id][$item_variation_id]['cost_price']) ? H(to_currency_no_money($location_variations[$location->location_id][$item_variation_id]['cost_price'])) : ''; ?>' /></td>
									<td><input type="text" class="form-control form-inps" size="5" name="locations[<?php echo $location->location_id;?>][item_variations][<?php echo $item_variation_id; ?>][unit_price]" value='<?php echo isset($location_variations[$location->location_id][$item_variation_id]['unit_price']) ? H(to_currency_no_money($location_variations[$location->location_id][$item_variation_id]['unit_price'])) : ''; ?>' /></td>
									<td class="is-service-toggle <?php if ($item_info->is_service){ echo 'hidden'; } ?>"><input type="text" class="form-control form-inps" size="5" name="locations[<?php echo $location->location_id;?>][item_variations][<?php echo $item_variation_id; ?>][reorder_level]" value='<?php echo isset($location_variations[$location->location_id][$item_variation_id]['reorder_level']) ? H(to_quantity($location_variations[$location->location_id][$item_variation_id]['reorder_level'],false)) : ''; ?>' /></td>
									<td class="is-service-toggle <?php if ($item_info->is_service){ echo 'hidden'; } ?>"><input type="text" class="form-control form-inps" size="5" name="locations[<?php echo $location->location_id;?>][item_variations][<?php echo $item_variation_id; ?>][replenish_level]" value='<?php echo isset($location_variations[$location->location_id][$item_variation_id]['replenish_level']) ? H(to_quantity($location_variations[$location->location_id][$item_variation_id]['replenish_level'],false)) : ''; ?>' /></td>
								</tr>
							<?php } ?>
					</tbody>
				</table>
			</div>
		</div> <!-- /item variations -->
		<?php } ?>
			</div><!-- /panel-body -->
		</div><!-- /panel -->
				 
		<?php } /*End foreach for locations*/ ?>
		
	</div>
</div><!-- /row -->

<?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
<?php echo form_hidden('progression', isset($progression) ? $progression : ''); ?>
<?php echo form_hidden('quick_edit', isset($quick_edit) ? $quick_edit : ''); ?>

<div class="form-actions">
	<?php
		echo form_submit(array(
			'name'=>'submitf',
			'id'=>'submitf',
			'value'=>lang('common_save'),
			'class'=>'submit_button floating-button btn btn-lg btn-primary hidden-print')
		);
	?>
</div>

<?php  echo form_close(); ?>
</div>

			
<script type='text/javascript'>
<?php $this->load->view("partial/common_js"); ?>

date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);
	$(".override_default_tax_checkbox, .override_prices_checkbox, .override_default_commission").change(function()
	{
		$(this).parent().parent().next().toggleClass('hidden')
	});
	
	var submitting = false;
	
	$('#item_form').validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
		errorClass: "text-danger",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		},
		rules:
		{
			<?php foreach($locations as $location) { ?>
				"<?php echo 'locations['.$location->location_id.'][quantity]'; ?>":
				{
					number: true
				},
				"<?php echo 'locations['.$location->location_id.'][reorder_level]'; ?>":
				{
					number: true
				},
				"<?php echo 'locations['.$location->location_id.'][replenish_level]'; ?>":
				{
					number: true
				},
				"<?php echo 'locations['.$location->location_id.'][cost_price]'; ?>":
				{
					number: true
				},
				"<?php echo 'locations['.$location->location_id.'][unit_price]'; ?>":
				{
					number: true
				},
				"<?php echo 'locations['.$location->location_id.'][promo_price]'; ?>":
				{
					number: true
				},
				<?php foreach($tiers as $tier) { ?>
					"<?php echo 'locations['.$location->location_id.'][item_tier]['.$tier->id.']'; ?>":
					{
						number: true
					},
				<?php } ?>

			<?php } ?>
		},
		submitHandler:function(form)
		{
			
			var args = {
				next: {
					label: <?php echo json_encode(lang('common_return_to_items')) ?>,
					redirect: <?php echo json_encode($redirect); ?>
				}
			};
					
			doItemSubmit(form, args);
		}
	});	
	
</script>
<?php $this->load->view('partial/footer'); ?>
