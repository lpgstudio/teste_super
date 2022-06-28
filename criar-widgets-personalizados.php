function widgets_init() {
    register_sidebar( array( 'name' => esc_html__( 'Sidebar' ), 'id' => 'barra-lateral', 'before_widget' =>
      '<aside id="%1$s" class="widget %2$s">', 'after_widget'  => '</aside>', 'before_title'  => '<h3 class="widget-title">','after_title'   => '</h3>', ));
  
    register_sidebar( array( 'name' => esc_html__( 'Rodapé - Quem somos' ), 'id' => 'rodape', 'before_widget' =>
      '<aside id="%1$s" class="widget %2$s">', 'after_widget textwidget'  => '</aside>', 'before_title'  => '<h3>','after_title'   => '<i></i></h3>', ));
  
  // MENU RODAPÉ
    register_sidebar( array( 'name' => esc_html__( 'Rodapé - menu' ), 'id' => 'rodape-menu', 'before_widget' =>
      '<aside id="%1$s" class="widget %2$s ">', 'after_widget'  => '</aside>', 'before_title'  => '<h3>','after_title'   => '<i></i></h3>', ));
  
          // news
    register_sidebar( array( 'name' => esc_html__( 'Rodapé - Newsletter' ), 'id' => 'rodape-news', 'before_widget' =>
      '<aside id="%1$s" class="widget %2$s">', 'after_widget'  => '</aside>', 'before_title'  => '<h3>','after_title'   => '<i></i></h3>', ));
  
  }
  
  add_action( 'widgets_init', 'widgets_init' );