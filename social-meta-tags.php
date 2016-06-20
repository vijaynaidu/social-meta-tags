<?php
/*
	Plugin Name: Social Meta Tags - Facebook, Twitter, Google Plus for Woocommerce Sites
	Description: Meta tags will be generated for facebook, twitter and google plus. It has capable of disabling/ changing social meta tags for individual post.
	Version: 1.0
	Author: Vijay M
	License: GPLv2
*/

if(!function_exists('socialMetaTags')){
    function socialMetaTags(){
        global $post;
        $maxLength = 500;
        $maxLenCont = array(
            'facebook'=>300,
            'google_plus'=>200,
            'twitter'=>100,
        );

        if(!empty($post)){
            $arrTags = array(
                'processed'=>false,
                'title'=>'',
                'description'=>'',
                'image'=>'',
                'url'=>'',
                'type'=>'',
            );

            if(strtolower($post->post_type) == 'product'){
                $arrTags['url'] = get_post_permalink($post->ID);


                $isDisable = false;
                $isDisableData = get_post_custom_values('smeta_disable', $post->ID);
                if((is_string($isDisableData) && ($isDisableData !="")) || (is_array($isDisableData) && ($isDisableData['0']!=""))){
                    $isDisable = (is_array($isDisableData))?$isDisableData['0']:$isDisableData;
                }
                if(!in_array($isDisable, array("false", "true"))){
                    $isDisable = false;
                }

                if($isDisable==false || $isDisable == "false"){
                    $arrTags['processed'] = true;
                    $customOgImageData = get_post_custom_values('smeta_og_image', $post->ID);
                    $customOgTitleData = get_post_custom_values('smeta_og_title', $post->ID);
                    $customOgDescData = get_post_custom_values('smeta_og_desc', $post->ID);
                    $customOgSiteNameData = get_post_custom_values('smeta_og_site_name', $post->ID);
                    $customOgTypeData = get_post_custom_values('smeta_og_type', $post->ID);

                    if((is_string($customOgTypeData) && !empty($customOgTypeData)) || (is_array($customOgTypeData) && !empty($customOgTypeData['0']))){
                        $arrTags['type'] = (is_array($customOgTypeData))?$customOgTypeData['0']:$customOgTypeData;
                    }
                    else{
                        $arrTags['type'] = 'product';
                    }

                    if((is_string($customOgSiteNameData) && !empty($customOgSiteNameData)) || (is_array($customOgSiteNameData) && !empty($customOgSiteNameData['0']))){
                        $arrTags['site_name'] = (is_array($customOgSiteNameData))?$customOgSiteNameData['0']:$customOgSiteNameData;
                    }
                    else{
                        $arrTags['site_name'] = bloginfo('name');
                    }

                    if((is_string($customOgTitleData) && !empty($customOgTitleData)) || (is_array($customOgTitleData) && !empty($customOgTitleData['0']))){
                        $arrTags['title'] = (is_array($customOgTitleData))?$customOgTitleData['0']:$customOgTitleData;
                    }
                    else{
                        $arrTags['title'] = $post->post_title;
                    }

                    if((is_string($customOgDescData) && !empty($customOgDescData)) || (is_array($customOgDescData) && !empty($customOgDescData['0']))){
                        $arrTags['description'] = (is_array($customOgDescData))?$customOgDescData['0']:$customOgDescData;
                        $arrTags['description'] = strip_tags($arrTags['description']);
                    }
                    else if(!empty($post->post_excerpt)){
                        $arrTags['description'] = strip_tags(substr($post->post_excerpt, 0, $maxLength));
                    }
                    else if(!empty($post->post_content)){
                        $arrTags['description'] = strip_tags(substr($post->post_content, 0, $maxLength));
                    }

                    if((is_string($customOgImageData) && !empty($customOgImageData)) || (is_array($customOgImageData) && !empty($customOgImageData['0']))){
                        $arrTags['image'] = (is_array($customOgImageData))?$customOgImageData['0']:$customOgImageData;
                    }
                    else{
                        $postThumbId = get_post_thumbnail_id();
                        if(!empty($postThumbId)){
                            //$productImageUrl = wp_get_attachment_url($postThumbId);
                            $productImageUrl = wp_get_attachment_thumb_url($postThumbId);
                            $arrTags['image'] = $productImageUrl;
                        }
                    }
            }
            }

            $arrMetaTags = array();
            if(($arrTags['processed'] == true)){
                $arrMetaMap = array(
                    'title'=>array(
                        array(
                            'itemprop'=>'name',
                            'content'=>'__SUB__',
                        ),
                        array(
                            'property'=>'og:title',
                            'content'=>'__SUB__',
                        ),
                        array(
                            'name'=>'twitter:title',
                            'content'=>'__SUB__',
                        ),
                    ),
                    'description'=>array(
                        array(
                            '_for'=>'google_plus',
                            'itemprop'=>'description',
                            'content'=>'__SUB__',
                        ),
                        array(
                            '_for'=>'facebook',
                            'property'=>'og:description',
                            'content'=>'__SUB__',
                        ),
                        array(
                            '_for'=>'twitter',
                            'name'=>'twitter:description',
                            'content'=>'__SUB__',
                        ),
                    ),
                    'image'=>array(
                        array(
                            'itemprop'=>'image',
                            'content'=>'__SUB__',
                        ),
                        array(
                            'property'=>'og:image',
                            'content'=>'__SUB__',
                        ),
                        array(
                            'name'=>'twitter:image',
                            'content'=>'__SUB__',
                        ),
                    ),
                    'url'=>array(
                        array(
                            'property'=>'og:url',
                            'content'=>'__SUB__',
                        ),
                    ),
                    'type'=>array(
                        array(
                            'property'=>'og:type',
                            'content'=>'__SUB__',
                        ),
                    ),
                    'site_name'=>array(
                        array(
                            'property'=>'og:site_name',
                            'content'=>'__SUB__',
                        ),
                    ),
                );

                foreach($arrMetaMap as $key=>$pos){
                    $oriContent = $arrTags[$key];
                    if(!empty($oriContent)){
                        foreach($pos as $metaElem){
                            $props = array();
                            foreach($metaElem as $prop=>$propVal){
                                if($prop == '_for'){
                                    continue;
                                }
                                else{
                                    $content = $oriContent;
                                    if($key == 'description' && !empty($metaElem['_for'])){
                                        $content = substr($content, 0, $maxLenCont[$metaElem['_for']]);
                                    }

                                    $propVal = str_ireplace('__SUB__', $content, $propVal);
                                    $props[] = ''.$prop.'="'.$propVal.'"';
                                }
                            }
                            $arrMetaTags[] = '<meta '.implode(' ', $props).' />';
                        }
                    }
                }

                echo "\n".implode("\n", $arrMetaTags)."\n";// Displaying tags
            }
        }
    }
    add_action('wp_head', 'socialMetaTags');
}

if(!function_exists('socialMetaTagsPage')){
    function socialMetaTagsPage(){
        ob_start();
        require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'html/social-meta-tags-guide.php';
        $data = ob_get_clean();
        echo $data;
    }

    add_action('admin_menu', function(){
        add_options_page(
            'Social Meta Tags - FAQ',
            'Social Meta Tags - FAQ',
            'manage_options',
            'social-meta-tags-faq',
            'socialMetaTagsPage'
        );
    });
}


?>