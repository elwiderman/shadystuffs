<?php
if (function_exists('icl_object_id')) { ?>
    <div class="language-switcher">
        <div class="dropdown">
            <?php
            $icl = icl_get_languages('skip_missing=0&orderby=id&order=asc');
            $currLng = wpml_current_lang()['language_code'];
            $currUrl = wpml_current_lang()['url'];
            $currFlag = wpml_current_lang()['country_flag_url'];
            ?>
            <a class="dropdown-toggle" id="languageSwitcher" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" href="#">
                <img src="<?= $currFlag; ?>" class="img-fluid">
            </a>
            <div class="dropdown-menu" aria-labelledby="languageSwitcher">
                <?php
                foreach ($icl as $lang) {
                    if (!$lang['active']) {
                        echo '<a class="dropdown-item" href="' . $lang['url'] . '"><img src="' . $lang['country_flag_url'] . '" class="img-fluid"></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
