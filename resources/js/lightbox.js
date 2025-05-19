import modalControl from './modal.js';

export function initGalleryLightbox() {
    // compile .gallery-lightbox as array to get their array[index]
    const galleryItems = Array.from(document.querySelectorAll('.gallery-lightbox'));
    if (!galleryItems.length) return;

    // each index, when clicked, triggers openLightbox to display the lightbox modal containing the target index from galleryItems array
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            openLightbox(index);
        });
    });

    // index ditekan -> di-render ke dalam modal-body dengan wrap .lighbox-content, makanya href di a.gallery-lightbox penting
    function openLightbox(i) {
        let currentIndex = i;

        const render = () => {
            const imgSrc = galleryItems[currentIndex].getAttribute('href');
            const lightboxHTML = `
                <div class="lightbox-content">
                    <img src="${imgSrc}" class="lightbox-img" />
                    <button class="lightbox-prev">&#10094;</button>
                    <button class="lightbox-next">&#10095;</button>
                </div>
            `;
            modalControl.open(lightboxHTML);

            requestAnimationFrame(() => {
                const prevBtn = document.querySelector('.lightbox-prev');
                const nextBtn = document.querySelector('.lightbox-next');

                prevBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
                    render();
                });
                nextBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % galleryItems.length;
                    render();
                });
            });
        };
        render();
    }
}
