<?php

/**

Plugin Name: SalesAutomator

Version: 3.0.0

Plugin URI: 

Author: Will Berger

Author URI: 

Contributors: Will Berger

Donate Link: 

Tags: marketing,sales,leads,email,email marketing,crm

Description: This plugin provides you with a robust marketing automation system that you can use directly from within WordPress.  Think of having a Infusionsoft, Hubspot, Marketo like marketing automation build directly into wordpress ready to automate your marketing tasks.
System includes for every user a CRM, Email Marketing (Unlimited email blasts, auto responders, scheduled emails, Automatic Tracking and Scoring of every page or blog post read by your leads, seamless integration
with ThriveThemes, Ability to create rules/automations, Ability to easily tag leads, add custom fields for your leads and much more.

Text Domain: lo

Copyright: 2016

WordPress Versions: 3.1 and above

Tested up to: 3.5

Stable tag: Stable

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html





GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>

This program is free software; you can redistribute it and/or modify

it under the terms of the GNU General Public License as published by

the Free Software Foundation; either version 2 of the License, or

(at your option) any later version.



This program is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

global $lo_version;
global $lo_plugin_name;
global $lo_domain;
global $lo_api_url;

//
// naturalhealthrev.com
// 


$lo_version = "3.0.10";
$lo_plugin_name = "Sales Automator";
$lo_drpl_domain = 'https://leads.mysuccessbyseeds.com';
$lo_domain = 'https://leads.mysuccessbyseeds.com';
$lo_api_java = '/app/mce/API';
$lo_api_drpl = '/app';
$lo_kit_id = '5140';

/*
$lo_version = "3.0.0";
$lo_plugin_name = "Sales Automator";
$lo_drpl_domain = 'https://leads.mysuccessbyseeds.com';
$lo_domain = 'https://leads.mysuccessbyseeds.com';
$lo_api_java = '/app/mce/API';
$lo_api_drpl = '/app';$lo_kit_id = '5125';



$lo_version = "3.0.0";
$lo_plugin_name = "Sales Automator";
$lo_drpl_domain = 'http://leads.teamjavahealth.com';
$lo_domain = 'https://leads.teamjavahealth.com';
$lo_api_java = '/app/mce/API';
$lo_api_drpl = '/app';$lo_kit_id = '5124';

$lo_version = "3.0.0";
$lo_plugin_name = "Sales Automator";
$lo_drpl_domain = 'http://www.leadoutcome.com';
$lo_domain = 'http://www.leadoutcome.com';
$lo_api_java = '/app/mce/API';
$lo_api_drpl = '/app';
$lo_kit_id = '5124';


// Local Dev Env

$lo_version = "3.0.8";
$lo_plugin_name = "Sales Automator";
$lo_drpl_domain = 'http://leads.leadoutcomelocal.com';
$lo_domain = 'http://leads.leadoutcomelocal.com';
$lo_api_java = '/app/mce/API';
$lo_api_drpl = '/app';
$lo_kit_id = '5124';
*/



@define('LO_PLUGIN_DIR',plugin_dir_path(__FILE__));
@define('LO_PLUGIN_DIR_URL',plugin_dir_url( __FILE__ ));

//@define('JQUERY_UI_THEME','black-tie');
//@define('JQUERY_UI_THEME','blitzer');
//@define('JQUERY_UI_THEME','south-street');
//@define('JQUERY_UI_THEME','smoothness');

@define('JQUERY_UI_THEME','cupertino');


if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']))
{
	die('Access Denied');
}

global $is_IIS;

# hack for some IIS installations

if ($is_IIS && @ini_get('error_log') == '') @ini_set('error_log', 'syslog');


include_once('includes/config.php');
include_once('includes/functions.php');
include_once('includes/hooks.php');


register_activation_hook(__FILE__, 'lo_plugin_activate');



