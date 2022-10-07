<?php 
 /** 
  * Ends container-main & page-wrap >---from header file---<
  * @package Relational 
  * @since 1.0.1
  */ 
?>
    
    </section>
        <footer id="copyFooterFooter">
            
            <div id="footer-floats" class="footer-page">
                <div class="maybe-copyright" style="display:block">
                    <p class="text-muted"><?php
                    $year  = date_i18n(__( 'Y', 'relational' ));
                    esc_html_e( 'Copyright ', 'relational' ); 
                    echo esc_attr( ' ' . $year . ' ' );
                    printf( esc_attr( bloginfo( 'name' ) ) ); ?></p>
                </div>
        </footer>    
</div>

    <?php wp_footer(); ?>

</body>
</html> 