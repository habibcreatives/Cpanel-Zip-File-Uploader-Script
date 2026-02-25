<?php
// File uploader for cpanel / file manager
// Downloads a ZIP from a direct link and saves as plugin-backup.zip


// link where from fetch zip file 
$url = "https://download1590.mediafire.com/qaegyb5tpzjgXzYUVaj3hOFIaZoNX5u_UpjRzFrV3EC8xIoqxCRAzRiXT5uko0EaTieRJLE7Ij3Wyq0eKDwta7LyIGxgxslC_LXNfGQ_LtQBDF1xf42K7rsSnVhkmRhbXa54NzoTFpPUB2QxbQOXXeCM2d9JVzgzWQPL4zIia76dzU8/h9e6p05qvv0tvtq/plugin-backup.zip";

// Output File Name
$out = "plugin-backup.zip";

$fp = fopen($out, "w");
if (!$fp) die("Cannot write file: $out (permission?)");

$ch = curl_init($url);
curl_setopt_array($ch, [
  CURLOPT_FILE => $fp,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_CONNECTTIMEOUT => 30,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYPEER => true,
  CURLOPT_SSL_VERIFYHOST => 2,
  CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36",
  CURLOPT_HTTPHEADER => [
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.9"
  ],
]);
$ok = curl_exec($ch);
$err = curl_error($ch);
$http = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);
fclose($fp);

if (!$ok) die("Download failed (HTTP $http): $err");

$size = @filesize($out);
echo "Saved: $out<br>";
echo "HTTP: $http<br>";
echo "Size: " . ($size ? number_format($size/1024/1024, 2) . " MB" : "unknown") . "<br>";

if ($size !== false && $size < 200*1024) {
  echo "<b>Warning:</b> File too small — likely HTML/blocked/redirect page, not the ZIP.<br>";
  echo "Try again or use cPanel Terminal (wget/curl).";
}
?>