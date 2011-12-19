<?php
/*
Plugin Name: Specific Category PN Link
Plugin URI: http://web.lugn-design.com/wordpress/%E3%80%90wordpress%E3%80%91%E7%89%B9%E5%AE%9A%E3%82%AB%E3%83%86%E3%82%B4%E3%83%AA%E3%81%AE%E3%81%BF%E3%81%AE%E5%89%8D%E5%BE%8C%E3%83%AA%E3%83%B3%E3%82%AF%E3%82%92%E5%8F%96%E5%BE%97%E3%81%99%E3%82%8B/
Description: The report link before and behind the specific category is outputted. 特定カテゴリの前後の記事リンクを出力します。
Version: 1.2
Author: Rosetta
Author URI: http://web.lugn-design.com/
*/

//!< カテゴリIDを受け取りその親カテゴリと子カテゴリを返す
function get_pc_id($cat){
	$parent_id = $cat->category_parent;
	$exclude_id = get_category_children($parent_id, "", ',');
	$exclude_id .= $parent_id;
	
	return $exclude_id;
}

//!< カテゴリIDを受け取りそれを除外したカテゴリIDを返す
function exclude_post_id($cat,$par){
	
	if($par === TRUE){
		$exclude_id = get_pc_id($cat);
	}
	else{
		$exclude_id = $cat;
	}
	
	$cat = get_categories('orderby=id&exclude='.$exclude_id);
	$exclude_id = "";
	foreach ($cat as $key => $value) {
		$exclude_id .= $value->term_id;
		if(count($cat) > $key){
			$exclude_id .= " and ";
		}
	}
	return $exclude_id;
}
//!< 指定したカテゴリのみの前後記事リンクを返す
//!< 引数
//!< $cat : 表示したいカテゴリの情報。$parがtrueの場合はカテゴリの配列。$parがfalseの場合はカテゴリのIDを受け取る。
//!< $par : $catの親カテゴリが持つ子カテゴリを含めるかどうか。trueで含む。falseで含まない。
function specific_cat_link($cat,$par){
	
	$exclude_id = exclude_post_id($cat,$par);
	
	?>
	<ul class="sc-pn-link">
		<li class="prevpost"><?php previous_post_link('« %link', '前の記事', FALSE, $exclude_id); ?></li>
		<li class="nextpost"><?php next_post_link('%link »', '次の記事', FALSE, $exclude_id); ?></li>
	</ul>
	<?php
}
?>