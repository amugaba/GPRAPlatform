<?php
/**
 * MySQL Backup Script
 * This is run periodically by Cron to backup MySQL databases to a Zip archive.
 * Daily backups exclude tables with large file size.
 * Backups are saved for 1 month.
 * Backups created on the first of the month are saved forever.
 */

require __DIR__ . '/../vendor/autoload.php';

$server = "127.0.0.1";
$username = 'gpra_user';
$password = 'TM3TSLubjhyMmMnV!';
$databases = ['gpra_platform'];
$dumpSettings = [];
$dumpSettings['add-drop-table'] = true;
$destination_path = '/var/www/gpra.angstrom-software.com/app/backup/dumps/';

foreach($databases as $database) {
    echo date('Y-m-d').': Exporting '.$database;
    try {
        $dump = new Ifsnop\Mysqldump\Mysqldump("mysql:host=$server;dbname=$database", $username, $password, $dumpSettings);
        $dump->start($destination_path.$database.date('Ymd').'.sql');
        echo " --- Complete\n";
    } catch (\Exception $e) {
        echo 'mysqldump-php error: ' . $e->getMessage();
    }
}

//combine into Zip archive
$zip = new ZipArchive;
if ($zip->open($destination_path.date('Ymd').'.zip', ZipArchive::CREATE) === TRUE) {
    foreach($databases as $database)
        $zip->addFile($destination_path.$database.date('Ymd').'.sql', $database.date('Ymd').'.sql');
    $zip->close();
}

//delete SQL files and old archive unless it's first of the month
$pastMonth = date('Ymd', strtotime('-1 months'));
foreach($databases as $database)
    unlink($destination_path.$database.date('Ymd').'.sql');
if(date('j') !== "1")
    unlink($pastMonth.'.zip');
