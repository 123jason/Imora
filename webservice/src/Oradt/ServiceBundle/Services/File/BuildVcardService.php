<?php
namespace Oradt\ServiceBundle\Services\File;
use Oradt\ServiceBundle\Services\File\VcardService;
use Oradt\ServiceBundle\Services\File\FileImcService;
class BuildVcardService extends VcardService
{
    protected $properties = array(
        'VERSION'	=> array( 'req' => array('2.1','3.0', '4.0'),	'limit' => true ),
        'FN'		=> array( 'req'	=> array('3.0', '4.0') ),
// 			'N'			=> array( 'req'	=> array('2.1','3.0', '4.0')),
        'PROFILE'	=> array( 'vers'=> array('3.0', '4.0'),		'limit' => true ),
        'NAME'		=> array( ),
        'SOURCE'	=> array( 'vers'=> array('3.0', '4.0'),		'limit' => true ),
        'NICKNAME'	=> array( 'vers'=> array('3.0', '4.0') ),
        'PHOTO' 	=> array( ),
        'BDAY'		=> array( ),
        'ADR'		=> array( ),	// 'limit' => false
        'LABEL'		=> array( ),	// 'limit' => false
        'TEL'		=> array( ),	// 'limit' => false
        'EMAIL'		=> array( ),	// 'limit' => false
        'MAILER'	=> array( ),
        'TZ'		=> array( ),
        'GEO'		=> array( ),
        'TITLE'		=> array( ),
        'ROLE'		=> array( ),
        'LOGO'		=> array( ),
        'AGENT'		=> array( ),
        'ORG'		=> array( ),
        'CATEGORIES'=> array( 'vers' => array('3.0', '4.0') ),
        'NOTE'		=> array( ),
        'PRODID'	=> array( 'vers' => array('3.0', '4.0') ),
        'CLASS'		=> array( 'vers' => array('3.0', '4.0') ),
        'REV'		=> array( ),
        'SORT-STRING'=>array( 'vers' => array('3.0', '4.0') ),
        'SOUND'		=> array( ),
        'UID'		=> array( ),
        'URL'		=> array( ),
        'CLASS'		=> array( 'vers'=> array('2.1', '3.0') ),
        'KEY'		=> array( ),
    );

    public function getVcardProperties ()
    {
        return $this->properties;
    }

    public function addVcardProperty ($propertyName, $propertyInfo=array())
    {
        $propertyName = strtoupper($propertyName);

        $_info = array();
        if (isset($propertyInfo['vers'])) {
            $_info['vers'] = $propertyInfo['vers'];
        }
        if (isset($propertyInfo['req'])) {
            $_info['req'] = $propertyInfo['req'];
        }
        if (isset($propertyInfo['limit'])) {
            $_info['limit'] = $propertyInfo['limit'];
        }

        $this->properties[$propertyName] = $_info;

        return $this;
    }

