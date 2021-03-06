<?php
function Install_EWD_OTP() {
	/* Add in the required globals to be able to create the tables */
  	global $wpdb;
   	global $EWD_OTP_db_version;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
    
	/* Create the Orders data table */  
   	$sql = "CREATE TABLE $EWD_OTP_orders_table_name (
  		Order_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Order_Name text DEFAULT '' NOT NULL,
		Order_Number text DEFAULT '' NOT NULL,
		Order_Status text DEFAULT '' NOT NULL,
		Order_External_Status text DEFAULT '' NOT NULL,
		Order_Location text DEFAULT '' NOT NULL,
		Order_Notes_Public text DEFAULT '' NOT NULL,
		Order_Notes_Private text DEFAULT '' NOT NULL,
		Order_Customer_Notes text DEFAULT '' NOT NULL,
		Order_Email text DEFAULT '' NOT NULL,
		Sales_Rep_ID mediumint(9) DEFAULT 0 NOT NULL,
		Customer_ID mediumint(9) DEFAULT 0 NOT NULL,
		WooCommerce_ID mediumint(9) DEFAULT 0 NOT NULL,
		Order_Status_Updated datetime DEFAULT '0000-00-00 00:00:00' NULL,
		Order_Display text DEFAULT '' NOT NULL,
		Order_Payment_Price text DEFAULT '' NOT NULL,
		Order_Payment_Completed text DEFAULT '' NOT NULL,
		Order_PayPal_Receipt_Number text DEFAULT '' NOT NULL,
		Order_View_Count mediumint(9) DEFAULT 0 NOT NULL,
		Order_Tracking_Link_Clicked text DEFAULT '' NOT NULL,
		Order_Tracking_Link_Code text DEFAULT '' NOT NULL,
  		UNIQUE KEY id (Order_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the Order Statuses data table */  
   	$sql = "CREATE TABLE $EWD_OTP_order_statuses_table_name (
  		Order_Status_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Order_ID mediumint(9) DEFAULT 0 NOT NULL,
		Order_Status text DEFAULT '' NOT NULL,
		Order_Location text DEFAULT '' NOT NULL,
		Order_Internal_Status text DEFAULT '' NOT NULL,
		Order_Status_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  		UNIQUE KEY id (Order_Status_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the Sales Rep data table */  
   	$sql = "CREATE TABLE $EWD_OTP_sales_reps (
  		Sales_Rep_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Sales_Rep_First_Name text DEFAULT '' NOT NULL,
		Sales_Rep_Last_Name text DEFAULT '' NOT NULL,
		Sales_Rep_Email text DEFAULT '' NOT NULL,
		Sales_Rep_WP_ID mediumint(9) DEFAULT 0 NOT NULL,
		Sales_Rep_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  		UNIQUE KEY id (Sales_Rep_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the Customers data table */  
   	$sql = "CREATE TABLE $EWD_OTP_customers (
  		Customer_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Customer_Name text DEFAULT '' NOT NULL,
		Sales_Rep_ID mediumint(9) DEFAULT 0 NOT NULL,
		Customer_WP_ID mediumint(9) DEFAULT 0 NOT NULL,
		Customer_FEUP_ID mediumint(9) DEFAULT 0 NOT NULL,
		Customer_Email text DEFAULT '' NOT NULL,
		Customer_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  		UNIQUE KEY id (Customer_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the custom fields table */
	$sql = "CREATE TABLE $EWD_OTP_fields_table_name (
  		Field_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Field_Name text DEFAULT '' NOT NULL,
		Field_Slug text DEFAULT '' NOT NULL,
		Field_Type text DEFAULT '' NOT NULL,
		Field_Description text DEFAULT '' NOT NULL,
		Field_Values text DEFAULT '' NOT NULL,
		Field_Front_End_Display text DEFAULT '' NOT NULL,
		Field_Required text DEFAULT '' NOT NULL,
		Field_Function text DEFAULT '' NOT NULL,
		Field_Display text DEFAULT '' NOT NULL,
		Field_Order mediumint(9) DEFAULT '9999',
		Field_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  		UNIQUE KEY id (Field_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the custom fields meta table */
	$sql = "CREATE TABLE $EWD_OTP_fields_meta_table_name (
  		Meta_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Field_ID mediumint(9) DEFAULT '0',
		Order_ID mediumint(9) DEFAULT '0',
		Meta_Value text DEFAULT '' NOT NULL,
  		UNIQUE KEY id (Meta_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
 		
	if (get_option("EWD_OTP_Full_Version") == "") {update_option("EWD_OTP_Full_Version", "No");}
	if (get_option("EWD_OTP_Custom_CSS") == "") {update_option("EWD_OTP_Custom_CSS", "");}
	if (get_option("EWD_OTP_AJAX_Reload") == "") {update_option("EWD_OTP_AJAX_Reload", "No");}
	if (get_option("EWD_OTP_New_Window") == "") {update_option("EWD_OTP_New_Window", "No");}
	if (get_option("EWD_OTP_Order_Email") == "") {update_option("EWD_OTP_Order_Email", "Never");}
	if (get_option("EWD_OTP_Order_Information") == "") {update_option("EWD_OTP_Order_Information", array(0 => "Order_Status", 1 => "Order_Updated"));}
	if (get_option("EWD_OTP_Hide_Blank_Fields") == "") {update_option("EWD_OTP_Hide_Blank_Fields", "No");}
	if (get_option("EWD_OTP_Form_Instructions") == "") {update_option("EWD_OTP_Form_Instructions", "Enter the order number you would like to track in the form below.");}
	if (get_option("EWD_OTP_Timezone") == "") {update_option("EWD_OTP_Timezone", "Europe/London");}
	if (get_option("EWD_OTP_Show_TinyMCE") == "") {update_option("EWD_OTP_Show_TinyMCE", "Yes");}
	
	if (get_option("EWD_OTP_Access_Role") == "") {update_option("EWD_OTP_Access_Role", "administrator");}
	if (get_option("EWD_OTP_WooCommerce_Integration") == "") {update_option("EWD_OTP_WooCommerce_Integration", "No");}
	if (get_option("EWD_OTP_WooCommerce_Prefix") == "") {update_option("EWD_OTP_WooCommerce_Prefix", "WC_");}
	if (get_option("EWD_OTP_WooCommerce_Random_Suffix") == "") {update_option("EWD_OTP_WooCommerce_Random_Suffix", "Yes");}
	if (get_option("EWD_OTP_WooCommerce_Show_On_Order_Page") == "") {update_option("EWD_OTP_WooCommerce_Show_On_Order_Page", "No");}
	if (get_option("EWD_OTP_Enabled_Locations_For_WooCommerce") == "") {update_option("EWD_OTP_Enabled_Locations_For_WooCommerce", "No");}
	if (get_option("EWD_OTP_Replace_WooCommerce_Statuses") == "") {update_option("EWD_OTP_Replace_WooCommerce_Statuses", "No");}
	if (get_option("EWD_OTP_WooCommerce_Revert_Statuses") == "") {update_option("EWD_OTP_WooCommerce_Revert_Statuses", "Yes");}
	if (get_option("EWD_OTP_WooCommerce_Paid_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_Paid_Order_Status", "Completed");}
	if (get_option("EWD_OTP_WooCommerce_Unpaid_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_Unpaid_Order_Status", "Pending Payment");}
	if (get_option("EWD_OTP_WooCommerce_Processing_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_Processing_Order_Status", "Processing");}
	if (get_option("EWD_OTP_WooCommerce_Cancelled_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_Cancelled_Order_Status", "Cancelled");}
	if (get_option("EWD_OTP_WooCommerce_OnHold_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_OnHold_Order_Status", "On Hold");}
	if (get_option("EWD_OTP_WooCommerce_Failed_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_Failed_Order_Status", "Failed");}
	if (get_option("EWD_OTP_WooCommerce_Refunded_Order_Status") == "") {update_option("EWD_OTP_WooCommerce_Refunded_Order_Status", "Refunded");}
	if (get_option("EWD_OTP_Display_Graphic") == "") {update_option("EWD_OTP_Display_Graphic", "Default");}
	if (get_option("EWD_OTP_Mobile_Stylesheet") == "") {update_option("EWD_OTP_Mobile_Stylesheet", "No");}
	if (get_option("EWD_OTP_Customer_Notes_Email") == "") {update_option("EWD_OTP_Customer_Notes_Email", "None");}
	if (get_option("EWD_OTP_Customer_Order_Email") == "") {update_option("EWD_OTP_Customer_Order_Email", "None");}
	if (get_option("EWD_OTP_Allow_Customer_Downloads") == "") {update_option("EWD_OTP_Allow_Customer_Downloads", "No");}
	if (get_option("EWD_OTP_Allow_Sales_Rep_Downloads") == "") {update_option("EWD_OTP_Allow_Sales_Rep_Downloads", "No");}

	if (get_option("EWD_OTP_Customer_Confirmation") == "") {update_option("EWD_OTP_Customer_Confirmation", "None");}
	if (get_option("EWD_OTP_Sales_Rep_Confirmation") == "") {update_option("EWD_OTP_Sales_Rep_Confirmation", "None");}
	if (get_option("EWD_OTP_Cut_Off_Days") == "") {update_option("EWD_OTP_Cut_Off_Days", 60);}

	if (get_option("EWD_OTP_Zendesk_Integration") == "") {update_option("EWD_OTP_Zendesk_Integration", "No");}

	if (get_option("EWD_OTP_Allow_Order_Payments") == "") {update_option("EWD_OTP_Allow_Order_Payments", "No");}
	if (get_option("EWD_OTP_Default_Payment_Status") == "") {update_option("EWD_OTP_Default_Payment_Status", "None");}
	if (get_option("EWD_OTP_PayPal_Email_Address") == "") {update_option("EWD_OTP_PayPal_Email_Address", "");}
	if (get_option("EWD_OTP_Pricing_Currency_Code") == "") {update_option("EWD_OTP_Pricing_Currency_Code", "AUD");}
	if (get_option("EWD_OTP_Thank_You_URL") == "") {update_option("EWD_OTP_Thank_You_URL", "");} 

	if (!is_array(get_option("EWD_OTP_Email_Messages_Array"))) {
		if (get_option("EWD_OTP_Message_Body") != "") {
			$Email_Messages_Array = array(
				array("Name" => "Default", "Message" => get_option("EWD_OTP_Message_Body"))
			);
			update_option("EWD_OTP_Email_Messages_Array", $Email_Messages_Array);
		}
		else {
			$Email_Messages_Array = array(
				array("Name" => "Default", "Message" => "Hello [order-name], You have an update for your order [order-number]!")
			);
			update_option("EWD_OTP_Email_Messages_Array", $Email_Messages_Array);
		}
	}
	if (get_option("EWD_OTP_Use_SMTP") == "") {update_option("EWD_OTP_Use_SMTP", "Yes");}
	if (get_option("EWD_OTP_Port") == "") {update_option("EWD_OTP_Port", "25");}
	if (get_option("EWD_OTP_Encryption_Type") == "") {update_option("EWD_OTP_Encryption_Type", "ssl");}

	if (get_option("EWD_OTP_Install_Time") == "") {update_option("EWD_OTP_Install_Time", time());}
		
   	add_option("EWD_OTP_db_version", $EWD_OTP_db_version);
	update_option('EWD_OTP_Install_Flag', "Yes");
	//add_option("EWD_OTP_Time_Frame", 60);
}
?>
