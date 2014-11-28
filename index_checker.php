<?php
if(isset($_POST['domain']) && $_POST['domain'] != "")
{
	$indexed = false;
		
	$domain = $_POST['domain'];
	
	$url = 'https://www.google.com/search?q='.$domain;

		$doc = new DOMDocument;
		@$doc->loadHTMLFile($url);
		
		$links = $doc->getElementsByTagName('li');

		foreach($links as $li)
		{
			if($li->hasAttribute('class'))
			{
				$class = $li->getAttribute('class');
				
					if($class == 'g')
					{
						$cite = $li->getElementsByTagName('cite')->item(0)->textContent;
			
							if(strpos($cite,$domain) !== false)
							{
								$indexed = true;
								break;
							}
					}
			}
		}
		
echo json_encode($indexed);
}
?>