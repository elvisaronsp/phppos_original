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

<?php echo form_open('items/save_item_pricing/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal')); ?>

<div class="row <?php echo $redirect ? 'manage-table' :''; ?>">
	<div class="col-md-12">
		<div class="panel panel-piluku">
			<div class="panel-heading pricing-widget">
	      <h3 class="panel-title"><i class="ion-cash"></i> <?php echo lang("common_pricing"); ?> <small>(<?php echo lang('common_fields_required_message'); ?>)</small></h3>
				
				<div class="panel-options custom pagination pagination-top hidden-print text-center" id="pagination_top">
					<?php
					if (isset($prev_item_id) && $prev_item_id)
					{
							echo anchor('items/pricing/'.$prev_item_id, '<span class="hidden-xs ion-chevron-left"> '.lang('items_prev_item').'</span>');
					}
					if (isset($next_item_id) && $next_item_id)
					{
							echo anchor('items/pricing/'.$next_item_id,'<span class="hidden-xs">'.lang('items_next_item').' <span class="ion-chevron-right"></span</span>');
					}
					?>
	  		</div>
			</div>
			
			<div class="panel-body">
				<?php if ($progression || $this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
					<div class="form-group">
						<?php echo form_label(lang('common_cost_price').' ('.lang('common_without_tax').')'.':', 'cost_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label required wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
								<span class="input-group-addon bg"><span class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
								<?php echo form_input(array(
									'name'=>'cost_price',
									'size'=>'8',
									'id'=>'cost_price',
									'class'=>'form-control form-inps',
									'value'=>$item_info->cost_price ? to_currency_no_money($item_info->cost_price,10) : '')
								);?>
							</div>
						</div>
					</div>
				<?php 
				}
				else
				{
					echo form_hidden('cost_price', $item_info->cost_price);
				}
				?>
								
				<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
				<?php if ($this->config->item('enable_markup_calculator')) { ?>
				<div class="form-group">
					<?php echo form_label(lang('common_markup').':', 'margin',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
						    <?php echo form_input(array(
									'type'=> 'number',
									'min'=> '0',
									'max'=> '',
					        'name'=>'markup',
					        'size'=>'8',
									'class'=>'form-control',
					        'id'=>'markup',
					        'value'=>'',
								  'placeholder' => lang('common_enter_markup_percent'),
								)
						    );?>
								<span class="input-group-addon bg"><span class="">%</span></span>
							</div>
						 
				    </div>
				</div>
				<?php } ?>
				
				<?php if ($this->config->item('enable_margin_calculator')) { ?>
				<div class="form-group">
					<?php echo form_label(lang('common_margin').':', 'margin',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
						    <?php echo form_input(array(
									'type'=> 'number',
									'min'=> '0',
									'max'=> '',
					        'name'=>'margin',
					        'size'=>'8',
									'class'=>'form-control',
					        'id'=>'margin',
					        'value'=>'',
								  'placeholder' => lang('common_enter_margin_percent'),
								)
						    );?>
								<span class="input-group-addon bg"><span class="">%</span></span>
							</div>
						 
				    </div>
				</div>
				<?php } ?>
				
				<?php } ?>
				
				<div class="form-group">
					<?php echo form_label(lang('common_unit_price').':', 'unit_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label required wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<div class="input-group">
							<span class="input-group-addon bg"><span class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
							<?php echo form_input(array(
								'name'=>'unit_price',
								'size'=>'8',
								'id'=>'unit_price',
										'class'=>'form-control form-inps',
								'value'=>$item_info->unit_price ? to_currency_no_money($item_info->unit_price, 10) : '')
							);?>
						</div>
					</div>
				</div>
				
				<?php foreach($tiers as $tier) { 
					
					$selected_tier_type_option = '';
					$tier_price_value = '';
					
					if ($tier_prices[$tier->id] !== FALSE)
					{
						if ($tier_prices[$tier->id]->unit_price !== NULL)
						{
							$selected_tier_type_option = 'unit_price';
							$tier_price_value = to_currency_no_money($tier_prices[$tier->id]->unit_price,10);
							
						}
						elseif($tier_prices[$tier->id]->percent_off !== NULL)
						{
							$selected_tier_type_option = 'percent_off';		
							$tier_price_value = to_quantity($tier_prices[$tier->id]->percent_off,false);						
														
						}
						elseif($tier_prices[$tier->id]->cost_plus_percent !== NULL)
						{
							$selected_tier_type_option = 'cost_plus_percent';		
							$tier_price_value = to_quantity($tier_prices[$tier->id]->cost_plus_percent,false);						
																							
						}
						elseif($tier_prices[$tier->id]->cost_plus_fixed_amount !== NULL)
						{
							$selected_tier_type_option = 'cost_plus_fixed_amount';
							$tier_price_value = to_currency_no_money($tier_prices[$tier->id]->cost_plus_fixed_amount,10);						
																
						}
					}
					
					?>
					<div class="form-group">
						<?php echo form_label($tier->name.':', 'tier_'.$tier->id,array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
								<span class="input-group-addon bg"><span class="flat"><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span><span class="percent hidden">%</span></span>
								<span class="input-group-addon tier_dropdown_group"><?php	echo form_dropdown('tier_type['.$tier->id.']', $tier_type_options, $selected_tier_type_option,'class="form-control tier_dropdown"');?></span>
								<?php echo form_input(array(
									'name'=>'item_tier['.$tier->id.']',
									'size'=>'8',
									'id'=>'tier_'.$tier->id,
									'class'=>'form-control form-inps margin10',
									'value'=> $tier_price_value,
								));?>
								
								
							</div>
						</div>
					</div>
				<?php } ?>

				<div class="form-group">
					<?php echo form_label(lang('items_promo_price').':', 'promo_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
								<span class="input-group-addon bg"><span class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
						    <?php echo form_input(array(
						        'name'=>'promo_price',
						        'size'=>'8',
										'class'=>'form-control',
						        'id'=>'promo_price',
						        'value'=> $item_info->promo_price ? to_currency_no_money($item_info->promo_price,10) : '')
						    );?>
							</div>
				    </div>
				</div>
				
				<div class="form-group">
					<?php echo form_label(lang('items_promo_start_date').':', 'start_date',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label text-info wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
					    <div class="input-group date" data-date="<?php echo $item_info->start_date ? date(get_date_format(), strtotime($item_info->start_date)) : ''; ?>">
							<span class="input-group-addon bg">
	              <i class="ion ion-ios-calendar-outline"></i>
	            </span>
							<?php echo form_input(array(
						        'name'=>'start_date',
						        'id'=>'start_date',
										'class'=>'form-control datepicker',
						        'value'=>$item_info->start_date ? date(get_date_format(), strtotime($item_info->start_date)) : '')
						    );?> 
					    </div>
				    </div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('items_promo_end_date').':', 'end_date',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label text-info wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
					    <div class="input-group date" data-date="<?php echo $item_info->end_date ? date(get_date_format(), strtotime($item_info->end_date)) : ''; ?>">
							<span class="input-group-addon bg">
	            	<i class="ion ion-ios-calendar-outline"></i>
	            </span>
							<?php echo form_input(array(
						        'name'=>'end_date',
						        'id'=>'end_date',
										'class'=>'form-control form-inps datepicker',
						        'value'=>$item_info->end_date ? date(get_date_format(), strtotime($item_info->end_date)) : '')
						    );?> 
						</div>
				    </div>
				</div>
				
				<?php if($item_variations) { ?>
					<div class="row form-group">	
					<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo lang('items_variations').':' ?></label>
					<div class="col-md-9 col-sm-9 col-lg-10">
						<div class="table-responsive">
							<table id="item_variation_prices" class="table">
								<thead>
									<tr>
										<th width="25%"></th>
										<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
										<th width="15%"><?php echo lang('common_cost_price'); ?></th>
										<?php } ?>
										<th width="15%"><?php echo lang('common_unit_price'); ?></th>
										<th width="15%"><?php echo lang('items_promo_price'); ?></th>
										<th width="15%"><?php echo lang('items_promo_start_date'); ?></th>
										<th width="15%"><?php echo lang('items_promo_end_date'); ?></th>
									</tr>
								</thead>
			
								<tbody>
				
								<?php
								 foreach($item_variations as $variation_id => $item_variation) { 
						 
									 $variation_name = $item_variation['name'];
						 
									 ?>
										<tr data-index="<?php echo H($variation_id); ?>">
											<td class="item_variation_name">
												<?php echo $variation_name ? H($variation_name) : implode(', ',array_column($item_variation['attributes'],'label'));?>
											</td>
										
											<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
											<td class="cost_price top">
												<input type="text" class="form-control" size="20" name="variations[<?php echo H($variation_id); ?>][cost_price]" value="<?php echo $item_variation['cost_price'] ? to_currency_no_money(H($item_variation['cost_price']),10) : '';?>" />
											</td>
										
											<?php 
											} else {
												echo form_hidden('cost_price', $item_info->cost_price);
											}
											?>
								
											<td class="unit_price top">
												<input type="text" class="form-control" size="20" name="variations[<?php echo H($variation_id); ?>][unit_price]" value="<?php echo $item_variation['unit_price'] ? to_currency_no_money(H($item_variation['unit_price']),10) : '';?>" />
											</td>
										
											<td class="promo_price top">
												<input type="text" class="form-control" size="20" name="variations[<?php echo H($variation_id); ?>][promo_price]" value="<?php echo $item_variation['promo_price'] ? to_currency_no_money(H($item_variation['promo_price']),10) : '';?>" />
											</td>
										
											<td class="promo_start top">
												<?php echo form_input(array(
											        'name'=>"variations[$variation_id][start_date]",
											        'id'=>'start_date_<?php echo $variation_id; ?>',
															'class'=>'form-control datepicker',
											        'value'=> $item_variation['start_date'] ? date(get_date_format(), strtotime($item_variation['start_date'])) : '')
											    );?>
											</td>
										
											<td class="promo_end top">
												<?php echo form_input(array(
											        'name'=>"variations[$variation_id][end_date]",
											        'id'=>"end_date_$variation_id",
															'class'=>'form-control datepicker',
											        'value'=> $item_variation['end_date'] ? date(get_date_format(), strtotime($item_variation['end_date'])) : '')
											    );?>
											</td>
								
										</tr>
						
									 <?php
									 }
									 ?>	
								</tbody>
							</table>
							</div>
						</div>
					</div>
				<?php } ?>
				
				
				
				<div class="form-group">
					<?php echo form_label(lang('common_disable_from_price_rules').':', 'disable_from_price_rules',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'disable_from_price_rules',
							'id'=>'disable_from_price_rules',
							'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>$item_info->disable_from_price_rules ? 1 : 0,
						));?>
						<label for="disable_from_price_rules"><span></span></label>
					</div>
				</div>
				
				
				<div class="form-group">
					<?php echo form_label(lang('common_allow_price_override_regardless_of_permissions').':', 'allow_price_override_regardless_of_permissions',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'allow_price_override_regardless_of_permissions',
							'id'=>'allow_price_override_regardless_of_permissions',
							'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>$item_info->allow_price_override_regardless_of_permissions ? 1 : 0,
						));?>
						<label for="allow_price_override_regardless_of_permissions"><span></span></label>
					</div>
				</div>
				
									
				<div class="form-group">
					<?php echo form_label(lang('common_prices_include_tax').':', 'tax_included',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'tax_included',
							'id'=>'tax_included',
							'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>$item_info->tax_included ? 1 : 0,
						));?>
						<label for="tax_included"><span></span></label>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo form_label(lang('common_only_integer').':', 'only_integer',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'only_integer',
							'id'=>'only_integer',
							'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>$item_info->only_integer ? 1 : 0,
						));?>
						<label for="only_integer"><span></span></label>
					</div>
				</div>
				
				<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
				
				
				<div class="form-group">
					<?php echo form_label(lang('common_change_cost_price_during_sale').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'change_cost_price',
							'id'=>'change_cost_price',
							'class' => 'delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)(($item_info->change_cost_price))));
						?>
						<label for="change_cost_price"><span></span></label>
					</div>
				</div>
				<?php } elseif($item_info->change_cost_price) { 
					echo form_hidden('change_cost_price', 1);
				?>
					
				<?php } ?>								
				
				
				<?php if ($this->config->item('limit_manual_price_adj')) { ?>
				<div class="form-group">
					<?php echo form_label(lang('common_min_edit_price').':', 'min_edit_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
								<span class="input-group-addon bg"><span class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>	
						   	<?php echo form_input(array(
										'type'=> 'number',
										'step'=>"0.01",
										'min'=> '0',
						        'name'=>'min_edit_price',
										'class'=>'form-control',
						        'id'=>'min_edit_price',
						        'value'=> $item_info->min_edit_price ? to_quantity($item_info->min_edit_price) : '')
						    );?>
							</div>	
				    </div>
				</div>
				
				<div class="form-group">
					<?php echo form_label(lang('common_max_edit_price').':', 'max_edit_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
								<span class="input-group-addon bg"><span class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
						   	<?php echo form_input(array(
										'type'=> 'number',
										'step'=>"0.01",
										'min'=> '0',
						        'name'=>'max_edit_price',
										'class'=>'form-control',
						        'id'=>'max_edit_price',
						        'value'=> $item_info->max_edit_price ? to_quantity($item_info->max_edit_price) : '')
						    );?>
									
								</div>
				    </div>
				</div>
				
				
				<div class="form-group">
					<?php echo form_label(lang('common_max_discount_percent').':', 'max_discount_percent',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
							<div class="input-group">
						   	<?php echo form_input(array(
										'type'=> 'number',
										'min'=> '0',
										'max'=> '100',
						        'name'=>'max_discount_percent',
										'class'=>'form-control',
						        'id'=>'max_discount_percent',
						        'value'=> $item_info->max_discount_percent ? to_quantity($item_info->max_discount_percent) : '')
						    );?>
								<span class="input-group-addon bg"><span class="">%</span></span>
							</div>
				    </div>
				</div>

				<?php } ?>
							

				<div class="form-group override-commission-container">
					<?php echo form_label(lang('common_override_default_commission').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'override_default_commission',
							'id'=>'override_default_commission',
							'class' => 'override_default_commission delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)(($item_info->commission_percent != '') || ($item_info->commission_fixed != ''))));
						?>
						<label for="override_default_commission"><span></span></label>
					</div>
				</div>

				<div class="commission-container <?php if (!($item_info->commission_percent != '') && !($item_info->commission_fixed != '')){echo 'hidden';} ?>">
					<div class="form-group">
						<?php echo form_label(lang('reports_commission'), 'commission_value',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class='col-sm-9 col-md-9 col-lg-10'>
							<?php echo form_input(array(
								'name'=>'commission_value',
								'id'=>'commission_value',
								'size'=>'8',
								'class'=>'form-control margin10 form-inps', 
								'value'=> $item_info->commission_fixed != '' ? to_quantity($item_info->commission_fixed, FALSE) : to_quantity($item_info->commission_percent, FALSE))
							);?>
							
							<?php echo form_dropdown('commission_type', array('percent' => lang('common_percentage'), 'fixed' => lang('common_fixed_amount')), $item_info->commission_fixed != '' ? 'fixed' : 'percent', 'id="commission_type"');?>
						</div>
					</div>
					
					<div class="form-group" id="commission-percent-calculation-container">	
						<?php echo form_label(lang('common_commission_percent_calculation').': ', 'commission_percent_type',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('commission_percent_type', array(
							'selling_price'  => lang('common_unit_price'),
							'profit'    => lang('common_profit'),
							),
							$item_info->commission_percent_type,
							array('id' =>'commission_percent_type'))
							?>
						</div>
					</div>
				</div>
			
				<div class="form-group override-taxes-container">
					<?php echo form_label(lang('common_override_default_tax').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'override_default_tax',
							'id'=>'override_default_tax',
							'class' => 'override_default_tax_checkbox delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)$item_info->override_default_tax));
						?>
						<label for="override_default_tax"><span></span></label>
					</div>
				</div>
				<div class="tax-container main <?php if (!$item_info->override_default_tax){echo 'hidden';} ?>">
					
					<div class="form-group">	
						<?php echo form_label(lang('common_tax_class').': ', 'tax_class',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('tax_class', $tax_classes, $item_info->tax_class_id, array('id' =>'tax_class','class' => 'form-control tax_class'));?>
						</div>
					</div>
					
					<div class="form-group">
						<h4 class="text-center"><?php echo lang('common_or') ?></h4>
					</div>
											
					<div class="form-group">
						<?php echo form_label(lang('common_tax_1').':', 'tax_percent_1',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_1',
								'size'=>'8',
								'class'=>'form-control margin10 form-inps',
								'placeholder' => lang('common_tax_name'),
								'value'=> isset($item_tax_info[0]['name']) ? $item_tax_info[0]['name'] : ($this->Location->get_info_for_key('default_tax_1_name') ? $this->Location->get_info_for_key('default_tax_1_name') : $this->config->item('default_tax_1_name')))
							);?>
						</div>
	                    <label class="col-sm-3 col-md-3 col-lg-2 control-label wide" for="tax_percent_name_1">&nbsp;</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_1',
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('common_tax_percent'),
								'value'=> isset($item_tax_info[0]['percent']) ? $item_tax_info[0]['percent'] : '')
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
						</div>
					</div>

					<div class="form-group">
						<?php echo form_label(lang('common_tax_2').':', 'tax_percent_2',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_2',
								'size'=>'8',
								'class'=>'form-control form-inps margin10',
								'placeholder' => lang('common_tax_name'),
								'value'=> isset($item_tax_info[1]['name']) ? $item_tax_info[1]['name'] : ($this->Location->get_info_for_key('default_tax_2_name') ? $this->Location->get_info_for_key('default_tax_2_name') : $this->config->item('default_tax_2_name')))
							);?>
						</div>
	                    <label class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">&nbsp;</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_2',
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('common_tax_percent'),
								'value'=> isset($item_tax_info[1]['percent']) ? $item_tax_info[1]['percent'] : '')
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_checkbox('tax_cumulatives[]', '1', (isset($item_tax_info[1]['cumulative']) && $item_tax_info[1]['cumulative']) ? (boolean)$item_tax_info[1]['cumulative'] : (boolean)$this->config->item('default_tax_2_cumulative'), 'class="cumulative_checkbox" id="tax_cumulatives"'); ?>
							<label for="tax_cumulatives"><span></span></label>
						    <span class="cumulative_label">
								<?php echo lang('common_cumulative'); ?>
						    </span>
						</div>
					</div>
	                 
					<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3"  style="visibility: <?php echo isset($item_tax_info[2]['name']) ? 'hidden' : 'visible';?>">
						<a href="javascript:void(0);" class="show_more_taxes"><?php echo lang('common_show_more');?> &raquo;</a>
					</div>
					<div class="more_taxes_container" style="display: <?php echo isset($item_tax_info[2]['name']) ? 'block' : 'none';?>">
						<div class="form-group">
							<?php echo form_label(lang('common_tax_3').':', 'tax_percent_3',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_3',
									'size'=>'8',
									'class'=>'form-control form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($item_tax_info[2]['name']) ? $item_tax_info[2]['name'] : ($this->Location->get_info_for_key('default_tax_3_name') ? $this->Location->get_info_for_key('default_tax_3_name') : $this->config->item('default_tax_3_name')))
								);?>
							</div>
	            <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_3',
									'size'=>'3',
									'class'=>'form-control form-inps-tax margin10',
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($item_tax_info[2]['percent']) ? $item_tax_info[2]['percent'] : '')
								);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
						</div>

						<div class="form-group">
						<?php echo form_label(lang('common_tax_4').':', 'tax_percent_4',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_4',
								'size'=>'8',
								'class'=>'form-control  form-inps margin10',
								'placeholder' => lang('common_tax_name'),
								'value'=> isset($item_tax_info[3]['name']) ? $item_tax_info[3]['name'] : ($this->Location->get_info_for_key('default_tax_4_name') ? $this->Location->get_info_for_key('default_tax_4_name') : $this->config->item('default_tax_4_name')))
							);?>
							</div>
	            <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_4',
								'size'=>'3',
								'class'=>'form-control form-inps-tax', 
								'placeholder' => lang('common_tax_percent'),
								'value'=> isset($item_tax_info[3]['percent']) ? $item_tax_info[3]['percent'] : '')
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
						</div>
						
						<div class="form-group">
						<?php echo form_label(lang('common_tax_5').':', 'tax_percent_5',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_5',
									'size'=>'8',
									'class'=>'form-control  form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($item_tax_info[4]['name']) ? $item_tax_info[4]['name'] : ($this->Location->get_info_for_key('default_tax_5_name') ? $this->Location->get_info_for_key('default_tax_5_name') : $this->config->item('default_tax_5_name')))
								);?>
							</div>
	            <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_5',
									'size'=>'3',
									'class'=>'form-control form-inps-tax margin10',
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($item_tax_info[4]['percent']) ? $item_tax_info[4]['percent'] : '')
								);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
						</div>
					</div> <!--End more Taxes Container-->
	                <div class="clear"></div>
				</div>
			</div><!-- /panel-body-->
		</div><!--/panel-piluku-->
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
			'class'=>'submit_button floating-button btn btn-lg btn-primary')
		);
	?>
