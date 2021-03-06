<?php
/**
 * mithra62 - Backup Pro
 *
 * @author		Eric Lamb <eric@mithra62.com>
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/Platforms/Wordpress.php
 */
namespace mithra62\BackupPro\Platforms;

use JaegerApp\Platforms\WordPress as m62Wp;
use mithra62\BackupPro\Platforms\PlatformInterface;

/**
 * Backup Pro - Wordpress Bridge
 *
 * Contains the Wordpress specific items Backup Pro needs
 *
 * @package mithra62\BackupPro
 * @author Eric Lamb <eric@mithra62.com>
 */
class WordPress extends m62Wp implements PlatformInterface
{

    /**
     * (non-PHPdoc)
     * 
     * @see \mithra62\BackupPro\Platforms\PlatformInterface::getCronCommands()
     */
    public function getBackupCronCommands(array $settings)
    {
        $url = $this->getSiteUrl();
        return array(
            'file_backup' => array(
                'url' => $url . '?backup_pro=' . $settings['cron_query_key'] . '&backup=files&type=file',
                'cmd' => 'curl "' . $url . '?backup_pro=' . $settings['cron_query_key'] . '&backup=files&type=file"'
            ),
            'db_backup' => array(
                'url' => $url . '?backup_pro=' . $settings['cron_query_key'] . '&backup=files&type=db',
                'cmd' => 'curl "' . $url . '?backup_pro=' . $settings['cron_query_key'] . '&backup=files&type=db"'
            )
        );
    }

    /**
     * (non-PHPdoc)
     * 
     * @ignore
     *
     * @see \mithra62\BackupPro\Platforms\PlatformInterface::getEmailDetails()
     */
    public function getIaCronCommands(array $settings)
    {
        $url = $this->getSiteUrl();
        return array(
            'verify_backup_stability' => array(
                'url' => $url . '?backup_pro=' . $settings['cron_query_key'] . '&integrity=check',
                'cmd' => '0 * * * * * curl "' . $url . '?backup_pro=' . $settings['cron_query_key'] . '&integrity=check"'
            )
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see \mithra62\BackupPro\Platforms\PlatformInterface::getRestApiRouteEntry()
     */
    public function getRestApiRouteEntry(array $settings)
    {
        $url = $this->getSiteUrl();
        return $url.'?api_method=';
    }    
}