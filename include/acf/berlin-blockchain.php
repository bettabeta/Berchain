<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_berlin_blockchain',
    'title' => 'Berlin\'s Blockchain Section',
    'fields' => array(
        array(
            'key' => 'field_sponsor_logos',
            'label' => 'Sponsor Logos',
            'name' => 'sponsor_logos',
            'type' => 'repeater',
            'layout' => 'table',
            'sub_fields' => array(
                array(
                    'key' => 'field_sponsor_logo',
                    'label' => 'Logo',
                    'name' => 'logo',
                    'type' => 'image',
                    'required' => 1,
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_sponsor_name',
                    'label' => 'Sponsor Name',
                    'name' => 'name',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_sponsor_link',
                    'label' => 'Sponsor Link',
                    'name' => 'link',
                    'type' => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'tpl-berlins-blockchain.php',
            ),
        ),
    ),
));

endif; 