<?php
/* @var $fields NewsletterFields */
?>

<?php $fields->select('schema', __('Schema', 'newsletter'), array('' => 'Custom', 'bright' => 'Bright', 'dark' => 'Dark'), ['after-rendering' => 'reload']) ?>

<?php $fields->button( 'button', 'Button layout', [
	'family_default' => true,
	'size_default'   => true,
	'weight_default' => true
] ) ?>

<div class="tnp-field-row">
    <div class="tnp-field-col-2">
        <?php $fields->size('button_width', __('Width', 'newsletter')) ?>
    </div>
    <div class="tnp-field-col-2">
        <?php $fields->select('button_align', 'Alignment', ['center' => __('Center'), 'left' => __('Left'), 'right' => __('Right')]) ?>
    </div>

</div>


<?php $fields->block_commons() ?>
