/**
 * Smooth Scroll JS
 */

function init() {
  if (typeof SmoothScroller_Settings !== "undefined") {
    var smooth =
        SmoothScroller_Settings.smoothness !== ""
          ? SmoothScroller_Settings.smoothness
          : 12,
      trigger = SmoothScroller_Settings.selector,
      newSmooth = smooth / 8; // previous value converted to new value for GSAP smooth scrolling
  } else {
    var newSmooth = 1.5,
      trigger = jQuery(document).find(".bdt-sticky").length
        ? ".bdt-sticky"
        : "";
  }

  // create the smooth scroller FIRST!
  ScrollSmoother.create({
    smooth: newSmooth,
    effects: true,
    normalizeScroll: true,
  });

  gsap.to("#smooth-content", {
    willChange: "transform",
  });

  
  // then create the GSAP scroll trigger pin element
  if (typeof trigger !== "undefined" && trigger !== "") {
    const groups = document.querySelectorAll(trigger);
    groups.forEach((group) => {
      gsap.to(group, {
        scrollTrigger: {
          trigger: group,
          endTrigger: "body",
          pin: true,
          start: "top top",
          end: "bottom bottom",
          pinSpacing: false,
        },
        zIndex: 999,
        position: "relative",
      });
    });
  }
}

window.addEventListener("DOMContentLoaded", () => {
  init();
});
