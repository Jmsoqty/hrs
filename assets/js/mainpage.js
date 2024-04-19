
    $(document).ready(function() {
        // Get the current page URL
        var currentUrl = window.location.href;

        // Loop through each sidebar link
        $('.sidebar a').each(function() {
            // Get the href attribute of the sidebar link
            var linkUrl = $(this).attr('href');

            // Check if the current page URL contains the sidebar link URL
            if (currentUrl.includes(linkUrl)) {
                // Add the 'active' class to the parent li element
                $(this).closest('li').addClass('active');
            }
        });
    });
