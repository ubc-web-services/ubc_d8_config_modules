# Drupal 10 config modules for UBC

This set of modules is used to create some general shared configuration between Drupal 10 websites.

## References

* [Drupal](https://www.drupal.org/)
* [Drupal on Platform.sh](https://docs.platform.sh/frameworks/drupal8.html)
* [PHP on Platform.sh](https://docs.platform.sh/languages/php.html)

## Wait, so what is this?

Collectively, these are something like a less locked-in Installation Profile. Installation profiles are fantastic for quickly delivering an intial set of functionality, but difficult to work with from there on out. Module updates end up tied to the profile instead of existing as their own separate functional pieces, and changing profiles at a later date is very tricky to acheive. Additionally, we don't always need or agree with all of a profile's choices and preferences.

These modules are instead a collection that can be used individually or as a whole to provide a sensible set of default configuration specific to Web Service's needs.

To work with the modules as intended, you will typically follow this worflow:
- [ ] Install Drupal 10 using the Standard installation Profile
- [ ] Install and enable UBC specific themes
- [ ] Install and enable a common set of contributed modules / dependencies
- [ ] Install and enable some of the low level modules from this repo that provide general and shared settings
- [ ] Install and enable modules that provide the content types you're interested in using
- [ ] Install and enable modules that provide the views for the content types you're interested in using and any user roles and permissions for our suite of modules
- [ ] Finally, remove some of the unnecessary content and settings

### Cool, so what are the modules and what do they do?

The custom modules included are:

- **UBC Alert** *[ubc_alert]*: Provides a custom Alert Banner entity and its fields, as well as the view to create the block that it outputs to.
- **UBC Announcement** *[ubc_announcement]*: Provides the UBC Announcement content type and its fields, pathauto settings
- **UBC Announcement Views** *[ubc_announcement_views]*: Provides views specific to the UBC Announcement content type
- **UBC Content Items** *[ubc_content_items]*: Provides an interface for defining and working with reusable entity types without a node view
- **UBC Custom Block Types** *[ubc_custom_block_types]*: Provides several preconfigured custom block types
- **UBC Date Formats** *[ubc_date_formats]*: Provides a set of commonly used date formats
- **UBC Editor Config** *[ubc_editor_config]*: Provides a custom predefined wysiwyg format and settings
- **UBC Editor File Entities** *[ubc_editor_file_entities]*: Provides a method of working with Media Entities and embedding them into the wysiwyg
- **UBC Event** *[ubc_event]*: Provides the UBC Event content type and its fields, pathauto settings
- **UBC Event Views** *[ubc_event_views]*: Provides views specific to the UBC Event content type
- **UBC General Shared Config** *[ubc_general_shared_config]*: Provides definitions for shared taxonomies, view modes, views and blocks
- **UBC Homepage** *[ubc_homepage]*: Provides the Homepage content type and its fields, pathauto settings, and workflow settings
- **UBC Homepage Views** *[ubc_homepage_views]*: Provides views specific to the Homepage content type
- **UBC Image Styles** *[ubc_image_styles]*: Provides a common set of image styles
- **UBC Landing Page** *[ubc_landing_page]*: Provides the UBC Landing Page content type and its fields, pathauto settings
- **UBC Landing Page Views** *[ubc_landing_page_views]*: Provides views specific to the UBC Landing Page content type
- **UBC Media Entites** *[ubc_media_entities]*: Provides a series of preconfigured media entities
- **UBC Page** *[ubc_page]*: Provides the UBC Page content type and its fields, pathauto settings
- **UBC Paragraph Entities** *[ubc_paragraph_entities]*: Provides a common set of paragraph types, used in UBC Landing Pages
- **UBC Profile** *[ubc_profile]*: Provides the UBC Profile content type and its fields, pathauto settings
- **UBC Profile Views** *[ubc_profile_views]*: Provides views specific to the UBC Profile content type
- **UBC Taxonomy Terms** *[ubc_taxonomy_terms]*: Provides a set of admin and user facing taxonomies and terms.
- **UBC User Roles** *[ubc_user_roles]*: Provides a set of user roles and their associated permsissions


## Lando Quick Start

This assumes you've installed Drupal using the Standard installation profile

### Enable and set themes

```lando drush theme:enable gin && lando drush theme:enable kraken && lando drush config-set system.theme admin gin -y && lando drush config-set system.theme default kraken -y```

### Enable contrib modules

```lando drush en address, admin_toolbar_links_access_filter, admin_toolbar_tools, allowed_formats, antibot, auto_entitylabel, block_exclude_pages, chosen, config_ignore, crop, ctools, datetime_range, datetimehideseconds, devel, devel_generate, editor_advanced_link, entity_reference_revisions, field_group, file_delete, focal_point, formtips, fullcalendar_view, gin_toolbar, google_analytics, image_widget_crop, linkit, linkit_media_library, maxlength, media, media_bulk_upload, media_entity_file_replace, media_library, menu_block, metatag, optional_end_date, pathauto, paragraphs, redirect, responsive_table_filter, role_delegation, scheduler, simple_gmap, simple_sitemap, smtp, svg_image, telephone, text_summary_options, token, twig_tweak, webform, webform_ui -y```

### Enable custom modules for general settings

```lando drush en ubc_ckeditor_widgets, ubc_date_formats, ubc_editor_config, ubc_editor_config_simple, ubc_image_styles, ubc_media_entities, ubc_paragraph_entities, ubc_general_shared_config, ubc_taxonomy_terms_admin, ubc_custom_block_types -y```

### Enable custom content type modules

```lando drush en ubc_announcement, ubc_homepage, ubc_event, ubc_landing_page, ubc_page, ubc_profile, ubc_taxonomy_terms_admin, ubc_taxonomy_terms_announcement, ubc_taxonomy_terms_department, ubc_taxonomy_terms_event -y```

### Enable User Role and Views modules last, once all the pieces are in place.

```lando drush en ubc_alert ubc_announcement_views, ubc_homepage_views, ubc_event_calendar, ubc_event_views, ubc_landing_page_views, ubc_profile_views, ubc_user_roles -y```
* note that `ubc_user_roles` currently assumes you have installed all of the modules as per the code snippet. Exclude this if you've opted not to install one or more of the UBC modules, otherwise it will fail.

### POST INSTALL

#### Use devel generate to remove all page and article nodes as a safeguard

```lando drush genc --kill --types=article 0 0 && lando drush genc --kill --types=page 0 0```

#### Delete unused content types by going to:

- /admin/structure/types/manage/article/delete
- /admin/structure/types/manage/page/delete

#### Delete unused comment types if not going to be used:

- /admin/structure/comment/manage/comment/delete

#### Disable unused text formats

```lando drush config-set editor.editor.basic_html status 0 -y && lando drush config-set filter.format.basic_html status 0 -y && lando drush config-set editor.editor.full_html status 0 -y && lando drush config-set filter.format.full_html status 0 -y```

#### Uninstall some infrequently used modules (need to delete Article and Comment types first)

```lando drush pmu comment -y```
