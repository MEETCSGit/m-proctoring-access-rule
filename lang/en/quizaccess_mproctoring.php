<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for the quizaccess_MegaProctoring plugin.
 *
 * @package    quizaccess_MegaProctoring
 * @author     MEETCS(Atul, Rushab & Abhishek)
 * @copyright  Meetcs@2020
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
defined('MOODLE_INTERNAL') || die();
$string['mprocto'] = 'Add new template';
$string['quizaccess_mproctoring'] = 'Add new template';





$string['mproctoingcheckheader']="Please read and accept the following message";
$string['mproctoingcheckstatement']=" <h2>Screen Capturing and Audio Recording Permission. </h2>I authorize MEGA PROCTOR to capture the screen, click pictures and record the audio while I am attempting the examination. I understand what can be classified as cheating and plagiarism and I will not use unfair means during the examination. ";
$string['mproctoingchecklabel']=" I agree to the above statement.";
$string['youmustagree']='You must agree to this statement before you start the quiz.';
$string['youmustauth']='You must Authenticate yourself to login.';

$string['mproctoring']=" Mega Proctoring";
$string['enablemproctoing']="Require the use of MegaProctoring";
$string['enablemproctoing_help']="Enable MegaProctoring to track urls,screen capture & audio";
$string['enableurl']="Record URL";
$string['enableurl_help']="Record URL will quiz";
$string['enableaudio']="Record Audio";
$string['enableaudio_help']="Record Audio will quiz";
$string['enablescreencapture']="Record Audio";
$string['enablescreencapture_help']="Record Audio will quiz";
$string['browsererror']="Browser is not supported Please use Chrome  or extension is disabled or not installed";

$string['enableevent']="Capture browser focus event ";
$string['enableevent_help']="Capture browser outof focus event ";

