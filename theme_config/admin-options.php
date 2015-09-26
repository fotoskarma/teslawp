<?php

return array(
        'favico' => array(
                'dir' => '/images/favicon.png'
        ),
        'option_saved_text' => 'Options successfully saved',
        'tabs' => array(
                array(
                        'title'=>'General Options',
                        'icon'=>1,
                        'boxes' => array(
                                'Logo Customization' => array(
                                        'icon'=>'customization',
                                        'size'=>'2_3',
                                        'columns'=>true,
                                        'description'=>'Here you upload a image as logo or you can write it as text and select the logo color, size, font.',
                                        'input_fields' => array(
                                                'Logo As Image'=>array(
                                                        'size'=>'half',
                                                        'id'=>'logo_image',
                                                        'type'=>'image_upload',
                                                        'note'=>'Here you can insert your link to a image logo or upload a new logo image.'
                                                ),
                                                'Logo As Text'=>array(
                                                        'size'=>'half_last',
                                                        'id'=>'logo_text',
                                                        'type'=>'text',
                                                        'note' => "Type the logo text here, then select a color, set a size and font",
                                                        'color_changer'=>true,
                                                        'font_changer'=>true,
                                                        'font_size_changer'=>array(1,1000, 'px'),
                                                        'font_preview'=>array(true, true)
                                                )
                                        )
                                ),
                                'Favicon' => array(
                                        'icon'=>'customization',
                                        'size'=>'1_3_last',
                                        'input_fields' => array(
                                                array(
                                                        'id'=>'favicon',
                                                        'type'=>'image_upload',
                                                        'note'=>'Here you can upload the favicon icon.'
                                                )
                                        )
                                ),
                                'Custom CSS' => array(
                                        'icon'=>'css',
                                        'size'=>'2_3',
                                        'description'=>'Here you can write your personal CSS for customizing the classes you choose to modify.',
                                        'input_fields' => array(
                                                array(
                                                        'id'=>'custom_css',
                                                        'type'=>'textarea'
                                                )
                                        )
                                ),
                                'Site Color' => array(
                                        'icon'=>'background',
                                        'size'=>'1_3_last',
                                        'input_fields' => array(
                                                array(
                                                        'size'=>'7',
                                                        'id'=>'site_color',
                                                        'type'=>'colorpicker',
                                                        'note'=>'Change the default color of the site.'
                                                )
                                        )
                                )
                        )
                ),
                array(
                        'title' => 'Site Background',
                        'icon'=>4,
                        'boxes' => array(
                                'Background Customization'=>array(
                                        'icon'=>'background',
                                        'columns'=>true,
                                        'input_fields' => array(
                                                'Background Color'=>array(
                                                        'size'=>'3',
                                                        'id'=>'bg_color',
                                                        'type'=>'colorpicker'
                                                ),
                                                'Background Image' => array(
                                                        'size'=>'3',
                                                        'id'=>'bg_image',
                                                        'type'=>'image_upload'
                                                ),
                                                'Position' => array(
                                                        'size'=>'3_last',
                                                        'id' => 'bg_image_position',
                                                        'type' => 'radio',
                                                        'values' => array('Left','Center','Right')
                                                ),
                                                'Repeat' => array(
                                                        'size'=>'3_last',
                                                        'id' => 'bg_image_repeat',
                                                        'type' => 'radio',
                                                        'values' => array('bitch'=>'No Repeat','Tile','Tile Horizontally','Tile Vertically')
                                                ),
                                                'Attachment' => array(
                                                        'size'=>'3_last',
                                                        'id' => 'bg_image_attachment',
                                                        'type' => 'radio',
                                                        'values' => array('Scroll','Fixed')
                                                )
                                        )
                                )
                        )
                ),
                array(
                        'title' => 'SEO and Socials',
                        'icon'=>2,
                        'boxes'=>array(
                                'Social Platforms'=>array(
                                        'icon'=>'social',
                                        'description'=>"Insert the link to the social share page.",
                                        'size'=>'1_3',
                                        'columns'=>true,
                                        'input_fields'=>array(
                                                array(
                                                        'id'=>'social_platforms',
                                                        'size'=>'half',
                                                        'type'=>'social_platforms',
                                                        'platforms'=>array('facebook','twitter','google','pinterest','linkedin','dribbble','behance','youtube','flickr')
                                                )
                                        )
                                ),
                                'Tracking Code' => array(
                                        'icon'=>'track',
                                        'size'=>'2_3_last',
                                        'input_fields'=>array(
                                                array(
                                                        'type'=>'textarea',
                                                        'id'=>'tracking_code'
                                                )
                                        )
                                )
                        )
                ),
                array(
                        'title' => 'Additional Options',
                        'icon'  => 6,
                        'boxes' => array(
                                'Additional options'=>array(
                                        'icon' => 'customization',
                                        'size'=>'2_3',
                                        'columns'=>true,
                                        'input_fields' =>array(
                                                'Blog Page Title' => array(
                                                        'id'    => 'blog_title',
                                                        'type'  => 'text',
                                                        'note' => 'Give another title for the blog page',
                                                        'size' => 'half',
                                                        'placeholder' => 'Ex: News, Updates, Events etc.'
                                                )
                                        )
                                ),
                                'Twitter Settings'=>array(
                                        'icon' => 'customization',
                                        'description'=>"Used by the Twitter Widget",
                                        'size'=>'1_3_last',
                                        'columns'=>false,
                                        'input_fields' =>array(
                                                'Consumer Key' => array(
                                                        'id'    => 'twitter_consumerkey',
                                                        'type'  => 'text',
                                                        'size' => '1'
                                                ),
                                                'Consumer Secret' => array(
                                                        'id'    => 'twitter_consumersecret',
                                                        'type'  => 'text',
                                                        'size' => '1',
                                                ),
                                                'Access Token' => array(
                                                        'id'    => 'twitter_accesstoken',
                                                        'type'  => 'text',
                                                        'size' => '1',
                                                ),
                                                'Access Toekn Secret' => array(
                                                        'id'    => 'twitter_accesstokensecret',
                                                        'type'  => 'text',
                                                        'size' => '1',
                                                )
                                        )
                                )
                        )
                ),
                array(
                        'title' => 'Contact Info',
                        'icon'  => 5,
                        'boxes' => array(
                                'Contact info'=>array(
                                        'icon' => 'customization',
                                        'description'=>"Provide contact information. This information will appear in contact template. For more informations read documentation.",
                                        'size'=>'2_3',
                                        'columns'=>true,
                                        'input_fields' =>array(
                                                'Map iframe' => array(
                                                        'id'    => 'contact_map',
                                                        'type'  => 'map',
                                                        'note' => 'Here you can insert iframe with your location. For more information you can find in theme\'s documentation' ,
                                                        'size' => 'half',
                                                        'icons' => array('google-marker.gif','home.png','home_1.png','home_2.png','administration.png','office-building.png')
                                                ),
                                                'Contact form' => array(
                                                        'id'    => 'email_contact',
                                                        'type'  => 'text',
                                                        'note' => 'Provide an email used to recive messages from Contact Form',
                                                        'size' => 'half_last',
                                                        'placeholder' => 'Contact Form Email'
                                                ),
                                                array(
                                                        'id'    => 'email_prefix',
                                                        'type'  => 'text',
                                                        'note' => 'Provide a prefix for subjects of the messages received from Contact Form',
                                                        'size' => 'half_last',
                                                        'placeholder' => 'Subject Prefix'
                                                ),
                                                array(
                                                        'id'    => 'form_title',
                                                        'type'  => 'text',
                                                        'note' => 'Provide a title for the contact form',
                                                        'size' => 'half_last',
                                                        'placeholder' => 'Ex: Don\'t be shy come along and say hi'
                                                )
                                        )
                                )

                        )
                )
        ),
        'styles' => array( array('wp-color-picker'),'style','select2' )
        ,
        'scripts' => array( array( 'jquery', 'jquery-ui-core','jquery-ui-datepicker','wp-color-picker' ), 'select2.min','jquery.cookie','tt_options', 'admin_js' )
);