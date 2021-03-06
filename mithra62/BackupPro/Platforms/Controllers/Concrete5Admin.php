<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/Controllers/Concrete5Admin.php
 */
namespace mithra62\BackupPro\Platforms\Controllers;

use mithra62\BackupPro\Platforms\Concrete5 as Platform;
use mithra62\BackupPro\Traits\Controller;
use mithra62\BackupPro\Platforms\View\Concrete5 AS Concrete5View;
use \Concrete\Core\Page\Controller\DashboardPageController;

/**
 * Backup Pro - Magento Base Controller
 *
 * Starts the Controllers up
 *
 * @package BackupPro\Controllers
 * @author Eric Lamb <eric@mithra62.com>
 */
class Concrete5Admin extends DashboardPageController
{
    use Controller;

    /**
     * The abstracted platform object
     * 
     * @var \mithra62\Platforms\Concrete5
     */
    protected $platform = null;

    /**
     * The Backup Pro Settings
     * 
     * @var array
     */
    protected $settings = array();

    /**
     * A container of system messages and errors
     * 
     * @var array
     */
    protected $bp_errors = array();

    /**
     * Set it up
     * 
     * @param unknown $id            
     * @param string $module            
     */
    public function __construct(\Concrete\Core\Page\Page $c)
    {
        parent::__construct($c);
        $this->initController();
        $this->platform = new Platform();
        $this->m62->setService('platform', function ($c) { 
            return $this->platform;
        });
        
        $this->m62->setDbConfig($this->platform->getDbCredentials());
        $this->settings = $this->services['settings']->get();
        $errors = $this->services['errors']->checkWorkingDirectory($this->settings['working_directory'])
            ->checkStorageLocations($this->settings['storage_details']);
            //->licenseCheck($this->settings['license_number'], $this->services['license']);
        
        if ($errors->totalErrors() == '0') {
            $errors = $errors->checkBackupState($this->services['backups'], $this->settings);
        }
        
        $this->bp_errors = $errors->getErrors();
        
        $this->view_helper = new Concrete5View($this->services['lang'], $this->services['files'], $this->services['settings'], $this->services['encrypt'], $this->platform);
        $this->m62->setService('view_helpers', function ($c) {
            return $this->view_helper;
        });
        
    }
    
    /**
     * Prepares the View layer for rendering
     * @param string $template The path to the view script to render 
     * @param array $vars Any variables to pass to the view
     * @return void
     */
    public function prepView($template, array $vars)
    {
        if(isset($vars['pageTitle']))
        {
            $vars['pageTitle'] = 'Backup Pro - '.$vars['pageTitle'];
        }
        
        $this->set('view_helper', $this->view_helper);
        $this->set('bp_errors', $this->bp_errors);
        $this->set('bp_static_path', rtrim($this->platform->getSiteUrl(), '/').'/packages/backup_pro/assets');
        //$this->set('__note_url', $this->url('/dashboard/backup_pro/manage/update_backup_note'));
        foreach($vars AS $key => $value)
        {
            $this->set($key, $value);
        }
        
        $this->requireAsset('b3_ui_assets');
        $this->render('/dashboard/backup_pro/'.$template);
    }
    
    /**
     * Returns an instance of the Concrete5 facade object
     * @return \Concrete\Core\Application\Application
     */
    public function getApp()
    {
        if(isset($this->app) && $this->app instanceof \Concrete\Core\Application\Application) {
            return $this->app;
        }
        
        $this->app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
        return $this->app;
    }
}