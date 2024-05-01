document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll(".section");
    
    window.addEventListener("scroll", function() {
      let current = "";
      sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop - sectionHeight / 3) {
          current = section.getAttribute("div");
        }
      });
      document.body.setAttribute("data-current", current);
    });
  });
  