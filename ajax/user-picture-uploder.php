<?php
require '../config.php';
$userId = $_SESSION['SESS_USER_ID'];

use Aws\S3\Exception\S3Exception;

try {
    $s3 = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => 'ap-southeast-1',
        'credentials' => [
            'key' => DB_KEY,
            'secret' => DB_SC_KEY,
        ],
    ]);

    $bucket = 'medproasia-public';
    $data = $_POST["image"];
    $imageArray1 = explode(";", $data);
    $imageArray2 = explode(",", $imageArray1[1]);
    $imgData = base64_decode($imageArray2[1]);
    $tmpFile = tempnam(sys_get_temp_dir(), 'png');
    file_put_contents($tmpFile, $imgData);
    $filename = $userId . '.png';

    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key' => 'user-profile-pictures/' . $filename,
        'SourceFile' => $tmpFile,
        'ContentType' => 'image/png',
    ]);
    unlink($tmpFile);
} catch (S3Exception $e) {
    echo 'Error uploading content to S3: ' . $e->getMessage();
} catch (\Exception $e) {
    echo 'Error uploading content to S3: ' . $e->getMessage();
}
