<?php



function listmsgs ($vmdir,$audio_extension) {
    
    // msg extension
    $msg_extension = array('txt');

    // directory to scan
    $scandir = new DirectoryIterator($vmdir);

    // iterate
    foreach ($scandir as $fileinfo) {
        // must be a file
        if ($fileinfo->isFile()) {
            // file extension
            $extension = strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
            // check if extension match
            if (in_array($extension, $audio_extension)) {
                // add to result
                $audiolist[] = $fileinfo->getPathname();
            }

             if (in_array($extension, $msg_extension)) {
                // add to result
                $msglist[] = $fileinfo->getPathname();
            }
        }
    }
    for ($i=0; $i <= count($msglist)-1; $i++ ) {
        
        $result['txt-'.$i] = $msglist[$i];
        $result['audio-'.$i] = preg_replace("/txt/",$audio_extension[0],$msglist[$i]);
        
    }
    
    return $result;
}

function detailmsg ($file,$search = array('callerid','origtime','duration')) {
    
    $loop = true;
    $i = 0;
    
    //echo "arquivo para processar: ".$file."\n";    
    
    while ($loop == true) {

        $searchfor = $search[$i];
        $contents = file_get_contents($file);
        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";

            if(preg_match_all($pattern, $contents, $matches)){
               
               $find = implode("\n", $matches[0]);
               $find = substr($find, strpos($find, "=") + 1);
               $result[$searchfor] = $find;
               
            }
            else{
                
               echo "No matches found";
               
            }
            
            if ($i == count($search)-1) {

                $loop = false;

            }else{

                $i++;
            }
        }
        
    return $result;
}

$msgs = listmsgs('/home/nicolas/teste/',array('wav'));

$mensagem = detailmsg($msgs['txt-0']);

echo "Lista dos arquivos encontrados:\n";
print_r($msgs);

echo "Detalhes do arquivo:".$msgs['txt-0']."\n";
print_r($mensagem);


?>
