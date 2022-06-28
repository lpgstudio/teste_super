<?php
/**
 * Adicionar Formulario nos produtos
 * Doc de Referencia
 * https://www.damiencarbery.com/2017/02/product-enquiry-form-using-woocommerce-and-contact-form-7/
 * */  

// Add the CF7 form between the short description and the 'Add to cart' button.
add_action( 'woocommerce_single_product_summary', 'dcwd_add_cf7_form_after_single_excerpt', 25 );
function  dcwd_add_cf7_form_after_single_excerpt() {
  echo do_shortcode('[contact-form-7 id="2813" title="Formulario-Produto"]'); ;
}

// Adiciona depois o formulario entre a descrição do produto e os recomendados
add_action('woocommerce_after_single_product_summary', 'add_quote_form');
function add_quote_form(){
    echo do_shortcode('[contact-form-7 id="2813" title="Formulario-Produto"]');
}

// Adiciona o formulario depois da descrição do produto
add_filter('the_content', 'dc_cf7_form_to_all_products');
function dc_cf7_form_to_all_products($content) {
    if ( class_exists( 'woocommerce' ) && is_product() && is_main_query() ) {  // Check suggested by: https://pippinsplugins.com/playing-nice-with-the-content-filter/
        return $content . '[contact-form-7 id="2813" title="Formulario-Produto"]';
    }  
    return $content;
}

//  Teste para pegar o titulo do produto
add_action( 'woocommerce_single_product_summary', 'dcwd_add_cf7_form_after_single_excerpt2', 30 );
 function  dcwd_add_cf7_form_after_single_excerpt2() {
	global $product, $post;
	$product = wc_get_product( $post );
	
	echo $product->get_name();
 }

 
// Ensure the Description tab is present as it is needed by the_content filter.
add_filter( 'woocommerce_product_tabs', 'dc_cf7_add_description_tab', 20 );
function dc_cf7_add_description_tab( $tabs ) {
    global $product, $post;
    // Description tab - add if there is no post content (i.e. if the Description is empty)
    // because woocommerce_default_product_tabs() in woocommerce/includes/wc-template-functions.php
    // excludes it if the post content is empty.
    if ( ! $post->post_content ) {
        $tabs['description'] = array(
            'title'    => __( 'Description', 'woocommerce' ),
            'priority' => 10,
            'callback' => 'woocommerce_product_description_tab',
		);
	}   
    return $tabs;
 }
 /**
  * Fim da altaração no formulario dos produtos 
  */