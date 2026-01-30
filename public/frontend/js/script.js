(function($) {

  "use strict";

  // Mobile Search Toggle
  var initMobileSearch = function() {
    const mobileSearchToggle = document.getElementById('mobileSearchToggle');
    const mobileSearchBar = document.getElementById('mobileSearchBar');

    if (mobileSearchToggle && mobileSearchBar) {
      mobileSearchToggle.addEventListener('click', function(e) {
        e.preventDefault();
        if (mobileSearchBar.style.display === 'none' || mobileSearchBar.style.display === '') {
          mobileSearchBar.style.display = 'block';
          setTimeout(() => {
            mobileSearchBar.querySelector('input').focus();
          }, 100);
        } else {
          mobileSearchBar.style.display = 'none';
        }
      });

      // Close mobile search when clicking outside
      document.addEventListener('click', function(e) {
        if (!mobileSearchBar.contains(e.target) && !mobileSearchToggle.contains(e.target)) {
          mobileSearchBar.style.display = 'none';
        }
      });
    }
  };

  // Cart Badge Update
  var initCartBadge = function() {
    function updateCartBadge() {
      const cartCount = window.cartCount || 0;
      const badges = document.querySelectorAll('.cart-count-badge');
      badges.forEach(badge => {
        badge.textContent = cartCount;
        if (cartCount > 0) {
          badge.style.display = 'flex';
        } else {
          badge.style.display = 'none';
        }
      });
    }

    // Initial update
    updateCartBadge();

    // Listen for cart updates (you'll need to trigger this when cart changes)
    $(document).on('cartUpdated', function() {
      updateCartBadge();
    });
  };

  // User Dropdown Hover for Desktop
  var initUserDropdown = function() {
    if (window.innerWidth > 768) {
      $('.user-dropdown .dropdown').hover(
        function() {
          $(this).addClass('show');
          $(this).find('.dropdown-menu').addClass('show');
        },
        function() {
          $(this).removeClass('show');
          $(this).find('.dropdown-menu').removeClass('show');
        }
      );
    }
  };

  var initPreloader = function() {
    $(document).ready(function($) {
    var Body = $('body');
        Body.addClass('preloader-site');
    });
    $(window).load(function() {
        $('.preloader-wrapper').fadeOut();
        $('body').removeClass('preloader-site');
    });
  }

  // init Chocolat light box
	var initChocolat = function() {
		Chocolat(document.querySelectorAll('.image-link'), {
		  imageSize: 'contain',
		  loop: true,
		})
	}

  var initSwiper = function() {

    var swiper = new Swiper(".main-swiper", {
      speed: 500,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    var category_swiper = new Swiper(".category-carousel", {
      slidesPerView: 8,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".category-carousel-next",
        prevEl: ".category-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 5,
        },
        1500: {
          slidesPerView: 8,
        },
      }
    });

    $(".products-carousel").each(function(){
      var $el_id = $(this).attr('id');

      var products_swiper = new Swiper("#"+$el_id+" .swiper", {
        slidesPerView: 5,
        spaceBetween: 30,
        speed: 500,
        navigation: {
          nextEl: "#"+$el_id+" .products-carousel-next",
          prevEl: "#"+$el_id+" .products-carousel-prev",
        },
        breakpoints: {
          0: {
            slidesPerView: 1,
          },
          768: {
            slidesPerView: 3,
          },
          991: {
            slidesPerView: 4,
          },
          1500: {
            slidesPerView: 5,
          },
        }
      });

    });


    // product single page
    var thumb_slider = new Swiper(".product-thumbnail-slider", {
      slidesPerView: 5,
      spaceBetween: 20,
      // autoplay: true,
      direction: "vertical",
      breakpoints: {
        0: {
          direction: "horizontal"
        },
        992: {
          direction: "vertical"
        },
      },
    });

    var large_slider = new Swiper(".product-large-slider", {
      slidesPerView: 1,
      // autoplay: true,
      spaceBetween: 0,
      effect: 'fade',
      thumbs: {
        swiper: thumb_slider,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  }

  // Update current year in footer
var initFooterYear = function() {
    const currentYear = new Date().getFullYear();
    const yearElement = document.getElementById('currentYear');
    if (yearElement) {
        yearElement.textContent = currentYear;
    }
};

// Newsletter Form Submission
var initNewsletterForm = function() {
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            const consent = this.querySelector('#newsletterConsent').checked;

            if (!consent) {
                alert('Please agree to receive marketing emails');
                return;
            }

            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'alert alert-success mt-3';
            successMsg.innerHTML = '<i class="fas fa-check-circle me-2"></i> Thank you for subscribing!';
            this.appendChild(successMsg);

            // Clear input
            this.querySelector('input[type="email"]').value = '';

            // Remove message after 5 seconds
            setTimeout(() => {
                successMsg.remove();
            }, 5000);
        });
    }
};

// Initialize in document ready
$(document).ready(function() {
    initFooterYear();
    initNewsletterForm();
});

// Enhanced Preloader Animation
var initOrganicPreloader = function() {
    const preloader = document.querySelector('.preloader-wrapper');
    const progressFill = document.querySelector('.progress-fill');
    const progressPercent = document.querySelector('.progress-percent');
    const progressStatus = document.querySelector('.progress-status');

    if (!preloader) return;

    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 10;
        if (progress > 100) progress = 100;

        if (progressFill) progressFill.style.width = progress + '%';
        if (progressPercent) progressPercent.textContent = Math.floor(progress) + '%';

        // Update status messages
        if (progressStatus) {
            if (progress < 30) {
                progressStatus.textContent = 'Loading organic products...';
            } else if (progress < 60) {
                progressStatus.textContent = 'Preparing fresh content...';
            } else if (progress < 90) {
                progressStatus.textContent = 'Almost ready...';
            } else {
                progressStatus.textContent = 'Welcome to Organic Store!';
            }
        }

        if (progress >= 100) {
            clearInterval(interval);

            // Add completion animation
            if (progressFill) {
                progressFill.style.background = 'linear-gradient(90deg, #4CAF50, #8BC34A)';
            }

            // Hide preloader with delay
            setTimeout(() => {
                preloader.classList.add('hidden');

                // Remove from DOM after animation
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 500);
        }
    }, 100);

    // Force complete after 3 seconds (fallback)
    setTimeout(() => {
        clearInterval(interval);
        if (progressFill) progressFill.style.width = '100%';
        if (progressPercent) progressPercent.textContent = '100%';
        if (progressStatus) progressStatus.textContent = 'Ready!';

        setTimeout(() => {
            preloader.classList.add('hidden');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }, 300);
    }, 3000);
};

// Replace existing preloader init in document ready
$(document).ready(function() {
    // Remove old preloader init and replace with:
    initOrganicPreloader();

    // ... rest of your existing code ...
});


// Best Selling Products Interactive Features
document.addEventListener('DOMContentLoaded', function() {
    // Add to Cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const quantity = 1; // Default quantity

            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;

            // Add to cart API call
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showToast('Product added to cart successfully!', 'success');

                    // Update cart count
                    updateCartCount(data.cart_count);

                    // Reset button
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 1000);
                } else {
                    showToast(data.message || 'Failed to add product to cart', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    });

    // Add to Wishlist functionality
    document.querySelectorAll('.add-to-wishlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');

            // Toggle heart icon
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                showToast('Added to wishlist!', 'success');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                showToast('Removed from wishlist!', 'info');
            }

            // API call for wishlist
            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId })
            });
        });
    });

    // Quantity Controls
    document.querySelectorAll('.btn-minus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('.quantity-input');
            if (parseInt(input.value) > parseInt(input.min)) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });

    document.querySelectorAll('.btn-plus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('.quantity-input');
            if (parseInt(input.value) < parseInt(input.max)) {
                input.value = parseInt(input.value) + 1;
            }
        });
    });

    // Buy Now button
    document.querySelectorAll('.btn-buy-now').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantityInput = this.closest('.quantity-section').querySelector('.quantity-input');
            const quantity = quantityInput.value;

            // Direct checkout functionality
            window.location.href = `/checkout/buy-now?product_id=${productId}&quantity=${quantity}`;
        });
    });

    // Show quantity section on hover (optional)
    document.querySelectorAll('.product-card-hover').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const quantitySection = this.querySelector('.quantity-section');
            if (quantitySection) {
                quantitySection.style.display = 'block';
            }
        });

        card.addEventListener('mouseleave', function() {
            const quantitySection = this.querySelector('.quantity-section');
            if (quantitySection) {
                quantitySection.style.display = 'none';
            }
        });
    });
});

