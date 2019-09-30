# Drupal 8 fconfig modules for UBC

This set of modules is used to create some general shared configuration between Drupal 8 websites.

## References

* [Drupal](https://www.drupal.org/)
* [Drupal on Platform.sh](https://docs.platform.sh/frameworks/drupal8.html)
* [PHP on Platform.sh](https://docs.platform.sh/languages/php.html)

## Lando Quick Start

This assumes you've used composer to add the correct modules.

### Enable and set themes

```lando drush theme:enable adminimal_theme && lando drush theme:enable octopus && lando drush config-set system.theme admin adminimal_theme -y && lando drush config-set system.theme default octopus -y```

### Enable contrib modules

```lando drush en address, admin_toolbar_links_access_filter, admin_toolbar_tools, adminimal_admin_toolbar, allowed_formats, anchor_link, antibot, auto_entitylabel, ckeditor_a11ychecker, content_moderation, crop, ctools, datetime_range, dropzonejs, dropzonejs_eb_widget, editor_advanced_link, editor_button_link, entity_browser, entity_browser_entity_form, entity_embed, entity_reference_revisions, embed, field_group, ga, image_widget_crop, inline_entity_form, inline_responsive_images, linkit, media,menu_block, metatag, pathauto, paragraphs, simple_gmap, smtp, telephone, token, twig_tweak, webform, webform_ui, workflows -y```

### Enable custom modules for general settings

```lando drush en ubc_ckeditor_widgets, ubc_date_formats, ubc_editor_config, ubc_image_styles, ubc_paragraph_entities, ubc_general_shared_config -y```

### Enable custom content type modules

```lando drush en ubc_editor_file_entities, ubc_announcement, ubc_homepage, ubc_event, ubc_landing_page, ubc_page, ubc_profile -y```

### And we run this last once all the pieces are in place and we can set the needed roles.

```lando drush en ubc_user_roles -y```
