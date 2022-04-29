<?php
/**
* Файл functions.php подключается на всех страницах сайта и содержит произвольные функции.
* Функции могут вносить изменения в ядро и поведение CMS Wordpress.
* @author Boris
* @version 1.0
*/

/**
* Add cumstom menu item to admin page via plugin ACF
* Добавляем собственную страницу настроек сайта (телефоны, меню и т.д.) с использованием плагина ACF
*/
function add_new_option_page() {
	if( function_exists('acf_add_options_page') ) {
		/*
		* Function to add item of admin menu
		* Функция ACF для добавления пункта меню
		* @param array $settings
		* <pre>
		* $params = [
		* 	'page_title' => (string) Page title.
		*   'menu_slug' => (string) URL of menu.
		*   'icon_url' => (string) Icon class.
		*   'redirect' => (bool) If set to true, this options page will redirect to the first child page (if a child page exists). If set to false, this parent page will appear alongside any child pages as its own page.
		* ]
		* </pre>
		* @return array The validated and final page settings.
		*/
		acf_add_options_page(array(
			'page_title' => 'Настройки сайта',
			'menu_slug'  => 'options-page',
			'icon_url' 	 => 'dashicons-admin-generic',
			'redirect' 	 => true,
		));
	}
}
/**
* Actions are the hooks that the WordPress core launches at specific points during execution, or when specific events occur.
* Добавление хука на добавление пункта меню
* @param string $hook_name The name of the action to add the callback to.
* @param callable $callback The callback to be run when the action is called.
*/
add_action( 'init', 'add_new_option_page' );

/**
* Add filter hook to modify data at run
* Добавляем фильтр для процесса проверки типа файла
* @param string $hook_name The name of the filter to add the callback to.
* @param callable $callback The callback to be run when the filter is applied.
* @param int $priority Used to specify the order in which the functions associated with a particular filter are executed.
* @param int $accepted_args The number of arguments the function accepts.
*/
add_filter( 'wp_check_filetype_and_ext', 
	/**
	* Change file data array
	* Подоготавливаем массив данных о файле
	* @param array $data Data of file.
	* @param string $file Full path to the file.
	* @param string $filename The name of the file.
	* @param array $mimes Array of allowed mime types.
	* @return array File data array.
	*/
	function($data, $file, $filename, $mimes) {
		$filetype = wp_check_filetype( $filename, $mimes );

		return [
			'ext' => $filetype['ext'],
			'type' => $filetype['type'],
			'proper_filename' => $data['proper_filename']
		];

}, 10, 4 );
/**
* Change mime type
* Добавляем mime тип image/svg+xml
* @param array $mimes Mimes types.
* @return array Mime type data array.
*/
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
/**
* Add filter hook to modify data at run
* Добавляем фильтр чтобы добавить допустимые mime типы
* @param string $hook_name The name of the filter to add the callback to.
* @param callable $callback The callback to be run when the filter is applied.
*/
add_filter( 'upload_mimes', 'cc_mime_types' );
/**
* Fix display SVG files
* Исправляем отображение файлов SVG в медиабиблиотеке
*/
function fix_svg() {
	echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
/**
* Actions are the hooks that the WordPress core launches at specific points during execution, or when specific events occur.
* Хук для правки отображения SVG
* @param string $hook_name The name of the action to add the callback to.
* @param callable $callback The callback to be run when the action is called.
*/
add_action( 'admin_head', 'fix_svg' );

/**
* Returns the value of a specific field.
* Получаем данные определенных пользовательских полей. Например поля logo_head
* @param string $selector The field name or field key.
* @param mixed $post_id The post ID where the value is saved. Also can be slug of type.
* @return mixed The field value.
*/
$logo_head = get_field('logo_head', 'option');

/**
* Displays information about the current site.
* Выводим название сайта
* @param string $show Site information to display.
*/
bloginfo('name');

/**
* Check this page is front.
* Проверка главной страницы
* @return bool Return true if is front page
*/
is_front_page();

/**
* Display or retrieve page title for all areas of blog.
* Вывод тайтла страницы
* @param string $sep How to separate the various items within the page title. Default '»'. Default value: '&raquo;'.
* @param bool $display Whether to display or retrieve title. Default value: true
* @param string $seplocation Location of the separator ('left' or 'right'). Default value: ''
* @return string|void String when $display is true, nothing otherwise.
*/
wp_title('');

/**
* Retrieves template directory URI for current theme.
* Получить путь к шаблону сайта
* @return string URI to current theme's template directory.
*/
get_template_directory_uri();

/**
* Load header template.
* Загружка шаблона шапки сайта
* @param string $name The name of the specialised header. Default value: null
* @param array $args Additional arguments passed to the header template. Default value: array()
* @return void|false Void on success, false if the template does not exist.
*/
get_header();

/**
* Load footer template.
* Загружка шаблона подвала сайта
* @param string $name The name of the specialised header. Default value: null
* @param array $args Additional arguments passed to the header template. Default value: array()
* @return void|false Void on success, false if the template does not exist.
*/
get_footer();

/**
* Retrieves post data given a post ID or post object.
* Загружка данных поста или страницы
* @param int|WP_Post|null $post Post ID or post object.
* @param string $output The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which correspond to a WP_Post object, an associative array, or a numeric array, respectively. Default value: OBJECT
* @param string $filter Type of filter to apply. Accepts 'raw', 'edit', 'db', or 'display'. Default value: 'raw'
* @return WP_Post|array|null Type corresponding to $output on success or null on failure. When $output is OBJECT, a WP_Post instance is returned.
*/
$page = get_post(123);

/**
* Search content for shortcodes and filter shortcodes through their hooks.
* Выполнения шорткода WordPress
* @param string $content Content to search for shortcodes.
* @param bool $ignore_html When true, shortcodes inside HTML elements will be skipped. Default value: false
* @return string Content with shortcodes filtered out.
*/
do_shortcode( 'test' );

/**
* Display or retrieve the current post title with optional markup.
* Получение или вывод названия текущей страницы
* @param string $before Markup to prepend to the title. Default value: ''
* @param string $after Markup to append to the title. Default value: ''
* @param bool $echo Whether to echo or return the title. Default true for echo. Default value: true
* @return void|string Void if $echo argument is true, current post title if $echo is false.
*/
the_title();

/**
* Display the post content.
* Вывод контента текущей страницы
* @param string $more_link_text Content for when there is more text. Default value: null
* @param bool $strip_teaser Strip teaser content before the more text. Default value: false
* @return void|string Void if $echo argument is true, current post title if $echo is false.
*/
the_content();
?>