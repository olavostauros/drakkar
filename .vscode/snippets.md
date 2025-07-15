# WordPress PHP Code Snippets

## WordPress Hook Snippets

### Action Hook
```php
add_action('${1:hook_name}', '${2:function_name}');

function ${2:function_name}() {
    ${3:// Your code here}
}
```

### Filter Hook
```php
add_filter('${1:hook_name}', '${2:function_name}');

function ${2:function_name}($${3:value}) {
    ${4:// Your code here}
    return $${3:value};
}
```

## WordPress Template Functions

### Get Template Part
```php
get_template_part('${1:template-name}', '${2:template-part}');
```

### WordPress Loop
```php
if (have_posts()) :
    while (have_posts()) : the_post();
        ${1:// Your loop content}
    endwhile;
endif;
```

### Custom Post Type Query
```php
$${1:query} = new WP_Query(array(
    'post_type' => '${2:custom_post_type}',
    'posts_per_page' => ${3:10},
    'meta_query' => array(
        array(
            'key' => '${4:meta_key}',
            'value' => '${5:meta_value}',
            'compare' => '${6:=}'
        )
    )
));

if ($${1:query}->have_posts()) :
    while ($${1:query}->have_posts()) : $${1:query}->the_post();
        ${7:// Your content}
    endwhile;
    wp_reset_postdata();
endif;
```
