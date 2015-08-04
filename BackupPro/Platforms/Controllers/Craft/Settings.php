<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/Controllers/Craft/Settings.php
 */
 
namespace mithra62\BackupPro\Platforms\Controllers\Craft;

/**
 * Backup Pro - Craft Settings Controller
 *
 * Contains the Settings Controller Actions for Craft
 *
 * @package 	BackupPro\Craft\Controllers
 * @author		Eric Lamb <eric@mithra62.com>
 */
trait Settings
{
    public function settings()
    {
        $section = ( \Craft\craft()->request->getParam('section') != '' ? \Craft\craft()->request->getParam('section') : 'general' );
        $variables = array('form_data' => $this->settings, 'form_errors' => $this->returnEmpty($this->settings));
        $variables['form_data']['cron_notify_emails'] = implode(PHP_EOL, $this->settings['cron_notify_emails']);
        $variables['form_data']['exclude_paths'] = implode(PHP_EOL, $this->settings['exclude_paths']);
        $variables['form_data']['backup_file_location'] = implode(PHP_EOL, $this->settings['backup_file_location']);
        $variables['form_data']['db_backup_archive_pre_sql'] = implode(PHP_EOL, $this->settings['db_backup_archive_pre_sql']);
        $variables['form_data']['db_backup_archive_post_sql'] = implode(PHP_EOL, $this->settings['db_backup_archive_post_sql']);
        $variables['form_data']['db_backup_execute_pre_sql'] = implode(PHP_EOL, $this->settings['db_backup_execute_pre_sql']);
        $variables['form_data']['db_backup_execute_post_sql'] = implode(PHP_EOL, $this->settings['db_backup_execute_post_sql']);
        
        if( \Craft\craft()->request->getRequestType() == 'POST' )
        {
            $data = \Craft\craft()->request->getPost();
        
            $variables['form_data'] = array_merge($this->multi, $data);
            $backup = $this->services['backups'];
            $backups = $backup->setBackupPath($this->settings['working_directory'])->getAllBackups($this->settings['storage_details']);
            $data['meta'] = $backup->getBackupMeta($backups);
            $settings_errors = $this->services['settings']->validate($data);
            if( !$settings_errors )
            {
                if( $this->services['settings']->update($data) )
                {
                    \Craft\craft()->userSession->setFlash('notice', $this->services['lang']->__('settings_updated'));
                    $this->redirect($this->platform->getCurrentUrl());
                }
            }
            else
            {
                $variables['form_errors'] = array_merge($variables['form_errors'], $settings_errors);
                \Craft\craft()->userSession->setError(\Craft\Craft::t($this->services['lang']->__('fix_form_errors')));
            }
        }
        
        $variables['section']= $section;
        $variables['db_tables'] = $this->services['db']->getTables();
        $variables['backup_cron_commands'] = $this->platform->getBackupCronCommands();
        $variables['ia_cron_commands'] = $this->platform->getIaCronCommands();
        $variables['errors'] = $this->errors;
        $variables['threshold_options'] = $this->services['settings']->getAutoPruneThresholdOptions();
        $variables['available_db_backup_engines'] = $this->services['backup']->getDataBase()->getAvailableEnginesOptions();
        $this->renderTemplate('backuppro/settings', $variables);
    }
}