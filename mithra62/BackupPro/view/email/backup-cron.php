
<?php
/**
 * mithra62 - Backup Pro
 *
 * @author		Eric Lamb
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/projects/view/backup-pro/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/view/email/backup-cron.php
 */
$this->setLayout('email/partials/_layout');
?>

<?php $this->capture(); ?>
<?php echo $this['content']?>
<?php $this->endCapture('body'); ?>