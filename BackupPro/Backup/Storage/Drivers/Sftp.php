<?php
/**
 * mithra62 - Backup Pro
 *
 * @author		Eric Lamb <eric@mithra62.com>
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/Backup/Storage/Sftp.php
 */
namespace mithra62\BackupPro\Backup\Storage\Drivers;

use mithra62\BackupPro\Backup\Storage\AbstractStorage;
use mithra62\BackupPro\Exceptions\Backup\StorageException;

/**
 * Backup Pro - SFTP Storage Object
 *
 * Driver for storing files on a remote SFTP/SSH server
 *
 * @package 	Backup\Storage\Driver
 * @author		Eric Lamb <eric@mithra62.com>
 */
class Sftp extends AbstractStorage
{
    /**
     * The name of the Storage Driver
     * @var string
     */
    protected $name = 'backup_pro_sftp_storage_driver_name';
    
    /**
     * A description of the Storage Driver
     * @var string
     */
    protected $desc = 'backup_pro_sftp_storage_driver_description';
    
    /**
     * The settings the Storage Driver provides
     * @var string
     */
    protected $settings = array(
        'sftp_host' => '',
        'sftp_port' => 22,
        'sftp_username' => '',
        'sftp_password' => '',
        'sftp_private_key' => '',
        'sftp_root' => '',
        'sftp_timeout' => 10,
    );
    
    /**
     * Boolean to determine whether the auto prune setting should apply to the Storage Driver
     * @var boolean
     */
    protected $prune_include = true;
    
    /**
     * The file name, sans .png extention, for the icon
     * @var string
     */
    protected $icon_name = 'sftp';
    
    /**
     * A slug for use; must be unique
     * @var string
     */
    protected $short_name = 'sftp';

    /**
     * Whether the selected Driver can supply download URLs
     * @var bool
     */
    protected $can_download = false;
    
    /**
     * Whether the selected Driver can allow for restores
     * @var bool
     */
    protected $can_restore = false;
    
    /**
     * Should remove the given directory path
     * @param string $path The path to the file
     */
    public function removeDir($path)
    {
        
    }
    
    /**
     * Should remove all the files and directories from the given path
     */
    public function clearFiles()
    {
        
    }
    
    /**
     * Should create a file using the Driver service
     * @param string $file The path to the file to create on the service
     * @param string $type
     * @return bool
     */
    public function createFile($file, $type = 'database')
    {
        
    }
    
    /**
     * Should validate the Driver settings using the \mithra62\Validate object
     * @param \mithra62\Validate $validate
     * @param array $settings
     * @param array $drivers
     * @return \mithra62\Validate
     */
    public function validateSettings(\mithra62\Validate $validate, array $settings, array $drivers = array())
    {
        $validate->rule('required', 'sftp_host')->message('{field} is required');
        $validate->rule('required', 'sftp_port')->message('{field} is required');
        $validate->rule('numeric', 'sftp_port')->message('{field} must be a number');
        $validate->rule('required', 'sftp_timeout')->message('{field} is required');
        $validate->rule('required', 'sftp_root')->message('{field} is required');
        $validate->rule('numeric', 'sftp_timeout')->message('{field} must be a number');
        
        return $validate;
    }
    
    /**
     * Should remove a file from the remove service
     * @param string $file The path to the file
     * @param string $type
     */
    public function removeFile($file, $type = 'database')
    {
        
    }
    
    /**
     * Should remove all the files from within the path
     * @param string $path The path to the file
     */
    public function removeFiles($path)
    {
        
    }
}