    /**
     * Fetches a full vCard text block based on $this->value and
     * $this->param. The order of the returned properties is similar to
     * their order in RFC 2426.  Honors the value of
     * $this->value['VERSION'] to determine which vCard properties are
     * returned (2.1- or 3.0-compliant).
     *
     * @access public
     * @uses self::get()
     *
     * @return string A properly formatted vCard text block.
     */
    public function fetch()
    {
        $prop_dfn_default = array(
            'vers'	=> array('2.1','3.0', '4.0'),
            'req'	=> array(),				// versions required in
            'limit'	=> false,				// just one value allowed
        );
        $prop_dfns = $this->properties;
        $ver = $this->getValue('VERSION');
        $newline = $ver == '2.1'
            ? "\r\n"	// version 2.1 uses \r\n for new lines
            : "\n";		// version 3.0 uses \n

        // initialize the vCard lines
        $lines = array();

        $lines[] = 'BEGIN:VCARD';
        $prop_keys = array_keys($this->value);
        foreach ( $prop_dfns as $prop => $prop_dfn ) {
            if ( !is_array($prop_dfn) )
                $prop_dfn = array( 'func' => $prop_dfn );
            $prop_dfn = array_merge($prop_dfn_default,$prop_dfn);
            if ( false !== $key = array_search($prop,$prop_keys) );
            unset($prop_keys[$key]);
            $prop_exists = isset($this->value[$prop]) && is_array($this->value[$prop]);
            if ( $prop == 'PROFILE' && in_array($ver,$prop_dfn['vers']) )
                $lines[] = 'PROFILE:VCARD';	// special case... don't really care what current val is
            elseif ( $prop_exists ) {
                if ( in_array($ver,$prop_dfn['vers']) ) {
                    foreach ( $this->value[$prop] as $iter => $val ) {
                        $lines[] = $this->get($prop,$iter);
                        if ( $prop_dfn['limit'] )
                            break;
                    }
                }
            }
            elseif ( in_array($ver,$prop_dfn['req']) ) {
                //throw new FileImcService_Exception($prop.' not set (required).',FileImcService::ERROR_PARAM_NOT_SET);
            }
        }
        ;
        // now build the extension properties
        foreach ( $prop_keys as $prop ) {
            if ( strpos($prop,'X-') === 0 ) {
                foreach ($this->value[$prop] as $key => $val) {
                    $lines[] = $this->get($prop,$key);
                }
            }
        }

        $lines[] = 'END:VCARD';

        // fold lines at 75 characters
        $regex = '/(.{1,75})/i';
        foreach ( $lines as $key => $val ) {
            if (strlen($val) > 75) {
                // we trim to drop the last newline, which will be added
                // again by the implode function at the end of fetch()
                //$lines[$key] = trim(preg_replace($regex, "\\1$newline ", $val));
            }
        }

        // compile the array of lines into a single text block and return
        return implode($newline, $lines);
    }

    /**
     * Sets the value of the specified property
     *   for PHOTO, LOGO, SOUND, & KEY properties:
     *		if a filepath is passed:, automatically base64-encodes
     *			and sets ENCODING parameter
     *		if a URL is passed, automatically sets the VALUE=URL|URI parameter
     *
     * _setPROPERTY($value,$iter) method will be used if exists  ( ie _setADR() )
     *
     * @access public
     *
     * @param string property
     * @param mixed value
     *       when property is ADR, GEO, or N:  value is an array
     *			additionaly, the array may be an associateive array
     *			ADR: 	post-office-box, extended-address, street-address, locality, region, postal-code, country-name
     *			GEO:	latitude, longitude
     *			N:		family-name, given-name, additional-name, honorific-prefix, honorific-suffix
     *       when property is ORG, value may be an string or array
     *			ORG		'organization-name','organization-unit'
     *       for all other properties, value is a string
     * @param mixed iteration default = 0; pass 'new' to add an iteration
     * @return $this
     */
    public function set($prop,$value,$iter=0)
    {
        $prop = strtoupper(trim($prop));
        if ( $iter === 'new' ){
            $iter = isset($this->value[$prop])
                ? count($this->value[$prop])
                : 0;
        }elseif ( !is_integer($iter) || $iter < 0) {
            throw new FileImcService_Exception(
                $prop.' iteration number not valid.', FileImcService::ERROR_INVALID_ITERATION
            );
        }
        $method = '_set'.$prop;
        if ( method_exists($this, $method) ) {
            call_user_func(array($this,$method), $value, $iter);
        }
        else {
            if ( $prop == 'VERSION' && !in_array($value,array('2.1','3.0', '4.0')) )
                throw new FileImcService_Exception('Version must be 3.0 or 2.1 to be valid.', FileImcService::ERROR_INVALID_VCARD_VERSION);
            elseif ( in_array($prop,array('PHOTO','LOGO','SOUND','KEY')) ) {
                if ( file_exists($value) )
                    $value = base64_encode(file_get_contents($value));
            }

            $this->setValue($prop, $iter, 0, $value);
            if ( in_array($prop,array('PHOTO','LOGO','SOUND','KEY')) ) {
                $ver = $this->getValue('VERSION');
                if ( preg_match('#^(https?|ftp)://#',$value) ) {
                    $this->addParam('VALUE', $ver == '2.1' ? 'URL' : 'URI' );
                }
                else {
                    $this->addParam('ENCODING', $ver == '2.1' ? 'BASE64' : 'B' );
                }
            }
        }
        return $this;
    }

