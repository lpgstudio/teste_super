<?php
  get_header();

  $estado = filter_input(INPUT_GET, 'estado', FILTER_SANITIZE_STRING);
  $cidade = filter_input(INPUT_GET, 'cidade', FILTER_SANITIZE_STRING);

  /* Filtro de estados */
  $args_estados = array
	(
    'taxonomy' => 'distribuidores_category',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC',
    'parent' => 0
  );
  $estados = get_terms($args_estados);

  if ($estado) {
    /* Filtro de cidades */
    $term = get_term_by('slug', $estado, 'distribuidores_category');

    $args_cidades = array
    (
      'taxonomy' => 'distribuidores_category',
      'posts_per_page'    => -1,
      'orderby'			=> 'date',
      'order'				=> 'ASC',
      'parent' => $term->term_id
    );
    $cidades = get_terms($args_cidades);
  }

  /* Listagem dos distribuidores */
  $paged = (get_query_var('paged')) ? get_query_var('paged') :  1;
  $args = array(
    'post_type' => 'distribuidores',
    'posts_per_page' => 10,
    'paged'     => $paged,
    'orderby' => 'title',
    'order' => 'ASC'
  );

  $filter_estado = null;
  $filter_cidade = null;

  if (!empty($estado)) {
    $filter_estado = array(
      'key'   => 'estado',
      'value' => $estado,
    );

    if (!empty($cidade)) {
      $cidade_term = get_term($cidade);

      $filter_cidade = array(
        'key'   => 'cidade',
        'value' => $cidade_term->name,
      );
    }

    $args = array_merge($args, array(
      'meta_query' => array (
        'relation' => 'AND', 
        $filter_estado, 
        $filter_cidade
      )
    ));
  }

  $posts = get_posts($args);
?>

<section class="page-distribuidor">
  <div class="container">
    <div class="row">
      <form id="form" class="col-12 d-flex px-0" method="get">
        <!-- Filtro Estado -->
        <div class="col-lg-6">
          <!--<label>Filtrar por estado</label>-->
          <select name="estado" id="estado">
            <option value="">Estado</option>
            <?php foreach ($estados as $e) : ?>
              <option <?php echo $e->slug == $estado ? 'selected="selected"' : ''; ?> value="<?php echo $e->slug; ?>"><?php echo $e->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-lg-6">
          <!-- Filtro Cidade -->
          <!--<label>Filtrar por cidade</label>-->
          <select name="cidade" id="cidade" <?= empty($estado) ? 'disabled' : ''; ?>>
            <option value="">Cidade</option>
            <?php foreach ($cidades as $c) : ?>
              <option <?php echo $c->term_id == $cidade ? 'selected="selected"' : ''; ?> value="<?php echo $c->term_id; ?>"><?php echo $c->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!--<div class="col-lg-2">
          <button id="search">Buscar</button>
        </div>-->
      </form>
        <?php 
          //$paged = (get_query_var('paged')) ? get_query_var('paged') :  1;

          /*$parametro = [
            'paged'     => $paged,
            'orderby'   => 'title',
            'order'     => 'ASC',				// ordem decrescente
            'post_type' => 'distribuidores'
          ];
          $query = new WP_Query($parametro);*/
        ?>
        <?php if (have_posts()) : ?>
            <?php foreach ($posts as $post) :
                $cidade_box = get_field('cidade', $post);
                $estado_box = get_field('estado', $post);
                $tel_box = get_field('telefone', $post);
        ?>
                <div class="col-lg-6">
                  <div class="box">
                    <div class="description">
                      <h2 class="company"><?= get_the_title() ?></h2>
                      <!-- Aqui entraria a div do endereço -->
                      <div class="info d-flex">
                        <p class="mr-4"><i class="fas fa-map-marker-alt"></i> <?= $cidade_box ?> - <?= $estado_box ?></p>
                        <?php if(!empty($tel_box)): ?>
                          <p><i class="fas fa-phone-alt"></i> <?= $tel_box ?></p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
            <?php wpbeginner_numeric_posts_nav(); //paginação ?>
        <?php endif; ?>
    </div>
  </div>
</section>

<!-- bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/21ca260e10.js" crossorigin="anonymous"></script>
<script>
  let estado = '<?= $estado; ?>';
  let cidade = '<?= $cidade; ?>';

  $('#estado').change(() => {
    if (estado != $('#estado').val()) {
      $('#cidade').val('');
      $('#cidade').prop('disabled', true);
    } else {
      $('#cidade').val(cidade);
      $('#cidade').prop('disabled', false);
    }

    $('#form').submit();
  });

  $('#cidade').change(() => {
    $('#form').submit();
  });

  /*$('#search').click(() => {
    $('#form').submit();
  });*/
</script>

<?php get_footer(); ?>


<!-- Functions -->
function distribuidores_post_type() {
  // Set UI labels for Custom Post Type
  $labels = array(
    'name'                => _x( 'Distribuidores', 'Post Type General Name', get_page_template_slug() ),
    'singular_name'       => _x( 'Distribuidores', 'Post Type Singular Name', get_page_template_slug() ),
    'menu_name'           => __( 'Distribuidores', get_page_template_slug() ),
    'parent_item_colon'   => __( 'Parent', get_page_template_slug() ),
    'all_items'           => __( 'Todos os Distribuidores', get_page_template_slug() ),
    'view_item'           => __( 'Visualizar', get_page_template_slug() ),
    'add_new_item'        => __( 'Adicionar Novo', get_page_template_slug() ),
    'add_new'             => __( 'Adicionar Novo', get_page_template_slug() ),
    'edit_item'           => __( 'Editar', get_page_template_slug() ),
    'update_item'         => __( 'Atualizar', get_page_template_slug() ),
    'search_items'        => __( 'Procurar', get_page_template_slug() ),
    'not_found'           => __( 'Nada encontrado', get_page_template_slug() ),
    'not_found_in_trash'  => __( 'Nada encontrado na lixeira', get_page_template_slug() )
  );

  // Set other options for Custom Post Type
  $args = array(
    'label'               => __( 'distribuidores', get_page_template_slug() ),
    'description'         => __( 'News and reviews', get_page_template_slug() ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions' ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
    'menu_icon'           => 'dashicons-groups',
    // This is where we add taxonomies to our CPT
    'taxonomies'          => array( 'distribuidores_category' ) //If you need a category
  );

  // Registering your Custom Post Type
  register_post_type( 'distribuidores', $args );
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
add_action( 'init', 'distribuidores_post_type', 0 );