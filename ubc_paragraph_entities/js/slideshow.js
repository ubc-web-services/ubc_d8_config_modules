/**
 * @file
 * Javascript functionality for Flexslider.
 */

(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.flexslider = {
    attach: function (context) {
      $('.flexslider').flexslider({
        animation: "slide"
      });
    }
  };

})(jQuery, Drupal);