$string['addtemplate'] = 'Add new template';
$string['allowedbrowserkeysdistinct'] = 'The keys must all be different.';
$string['allowedbrowserkeyssyntax'] = 'A key should be a 64-character hex string.';
$string['cachedef_config'] = 'MegaProctoring config cache';
$string['cachedef_configkey'] = 'MegaProctoring config key cache';
$string['cachedef_quizsettings'] = 'MegaProctoring quiz settings cache';
$string['cantdelete'] = 'The template can\'t be deleted as it has been used for one or more quizzes.';
$string['cantedit'] = 'The template can\'t be edited as it has been used for one or more quizzes.';
$string['clientrequiresmproctoring'] = 'This quiz has been configured to use the  MegaProctoring with client configuration.';
$string['confirmtemplateremovalquestion'] = 'Are you sure you want to remove this template?';
$string['confirmtemplateremovaltitle'] = 'Confirm template removal?';
$string['conflictingsettings'] = 'You don\'t have permission to update existing MegaProctoring settings.';
$string['content'] = 'Template';
$string['description'] = 'Description';
$string['disabledsettings'] = 'Disabled settings.';
$string['disabledsettings_help'] =' MegaProctoring quiz settings can\'t be changed if the quiz has been attempted. To change a setting, all quiz attempts must first be deleted.';
$string['downloadmproctoringconfig'] = 'Download MegaProctoring config file';
$string['duplicatetemplate'] = 'A template with the same name already exists.';
$string['edittemplate'] = 'Edit template';
$string['enabled'] = 'Enabled';
$string['event:accessprevented'] = "Quiz access was prevented";
$string['event:templatecreated'] = 'MegaProctoring template was created';
$string['event:templatedeleted'] = 'MegaProctoring template was deleted';
$string['event:templatedisabled'] = 'MegaProctoring template was disabled';
$string['event:templateenabled'] = 'MegaProctoring template was enabled';
$string['event:templateupdated'] = 'MegaProctoring template was updated';
$string['exitmproctoringbutton'] = 'Exit MegaProctoring';
$string['filemanager_mproctoringconfigfile'] = 'Upload MegaProctoring config file';
$string['filemanager_mproctoringconfigfile_help'] = 'Please upload your own MegaProctoring config file for this quiz.';
$string['filenotpresent'] = 'Please upload a MegaProctoring config file.';
$string['fileparsefailed'] = 'The uploaded file could not be saved as a MegaProctoring config file.';
$string['httplinkbutton'] = 'Download configuration';
$string['invalid_browser_key'] = "Invalid MegaProctoring browser key";
$string['invalid_config_key'] = "Invalid MegaProctoring config key";
$string['invalidkeys'] = "The config key or browser exam keys could not be validated. Please ensure you are using the MegaProctoring with correct configuration file.";
$string['invalidtemplate'] = "Invalid MegaProctoring config template";
$string['manage_templates'] = 'MegaProctoring templates';
$string['managetemplates'] = 'Manage templates';
$string['missingrequiredsettings'] = 'Config settings are missing some required values.';
$string['name'] = 'Name';
$string['newtemplate'] = 'New template';
$string['noconfigfilefound'] = 'No uploaded MegaProctoring config file could be found for quiz with cmid: {$a}';
$string['noconfigfound'] = 'No MegaProctoring config could be found for quiz with cmid: {$a}';
$string['not_mproctoring'] = 'No MegaProctoring is being used.';
$string['notemplate'] = 'No template';
$string['passwordnotset'] = 'Current settings require quizzes using the MegaProctoring to have a quiz password set.';
$string['pluginname'] = 'MegaProctoring access rules';
$string['privacy:metadata:quizaccess_mproctoring_quizsettings'] = 'MegaProctoring settings for a quiz. This includes the ID of the last user to create or modify the settings.';
$string['privacy:metadata:quizaccess_mproctoring_quizsettings:quizid'] = 'ID of the quiz the settings exist for.';
$string['privacy:metadata:quizaccess_mproctoring_quizsettings:timecreated'] = 'Unix time that the settings were created.';
$string['privacy:metadata:quizaccess_mproctoring_quizsettings:timemodified'] = 'Unix time that the settings were last modified.';
$string['privacy:metadata:quizaccess_mproctoring_quizsettings:usermodified'] = 'ID of user who last created or modified the settings.';
$string['privacy:metadata:quizaccess_mproctoring_template'] = 'MegaProctoring template settings. This includes the ID of the last user to create or modify the template.';
$string['privacy:metadata:quizaccess_mproctoring_template:timecreated'] = 'Unix time that the template was created.';
$string['privacy:metadata:quizaccess_mproctoring_template:timemodified'] = 'Unix time that the template was last modified.';
$string['privacy:metadata:quizaccess_mproctoring_template:usermodified'] = 'ID of user who last created or modified the template.';
$string['quizsettings'] = 'Quiz settings';
$string['restoredfrom'] = '{$a->name} (restored via cmid {$a->cmid})';
$string['mproctoring'] = 'MegaProctoring';
$string['mproctoring:bypassmproctoring'] = 'Bypass the requirement to view quiz in MegaProctoring.';
$string['mproctoring:manage_filemanager_mproctoringconfigfile'] = 'Change MegaProctoring quiz setting: Select MegaProctoring config file';
$string['mproctoring:manage_mproctoring_activateurlfiltering'] = 'Change MegaProctoring quiz setting: Activate URL filtering';
$string['mproctoring:manage_mproctoring_allowedbrowserexamkeys'] = 'Change MegaProctoring quiz setting: Allowed browser exam keys';
$string['mproctoring:manage_mproctoring_allowreloadinexam'] = 'Change MegaProctoring quiz setting: Allow reload';
$string['mproctoring:manage_mproctoring_allowspellchecking'] = 'Change MegaProctoring quiz setting: Enable spell checking';
$string['mproctoring:manage_mproctoring_allowuserquitmproctoring'] = 'Change MegaProctoring quiz setting: Allow quit';
$string['mproctoring:manage_mproctoring_enableaudiocontrol'] = 'Change MegaProctoring quiz setting: Enable audio control';
$string['mproctoring:manage_mproctoring_expressionsallowed'] = 'Change MegaProctoring quiz setting: Simple expressions allowed';
$string['mproctoring:manage_mproctoring_expressionsblocked'] = 'Change MegaProctoring quiz setting: Simple expressions blocked';
$string['mproctoring:manage_mproctoring_filterembeddedcontent'] = 'Change MegaProctoring quiz setting: Filter embedded content';
$string['mproctoring:manage_mproctoring_linkquitmproctoring'] = 'Change MegaProctoring quiz setting: Quit link';
$string['mproctoring:manage_mproctoring_muteonstartup'] = 'Change MegaProctoring quiz setting: Mute on startup';
$string['mproctoring:manage_mproctoring_quitpassword'] = 'Change MegaProctoring quiz setting: Quit password';
$string['mproctoring:manage_mproctoring_regexallowed'] = 'Change MegaProctoring quiz setting: Regex expressions allowed';
$string['mproctoring:manage_mproctoring_regexblocked'] = 'Change MegaProctoring quiz setting: Regex expressions blocked';
$string['mproctoring:manage_mproctoring_requiresafeexambrowser'] = 'Change MegaProctoring quiz setting: Require MegaProctoring';
$string['mproctoring:manage_mproctoring_showkeyboardlayout'] = 'Change MegaProctoring quiz setting: Show keyboard layout';
$string['mproctoring:manage_mproctoring_showreloadbutton'] = 'Change MegaProctoring quiz setting: Show reload button';
$string['mproctoring:manage_mproctoring_showmproctoringtaskbar'] = 'Change MegaProctoring quiz setting: Show task bar';
$string['mproctoring:manage_mproctoring_showtime'] = 'Change MegaProctoring quiz setting: Show time';
$string['mproctoring:manage_mproctoring_showwificontrol'] = 'Change MegaProctoring quiz setting: Show Wi-Fi control';
$string['mproctoring:manage_mproctoring_showmproctoringdownloadlink'] = 'Change MegaProctoring quiz setting: Show download link';
$string['mproctoring:manage_mproctoring_templateid'] = 'Change MegaProctoring quiz setting: Select MegaProctoring template';
$string['mproctoring:manage_mproctoring_userconfirmquit'] = 'Change MegaProctoring quiz setting: Confirm on quit';
$string['mproctoring:managetemplates'] = 'Manage MegaProctoring configuration templates';
$string['mproctoring_activateurlfiltering'] = 'Enable URL filtering';
$string['mproctoring_activateurlfiltering_help'] = 'If enabled, URLs will be filtered when loading web pages. The filter set has to be defined below.';
$string['mproctoring_allowedbrowserexamkeys'] = 'Allowed browser exam keys';
$string['mproctoring_allowedbrowserexamkeys_help'] = 'In this field you can enter the allowed browser exam keys for versions of MegaProctoring that are permitted to access this quiz. If no keys are entered, then browser exam keys are not checked.';
$string['mproctoring_allowreloadinexam'] = 'Enable reload in exam';
$string['mproctoring_allowreloadinexam_help'] = 'If enabled, page reload is allowed (reload button in MegaProctoring task bar, browser tool bar, iOS side slider menu, keyboard shortcut F5/cmd+R). Note that offline caching may break if a user tries to reload a page without an internet connection.';
$string['mproctoring_allowspellchecking'] = 'Enable spell checking';
$string['mproctoring_allowspellchecking_help'] = 'If enabled, spell checking in the MegaProctoring browser is allowed.';
$string['mproctoring_allowuserquitmproctoring'] = 'Enable quitting of MegaProctoring';
$string['mproctoring_allowuserquitmproctoring_help'] = 'If enabled, users can quit MegaProctoring with the "Quit" button in the MegaProctoring task bar or by pressing the keys Ctrl-Q or by clicking the main browser window close button.';
$string['mproctoring_enableaudiocontrol'] = 'Enable audio controls';
$string['mproctoring_enableaudiocontrol_help'] = 'If enabled, the audio control icon is shown in the MegaProctoring task bar.';
$string['mproctoring_expressionsallowed'] = 'Expressions allowed';
$string['mproctoring_expressionsallowed_help'] = 'A text field which contains the allowed filtering expressions for the allowed URLs. Use of the wildcard char \'\*\' is possible. Examples for expressions: \'example.com\' or \'example.com/stuff/\*\'. \'example.com\' matches \'example.com\', \'www.example.com\' and \'www.mail.example.com\'. \'example.com/stuff/\*\' matches all requests to any subdomain of \'example.com\' that have \'stuff\' as the first segment of the path.';
$string['mproctoring_expressionsblocked'] = 'Expressions blocked';
$string['mproctoring_expressionsblocked_help'] = 'A text field which contains the filtering expressions for the blocked URLs. Use of the wildcard char \'\*\' is possible. Examples for expressions: \'example.com\' or \'example.com/stuff/\*\'. \'example.com\' matches \'example.com\', \'www.example.com\' and \'www.mail.example.com\'. \'example.com/stuff/\*\' matches all requests to any subdomain of \'example.com\' that have \'stuff\' as the first segment of the path.';
$string['mproctoring_filterembeddedcontent'] = 'Filter also embedded content';
$string['mproctoring_filterembeddedcontent_help'] = 'If enabled, embedded resources will also be filtered using the filter set.';
$string['mproctoring_help'] = 'Setup quiz to use the MegaProctoring.';
$string['mproctoring_linkquitmproctoring'] = 'Show Exit MegaProctoring button, configured with this quit link';
$string['mproctoring_linkquitmproctoring_help'] = 'In this field you can enter the link to quit MegaProctoring. It will be used on an "Exit MegaProctoring" button on the page that appears after the exam is submitted. When clicking the button or the link placed wherever you want to put it, it is possible to quit MegaProctoring without having to enter a quit password. If no link is entered, then the "Exit MegaProctoring" button does not appear and there is no link set to quit MegaProctoring.';
$string['mproctoring_managetemplates'] = 'Manage MegaProctoring templates';
$string['mproctoring_muteonstartup'] = 'Mute on startup';
$string['mproctoring_muteonstartup_help'] = 'If enabled, audio is initially muted when starting MegaProctoring.';
$string['mproctoring_quitpassword'] = 'Quit password';
$string['mproctoring_quitpassword_help'] = 'This password is prompted when users try to quit MegaProctoring with the "Quit" button, Ctrl-Q or the close button in the main browser window. If no quit password is set, then MegaProctoring just prompts "Are you sure you want to quit MegaProctoring?".';
$string['mproctoring_regexallowed'] = 'Regex allowed';
$string['mproctoring_regexallowed_help'] = 'A text field which contains the filtering expressions for allowed URLs in a regular expression (Regex) format.';
$string['mproctoring_regexblocked'] = 'Regex blocked';
$string['mproctoring_regexblocked_help'] = 'A text field which contains the filtering expressions for blocked URLs in a regular expression (Regex) format.';
$string['mproctoring_requiresafeexambrowser'] = 'Require the use of MegaProctoring';
$string['mproctoring_requiresafeexambrowser_help'] = 'If enabled, students can only attempt the quiz using the MegaProctoring.
The available options are:

