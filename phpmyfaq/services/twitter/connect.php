<?php
/**
 * Clears PHP sessions and redirects to the connect page.
 *
 * PHP Version 5.2
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
 * 
 * @category  phpMyFAQ
 * @package   Services
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @author    Thomas Zeithaml <tom@annatom.de>
 * @copyright 2010 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2010-09-18
 */

//
// Prepend and start the PHP session
//
define('PMF_ROOT_DIR', dirname(dirname(dirname(__FILE__))));
define('IS_VALID_PHPMYFAQ', null);

require_once PMF_ROOT_DIR . '/inc/Init.php';

PMF_Init::cleanRequest();
session_name(PMF_COOKIE_NAME_AUTH . trim($faqconfig->get('main.phpMyFAQToken')));
session_start();

if ($faqconfig->get('socialnetworks.twitterConsumerKey') === '' || 
    $faqconfig->get('socialnetworks.twitterConsumerSecret') === '') {
    
    print 'Get a consumer key and secret from <a href="https://twitter.com/apps">twitter.com</a>.';
    exit;
}

print '<a href="./redirect.php"><img src="./images/twitter.signin.png" alt="Sign in with Twitter"/></a>';