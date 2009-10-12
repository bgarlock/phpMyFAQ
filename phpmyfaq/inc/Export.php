<?php
/**
 * XML, XML DocBook, XHTML and PDF export - Classes and Functions
 *
 * @package    phpMyFAQ
 * @subpackage PMF_Export
 * @author     Thorsten Rinne <thorsten@phpmyfaq.de>
 * @author     Matteo Scaramuccia <matteo@scaramuccia.com>
 * @since      2005-11-02
 * @version    SVN: $Id$
 * @copyright  2005-2009 phpMyFAQ Team
 *
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 */

require_once PMF_CONFIG_DIR . '/constants.php';

define("EXPORT_TYPE_DOCBOOK", "docbook");
define("EXPORT_TYPE_PDF", "pdf");
define("EXPORT_TYPE_XHTML", "xhtml");
define("EXPORT_TYPE_XML", "xml");
define("EXPORT_TYPE_NONE", "none");


/**
 * PMF_Export Class
 *
 * This class manages the export formats supported by phpMyFAQ:
 * - DocBook
 * - PDF
 * - XHTML
 * - XML
 *
 * This class has only static methods
 * @package    phpMyFAQ
 * @subpackage PMF_Export
 * @author     Thorsten Rinne <thorsten@phpmyfaq.de>
 * @author     Matteo Scaramuccia <matteo@scaramuccia.com>
 * @since      2005-11-02
 * @copyright  2005-2009 phpMyFAQ Team
 */
class PMF_Export
{
	/**
	 * PMF_Faq object
	 * 
	 * @var PMF_Faq
	 */
	protected $faq = null;
	
	/**
	 * PMF_Category object
	 * 
	 * @var PMF_Category
	 */
	protected $category = null;
	
	/**
	 * Factory
	 * 
	 * @param PMF_Faq      $faq      PMF_Faq object
	 * @param PMF_Category $category PMF_Category object 
	 * @param string       $mode     Export 
	 * 
	 * @return PMF_Export
	 */
	public static function create(PMF_Faq $faq, PMF_Category $category, $mode = 'pdf')
	{
		switch ($mode) {
			case 'pdf':
				return new PMF_Export_Pdf($faq, $category);
				break;
			case 'xml':
                return new PMF_Export_Xml($faq, $category);
                break;
			case 'xhtml':
				return new PMF_Export_Xhtml($faq, $category);
				break;
			case 'docbook':
				return new PMF_Export_Docbook($faq, $category);
				break;
			default:
				throw new Exception('Export not implemented!');
		}
	}
	
    /**
     * Returns the timestamp of the export
     *
     * @return string
     */
    public static function getExportTimeStamp()
    {
        return date("Y-m-d-H-i-s", $_SERVER['REQUEST_TIME']);
    }    
}