* No
<br/>MegaProctoring is not required to attempt the quiz.
* Yes – Use an existing template
<br/>A template for the configuration of MegaProctoring can be used. Templates are managed in the site administration. Your manual settings overwrite the settings in the template.
* Yes – Configure manually
<br/>No template for the configuration of MegaProctoring will be used. You can configure MegaProctoring manually.
* Yes – Upload my own config
<br/>You can upload your own MegaProctoring configuration file. All manual settings and the use of templates will be disabled.
* Yes – Use mproctoring client config
<br/>No configurations of MegaProctoring are on the Moodle side. The quiz can be attempted with any configuration of MegaProctoring.';
$string['mproctoring_showkeyboardlayout'] = 'Show keyboard layout';
$string['mproctoring_showkeyboardlayout_help'] = 'If enabled, the current keyboard layout is shown in the MegaProctoring task bar. It allows you to switch to other keyboard layouts, which have been enabled in the operating system.';
$string['mproctoring_showreloadbutton'] = 'Show reload button';
$string['mproctoring_showreloadbutton_help'] = 'If enabled, a reload button is displayed in the MegaProctoring task bar, allowing the current web page to be reloaded.';
$string['mproctoring_showmproctoringtaskbar'] = 'Show MegaProctoring task bar';
$string['mproctoring_showmproctoringtaskbar_help'] = 'If enabled, a task bar appears at the bottom of the MegaProctoring browser window. The task bar is required to display items such as Wi-Fi control, reload button, time and keyboard layout.';
$string['mproctoring_showtime'] = 'Show time';
$string['mproctoring_showtime_help'] = 'If enabled, the current time is displayed in the MegaProctoring task bar.';
$string['mproctoring_showwificontrol'] = 'Show Wi-Fi control';
$string['mproctoring_showwificontrol_help'] = 'If enabled, a Wi-Fi control button appears in the MegaProctoring task bar. The button allows users to reconnect to Wi-Fi networks which have previously been connected to.';
$string['mproctoring_showmproctoringdownloadlink'] = 'Show MegaProctoring download button';
$string['mproctoring_showmproctoringdownloadlink_help'] = 'If enabled, a button for MegaProctoring download will be shown on the quiz start page.';
$string['mproctoring_templateid'] = 'MegaProctoring config template';
$string['mproctoring_templateid_help'] = 'The settings in the selected config template will be used for the configuration of the MegaProctoring while attempting the quiz. You may overwrite the settings in the template with your manual settings.';
$string['mproctoring_use_client'] = 'Yes – Use MegaProctoring client config';
$string['mproctoring_use_manually'] = 'Yes – Configure manually';
$string['mproctoring_use_template'] = 'Yes – Use an existing template';
$string['mproctoring_use_upload'] = 'Yes – Upload my own config';
$string['mproctoring_userconfirmquit'] = 'Ask user to confirm quitting';
$string['mproctoring_userconfirmquit_help'] = 'If enabled, users have to confirm quitting of MegaProctoring when a quit link is detected.';
$string['mproctoringdownloadbutton'] = 'Download MegaProctoring';
$string['mproctoringlinkbutton'] = 'Launch MegaProctoring';
$string['mproctoringrequired'] = "This quiz has been configured so that students may only attempt it using the MegaProctoring.";
$string['setting:autoreconfiguremproctoring'] = 'Auto-configure MegaProctoring';
$string['setting:autoreconfiguremproctoring_desc'] = 'If enabled, users who navigate to the quiz using the MegaProctoring will be automatically forced to reconfigure their MegaProctoring.';
$string['setting:displayblocksbeforestart'] = 'Display blocks before starting quiz';
$string['setting:displayblocksbeforestart_desc'] = 'If enabled, blocks will be displayed before a user attempts the quiz.';
$string['setting:displayblockswhenfinished'] = 'Display blocks after finishing quiz';
$string['setting:displayblockswhenfinished_desc'] = 'If enabled, blocks will be displayed after a user has finished their quiz attempt.';
$string['setting:downloadlink'] = 'MegaProctoring download link';
$string['setting:downloadlink_desc'] = 'URL for downloading the MegaProctoring application.';
$string['setting:quizpasswordrequired'] = 'Quiz password required';
$string['setting:quizpasswordrequired_desc'] = 'If enabled, all quizzes that require the MegaProctoring must have a quiz password set.';
$string['setting:showhttplink'] = 'Show http:// link';
$string['setting:showmproctoringlink'] = 'Show MegaProctoring:// link';
$string['setting:showmproctoringlinks'] = 'Show MegaProctoring config links';
$string['setting:showmproctoringlinks_desc'] = 'Whether to show links for a user to access the MegaProctoring configuration file when access to the quiz is prevented. Note that MegaProctoring:// links may not work in every browser.';
$string['setting:supportedversions'] = 'Please note that the following minimum versions of the MegaProctoring client are required to use the config key feature: macOS - 2.1.5pre2, Windows - 3.0, iOS - 2.1.14.';
$string['settingsfrozen'] = 'Due to there being at least one quiz attempt, the MegaProctoring settings can no longer be updated.';
$string['unknown_reason'] = "Unknown reason";
$string['used'] = 'In use';
