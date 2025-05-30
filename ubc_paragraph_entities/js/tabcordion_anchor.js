(function (Drupal, once) {
  'use strict';

  function findTabByContentId(hash) {
    if (!hash) return null;
    const targetId = hash.replace('#', '');
    const targetElement = document.getElementById(targetId);
    if (!targetElement) return null;
    const tabPane = targetElement.closest('.tab-pane');
    if (!tabPane || !tabPane.id) return null;
    return tabPane.id.split('-')[1]; // Return only the pane number
  }

  function scrollToAnchor(hash) {
    if (!hash) return;
    const anchor = document.getElementById(hash.replace('#', ''));
    if (anchor) {
      setTimeout(() => {
        anchor.scrollIntoView({ behavior: 'smooth' });
      }, 200);
    }
  }

  function activateTabFromAnchor(hash) {
    if (!hash) return;
  
    const paneNumber = findTabByContentId(hash);
    if (!paneNumber) return;
  
    const isMobile = window.innerWidth < 980;
    const cleanedHash = hash.replace('#', '');

    function triggerClick(element) {
      if (element) {
        element.click();
      }
    }

    if (isMobile) {
      const mobileTabButton = document.querySelector(`[data-bs-target="#collapse-${paneNumber}"]`);
      const targetContent = document.getElementById(`collapse-${paneNumber}`);

      if (!mobileTabButton || !targetContent) return;

      // If the target tab is already open, do nothing
      if (targetContent.classList.contains('show')) return;

      // Close all other open tabs before opening the new one
      document.querySelectorAll('.tabcordion__heading:not(.collapsed)').forEach((heading) => {
        heading.classList.add('collapsed');
        heading.setAttribute('aria-expanded', 'false');
      });

      document.querySelectorAll('.tabcordion__content.show').forEach((content) => {
        content.classList.remove('show');
      });

      triggerClick(mobileTabButton);
    } else {
      const tabButton = document.getElementById(`tab-${paneNumber}`);
      triggerClick(tabButton);
      scrollToAnchor(cleanedHash);
    }
  }

  Drupal.behaviors.tabcordionAnchor = {
    attach(context) {
      // Page load with hash
      once('tabcordionAnchorInit', 'html', context).forEach(() => {
        if (window.location.hash) {
          activateTabFromAnchor(window.location.hash);
        }
      });

      // Anchor link clicks
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