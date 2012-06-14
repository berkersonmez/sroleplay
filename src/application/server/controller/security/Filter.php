<?php

// Functions about filtering.
class C_Security_Filter
{

    // crypts given password. More complicated techniques may be used
    public static function cryptPassword($password)
    {
        return hash('whirlpool', $password);
        //return md5($password);
    }

    /* filters queries to prevent unwanted characters that may cause SQL injections.
    public static function queryFilter($text) {
        return trim(htmlentities(mb_convert_encoding($text, 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'));
    }*/

    public static function textFilter($text)
    {
        return $text;
    }

    public static function stringFilter($string)
    {
        return filter_var(trim($string), FILTER_SANITIZE_STRING);
    }

    public static function urlFilter($string)
    {
        return urlencode($string);
    }

    public static function numericFilter($string)
    {
        return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function emailFilter($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    // -------------------------------------------------------------------------
    // Security methods extracted from CodeIgniter 2.1
    // -------------------------------------------------------------------------

    /**
     * Clean Input Data
     *
     * This is a helper function. It escapes data and
     * standardizes newline characters to \n
     *
     * @param    string
     * @return    string
     */
    public static function queryFilter($str, $enableXSS = true)
    {
        if (is_array($str)) {
            $new_array = array();
            foreach ($str as $key => $val)
            {
                $new_array[self::cleanInputKeys($key)] = self::queryFilter($val);
            }
            return $new_array;
        }

        /* We strip slashes if magic quotes is on to keep things consistent

             NOTE: In PHP 5.4 get_magic_quotes_gpc() will always return 0 and
               it will probably not exist in future versions at all.
          */
        if (!self::isPHP('5.4') && get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }

        // Remove control characters
        $str = self::removeInvisibleCharacters($str);

        // Should we filter the input data?
        if ($enableXSS === TRUE) {
            $str = self::xssClean($str);
        }

        // Standardize newlines
        if (strpos($str, "\r") !== FALSE) {
            $str = str_replace(array("\r\n", "\r", "\r\n\n"), PHP_EOL, $str);
        }

        return $str;
    }

    /**
     * Clean Keys
     *
     * This is a helper function. To prevent malicious users
     * from trying to exploit keys we make sure that keys are
     * only named with alpha-numeric text and a few other items.
     *
     * @param    string
     * @return    string
     */
    public static function cleanInputKeys($str)
    {
        if (!preg_match("/^[a-z0-9:_\/-]+$/i", $str)) {
            throw new Exception('İzin verilmeyen karakterler mevcut!');
        }

        return $str;
    }

    /**
     * Remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param    string
     * @return    string
     */
    public static function removeInvisibleCharacters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10)
        // carriage return (dec 13), and horizontal tab (dec 09)

        if ($url_encoded) {
            $non_displayables[] = '/%0[0-8bcef]/'; // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/'; // url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'; // 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }

    /**
     * XSS Clean
     *
     * Sanitizes data so that Cross Site Scripting Hacks can be
     * prevented.  This function does a fair amount of work but
     * it is extremely thorough, designed to prevent even the
     * most obscure XSS attempts.  Nothing is ever 100% foolproof,
     * of course, but I haven't been able to get anything passed
     * the filter.
     *
     * Note: This function should only be used to deal with data
     * upon submission.  It's not something that should
     * be used for general runtime processing.
     *
     * This function was based in part on some code and ideas I
     * got from Bitflux: http://channel.bitflux.ch/wiki/XSS_Prevention
     *
     * To help develop this script I used this great list of
     * vulnerabilities along with a few other hacks I've
     * harvested from examining vulnerabilities in other programs:
     * http://ha.ckers.org/xss.html
     *
     * @param    mixed    string or array
     * @param     bool
     * @return    string
     */
    public static function xssClean($str, $is_image = FALSE)
    {
        /*
           * Is the string an array?
           *
           */
        if (is_array($str)) {
            while (list($key) = each($str))
            {
                $str[$key] = self::xssClean($str[$key]);
            }

            return $str;
        }

        /*
           * Remove Invisible Characters
           */
        $str = self::removeInvisibleCharacters($str);

        // Validate Entities in URLs
        /*
           * Protect GET variables in URLs
           */

        // 901119URL5918AMP18930PROTECT8198

        $str = preg_replace('|\&([a-z\_0-9\-]+)\=([a-z\_0-9\-]+)|i', self::xssHash() . "\\1=\\2", $str);

        /*
           * Validate standard character entities
           *
           * Add a semicolon if missing.  We do this to enable
           * the conversion of entities to ASCII later.
           *
           */
        $str = preg_replace('#(&\#?[0-9a-z]{2,})([\x00-\x20])*;?#i', "\\1;\\2", $str);

        /*
           * Validate UTF16 two byte encoding (x00)
           *
           * Just as above, adds a semicolon if missing.
           *
           */
        $str = preg_replace('#(&\#x?)([0-9A-F]+);?#i', "\\1\\2;", $str);

        /*
           * Un-Protect GET variables in URLs
           */
        $str = str_replace(self::xssHash(), '&', $str);

        /*
           * URL Decode
           *
           * Just in case stuff like this is submitted:
           *
           * <a href="http://%77%77%77%2E%67%6F%6F%67%6C%65%2E%63%6F%6D">Google</a>
           *
           * Note: Use rawurldecode() so it does not remove plus signs
           *
           */
        $str = rawurldecode($str);

        /*
           * Convert character entities to ASCII
           *
           * This permits our tests below to work reliably.
           * We only convert entities that are within tags since
           * these are the ones that will pose security problems.
           *
           */

        //$str = preg_replace_callback("/[a-z]+=([\'\"]).*?\\1/si", array($this, '_convert_attribute'), $str);

        //$str = preg_replace_callback("/<\w+.*?(?=>|<|$)/si", array($this, '_decode_entity'), $str);

        /*
           * Remove Invisible Characters Again!
           */
        $str = self::removeInvisibleCharacters($str);

        /*
           * Convert all tabs to spaces
           *
           * This prevents strings like this: ja	vascript
           * NOTE: we deal with spaces between characters later.
           * NOTE: preg_replace was found to be amazingly slow here on
           * large blocks of data, so we use str_replace.
           */

        if (strpos($str, "\t") !== FALSE) {
            $str = str_replace("\t", ' ', $str);
        }

        /*
           * Capture converted string for later comparison
           */
        $converted_string = $str;

        /*
           * Makes PHP tags safe
           *
           * Note: XML tags are inadvertently replaced too:
           *
           * <?xml
           *
           * But it doesn't seem to pose a problem.
           */
        if ($is_image === TRUE) {
            // Images have a tendency to have the PHP short opening and
            // closing tags every so often so we skip those and only
            // do the long opening tags.
            $str = preg_replace('/<\?(php)/i', "&lt;?\\1", $str);
        }
        else
        {
            $str = str_replace(array('<?', '?' . '>'), array('&lt;?', '?&gt;'), $str);
        }

        /*
           * Compact any exploded words
           *
           * This corrects words like:  j a v a s c r i p t
           * These words are compacted back to their correct state.
           */
        $words = array(
            'javascript', 'expression', 'vbscript', 'script',
            'applet', 'alert', 'document', 'write', 'cookie', 'window'
        );

        $filterInstance = new C_Security_Filter();
        foreach ($words as $word)
        {
            $temp = '';

            for ($i = 0, $wordlen = strlen($word); $i < $wordlen; $i++)
            {
                $temp .= substr($word, $i, 1) . "\s*";
            }

            // We only want to do this when it is followed by a non-word character
            // That way valid stuff like "dealer to" does not become "dealerto"
            $str = preg_replace_callback('#(' . substr($temp, 0, -3) . ')(\W)#is', array($filterInstance, '_compact_exploded_words'), $str);
        }

        /*
           * Remove disallowed Javascript in links or img tags
           * We used to do some version comparisons and use of stripos for PHP5,
           * but it is dog slow compared to these simplified non-capturing
           * preg_match(), especially if the pattern exists in the string
           */
        do
        {
            $original = $str;

            if (preg_match("/<a/i", $str)) {
                $str = preg_replace_callback("#<a\s+([^>]*?)(>|$)#si", array($filterInstance, '_js_link_removal'), $str);
            }

            if (preg_match("/<img/i", $str)) {
                $str = preg_replace_callback("#<img\s+([^>]*?)(\s?/?>|$)#si", array($filterInstance, '_js_img_removal'), $str);
            }

            if (preg_match("/script/i", $str) OR preg_match("/xss/i", $str)) {
                $str = preg_replace("#<(/*)(script|xss)(.*?)\>#si", '[removed]', $str);
            }
        }
        while ($original != $str);

        unset($original);

        // Remove evil attributes such as style, onclick and xmlns
        $str = $filterInstance->_remove_evil_attributes($str, $is_image);

        /*
           * Sanitize naughty HTML elements
           *
           * If a tag containing any of the words in the list
           * below is found, the tag gets converted to entities.
           *
           * So this: <blink>
           * Becomes: &lt;blink&gt;
           */
        $naughty = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
        $str = preg_replace_callback('#<(/*\s*)(' . $naughty . ')([^><]*)([><]*)#is', array($filterInstance, '_sanitize_naughty_html'), $str);

        /*
           * Sanitize naughty scripting elements
           *
           * Similar to above, only instead of looking for
           * tags it looks for PHP and JavaScript commands
           * that are disallowed.  Rather than removing the
           * code, it simply converts the parenthesis to entities
           * rendering the code un-executable.
           *
           * For example:	eval('some code')
           * Becomes:		eval&#40;'some code'&#41;
           */
        $str = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $str);

        /*
           * Images are Handled in a Special Way
           * - Essentially, we want to know that after all of the character
           * conversion is done whether any unwanted, likely XSS, code was found.
           * If not, we return TRUE, as the image is clean.
           * However, if the string post-conversion does not matched the
           * string post-removal of XSS, then it fails, as there was unwanted XSS
           * code found and removed/changed during processing.
           */

        if ($is_image === TRUE) {
            return ($str == $converted_string) ? TRUE : FALSE;
        }

        return $str;
    }

    /**
     * Random Hash for protecting URLs
     *
     * @return    string
     */
    public static function xssHash()
    {
        mt_srand();
        return md5(time() + mt_rand(0, 1999999999));
    }

    /**
     * Compact Exploded Words
     *
     * Callback function for xss_clean() to remove whitespace from
     * things like j a v a s c r i p t
     *
     * @param    type
     * @return    type
     */
    public function _compact_exploded_words($matches)
    {
        return preg_replace('/\s+/s', '', $matches[1]) . $matches[2];
    }

    /**
     * JS Link Removal
     *
     * Callback function for xss_clean() to sanitize links
     * This limits the PCRE backtracks, making it more performance friendly
     * and prevents PREG_BACKTRACK_LIMIT_ERROR from being triggered in
     * PHP 5.2+ on link-heavy strings
     *
     * @param    array
     * @return    string
     */
    public function _js_link_removal($match)
    {
        $attributes = $this->_filter_attributes(str_replace(array('<', '>'), '', $match[1]));

        return str_replace($match[1], preg_replace("#href=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|base64\s*,)#si", "", $attributes), $match[0]);
    }

    /**
     * JS Image Removal
     *
     * Callback function for xss_clean() to sanitize image tags
     * This limits the PCRE backtracks, making it more performance friendly
     * and prevents PREG_BACKTRACK_LIMIT_ERROR from being triggered in
     * PHP 5.2+ on image tag heavy strings
     *
     * @param    array
     * @return    string
     */
    public function _js_img_removal($match)
    {
        $attributes = $this->_filter_attributes(str_replace(array('<', '>'), '', $match[1]));

        return str_replace($match[1], preg_replace("#src=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|base64\s*,)#si", "", $attributes), $match[0]);
    }

    /**
     * Filter Attributes
     *
     * Filters tag attributes for consistency and safety
     *
     * @param    string
     * @return    string
     */
    public function _filter_attributes($str)
    {
        $out = '';

        if (preg_match_all('#\s*[a-z\-]+\s*=\s*(\042|\047)([^\\1]*?)\\1#is', $str, $matches)) {
            foreach ($matches[0] as $match)
            {
                $out .= preg_replace("#/\*.*?\*/#s", '', $match);
            }
        }

        return $out;
    }

    /*
      * Remove Evil HTML Attributes (like evenhandlers and style)
      *
      * It removes the evil attribute and either:
      * 	- Everything up until a space
      *		For example, everything between the pipes:
      *		<a |style=document.write('hello');alert('world');| class=link>
      * 	- Everything inside the quotes
      *		For example, everything between the pipes:
      *		<a |style="document.write('hello'); alert('world');"| class="link">
      *
      * @param string $str The string to check
      * @param boolean $is_image TRUE if this is an image
      * @return string The string with the evil attributes removed
      */
    public function _remove_evil_attributes($str, $is_image)
    {
        // All javascript event handlers (e.g. onload, onclick, onmouseover), style, and xmlns
        $evil_attributes = array('on\w*', 'style', 'xmlns', 'formaction');

        if ($is_image === TRUE) {
            /*
                * Adobe Photoshop puts XML metadata into JFIF images,
                * including namespacing, so we have to allow this for images.
                */
            unset($evil_attributes[array_search('xmlns', $evil_attributes)]);
        }

        do {
            $count = 0;
            $attribs = array();

            // find occurrences of illegal attribute strings without quotes
            preg_match_all("/(" . implode('|', $evil_attributes) . ")\s*=\s*([^\s]*)/is", $str, $matches, PREG_SET_ORDER);

            foreach ($matches as $attr)
            {
                $attribs[] = preg_quote($attr[0], '/');
            }

            // find occurrences of illegal attribute strings with quotes (042 and 047 are octal quotes)
            preg_match_all("/(" . implode('|', $evil_attributes) . ")\s*=\s*(\042|\047)([^\\2]*?)(\\2)/is", $str, $matches, PREG_SET_ORDER);

            foreach ($matches as $attr)
            {
                $attribs[] = preg_quote($attr[0], '/');
            }

            // replace illegal attribute strings that are inside an html tag
            if (count($attribs) > 0) {
                $str = preg_replace("/<(\/?[^><]+?)([^A-Za-z\-])(" . implode('|', $attribs) . ")([\s><])([><]*)/i", '<$1$2$4$5', $str, -1, $count);
            }

        } while ($count);

        return $str;
    }

    /**
     * Sanitize Naughty HTML
     *
     * Callback function for xss_clean() to remove naughty HTML elements
     *
     * @param    array
     * @return    string
     */
    public function _sanitize_naughty_html($matches)
    {
        // encode opening brace
        $str = '&lt;' . $matches[1] . $matches[2] . $matches[3];

        // encode captured opening or closing brace to prevent recursive vectors
        $str .= str_replace(array('>', '<'), array('&gt;', '&lt;'),
            $matches[4]);

        return $str;
    }

    public static function isPHP($version = '5.0.0')
    {
        static $_is_php;
        $version = (string)$version;

        if (!isset($_is_php[$version])) {
            $_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
        }

        return $_is_php[$version];
    }

}