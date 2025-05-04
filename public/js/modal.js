import { fetchContent, toggleShow } from "./misc.js";

/**
 *  Modal
 * Use [data-url] and [data-content] to pass data
*/
const modalControl = {
    get modal() {return document.querySelector('#data-modal');},
    get modalBody() {return this.modal.querySelector('.modal-body');},
    focusElement: [],
    keydownListener: null,

    // [✓] Get the modal content
    async loadModalContent(url) {
        const content = await fetchContent(url);
        if (content !== null) {
            this.open(content);
        }
    },
    // [✓] Show modal
    open(content = '') {
        this.modalBody.innerHTML = content;
        toggleShow(this.modal, true);
        this.trapFocus();

        this.boundCloseOnClick = this.closeOnClick.bind(this);
        this.modal.addEventListener('click', this.boundCloseOnClick);
        this.keydownListener = this.handleKeyDown.bind(this);
        document.addEventListener('keydown', this.keydownListener);
    },
    // [✓] Close modal
    close() {
        toggleShow(this.modal, false);
        this.modalBody.innerHTML = '';

        if (this.keydownListener) {
            document.removeEventListener('keydown', this.keydownListener);
            this.keydownListener = null;
        }

        this.modal.removeEventListener('click', this.boundCloseOnClick);
        this.boundCloseOnClick = null;
    },
    // [✓] Close by clicking outside the modal
    closeOnClick(event) {
        if (event.target === event.currentTarget) {
            this.close();
        }
    },
    // [✓] Trapping tab focus inside modal
    trapFocus() {
        this.focusElement  = this.modal.querySelectorAll('a, button, input, textarea, select');
        if (this.focusElement.length === 0) return;

        this.focusElement[0].focus();
        // document.addEventListener('keydown', this.handleKeyDown.bind(this));
    },
    // [✓] Handle keyboard events, tabbing prevention
    handleKeyDown(event) {
        if (this.focusElement.length === 0) return;

        let firstElement = this.focusElement[0];
        let lastElement = this.focusElement[this.focusElement.length-1];

        if (event.key == 'Tab') {
            if (event.shiftKey && document.activeElement === firstElement) {
                event.preventDefault();
                lastElement.focus();
            } else if (!event.shiftKey && document.activeElement === lastElement) {
                event.preventDefault();
                firstElement.focus();
            }
        } else if (event.key == 'Escape') {
            this.close();
        }
    }
};

export default modalControl;