// Helper Functions
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    document.body.appendChild(toast);

    // Show toast
    const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
    bsToast.show();

    // Remove after hide
    toast.addEventListener('hidden.bs.toast', function() {
        document.body.removeChild(toast);
    });
}

function updateCartCount(count) {
    const cartBadge = document.querySelector('.cart-count-badge');
    if (cartBadge) {
        cartBadge.textContent = count;
        cartBadge.classList.remove('d-none');
    }
}

  // input spinner
  var initProductQty = function(){

    $('.product-qty').each(function(){

      var $el_product = $(this);
      var quantity = 0;

      $el_product.find('.quantity-right-plus').click(function(e){
        e.preventDefault();
        quantity = parseInt($el_product.find('#quantity').val());
        $el_product.find('#quantity').val(quantity + 1);
      });

      $el_product.find('.quantity-left-minus').click(function(e){
        e.preventDefault();
        quantity = parseInt($el_product.find('#quantity').val());
        if(quantity>0){
          $el_product.find('#quantity').val(quantity - 1);
        }
      });

    });

  }

  // init jarallax parallax
  var initJarallax = function() {
    jarallax(document.querySelectorAll(".jarallax"));

    jarallax(document.querySelectorAll(".jarallax-keep-img"), {
      keepImg: true,
    });
  }

  // document ready
  $(document).ready(function() {

    initPreloader();
    initSwiper();
    initProductQty();
    initJarallax();
    initChocolat();
    initMobileSearch();
    initCartBadge();
    initUserDropdown();

  }); // End of a document

  // Window resize handler
  $(window).on('resize', function() {
    initUserDropdown();
  });

})(jQuery);
