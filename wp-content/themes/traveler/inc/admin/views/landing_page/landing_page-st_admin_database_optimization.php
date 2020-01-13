<div class="traveler-important-notice">
	<div class="traveler-registration-steps">
		<div class="feature-section st_admin_support">
			<div class="st_col_12">
				<h3>
					<?php echo __('Optimize Database table metabox',ST_TEXTDOMAIN)?>
				</h3>
				<p><?php echo __('Remove redundant records in the post meta table - Please confirm by keyword  : yes ,',ST_TEXTDOMAIN)?></p>
				<div class="updated" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;"><?php echo __('Recommend : To avoid losing data, Please backup the database before running',ST_TEXTDOMAIN)?></div>
				<p class="control-form">
					<input type="hidden" name="_s" id="st_security_optimize" value="<?php echo wp_create_nonce( "st_security_optimize" ); ?>">
					<input type="text" required name="st_optimize_meta_key" id="st_optimize_meta_key" placeholder="<?php echo __('Confirm',ST_TEXTDOMAIN)?>">
					<a class="button button-large button-primary" id="st_optimize_database"><?php echo __('Optimize',ST_TEXTDOMAIN)?><i class="fa fa-spin fa-spinner" style="display:none"></i></a>
				</p>
				
				
				
			</div>
		</div>
	</div>
	
</div>