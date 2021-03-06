# UBC Config Modules - changes for Jan/2021

## Disable
- [x] Workflows (complicates and confuses editing experience, especially with node Revisions on)

## Remove
- [x] image_widget_crop (too situation-specific and requires too much config)
- [ ] Slideshow Paragraph (js library in use is problematic in practice, needs a rethink)

## Add
### Asset Library / Media settings
- [x] Media Bulk Upload (adds bulk upload options)
- [x] Media Entity File Replace (adds ability to replace file instead of renaming as _0)
- [x] Linkit Media Library (adds Media Library button to Link wysiwyg button popup, for inserting links to docs)

### Editing tweaks / enhancements
- [x] Focal Point (instead of Manual Crops - allows for simpler editing experience and more latitude than image_widget_crop)
- [x] Formtips (tooltips on hover / click)
- [x] Maxlength (set field input length with realtime status)
- [x] Optional End Date (allows dates to be handled easier in a single field - extends daterange)
- [x] Scheduler (provides scheduled node publication)
- [x] Text Summary Options (exposes settings to require / always show the summary field)
- [x] Editor Advanced Link (adds some additional options to Link wysiwyg button popup - used to add Target)
- [x] Editor Button Link (integrate button classes in Link wysiwyg button)
- [x] Chosen (Admin and public facing, allows selects to be searchable, themeable - does make jQuery a requirement though)

### Other
- [x] Google Tag Manager (add by default, but leave it disabled)
- [x] Redirect (missed this one)

## Needed
### Events
- [ ] recurring date function (eg, every wednesday during may at 6pm)
- [ ] ongoing flag (instead of a start-end date)
- [ ] Views to accomodate these with upcoming events
- [ ] Add to Calendar module (eg Allard) with config / options

### Custom blocks
- [ ] Twitter Stream embed
- [ ] Instagram embed

### Image gallery library and styles
- [ ] Vue, Tinyslider (Sauder)?

### WYSIWYG
- [ ] iFrame (ckeditor_iframe module is essentially abandoned. Do we roll our own?, Use Media type, other?)

### Sitewide alerts
- [x] start with Security implementation?

## Drupal 9 compatibility
### UBC Content Items
- Custom module not currently D9 compatible - 19 errors, 3 warnings
- Errors
  - [ ] Call to deprecated method entityManager()
  - [ ] Call to deprecated function format_date()
  - [ ] Call to deprecated method link()
  - [ ] Call to deprecated function drupal_set_message()
  - [ ] Call to deprecated constant REQUEST_TIME
- Warnings
  - [ ] .info version requirement
  - [ ] Class PHPUnit\Framework\TestCase not found
