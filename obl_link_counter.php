<?php
if(isset($_POST['domain']) && $_POST['domain'] != "")
{
$url = "http://".$_POST['domain'];
$pUrl = parse_url($url);

$doc = new DOMDocument;
@$doc->loadHTMLFile($url);

$links = $doc->getElementsByTagName('a');

$numLinks = 0;
foreach($links as $link)
{
    preg_match_all('/\S+/', strtolower($link->getAttribute('rel')), $rel);
	
    if(!$link->hasAttribute('href') || in_array('nofollow', $rel[0]))
      continue;

    // Exclude if internal link
    $href = $link->getAttribute('href');

    if(substr($href, 0, 2) === '//')
      $href = $pUrl['scheme'] . ':' . $href;

    $pHref = @parse_url($href);
	
    if(!$pHref || !isset($pHref['host']) || strtolower($pHref['host']) === strtolower($pUrl['host']))
      continue;

    $numLinks++;
}

echo json_encode($numLinks);
}
?>