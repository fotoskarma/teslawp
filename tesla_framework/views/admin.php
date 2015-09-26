<?php
/*
 * Admin Panel markup Tesla Framework
*/
$options = get_option( THEME_OPTIONS );
$options = unserialize($options);
if ( ! isset( $_REQUEST[ 'settings-updated' ] ) )
  $_REQUEST[ 'settings-updated' ] = false;
else if ($_REQUEST[ 'settings-updated' ] == true)
  echo "<script type='text/javascript'>var updated = true</script>"
;?>
<div class="tt_admin">
<form method="post" action="save_options">
  <?php settings_fields( THEME_OPTIONS );?>
  <div class="tt_top_bar">
    <div class="tt_top_links">
      <span>
        <a class="tt_documentation" href="#"><?php _e("Documentation",THEME_NAME)?></a>
      </span>
      <span>
        <a class="tt_support" href="#"><?php _e("Support Tickets",THEME_NAME)?></a>
      </span>
      <span>
        <a class="tt_news" href="#"><?php _e("Latest News",THEME_NAME)?></a>
      </span>
    </div>
    <div class="tt_theme_logo">
      <span><?php echo THEME_PRETTY_NAME ?></span><?php _e(" Version " . THEME_VERSION,THEME_NAME);?> | 
      <span><?php _e("Framework ",THEME_NAME)?></span><?php _e("Version " . TT_FW_VERSION,THEME_NAME)?> 
    </div>
  </div>
  <div class="tt_sidebar">
    <div class="tt_logo"><a href="http://www.teslathemes.com" target="_blank"></a></div>
    <ul class="tt_left_menu" id="myTab">
    <?php foreach ( $tabs as $key => $tab ) : ?>
      <li
        class="<?php if ( $key == 0 )
                      echo "first active";
                     elseif ($key == count($tabs)-1)
                      echo "last"; ?>"
      ><a
            class="<?php if (!empty($tab['icon'])) echo "menu_" . $tab['icon']?>"
            href="#<?php echo str_replace(' ','_',$tab[ 'title' ]) ;?>"
            data-toggle="tab"
          ><?php printf( __( '%s', THEME_NAME ), $tab[ 'title' ] ) ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>
  <div class="tt_content">
    <a class="tt_teslathemes" target="_blank" href="http://teslathemes.com/"></a>
    <?php $j = 0 ;?>
