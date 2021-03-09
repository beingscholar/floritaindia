<?php
$size = array('width' => 240, 'height' => 160, "crop" => true);
?>
<style>
    .post-title {
        font-family: <?php echo $title_font_family ?>;
        font-size: <?php echo $title_font_size ?>px;
        font-weight: <?php echo $title_font_weight ?>;
        color: <?php echo $title_font_color ?>;
        line-height: 1.3em;
        padding: 15px 0 0 0;
    }

    .post-excerpt {
        font-family: <?php echo $text_font_family ?>;
        font-size: <?php echo $text_font_size ?>px;
        font-weight: <?php echo $text_font_weight ?>;
        color: <?php echo $text_font_color ?>;
        line-height: 1.4em;
        padding: 5px 0 0 0;
    }

    .post-date {
        font-family: <?php echo $text_font_family ?>;
        color: <?php echo $text_font_color ?>;
        font-size: <?php echo round($text_font_size * 0.8) ?>px;
        font-weight: normal;
        padding: 10px 0 0 15px;
    }

    .post-author {
        font-family: <?php echo $text_font_family ?>;
        color: <?php echo $text_font_color ?>;
        font-size: <?php echo round($text_font_size * 0.8) ?>px;
        font-weight: normal;
        padding: 0 0 5px 0;
    }
</style>

<!-- TWO COLUMNS -->
<table cellspacing="0" cellpadding="0" border="0" width="100%">

    <?php foreach (array_chunk($posts, 2) AS $row) { ?>
        <?php
        $media = null;
        if ($show_image) {
            $media = tnp_composer_block_posts_get_media($row[0], $size, $image_placeholder_url);
            $media->link = tnp_post_permalink($row[0]);
        }

	    $author = '';
	    if ($show_author) {
		    $author_object = get_user_by('id', $post->post_author);
		    if ($author_object) {
			    $author = $author_object->display_name;
		    }
	    }

        $options['button_url'] = tnp_post_permalink($row[0]);
        ?>
        <tr>
            <td valign="top" style="padding: 10px;" class="mobile-wrapper two-columns">

                <!-- LEFT COLUMN -->
                <table cellpadding="0" cellspacing="0" border="0" width="47%" align="left" class="responsive-table">
                    <tr>
                        <td style="padding: 20px 0 40px 0;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <?php if ($media) { ?>
                                    <tr>
                                        <td align="center" valign="middle" class="tnpc-row-edit" data-type="image">
                                            <?php echo TNP_Composer::image($media) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td align="center"
                                        inline-class="post-title"
                                        class="tnpc-row-edit tnpc-inline-editable"
                                        data-type="title" data-id="<?php echo $row[0]->ID ?>">
                                            <?php
                                            echo TNP_Composer::is_post_field_edited_inline($options['inline_edits'], 'title', $row[0]->ID) ?
                                                    TNP_Composer::get_edited_inline_post_field($options['inline_edits'], 'title', $row[0]->ID) :
                                                    tnp_post_title($row[0])
                                            ?>
                                    </td>
                                </tr>
                                <?php if ($show_date) { ?>
                                    <tr>
                                        <td  align="center" inline-class="post-date">
                                            <?php echo tnp_post_date($row[0]) ?>
                                        </td>
                                    </tr>
                                <?php } ?>

	                            <?php if ($show_author) { ?>
                                    <tr>
                                        <td align="center" inline-class="post-author">
				                            <?php echo $author ?>
                                        </td>
                                    </tr>
	                            <?php } ?>

                                <tr>
                                    <td align="center"
                                        inline-class="post-excerpt"
                                        class="tnpc-row-edit tnpc-inline-editable"
                                        data-type="text" data-id="<?php echo $row[0]->ID ?>">
                                            <?php
                                            echo TNP_Composer::is_post_field_edited_inline($options['inline_edits'], 'text', $row[0]->ID) ?
                                                    TNP_Composer::get_edited_inline_post_field($options['inline_edits'], 'text', $row[0]->ID) :
                                                    tnp_post_excerpt($row[0], $excerpt_length)
                                            ?>
                                    </td>
                                </tr>
	                            <?php if ($show_read_more_button) { ?>
                                    <tr>
                                        <td align="center">
	                                        <?php $button_options['button_url'] = $options['button_url']; ?>
	                                        <?php echo TNP_Composer::button( $button_options ) ?>
                                            <br><br>
                                        </td>
                                    </tr>
	                            <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>

                <?php
                if (!isset($row[1])) {
                    continue;
                }
                $media = null;
                if ($show_image) {
                    $media = tnp_composer_block_posts_get_media($row[1], $size, $image_placeholder_url);
                    $media->link = tnp_post_permalink($row[1]);
                }
                $options['button_url'] = tnp_post_permalink($row[1]);
                ?>
                <!-- RIGHT COLUMN -->
                <table cellpadding="0" cellspacing="0" border="0" width="47%" align="right" class="responsive-table">
                    <tr>
                        <td style="padding: 20px 0 40px 0;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <?php if ($media) { ?>

                                    <tr>
                                        <td align="center" valign="middle" class="tnpc-row-edit" data-type="image">
                                            <?php echo TNP_Composer::image($media) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td align="center"
                                        inline-class="post-title"
                                        class="tnpc-row-edit tnpc-inline-editable"
                                        data-type="title" data-id="<?php echo $row[1]->ID ?>">
                                            <?php
                                            echo TNP_Composer::is_post_field_edited_inline($options['inline_edits'], 'title', $row[1]->ID) ?
                                                    TNP_Composer::get_edited_inline_post_field($options['inline_edits'], 'title', $row[1]->ID) :
                                                    tnp_post_title($row[1])
                                            ?>
                                    </td>
                                </tr>
                                <?php if ($show_date) { ?>
                                    <tr>
                                        <td  align="center" inline-class="post-date">
                                            <?php echo tnp_post_date($row[1]) ?>
                                        </td>
                                    </tr>
                                <?php } ?>

	                            <?php if ($show_author) { ?>
                                    <tr>
                                        <td align="center" inline-class="post-author">
				                            <?php echo $author ?>
                                        </td>
                                    </tr>
	                            <?php } ?>

                                <tr>
                                    <td align="center"
                                        inline-class="post-excerpt"
                                        class="tnpc-row-edit tnpc-inline-editable"
                                        data-type="text" data-id="<?php echo $row[1]->ID ?>">
                                            <?php
                                            echo TNP_Composer::is_post_field_edited_inline($options['inline_edits'], 'text', $row[1]->ID) ?
                                                    TNP_Composer::get_edited_inline_post_field($options['inline_edits'], 'text', $row[1]->ID) :
                                                    tnp_post_excerpt($row[1], $excerpt_length)
                                            ?>
                                    </td>
                                </tr>
	                            <?php if ($show_read_more_button) { ?>
                                    <tr>
                                        <td align="center">
	                                        <?php $button_options['button_url'] = $options['button_url']; ?>
	                                        <?php echo TNP_Composer::button( $button_options ) ?>
                                            <br><br>
                                        </td>
                                    </tr>
	                            <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>


            </td>
        </tr>

    <?php } ?>

</table>

