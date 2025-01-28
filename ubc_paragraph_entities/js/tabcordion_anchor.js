(function (Drupal, once) {
  'use strict';

  function findTabByContentId(hash) {
    if (!hash) return null;
    const targetId = hash.replace('#', '');
    const targetElement = document.getElementById(targetId);
    if (!targetElement) return null;
    const tabPane = targetElement.closest('.tab-pane');
    if (!tabPane || !tabPane.id) return null;
    const paneNumber = tabPane.id.split('-')[1];
    return paneNumber;
  }

  function activateTabFromAnchor(hash) {
    if (!hash) return;
    const paneNumber = findTabByContentId(hash);
    if (!paneNumber) return;
    const tabButton = document.getElementById(`tab-${paneNumber}`);
    if (tabButton) {
      tabButton.click();
      const anchorId = hash.replace('#', '');
      const anchor = document.getElementById(anchorId);
      if (anchor) {
        setTimeout(() => {
          anchor.scrollIntoView({ behavior: 'smooth' });
        }, 200);
      }
    }
  }

  Drupal.behaviors.tabcordionAnchor = {
    attach(context) {
      // Initial load.
      once('tabcordionAnchorInit', 'html', context).forEach(() => {
        activateTabFromAnchor(window.location.hash);
      });
      // Anchor link clicked.
      once('tabcordionAnchorLink', 'a[href^="#"]', context).forEach((anchorLink) => {
        anchorLink.addEventListener('click', (event) => {
          const hash = anchorLink.getAttribute('href');
          if (hash) {
            event.preventDefault();
            window.location.hash = hash;
            activateTabFromAnchor(hash);
          }
        });
      });
    },
  };
})(Drupal, once);