</div>

<?php  echo form_close(); ?>
</div>

			
<script type='text/javascript'>
<?php $this->load->view("partial/common_js"); ?>
	
	function commission_change()
	{
		if ($("#commission_type").val() == 'percent')
		{
			$("#commission-percent-calculation-container").show();
		}
		else
		{
			$("#commission-percent-calculation-container").hide();						
		}
	}
	
	$("#commission_type").change(commission_change);
	
	$(document).ready(commission_change);

	function get_taxes()
	{
		var taxes = [];
	
		if (!$("#override_default_tax").prop('checked'))
		{
			var default_taxes = <?php echo json_encode($this->Item_taxes_finder->get_info($item_info->item_id)) ?>;
	
			for(var k = 0;k<default_taxes.length;k++)
			{
				taxes.push({'percent': parseFloat(default_taxes[k]['percent']), 'cumulative':default_taxes[k]['cumulative'] == 1});
			}	
		}
		else
		{
			var k=0;
		
			$('.tax-container.main input[name="tax_percents[]"]').each(function()
			{
				if ($(this).val())
				{
					taxes.push({'percent': parseFloat($(this).val()), 'cumulative': k==1 && $("#tax_cumulatives").prop('checked')});
				}
			
				k++;
			});	
		}
		return taxes;
	
	}
	
	function get_total_tax_percent()
	{
		var total_tax_percent = 0;
		var taxes = get_taxes();
		for(var k = 0;k<taxes.length;k++)
		{
			total_tax_percent += parseFloat(taxes[k]['percent']);
		}
	
		return total_tax_percent;
	}

	function are_taxes_cumulative()
	{
		var taxes = get_taxes();
	
		return (taxes.length == 2 && taxes[1].cumulative);
	}

	function calculate_markup_percent()
	{
		if ($("#tax_included").prop('checked') )
		{
			var cost_price = parseFloat($('#cost_price').val());
			var unit_price = parseFloat($('#unit_price').val());

			var cumulative = are_taxes_cumulative();
		
			if (!cumulative)
			{
				//Markup amount
				//(100*.1)
				//100 + (100*.1) = 118.80 * .08 
	
				//cost price 100.00
				//8% tax
				//Markup 10%
				//110.00 before tax
				//selling price 118.80
				//100 * 1.1 = profit 10%	
	
	
				// X = COST PRICE
				// Y = MARKUP PERCENT
				// Z = SELLING PRICE
				// Q = TAX PERCENT
				//100 * (1+ (10/100)) = 118.80 - (100 * (1+ (10/100)) * 8/100);
	
				//X * (1+Y/100) = Z - (X * (1+(Y/100)) * Q/100)
				//Y = -(100 ((Q+100) X-100 Z))/((Q+100) X) and (Q+100) X!=0

				var tax_percent = parseFloat(get_total_tax_percent());
		
				var Z = unit_price;
				var X = cost_price;
				var Q = tax_percent;
				var markup_percent = -(100*((Q+100)*X-100*Z))/((Q+100)*X);
			}
			else
			{
				var taxes = get_taxes();
				var tax_1 = 1+(taxes[0]['percent']/100);
				var tax_2 = 1+(taxes[1]['percent']/100);
				markup_percent = (unit_price / (cost_price * tax_1 * tax_2) - 1) * 100;
			}

		}
		else
		{
			var cost_price = parseFloat($('#cost_price').val());
			var unit_price = parseFloat($('#unit_price').val());
			var markup_percent =  -100 + (100*(unit_price/cost_price));
		}

		markup_percent = parseFloat(Math.round(markup_percent * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
	
		$('#markup').val(markup_percent);
	}
	function calculate_markup_price()
	{		
		if ($("#tax_included").prop('checked') )
		{		
			var cost_price = parseFloat($('#cost_price').val());
			var markup_percent = parseFloat($("#markup").val());
		
			var cumulative = are_taxes_cumulative();
		
			if (!cumulative)
			{
				//markup amount
				//(100*.1)
				//100 + (100*.1) = 118.80 * .08 
	
				//cost price 100.00
				//8% tax
				//markup 10%
				//110.00 before tax
				//selling price 118.80
				//100 * 1.1 = profit 10%	
	
	
				// X = COST PRICE
				// Y = MARKUP PERCENT
				// Z = SELLING PRICE
				// Q = TAX PERCENT
				//100 * (1+ (10/100)) = 118.80 - (100 * (1+ (10/100)) * 8/100);
	
				//X * (1+Y/100) = Z - (X * (1+(Y/100)) * Q/100)
				//Z = (Q X Y+100 Q X+100 X Y+10000 X)/10000
			
				var tax_percent = get_total_tax_percent();
				
				var X = cost_price;
				var Y = markup_percent;
				var Q = tax_percent;
		
				var markup_price = (Q*X*Y+100*Q*X+100*X*Y+10000*X)/10000;		
			}
			else
			{
				var marked_up_price_before_tax = cost_price * (1+(markup_percent/100));
			
				var taxes = get_taxes();
				var cumulative_tax_percent = taxes[1]['percent'];
			
				var first_tax = (marked_up_price_before_tax*(taxes[0]['percent']/100));
				var second_tax = (marked_up_price_before_tax + first_tax) *(taxes[1]['percent']/100);
				var markup_price = marked_up_price_before_tax + first_tax + second_tax;
			}
		
			markup_price = parseFloat(Math.round(markup_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
		}
		else
		{
			var cost_price = parseFloat($('#cost_price').val());
			var markup_percent = parseFloat($("#markup").val());

			var markup_price = cost_price + (cost_price / 100 * (markup_percent));
			markup_price = parseFloat(Math.round(markup_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
		
		}

		$('#unit_price').val(markup_price);
	}
	
	<?php if ($this->config->item('enable_markup_calculator')) { ?>
	
	if ($('#unit_price').val() && $('#cost_price').val())
	{
		calculate_markup_percent();
	}
	
	$('#markup, #cost_price,.tax-container.main input[name="tax_percents[]"]').keyup(function()
	{
		if($("#markup").val() != '')
		{
			calculate_markup_price();
		}
	});
	
	<?php } ?>
	
	function calculate_margin_percent()
	{
		if ($("#tax_included").prop('checked') )
		{
			var cost_price = parseFloat($('#cost_price').val());
			var unit_price = parseFloat($('#unit_price').val());

			var cumulative = are_taxes_cumulative();
		
			if (!cumulative)
			{
				var tax_percent = parseFloat(get_total_tax_percent());
				var cost_price_inc_tax = cost_price * (1 + (tax_percent/100));
				var margin_percent = (100*(unit_price-cost_price_inc_tax))/unit_price;
			}
			else
			{
				var taxes = get_taxes();
				var first_tax = (cost_price*(taxes[0]['percent']/100));
				var second_tax = (cost_price + first_tax) *(taxes[1]['percent']/100);
				var cost_price_inc_tax = cost_price + first_tax + second_tax;
				//TODO this is wrong
				var margin_percent =  ((unit_price - cost_price_inc_tax) / unit_price)*100
			}
		}
		else
		{
			var cost_price = parseFloat($('#cost_price').val());
			var unit_price = parseFloat($('#unit_price').val());
			var margin_percent =  ((unit_price - cost_price) / unit_price)*100;
		}

		margin_percent = parseFloat(Math.round(margin_percent * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
		$('#margin').val(margin_percent);
	}
	function calculate_margin_price()
	{
		if ($("#tax_included").prop('checked') )
		{		
			var cost_price = parseFloat($('#cost_price').val());
			var margin_percent = parseFloat($("#margin").val());
		
			var cumulative = are_taxes_cumulative();
		
			if (!cumulative)
			{
				var tax_percent = get_total_tax_percent();
				
				var X = cost_price * (1+ (tax_percent/100));
				var Y = margin_percent;
				
				var margin_price = -1*((100*X)/ (Y-100)); 
			}
			else
			{
				var marked_up_price_before_tax = cost_price * (1+(margin_percent/100));
			
				var taxes = get_taxes();
			
				var first_tax = (marked_up_price_before_tax*(taxes[0]['percent']/100));
				var second_tax = (marked_up_price_before_tax + first_tax) *(taxes[1]['percent']/100);
				
				var X = cost_price + first_tax + second_tax;
				var Y = margin_percent;
				
				var margin_price = -1*((100*X)/ (Y-100)); 
			}
		
			margin_price = parseFloat(Math.round(margin_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
		}
		else
		{
			var cost_price = parseFloat($('#cost_price').val());
			var margin_percent = parseFloat($("#margin").val());

			var margin_price = -1*((100*cost_price)/ (margin_percent-100));
			margin_price = parseFloat(Math.round(margin_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
		
		}

		$('#unit_price').val(margin_price);
	}
	
	<?php if ($this->config->item('enable_margin_calculator')) { ?>
	
	if ($('#unit_price').val() && $('#cost_price').val())
	{
		calculate_margin_percent();
	}
	
	$('#margin, #cost_price,.tax-container.main input[name="tax_percents[]"]').keyup(function()
	{
		if($("#margin").val() != '')
		{
			calculate_margin_price();
		}
	});
	
	<?php } ?>
	
	
	date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);
	
	$(".override_default_tax_checkbox, .override_prices_checkbox, .override_default_commission").change(function()
	{
		$(this).parent().parent().next().toggleClass('hidden')
	});
	
	$(".tier_dropdown").on('change', function() {
		if($(this).val() == 'percent_off' || $(this).val() == 'cost_plus_percent')
		{
			$(this).siblings('.input-group-addon').find('.percent').toggleClass('hidden', false);
			$(this).siblings('.input-group-addon').find('.flat').toggleClass('hidden', true);
		} else {
			$(this).siblings('.input-group-addon').find('.percent').toggleClass('hidden', true);
			$(this).siblings('.input-group-addon').find('.flat').toggleClass('hidden', false);
		}
	});
	
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
		<?php foreach($tiers as $tier) { ?>
			"<?php echo 'item_tier['.$tier->id.']'; ?>":
			{
				number: true
			},
		<?php } ?>
			cost_price:
			{
				required:true,
				number:true
			},

			unit_price:
			{
				required:true,
				number:true
			},
			promo_price:
			{
				number: true
			},
		},
		submitHandler: function(form)
		{			
			var args = {
				next: {
					label: <?php echo json_encode(lang('common_edit').' '.lang('common_inventory')) ?>,
					url: <?php echo json_encode(site_url("items/inventory/".($item_info->item_id ? $item_info->item_id : -1)."?$query")); ?>
				}
			};
		
			doItemSubmit(form, args);
		}
		
	});
	
</script>
<?php $this->load->view('partial/footer'); ?>
