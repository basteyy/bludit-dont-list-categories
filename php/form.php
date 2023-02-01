<?php
/** @var Categories $categories */
/** @var Category $category */
/** @var Security $security */
/** @var Language $L */

if(!isset($html)) {
    $html = '';
}

if($this->getValue($this->db_field_name) !== null) {
    $fields = json_decode(base64_decode($this->getValue($this->db_field_name)), true);

    if(!$fields) {
        $html .= 'DB Error';
    }
}

$html .= '<p>Select the Category which should be not displayed on the startpage (home)</p>';

$html .= '<table class="table table-striped mt-3">';
$html .= '<thead>';
//
$html .= '<tr>';
$html .= sprintf('<th class="border-bottom-0" scope="col">%s</td>', $L->get('Category'));
$html .= sprintf('<th class="border-bottom-0" scope="col">%s</td>', $L->get('Posts'));
$html .= sprintf('<th class="border-bottom-0" scope="col">%s</td>', $L->get('Select'));
$html .= '</tr>';

$html .= '</thead>';
foreach($categories->getDB() as $key => $_category) {
     $category = new Category($key);
     $html .= '<tr>';
     $html .= sprintf('<td><label for="ignore_%1$s"><strong>%2$s</strong></label></td>', $category->key(), $category->name());
     $html .= sprintf('<td>%s</td>', count($category->pages()));
     $html .= sprintf('<td><input id="ignore_%1$s" name="ignore[%1$s]" type="checkbox"%2$s/></td>', $category->key(), isset($fields[$category->key()]) ? ' checked':'');
     $html .= '</tr>';
}

$html .= '<input type="hidden" name="update_hidden_categories" value="1" />';
$html .= sprintf('<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="%s">', $security->getTokenCSRF());
