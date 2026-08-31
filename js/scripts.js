/*!
* Start Bootstrap - Freelancer v7.0.7 (https://startbootstrap.com/theme/freelancer)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-freelancer/blob/master/LICENSE)
*/
//
// Scripts
// 
window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function (navbarId) {
        const navbarCollapsible = document.body.querySelector(navbarId);
        if (!navbarCollapsible) {
            return;
        }

        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Shrink the main navbar
    navbarShrink('#mainNav');
    // Shrink the shop navbar
    // navbarShrink('#shopNav');

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', () => {
        navbarShrink('#mainNav');
        //navbarShrink('#shopNav');
    });

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    }

    // Activate Bootstrap scrollspy on the shop nav element
    const shopNav = document.body.querySelector('#shopNav');
    if (shopNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#shopNav',
            rootMargin: '0px 0px -40%',
        });
    }

    // Collapse responsive navbar when toggler is visible for main nav
    const navbarTogglerMain = document.body.querySelector('.navbar-toggler');
    const responsiveNavItemsMain = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItemsMain.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarTogglerMain).display !== 'none') {
                navbarTogglerMain.click();
            }
        });
    });

    // Collapse responsive navbar when toggler is visible for shop nav
    const navbarTogglerShop = document.body.querySelector('#shopNav .navbar-toggler');
    const responsiveNavItemsShop = [].slice.call(
        document.querySelectorAll('#shopNavbarResponsive .nav-link')
    );
    responsiveNavItemsShop.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarTogglerShop).display !== 'none') {
                navbarTogglerShop.click();
            }
        });
    });

    // Smooth scrolling for WordPress anchor links
    document.querySelectorAll('a[href*="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            // Check if the clicked link is a hash link and has a valid target
            const targetId = this.getAttribute('href').split('#')[1];
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                e.preventDefault();

                // Scroll to the target with offset and smooth behavior
                window.scrollTo({
                    top: targetElement.getBoundingClientRect().top + window.scrollY - 70, // Adjust the offset based on your navbar height
                    behavior: 'smooth'
                });
            }
        });
    });

    // Function to set the container type based on the customizer setting
    function setContainerType() {
        const containers = document.querySelectorAll('.container, .container-fluid');

        containers.forEach(container => {
            if (bhSolutionsSettings.containerType === 'container-fluid') {
                // Full-width setting
                container.classList.remove('container');
                container.classList.add('container-fluid');
            } else if (bhSolutionsSettings.containerType === 'container') {
                // Fixed-width setting
                container.classList.remove('container-fluid');
                container.classList.add('container');
            }
        });
    }

    // Function to adjust container class based on screen size (only if fixed-width is selected)
    function adjustContainerClass() {
        const containers = document.querySelectorAll('.container, .container-fluid');

        containers.forEach(container => {
            if (window.innerWidth < 992) {
                container.classList.remove('container');
                container.classList.add('container-fluid');
            } else {
                container.classList.remove('container-fluid');
                container.classList.add('container');
            }
        });
    }

    // Call setContainerType on page load to apply the customizer's container type setting
    setContainerType();

    // If the user has selected 'fixed-width', run the adjustContainerClass function
    if (bhSolutionsSettings.containerType === 'container') {
        adjustContainerClass();

        // Adjust container class on window resize
        window.addEventListener('resize', adjustContainerClass);
    }

        // Spacer adjustment function
        function adjustSpacerHeight() {
            const navbar = document.getElementById('mainNav');
            const spacer = document.getElementById('navbarSpacer');
    
            if (navbar && spacer) {
                spacer.style.height = navbar.offsetHeight + 'px';
            }
        }
    
        // Adjust spacer height on page load and window resize
        adjustSpacerHeight();
        window.addEventListener('resize', adjustSpacerHeight);
    
});
