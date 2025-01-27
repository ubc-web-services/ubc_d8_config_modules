/*
 * File: tabcordion_anchor
 *
 * Desc: Open appropriate tab when anchor link is clicked.
 *
 */
(function (Drupal, $) {
  Drupal.behaviors.tabCordionBehavior = {
    attach(context, settings) {
      function findTabByContentId(hash) {
        if (!hash) return null;
      
        const targetId = hash.replace("#", "");
        const targetElement = document.getElementById(targetId);
        if (!targetElement) return null;
        
        const tabPane = targetElement.closest(".tab-pane");
        if (!tabPane || !tabPane.id) return null;
  
        const paneNumber = tabPane.id.split("-")[1];
      
        return paneNumber;
      }
    
      function activateTabFromAnchor(hash) {
        if (!hash) return;
      
        const paneNumber = findTabByContentId(hash);
        if (!paneNumber) return;
        const tabButton = document.getElementById(`tab-${paneNumber}`);
       
        if (tabButton) {
          tabButton.click();
      
          // Scroll to the anchor inside the tab content
          const anchorId = hash.replace("#", "");
          const anchor = document.getElementById(anchorId);
          if (anchor) {
            setTimeout(() => {
              anchor.scrollIntoView({ behavior: "smooth" });
            }, 200);
          }
        }
      }  
    
      // Activate tab on page load if linked from other pages
      activateTabFromAnchor(window.location.hash);
      
      // For same page anchors
      document.querySelectorAll('a[href^="#"]').forEach((anchorLink) => {
        anchorLink.addEventListener("click", function (event) {
          const hash = anchorLink.getAttribute("href");
          if (hash) {
            event.preventDefault(); 
            window.location.hash = hash;
            activateTabFromAnchor(hash);
          }
        });
      });
    }
  };
})(Drupal);