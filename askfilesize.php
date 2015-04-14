<?php

function getimgsize($remoteFile) {
	$ch = curl_init($remoteFile);
	/* proxy stuff */
	#curl_setopt($ch, CURLOPT_PROXY, "http://proxy.student.otago.ac.nz:3128");
	#	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	#	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
	#curl_setopt($ch, CURLOPT_PROXYUSERPWD, "");
	/* end proxy stuff */
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
	/*print_r (curl_getinfo($ch));*/
	$data = curl_exec($ch);
	curl_close($ch);
	if ($data === false) {
	  echo 'cURL failed';
	  return NULL;
	}

  #echo $data."\n";
	$contentLength = 'unknown';
	$status = 'unknown';
	if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
	  $status = (int)$matches[1];
	}
	if (preg_match('/Content-[lL]ength: (\d+)/', $data, $matches)) {
	  $contentLength = (int)$matches[1];
	}
	/*
	echo 'HTTP Status: ' . $status . "\n";
	echo 'Content-Length: ' . $contentLength;
	*/
	return $contentLength;
}

?>
