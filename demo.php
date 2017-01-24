<?php

  $url = 'https://api.openbd.jp/v1/coverage';
  $json = file_get_contents($url);
  $bd = json_decode($json, true );

  $data = preg_grep('/978487615.+?/', $bd);

  $isbns = implode(',', $data);

  $url_detail = 'https://api.openbd.jp/v1/get?isbn=' .$isbns;
  $json_detail = file_get_contents($url_detail);

  $detail = json_decode($json_detail, false );

  $html = "<ul>";

  foreach($detail as $key){
    $isbn = $key->summary->isbn;
    $pubdate = $key->summary->pubdate;
    $title = $key->summary->title;

    $html .= "<li>" .$pubdate .":" .$isbn .":" .$title ."</li>";
  }

  $html .= "</ul>";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<title>openDB</title>
<style>
</style>
</head>
<body>

<section>
<div>
<?=$html?>
</div>
</section>


</body>
</html>