    /**
     * Validates parameter names and values based on the vCard version
     * (2.1 or 3.0).
     *
     * @access public
     * @param  string $name The parameter name (e.g., TYPE or ENCODING).
     *
     * @param  string $text The parameter value (e.g., HOME or BASE64).
     *
     * @param  string $prop Optional, the propety name (e.g., ADR or PHOTO).
     *						Only used for error messaging.
     *
     * @param  int $iter Optional, the iteration of the property.
     *						Only used for error messaging.
     *
     * @return mixed	Boolean true if the parameter is valid
     * @throws FileImcService_Exception ... if not.
     *
     * @uses self::validateParam21()
     * @uses self::validateParam30()
     */
    public function validateParam($name, $text, $prop=null, $iter=null)
    {
        $name = strtoupper($name);
        $text = strtoupper($text);
        // all param values must have only the characters A-Z 0-9 and -.
        if (preg_match('/[^a-zA-Z0-9\-=]/i', $text)) {
            throw new FileImcService_Exception(
                "vCard [$prop] [$iter] [$name]: The parameter value may contain only a-z, A-Z, 0-9, and dashes (-).",
                FileImcService::ERROR_INVALID_PARAM);
        }
        if ( $this->value['VERSION'][0][0][0] == '2.1' ) {
            return $this->_validateParam21($name, $text, $prop, $iter);
        } elseif ( $this->value['VERSION'][0][0][0] == '3.0' ) {
            return $this->_validateParam30($name, $text, $prop, $iter);
        } elseif ( $this->value['VERSION'][0][0][0] == '4.0' ) {
            return $this->_validateParam40($name, $text, $prop, $iter);
        }
        throw new FileImcService_Exception(
            "[$prop] [$iter] Unknown vCard version number or other error.",
            FileImcService::ERROR);
    }

    /**
     * Validate parameters with 3.0 vcards.
     *
     * @access private
     * @param string $name The parameter name (e.g., TYPE or ENCODING).
     * @param string $text The parameter value (e.g., HOME or BASE64).
     * @param string $prop the property name (e.g., ADR or PHOTO).
     *						Only used for error messaging.
     * @param int $iter the iteration of the property.
     *						Only used for error messaging.
     * @return boolean
     */
    protected function _validateParam40($name, $text, $prop, $iter)
    {
        // Validate against version 3.0 (pretty lenient)
        $x_val = strpos($text,'X-') === 0;
        switch ($name) {
            case 'TYPE':     // all types are OK
            case 'LANGUAGE': // all languages are OK
                $result = true;
                break;
            case 'PREF': // all languages are OK
                $result = is_numeric($text);
                break;
            case 'ENCODING':
                $vals = array('8BIT','B');
                $result = ( in_array($text, $vals) || $x_val );
                break;
            case 'VALUE':
                $vals = array('BINARY','PHONE-NUMBER','TEXT','URI','UTC-OFFSET','VCARD');
                $result = ( in_array($text, $vals) || $x_val );
                break;
            default:
                $result = ( strpos($name,'X-') === 0 );
                /*
                if ( !$result )
                    throw new FileImcService_Exception(
                        'vCard 3.0 ['.$prop.']['.$iter.']: "'.$name.'" is an unknown or invalid parameter name.',
                        FileImcService::ERROR_INVALID_PARAM);
                */
                break;
        }
        /*
        if ( !$result )
            throw new FileImcService_Exception(
                'vCard 3.0 ['.$prop.']['.$iter.']: "'.$text.'" is not a recognized '.$name.' value.',
                FileImcService::ERROR_INVALID_PARAM);
        */
        return $result;
    }

}

/* EOF */