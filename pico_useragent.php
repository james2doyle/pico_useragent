<?php

/**
 * Sniff the browser and user agent string
 *
 * @author James Doyle
 * @link http://github.com/james2doyle/pico_useragent
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Useragent {

	private function _read_user_agent()
	{
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$u_agent = $_SERVER['HTTP_USER_AGENT'];
		} else {
			return false;
		}

		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";

		// First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/iPhone|iPod|iPad/i', $u_agent)) {
			$platform = 'ios';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		} elseif (preg_match('/Android/i', $u_agent)) {
			$platform = 'android';
		} elseif (preg_match('/BlackBerry/i', $u_agent)) {
			$platform = 'blackberry';
		}

		// Next get the name of the useragent seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} elseif(preg_match('/Firefox/i', $u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} elseif(preg_match('/Chrome/i', $u_agent)) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} elseif(preg_match('/Safari/i', $u_agent) && $platform == 'ios') {
			$bname = 'Apple Mobile Safari';
			$ub = "Safari";
		} elseif(preg_match('/Safari/i', $u_agent)) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} elseif(preg_match('/Opera/i', $u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		}

		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}

		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			// we will have two since we are not using 'other' argument yet
			// see if version is before or after the name
			if ($platform == 'ios') {
				$version = preg_replace("/(.*) OS ([0-9]*)_(.*)/","$2", $u_agent);
			} elseif (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version = $matches['version'][0];
			} else {
				$version = $matches['version'][1];
			}
		} else {
			$version = $matches['version'][0];
		}

		// check if we have a number
		if ($version == null || $version == "") {
			$version = "?";
		}

		$type = (preg_match('!(tablet|pad|mobile|phone|symbian|android|ipod|ios|blackberry|webos)!i', $u_agent)) ? 'mobile' : 'desktop';

		return array(
			'useragent' => $u_agent,
			'name'      => $bname,
			'browser'   => str_replace(' ', '-', strtolower($bname)),
			'version'   => $version,
			'type'   => $type,
			'platform'  => $platform,
			'pattern'   => $pattern
			);
	}

	public function before_render(&$twig_vars, &$twig)
	{
		$twig_vars['browser'] = $this->_read_user_agent();
		return;
	}

}

?>