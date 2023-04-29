<?php
$settings = get_option('framework_options');
if(!empty($settings['social_urls'])) :
    echo '<ul class="socials">';
    foreach($settings['social_urls'] as $key => $value ):
        if(empty($value))
        continue;

        echo <<<SOCIAL
        <li>
            <a itemprop="sameAs" href="{$value}" target="_blank">
                <i class="fab {$key}"></i>
            </a>
        </li>
SOCIAL;
    endforeach;
    echo '</ul>';
endif;


