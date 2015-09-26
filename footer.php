<?php
$teslawp_footer_company = _go('footer_company');
if(empty($teslawp_footer_company))
    $teslawp_footer_company = 'teslathemes';
?>
            </div>
        </div><!-- CONTENTS END -->
        
        <?php if (is_active_sidebar('footer-sidebar')): ?>
        
        <div class="footerbg"><!-- FOOTER START -->
            <div class="wrapper">
                <div class="footer textcolor5">
                    <?php dynamic_sidebar('footer-sidebar'); ?>
                </div>
            </div>
        </div><!-- FOOTER END -->
        
        <?php endif; ?>
        
        <!--<div class="lowerfooterbg">
            <div class="wrapper">
                <div class="lowerfooter">
                    <div class="copyright textcolor10">
                       <?php _e('powered by','teslawp'); ?> <a target="_blank" href="http://wordpress.org/"><span class="textcolor9">wordpress</span></a> 
                    </div>
                    <div class="signature textcolor10">
                        <?php _e('designed by','teslawp'); ?> <a target="_blank" href="http://teslathemes.com/"><span class="textcolor"><?php echo $teslawp_footer_company; ?></span></a>
                    </div>
                </div>
            </div>
        </div>-->
        
        <?php wp_footer(); ?>
        
    </body>
</html>
