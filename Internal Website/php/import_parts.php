<?php
$directory = '/home/ubuntu/parts';
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
foreach($scanned_directory as $key=>$value)
{
	//echo "Processing: $key $value\n";
	shell_exec("/usr/bin/php /var/www/html/import-args.php $key $value > /var/www/html/logs/$value.log 2>/var/www/html/logs/$value.log &");
}
echo "Main Process Done\n";
?>