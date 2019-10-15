# Drupal 8 config modules for UBC

This set of modules is used to create some general shared configuration between Drupal 8 websites.

## References

* [Drupal](https://www.drupal.org/)
* [Drupal on Platform.sh](https://docs.platform.sh/frameworks/drupal8.html)
* [PHP on Platform.sh](https://docs.platform.sh/languages/php.html)

## Wait, so what is this?

Collectively, these are something like a less locked-in Installation Profile. Installation profiles are fantastic for quickly delivering an intial set of functionality, but difficult to work with from there on out. Module updates end up tied to the profile instead of existing as their own separate functional pieces, and changing profiles at a later date is very tricky to acheive. Additionally, we don't always need or agree with all of a profile's choices and preferences.

These modules are instead a collection that can be used individually or as a whole to provide a sensible set of default configuration specific to Web Service's needs.

To work with the modules as intended, you will typically follow this worflow:
- [ ] Install Drupal 8 using the Standard installation Profile
- [ ] Install and enable UBC specific themes
- [ ] Install and enable a common set of contributed modules / dependencies
- [ ] Install and enable some of the low level modules from this repo that provide general and shared settings
- [ ] Install and enable modules that provide the content types you're interested in using
- [ ] Install and enable modules that provide the views for the content types you're interested in using and any user roles and permissions for our suite of modules
- [ ] Finally, remove some of the unnecessary content and settings

### Cool, so what are the modules and what do they do?

The custom modules included are:

- **UBC Announcement** *[ubc_announcement]*: Provides the UBC Announcement content type and its fields, pathauto settings, workflow settings and a Tour
- **UBC Announcement Views** *[ubc_announcement_views]*: Provides views specific to the UBC Announcement content type
- **UBC Content Items** *[ubc_content_items]*: Provides an interface for defining and working with reusable entity types without a node view
- **UBC Date Formats** *[ubc_date_formats]*: Provides a set of commonly used date formats
- **UBC Editor Config** *[ubc_editor_config]*: Provides a custom predefined wysiwyg format and settings
- **UBC Editor File Entities** *[ubc_editor_file_entities]*: Provides a method of working with Media Entities and embedding them into the wysiwyg
- **UBC Event** *[ubc_event]*: Provides the UBC Event content type and its fields, pathauto settings, workflow settings and a Tour
- **UBC Event Views** *[ubc_event_views]*: Provides views specific to the UBC Event content type
- **UBC General Shared Config** *[ubc_general_shared_config]*: Provides definitions for shared taxonomies, view modes, views and blocks
- **UBC Homepage** *[ubc_homepage]*: Provides the Homepage content type and its fields, pathauto settings, and workflow settings
- **UBC Homepage Views** *[ubc_homepage_views]*: Provides views specific to the Homepage content type
- **UBC Image Styles** *[ubc_image_styles]*: Provides a common set of image styles
- **UBC Landing Page** *[ubc_landing_page]*: Provides the UBC Landing Page content type and its fields, pathauto settings, workflow settings and a Tour
- **UBC Landing Page Views** *[ubc_landing_page_views]*: Provides views specific to the UBC Landing Page content type
- **UBC Page** *[ubc_page]*: Provides the UBC Page content type and its fields, pathauto settings, workflow settings and a Tour
- **UBC Page Views** *[ubc_page_views]*: Provides views specific to the UBC Page content type
- **UBC Paragraph Entities** *[ubc_paragraph_entities]*: Provides a common set of paragraph types, used in UBC Landing Pages
- **UBC Profile** *[ubc_profile]*: Provides the UBC Profile content type and its fields, pathauto settings, workflow settings and a Tour
- **UBC Profile Extend** *[ubc_profile_extend]*: Provides a sample implemention dor adding an additional field to the UBC Profile content type. This is meant to serve as a model of non-core additions to content types
- **UBC Profile Views** *[ubc_profile_views]*: Provides views specific to the UBC Profile content type
- **UBC Share Block** *[ubc_share_block]*: **Work in progress**. Provides a custom block type for adding share links to various social media networks
- **UBC Tailwind CSS** *[ubc_tailwind_css]*: **Work in progress**. Provides a set of shared utility classes that can be used on any UBC-Branded website
- **UBC User Roles** *[ubc_user_roles]*: Provides a set of user roles and their associated permsissions


## Lando Quick Start

This assumes you've installed Drupal using the Standard installation profile

### Enable and set themes

```lando drush theme:enable adminimal_theme && lando drush theme:enable octopus && lando drush config-set system.theme admin adminimal_theme -y && lando drush config-set system.theme default octopus -y```

### Enable contrib modules

```lando drush en address, admin_toolbar_links_access_filter, admin_toolbar_tools, adminimal_admin_toolbar, allowed_formats, anchor_link, antibot, auto_entitylabel, ckeditor_a11ychecker, content_moderation, crop, ctools, datetime_range, dropzonejs, dropzonejs_eb_widget, editor_advanced_link, editor_button_link, entity_browser, entity_browser_entity_form, entity_embed, entity_reference_revisions, entity_tasks, embed, field_group, ga, image_widget_crop, inline_entity_form, inline_responsive_images, linkit, media,menu_block, metatag, pathauto, paragraphs, simple_gmap, simple_sitemap, smtp, structure_sync, telephone, token, twig_tweak, webform, webform_ui, workflows -y```

### Enable custom modules for general settings

```lando drush en ubc_ckeditor_widgets, ubc_date_formats, ubc_editor_config, ubc_image_styles, ubc_paragraph_entities, ubc_general_shared_config -y```

### Enable custom content type modules

```lando drush en ubc_editor_file_entities, ubc_announcement, ubc_homepage, ubc_event, ubc_landing_page, ubc_page, ubc_profile -y```

### Enable User Role and Views modules last, once all the pieces are in place.

```lando drush en ubc_announcement_views, ubc_homepage_views, ubc_event_views, ubc_landing_page_views, ubc_profile_views, ubc_user_roles -y```

### POST INSTALL

GO to:

- /admin/structure/types/manage/article/delete
- /admin/structure/types/manage/page/delete
(TODO: these (below) could probably be run via drush)
- /admin/config/content/formats/manage/full_html/disable
- /admin/config/content/formats/manage/restricted_html/disable
- /admin/config/content/formats/manage/basic_html/disable
