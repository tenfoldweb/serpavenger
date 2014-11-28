<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Whois Class
 *
 * @author		G l a z z
 * @date		27.12.2010 13:40 PM
 */
class Domain {
	/**
	 * Error messages.
	 */
	var $errors = array(
		'error'       => 'An error occurred, please try again!',
		'invalid'     => 'Dom&iacute;nio &eacute; inv&aacute;lido!',
		'invalid tld' => 'O TLD <strong>.%s</strong> &eacute; invalido!'
	);

	var $servers = array();

	# --

	/**
	 * Constructor
     *
	 */
	public function __construct()
	{
		// Class loaded.
		//
            log_message('debug', 'Whois Class Initialized');

		// Load servers list.
		//
            $this->servers = $this->ServersList();
	}

	# --

	/**
	 * Domain Check function.
	 *
	 *	Check if domain is valid and if is available.
	 *
	 * @access	public
	 * @return	array
     *
	 */
	public function Check($domain)
	{
		// Separate both SLD and the TLD.
		//
		$split = explode ('.', $domain, 2);
		$sld = (isset($split[0])? $split[0] : '');
		$tld = (isset($split[1])? $split[1] : '');

	    // Check if domain is valid.
	    //
	    if (count($split) == 1 || ! preg_match("/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i", $domain)):
	        return array('code' => 0, 'domain' => $domain, 'tld' => $tld, 'message' => $this->errors['invalid']);

		// Check if TLD is valid.
		//
		elseif(!array_key_exists($tld, $this->servers)):
			return array('code' => 0, 'domain' => $domain, 'tld' => $tld, 'message' => sprintf($this->errors['invalid tld'], $tld));

		// Check domain.
		//
		else:
			return $this->Whois($domain, $tld);
		endif;
	}

	# --

	/**
	 * Servers List
	 *
	 *	Returns the whois servers list.
	 *
	 * @access	private
	 * @return	array
     *
	 */
	private function ServersList()
	{
		// Create the servers array.
		//
		$servers = array();

		// Loop trough the servers list and it them to the array.
		//
		foreach(parse_ini_file(dirname (__FILE__) . '/Domain.servers.ini') as $tld => $value):
			$value = explode('|', $value);
			$servers[$tld] = array('server' => trim(strip_tags($value[0])), 'return' => trim(strip_tags($value[1])));
		endforeach;

		// Return the servers.
		//
		return $servers;
	}

	# --

	private function Whois($domain, $tld)
	{

		$server = $this->servers[$tld]['server'];
		$return = $this->servers[$tld]['return'];

		$result = array();

		if (substr ($return, 0, 12) == 'HTTPREQUEST-'):
					$ch = curl_init();
					$url = $server . $domain;
					curl_setopt ($ch, CURLOPT_URL, $url);
					curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
					curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$data = curl_exec ($ch);
					curl_close ($ch);
					$data2 = ' ---' . $data;
					if (strpos ($data2, substr ($return, 12)) == true):
						$result['code']   = 1;
                        $result['domain'] = $domain;
						$result['tld']    = $tld;
						$result['whois']  = '';
					else:
						$result['code']   = 2;
                        $result['domain'] = $domain;
						$result['tld']    = $tld;
						$result['whois']  = nl2br(strip_tags($data));
					endif;
				else:
					$fp = @fsockopen ($server, 43, $errno, $errstr, 10);
					if ($fp):
						$data = '';
						@fputs ($fp, $domain . "\n");
						@socket_set_timeout ($fp, 10);
						while (!@feof ($fp)):
							$data .= @fread ($fp, 4096);
						endwhile;

						@fclose ($fp);
						$data2 = ' ---' . $data;
						if (strpos ($data2, $return) == true):
							$result['code']   = 1;
                            $result['domain'] = $domain;
							$result['tld']    = $tld;
							$result['whois']  = '';
						else:
							$result['code']   = 2;
                            $result['domain'] = $domain;
							$result['tld']    = $tld;
							$result['whois']  = nl2br($data);
						endif;
					else:
						$result['code']   = 0;
                        $result['domain'] = $domain;
						$result['tld']    = $tld;
					endif;
				endif;

				return $result;
	}

}

// END Domain Whois Class

/* End of file Domain.php */
/* Location: ./system/libraries/Domain.php */