<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

/**
 * Create URL Title - modified version
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = FALSE)
    {
        if(preg_match("/[^A-Za-z0-9-_]+/",$str)){
            return md5($str);
        }
        if ($separator == 'dash')
        {
            $search        = '_';
            $replace    = '-';
        }
        else
        {
            $search        = '-';
            $replace    = '_';
        }

        $trans = array(
                        '&\#\d+?;'                => '',
                        '&\S+?;'                => '',
                        '\s+'                    => $replace,
                        '[^a-z袗袘袙袚覑袛袝袆衼袞袟袠袉蝎袊袡袣袥袦袧袨袩袪小孝校肖啸笑效楔些挟携鞋歇邪斜胁谐覒写械褦褢卸蟹懈褨褘褩泄泻谢屑薪芯锌褉褋褌褍褎褏褑褔褕褖褞褟褜褗0-9\-\._]' => '',
                        $replace.'+'            => $replace,
                        $replace.'$'            => $replace,
                        '^'.$replace            => $replace,
                        '\.+$'                    => ''
                      );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }

        if ($lowercase === TRUE)
        {
        	if( function_exists('mb_convert_case') )
			{
				$str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
			}
			
			else
			{
				$str = strtolower($str);
			}
        }
        
        return trim(stripslashes($str));
    }
}

// ------------------------------------------------------------------------

/**
 * Shorten URL
 *
 * Takes a long url and uses the TinyURL API to
 * return a shortened version.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	long url
 * @return	string  short url
 */
function shorten_url($url = '')
{
	$CI =& get_instance();
	
	$CI->load->library('cURL');

	if(!$url)
	{
		$url = site_url($CI->uri->uri_string());
	}
	
	// If no a protocol in URL, assume its a CI link
	elseif(!preg_match('!^\w+://! i', $url))
	{
		$url = site_url($url);
	}

	return $CI->curl->simple_get('http://tinyurl.com/api-create.php?url='.$url);
}

?>