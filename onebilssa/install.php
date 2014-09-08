<?
class Install{
	function __construct(){
		$sql='
			TRUNCATE `one_access`;
			TRUNCATE `one_cashe`;
			TRUNCATE `one_catalog`;
			TRUNCATE `one_codes`;
			TRUNCATE `one_codes_type`;
			TRUNCATE `one_cron`;
			TRUNCATE `one_data`;
			TRUNCATE `one_dealers`;
			TRUNCATE `one_dealers_balance`;
			TRUNCATE `one_dealers_common_files`;
			TRUNCATE `one_dealers_consignee`;
			TRUNCATE `one_dealers_files`;
			TRUNCATE `one_dealers_orders`;
			TRUNCATE `one_dealers_orders_history`;
			TRUNCATE `one_dealers_orders_items`;
			TRUNCATE `one_dealers_orders_status`;
			TRUNCATE `one_dealers_status`;
			TRUNCATE `one_dealers_stores`;
			TRUNCATE `one_fields`;
			TRUNCATE `one_files`;
			TRUNCATE `one_forms`;
			TRUNCATE `one_forms_answers`;
			TRUNCATE `one_forms_fields`;
			TRUNCATE `one_forum`;
			TRUNCATE `one_groups`;
			TRUNCATE `one_igroups`;
			TRUNCATE `one_infoblock`;
			TRUNCATE `one_iusers`;
			TRUNCATE `one_iusers_address`;
			TRUNCATE `one_iusers_adds`;
			TRUNCATE `one_iusers_balance`;
			TRUNCATE `one_iusers_bonuses`;
			TRUNCATE `one_iusers_files`;
			TRUNCATE `one_iusers_filter`;
			TRUNCATE `one_iusers_options`;
			TRUNCATE `one_iusers_status`;
			TRUNCATE `one_modules`;
			TRUNCATE `one_multival`;
			TRUNCATE `one_notification`;
			TRUNCATE `one_orders`;
			TRUNCATE `one_orders_items`;
			TRUNCATE `one_orders_opinion`;
			TRUNCATE `one_price`;
			TRUNCATE `one_reference`;
			TRUNCATE `one_reference_files`;
			TRUNCATE `one_relations`;
			TRUNCATE `one_reports`;
			TRUNCATE `one_search`;
			TRUNCATE `one_subscribers`;
			TRUNCATE `one_translator`;
			TRUNCATE `one_tree`;
			TRUNCATE `one_users`;
			TRUNCATE `one_user_options`;
			TRUNCATE `one_votes`;
		';
		DB::exec($sql);
	}
}
?>