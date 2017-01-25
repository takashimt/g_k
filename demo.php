<?php

  $url = 'https://api.openbd.jp/v1/coverage'; // openbdの /covrerage のURLを指定
  $json = file_get_contents($url); // openbdの /covrerage から全件のISBNを一覧したjsonを取得
  $bd = json_decode($json, true ); // json_decode のオプションを true とすることで配列として扱う

  $data = preg_grep('/978487615.+?/', $bd); // 正規表現でISBNの出版社記号（ registrant、この場合は87615（語研））を含む値を配列として抽出

  $isbns = implode(',', $data); // 抽出した配列をカンマ区切りの文字列に implode する

  $url_detail = 'https://api.openbd.jp/v1/get?isbn=' .$isbns; // openbdの /get?isbn=ISBN,ISBN... で、個々の書誌情報を一括で取得するjsonのURLを指定
  $json_detail = file_get_contents($url_detail);
  $detail = json_decode($json_detail, false ); // json_decode のオプションを false とすることでオブジェクトとして扱う

/** 以下、foreach を使ってオブジェクト（個々の書誌データ）の summary からISBN・出版日・タイトルを取得してリストとしてHTMLに書き出す */

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