<!-- ========================================= TABS START ========================================================== -->
    <?php foreach ( $tabs as $key => $tab ) : ?>
      <div
        class="tt_tab<?php if ( $key == 0 )
                      echo " active";?>"
        id="<?php echo str_replace(' ','_',$tab[ 'title' ]) ; ?>"
      >
      <?php
        if ( ! empty( $tab[ 'boxes' ] ) ) :  //======================BOXES START========================================
          foreach ( $tab[ 'boxes' ] as $box_name => $box ) :?>
          <?php if (count($tab[ 'boxes' ]) > 1):?>
            <div class="tt_box tt_box_<?php if (!empty($box['size'])) echo $box['size'];?>">
          <?php endif;?>
              <div class="tt_content_box">
                <div class="tt_content_box_title">
                  <span class="tt_bg_icon tt_<?php if(!empty($box['icon'])) echo $box['icon'];?>"><?php printf( __( '%s', THEME_NAME ), $box_name ); ?></span>
                </div>
                <div class="tt_content_box_content">
                  <?php if (!empty($box['description']))
                    echo "<p>{$box['description']}</p>"?>
                  <?php foreach($box['input_fields'] as $input_field_name => $input) : //INPUT FIELDS START=============?>
                  <?php if (count($box['input_fields']) > 1 && !( empty($box['columns'] ) ) ):?>
                    <div class="tt_box tt_box_<?php if (isset($input['size'])) echo $input['size'];?>">
                  <?php endif;?>
                    <?php if (!empty($input_field_name) && !is_int($input_field_name)):?>
                      <div class="tt_option_title">
                        <span><?php printf( __( '%s', THEME_NAME ), $input_field_name ); ?></span>
                      </div>
                    <?php endif;?>
                    <?php 
                    $input_id = $input['id'];
                    if (!empty($input['hidden'])) //adding class for hidden elements
                      $input['class'] = (!empty($input['class'])) ? $input['class'] . " hidden" : "hidden";
                    switch ($input['type']) : //==========================START INPUT TYPES=======================================
                            case 'select' :          //---------- SELECT------------------------------------
                                if (empty($options[ $input_id ]))
                                    $options[ $input_id ] = NULL;?>
                                <select
                                  id="<?php echo $input_id?>"
                                  name="<?php echo THEME_OPTIONS?>[<?php echo $input_id?>]<?php if (!empty($input['multiple']))echo '[]';?>"
                                  class="<?php if (!empty($input['class']))echo $input['class']; if (!empty($input['multiple'])) echo ' multiple_select';?>"
                                  <?php if (!empty($input['multiple']))echo ' multiple';?>
                                  >
                                <?php if (!empty($input['range']) && $input['range_type'] == 'digit' ) : ?>
                                    <?php for ( $i = $input['range'][0]; $i <= $input['range'][1]; $i ++  ) : ?>
                                        <option
                                            value="<?php echo $i ?>"<?php if (!empty($input['multiple']))
                                                                            foreach($options[ $input_id ] as $value)
                                                                              if ( $i == $value )
                                                                                echo ' selected="selected"';
                                             elseif ( $i == $options[ $input_id ] )
                                               echo ' selected="selected"'  ?>
                                         ><?php echo $i ?></option>
                                    <?php endfor; ?>
                                <?php else:?>
                                    <?php foreach ( $input['options'] as $name=>$value ) : ?>
                                        <option
                                            value="<?php echo $value ?>"<?php if (!empty($input['multiple']))
                                                                                if (!empty($options[ $input_id ]))
                                                                                  foreach($options[ $input_id ] as $option)
                                                                                    if ( $value == $option )
                                                                                      echo ' selected="selected"';
                                                                              elseif ( $name == $options[ $input_id ] )
                                                                                echo ' selected="selected"' ?>
                                        ><?php echo $name ?></option>
                                    <?php endforeach; ?>
                                <?php endif;?>
                                </select>
                            <?php break;?>
                            <?php case 'text' : //------------------TEXT------------------------------------?>
                                <input
                                    class="<?php if (!empty($input['class']))echo $input['class'];?>"
                                    id="<?php echo $input_id?>"
                                    type="<?php echo $input['type'];?>"
                                    name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                    placeholder="<?php if (!empty($input['placeholder']))echo $input['placeholder'];?>"
                                    value="<?php if ( ! empty( $options[ $input_id ] ) ) echo $options[ $input_id ] ; ?>"
                                >
                                <?php if (!empty($input['color_changer'])) : //---text color changer--------?> 
                                    <input
                                        type="text" 
                                        value="<?php if ( ! empty( $options[ $input_id . "_color"]  ) )  echo $options[ $input_id . "_color"]  ; ?>"
                                        class="text_color<?php if (!empty($input['class']))echo " " . $input['class'];?>"
                                        data-default-color="<?php if (!empty($input['default']))  $input['default'];?>" 
                                        name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>_color]"
                                    />
                                <?php endif?>
                                <?php if (!empty($input['font_changer'])) : //---text font changer----------?>
                                    <select class="font_changer font_search" id="<?php echo $input_id?>_font" name="<?php echo THEME_OPTIONS?>[<?php echo $input_id?>_font]">
                                    <?php 
                                    $fonts = get_google_fonts();
                                    if ( !empty($fonts) ) :?>
                                        <?php foreach ( $fonts->items as $font ) : ?>
                                            <option value='<?php echo $font->family ?>'<?php if ( $font->family == $options[ $input_id . "_font" ]  ) echo ' selected="selected"'  ?>><?php echo $font->family ?></option>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                    </select>
                                <?php endif;?>
                                <?php if (!empty($input['font_size_changer'])) : //---text size changer-----?>
                                    <input
                                      type="number"
                                      min="<?php echo $input['font_size_changer'][0];?>"
                                      max="<?php echo $input['font_size_changer'][1]?>"
                                      value="<?php if (!empty($options[ $input_id . "_size" ])) echo $options[ $input_id . "_size" ]?>"
                                      class="font_size_changer"
                                      id="<?php echo $input_id?>_size"
                                      name="<?php echo THEME_OPTIONS?>[<?php echo $input_id?>_size]"
                                      data-size-unit ="<?php echo $input['font_size_changer'][2];?>"
                                      ><span class="units"><?php if (!empty($input['font_size_changer'][2])) echo $input['font_size_changer'][2]?></span>
                                <?php endif;?>
                                <?php if (!empty($input['font_preview'][0])) : //---Font Preview---------------?>
                                    <div class="tt_option_title mt30"><span><?php _e('Text Logo Preview',THEME_NAME)?></span></div>
                                    <div
                                        class='tt_show_logo font_preview <?php if (!empty($input['font_preview'][1]))echo 'change_font_size'?>'
                                        style="color:<?php if ( ! empty( $options[ $input_id . "_color"]  ) )   $options[ $input_id . "_color"] ; ?>;
                                                font-family:<?php if ( ! empty( $options[ $input_id . "_font"]  ) )  $options[ $input_id . "_font"]  ; ?>;
                                                font-size:<?php if ( ! empty( $options[ $input_id . "_size"]  ) && !empty($input['font_preview'][1]))  $options[ $input_id . "_size"] . $input['font_size_changer'][2] ; ?>"
                                    ><?php if ( ! empty( $options[ $input_id ] ) ) echo $options[ $input_id ]; ?></div>
                                <?php endif;?>
                            <?php break;?>
                            <?php case 'checkbox' : //------------------CHECKBOX----------------------------?>
                            <label class="tt_checkbox tt_checkbox_<?php if(!empty($input['list'])) echo 'list'; else echo 'grid'?> <?php if (!empty($input['class']))echo $input['class']?>">
                                <input
                                    class="<?php if (!empty($input['action']))echo "tt_interact";?>"
                                    id="<?php echo $input_id?>"
                                    type="checkbox"
                                    name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                    <?php if( !empty( $options[ $input_id ] ) ) 
                                          checked( $input_id, $options[ $input_id ] );?>
                                    value = "<?php echo $input_id;?>"
                                    <?php if (!empty($input['action'])) :?>
                                      data-tt-interact-objs='<?php echo json_encode($input['action'][1]) ?>'
                                      data-tt-interact-action="<?php echo $input['action'][0] ?>"
                                    <?php endif;?>
                                >
                                <span><?php if (!empty($input['label'])) echo $input['label'];?></span>
                            </label>
                            <?php break;?>
                            <?php case 'radio' : //------------------RADIO BUTTONs-------------------------?>
                                <?php foreach($input['values'] as $value) : ?>
                                  <input
                                      class="<?php if (!empty($input['class']))echo $input['class'];if (!empty($input['action']))echo " tt_interact";?>"
                                      type="<?php echo $input['type'];?>"
                                      name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                      <?php if( !empty( $options[ $input_id ] ) ) 
                                            checked( $value , $options[ $input_id ]);?>
                                      value ="<?php echo $value;?>"
                                      <?php if (!empty($input['action'])) :?>
                                        data-tt-interact-objs='<?php echo json_encode($input['action'][1]) ?>'
                                        data-tt-interact-action="<?php echo $input['action'][0] ?>"
                                      <?php endif;?>
                                  ><?php echo $value;?>
                                <?php endforeach;?>
                            <?php break;?>
                            <?php case 'colorpicker' : //------------------COLORPICKER----------------------?>
                                <input
                                    id="<?php echo $input_id?>"
                                    type="text" 
                                    value="<?php if ( ! empty( $options[ $input_id ] ) ) echo $options[ $input_id ]; ?>"
                                    class="my-color-field<?php if (!empty($input['class']))echo " " . $input['class'];?>"
                                    data-default-color="<?php if (!empty($input['default'])) echo $input['default'];?>" 
                                    name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                />
                            <?php break;?>
                            
                            <?php case 'textarea' : //------------------TEXTAREA----------------------------?>
                                <textarea
                                    id="<?php echo $input_id?>"
                                    name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                    class=<?php if ( ! empty( $input[ 'class' ] ) ) echo $input['class'] ; ?>
                                    rows="<?php if ( ! empty( $input[ 'rows' ] ) ) echo $input['rows'] ;else echo '5' ;?>"
                                    cols="<?php if ( ! empty( $input[ 'cols' ] ) ) echo $input['cols'] ;else echo '10' ;?>"
                                ><?php if ( ! empty( $options[ $input_id ] ) )
                                          echo ( $options[ $input_id ] );
                                       elseif (! empty( $input['default_value'] ) )
                                          echo ( $input['default_value'] );
                                  ?></textarea>
                            <?php break;?>
                            <?php case 'image_upload' ://------------------IMAGE UPLOAD---------------------?>
                                    <input 
                                        type="text" 
                                        name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]" 
                                        id="<?php echo $input_id;?>"
                                        value="<?php if ( ! empty( $options[ $input_id ] ) ) echo $options[ $input_id ] ; ?>"
                                    />
                                    <button class="upload_image_button tt_button">
                                    <?php
                                        if ( !empty( $input ['title'] ) )
                                          printf( __( '%s', THEME_NAME ), $input ['title'] );
                                        else
                                          _e('Upload Image', THEME_NAME);?>
                                    </button>
                                    <button class='tt_button remove_img'><?php _e('Remove Image',THEME_NAME)?></button>
                                    
                                    <div class="tt_option_title"><span><?php _e("Preview",THEME_NAME)?></span></div> 
                                    <div class="tt_show_logo">
                                      <img
                                          class="img_preview"
                                          src="<?php if ( ! empty( $options[ $input_id ] ) )
                                                       echo  $options[ $input_id ] ;
                                                     else
                                                       echo TT_FW . "/static/images/tesla_logo.png" ?>"
                                      />
                                    </div>
                                <?php if (!empty($input['custom_width'])) : ?>
                                        <!-- IMAGE WIDTH RESIZE CODE HERE -->
                                <?php endif;?>
                            <?php break;?>
                            <?php case 'date_picker' ://------------------Date Picker-----------------------?>
                                <input
                                    class="datepicker"
                                    id="<?php echo $input_id;?>"
                                    type="text"
                                    name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                    value="<?php if ( ! empty( $options[ $input_id ] ) ) echo $options[ $input_id ] ; ?>"
                                >
                                <?php if (!empty($input['date_range'])) : //---Date Range-------------------?> 
                                    <input
                                        class="datepicker"
                                        id="<?php echo $input_id . '-to';?>"
                                        type="text"
                                        name="<?php echo THEME_OPTIONS?>[<?php echo $input_id . '-to';?>]"
                                        value="<?php if ( ! empty( $options[ $input_id . '-to' ] ) ) echo  $options[ $input_id . '-to' ] ; ?>"
                                    />
                                <?php endif?>
                            <?php break;?>
                            <?php case 'button' ://------------------BUTTON---------------------------------?>
                                <button
                                    id="<?php echo $input_id;?>"
                                    class="tt_button <?php if ( ! empty( $input['class' ] ) ) echo $input['class'] ; ?>"
                                    name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                ><?php if ( ! empty(  $input [ 'value' ] ) ) printf(__( '%s', THEME_NAME ),$input['value']); ; ?></button>
                            <?php break;?>
                            <?php case 'social_platforms' ://------------------SOCIAL PLATFORMS -------------?>
                              <ul class="tt_share_platform">
                                <?php if (!empty($input['platforms']))
                                  foreach ( $input['platforms'] as $platform ) : ?>
                                    <li>
                                      <input
                                        class="tt_social_<?php echo $platform?> <?php if (!empty($options[$input_id . '_' . $platform])) echo 'social_active'?>"
                                        type="text"
                                        value="<?php if (!empty($options[$input_id . '_' . $platform])) echo $options[$input_id . '_' . $platform]?>"
                                        title="<?php echo $platform?> Page"
                                        name="<?php echo THEME_OPTIONS?>[<?php echo $input_id . "_" . $platform?>]"
                                        placeholder="<?php echo ucfirst($platform)?>">
                                    </li>
                                  <?php endforeach;?>
                              </ul>
                            <?php break;?>
                            <?php case 'map' ://------------------MAP-------------------------------------?>
                                <input
                                  id="map_search"
                                  type="text">
                                <div
                                  id="map-canvas"
                                  class="tt_map <?php if ( ! empty( $input['class' ] ) ) echo $input['class'] ; ?>"
                                  name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>]"
                                ></div>
                                <input
                                  id="map-coords"
                                  type="hidden"
                                  name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>_coords]"
                                  value="<?php if ( ! empty( $options[ $input_id . "_coords" ] ) ) echo $options[ $input_id . "_coords" ] ;?>">
                                <input
                                  id="marker-coords"
                                  type="hidden"
                                  name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>_marker_coords]"
                                  value="<?php if ( ! empty( $options[ $input_id . "_marker_coords" ] ) ) echo $options[ $input_id . "_marker_coords" ] ;?>">
                                <input
                                  id="map-zoom"
                                  type="hidden"
                                  name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>_zoom]"
                                  value="<?php if ( ! empty( $options[ $input_id . "_zoom" ] ) ) echo $options[ $input_id . "_zoom" ] ;?>">
                                <?php if (!empty($input['icons']))
                                  foreach ($input['icons'] as $icon) : ?>
                                    <label class="map-icon">
                                      <input
                                        type="radio"
                                        name="<?php echo THEME_OPTIONS?>[<?php echo $input_id;?>_icon]"
                                        value="<?php echo TT_FW . '/static/images/mapicons/' . $icon?>"
                                        <?php if(!empty($options[ $input_id . '_icon']))checked( TT_FW . '/static/images/mapicons/' . $icon , $options[ $input_id . '_icon']); ?>
                                        ><img src="<?php echo TT_FW . '/static/images/mapicons/' . $icon?>" alt="map icon" /></label>
                                  <?php endforeach;?>
                            <?php break;?>
                        <?php endswitch;//==========================END INPUT TYPES=========================?>
                        <?php //===================================LABELS===================================
                        if (!empty($input['note'])) : ?>
                            <p class="tt_explain<?php if (!empty($input['hidden'])) echo " hidden"?>"><?php escape_htmle(($input['note'])); ?></p>
                        <?php endif;?>
                    <?php if (count($box['input_fields']) > 1 && !( empty($box['columns'] ) ) ):?>
                      </div>
                    <?php endif;?>
                  <?php endforeach;//==================================INPUT FIELDS END=================================?>
                  <div class="clear"></div>
                </div>
                <div class="tt_content_box_bottom">
                  <input class="tt_submit" type="submit" value="<?php _e('Save Changes',THEME_NAME)?>">
                    <div class="tt_bottom_note">
                      <?php printf( __( '%s', THEME_NAME ), $option_saved_text ); ?>
                    </div>
                </div>
              </div>
            <?php if (count($tab[ 'boxes' ]) > 1):?>
              </div>
            <?php endif;?>
        <?php endforeach;?>
        <?php endif;//================================================BOXES END=========================================?>
      </div>
    <?php endforeach;?>
<!-- =========================================== TABS END ========================================================== -->
    
    </div>
  </form>
</div>