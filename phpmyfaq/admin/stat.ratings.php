<?php
/**
 * The page with the ratings of the votings
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
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2003-2010 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2003-02-24
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

if ($permission['viewlog']) {
    // Get category data
    $categoryData   = new PMF_Category_Tree_DataProvider_SingleQuery($LANGCODE);
    $categoryLayout = new PMF_Category_Layout(new PMF_Category_Tree_Helper(new PMF_Category_Tree($categoryData)));
    
    // Get rating data
    $ratings        = new PMF_Rating();
    //$ratingData     = $ratings->fetchAll();
    $ratingdata     = $ratings->getAllRatings();
    $numratings     = count($ratingdata);
    $oldcategory    = 0;
    
    // Get FAQ record data
    $faqRecord = new PMF_Faq_Record();
    $faqRecord->setLanguage($LANGCODE);
    $faqData = $faqRecord->fetchAll();
?>
    <h2><?php print $PMF_LANG["ad_rs"] ?></h2>
    <table id="tableUserRatings">
<?php
    foreach ($ratingdata as $data) {
        if ($data['category_id'] != $oldcategory) {
?>
    <tr>
        <th colspan="5"><strong><?php print $categoryLayout->renderBreadcrumb($categoryData->getPath($data['category_id'])); ?></strong></th>
    </tr>
<?php
        }
?>
    <tr>
        <td><?php print $data['id']; ?></td>
        <td><?php print $data['lang']; ?></td>
        <td><a href="../index.php?action=artikel&amp;cat=<?php print $data['category_id']; ?>&amp;id=<?php print $data['id'];?>&amp;artlang=<?php print $data['lang']; ?>" title="<?php print PMF_String::htmlspecialchars(trim($data['question']), ENT_QUOTES, 'utf-8'); ?>"><?php print PMF_Utils::makeShorterText(PMF_String::htmlspecialchars(trim($data['question']), ENT_QUOTES, 'utf-8'), 14); ?></a></td>
        <td><?php print $data['usr']; ?></td>
        <td style="width: 50px;"><img src="stat.bar.php?num=<?php print $data['num']; ?>" border="0" alt="<?php print round($data['num'] * 20); ?> %" width="50" height="15" title="<?php print round($data['num'] * 20); ?> %" /></td>
    </tr>
<?php
        $oldcategory = $data['category_id'];
    }
    if ($numratings > 0) {
?>
    <tr>
        <td colspan="5"><span style="color: green; font-weight: bold;"><?php print $PMF_LANG["ad_rs_green"] ?></span> <?php print $PMF_LANG["ad_rs_ahtf"] ?>, <span style="color: red; font-weight: bold;"><?php print $PMF_LANG["ad_rs_red"] ?></span> <?php print $PMF_LANG["ad_rs_altt"] ?></td>
    </tr>
<?php
    } else {
?>
    <tr>
        <td colspan="5"><?php print $PMF_LANG["ad_rs_no"] ?></td>
    </tr>
<?php
    }
?>
    </table>
<?php
} else {
    print $PMF_LANG["err_NotAuth"];
}