// [✓] Fetch
export async function fetchContent(url, targetSelector = null) {
    try {
        const response = await fetch(url);
		if(!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const content = await response.text();
        if(targetSelector) {
            const targetElement = document.querySelector(targetSelector);
            if(targetElement) {
                targetElement.innerHTML = content;
            } else {
                console.error(`Target element '${targetSelector}' not found.`);
            }
        }

        return content;
    } catch (error) {
        console.error("Error fetching content:", error);
        return null;
    }
}

// [✓] Alert
export function alert(selector='.alert', delay=10000, fade=2000 ) {
    setTimeout(() => {
        let alert = document.querySelector(selector);
        if(alert) {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), fade);
        }
    }, delay);
}

// [✓] Copy ID to Clipboard
export function copyToClipboard() {
    const copyButton = document.getElementById("copyButton");
    const userIdElement = document.getElementById("userId");
    const tooltiptext = document.getElementById("tooltiptext");

    if(!copyButton || !userIdElement || !tooltiptext) return;
    const copiedText = userIdElement.textContent.trim();

    copyButton.addEventListener("click", () => {
        if(navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(copiedText)
                .then(() => { tooltiptext.textContent = `ID ${copiedText} disalin!`; })
                .catch(() => { tooltiptext.textContent = `Gagal menyalin!`; });

        } else { //fallback http
            const tempInput = document.createElement("textarea");
            tempInput.value = copiedText;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            tooltiptext.textContent = `ID ${copiedText} disalin!`;
        }
    });

    copyButton.addEventListener("mouseleave", () => {
        tooltiptext.textContent = "Salin";
    });
}

// [✓] Tooltip
/* Penggunaan
    <element class="tooltip" tooltip="left">
        <span class="tooltiptext">Buat</span>
    </element>
*/
export function tooltip() {
    const tooltipElements = document.querySelectorAll(".tooltip");

    tooltipElements.forEach(element => {
        const tooltipText = element.querySelector(".tooltiptext");

        if(!tooltipText) return;

        element.addEventListener("mouseenter", () => {
            const rect = element.getBoundingClientRect();
            const placement = element.getAttribute("tooltip") || "top";

            switch(placement) {
                case "bottom":
                    tooltipText.style.left = `${rect.left + window.scrollX + rect.width / 2 - tooltipText.offsetWidth / 2}px`;
                    tooltipText.style.top = `${rect.bottom + window.scrollY + 5}px`;
                    break;

                case "left":
                    tooltipText.style.left = `${rect.left + window.scrollX - tooltipText.offsetWidth - 5}px`;
                    tooltipText.style.top = `${rect.top + window.scrollY + rect.height / 2 - tooltipText.offsetHeight / 2}px`;
                    break;

                case "right":
                    tooltipText.style.left = `${rect.right + window.scrollX + 5}px`;
                    tooltipText.style.top = `${rect.top + window.scrollY + rect.height / 2 - tooltipText.offsetHeight / 2}px`;
                    break;

                default:
                    tooltipText.style.left = `${rect.left + window.scrollX + rect.width / 2 - tooltipText.offsetWidth / 2}px`;
                    tooltipText.style.top = `${rect.top + window.scrollY - tooltipText.offsetHeight - 5}px`;
            }

            // tooltipText.classList.add("tooltip-visible");
        });
        // element.addEventListener("mouseleave", () => {
        //     tooltipText.classList.remove("tooltip-visible");
        // });
    });
}

// [✓] Handling simple .open ⇄ .close behavior
/* Penggunaan
    <!-- Toggle (Default Behavior) -->
    <element data-toggle-target="#target"/>

    <!-- Explicit Open -->
    <element data-toggle-target="#target" data-toggle-mode="open"/>

    <!-- Explicit Close -->
    <element data-toggle-target="#target" data-toggle-mode="close"/>

    <!-- Target Element -->
    <element id="target" data-persistent/>
*/
export function toggleShow(element, open = true) {
    if(!element) return;
    element.classList.remove(open ? 'close' : 'open');
    element.classList.add(open ? 'open' : 'close');
}
export function toggleStaticOpen() {
    document.querySelectorAll('[data-toggle-target]').forEach(item => {
        const mode = item.getAttribute('data-toggle-mode');
        const targetSelector = item.getAttribute('data-toggle-target');
        const group = item.getAttribute('data-toggle-group');

        if(!targetSelector) return;
        const target = document.querySelector(targetSelector);
        if(!target) {return console.warn("Target element not found.");};

        if(!target.classList.contains('open') && !target.classList.contains('close')) {
            target.classList.add('close');
        }

        if(item._toggleHandler) {
            item.removeEventListener('click', item._toggleHandler);
        }

        item._toggleHandler = (e) => {
            e.stopPropagation();

            if(group) {
                document.querySelectorAll(`[data-toggle-group="${group}"]`).forEach(shell => {
                    const shellTargetSelector = shell.getAttribute('data-toggle-target');
                    const shellTarget = document.querySelector(shellTargetSelector);
                    if(shell !== item) {
                        shell.classList.remove('active');
                        if (shellTarget) toggleShow(shellTarget, false);
                    }
                });
            }

            switch (mode) {
                case 'open':
                    toggleShow(target, true);
                    item.classList.add('active')
                    break;
                case 'close':
                    toggleShow(target, false);
                    item.classList.remove('active')
                    break;
                default:
                    toggleShow(target, target.classList.contains('close'));
                    item.classList.toggle('active', target.classList.contains('open'))
            }
        };

        item.addEventListener('click', item._toggleHandler);

        // if(!target.dataset.persistent && !target._clickOutsideHandler) {
        //     target._clickOutsideHandler = (e) => {
        //         if(target.classList.contains('open') && !target.contains(e.target) && !item.contains(e.target)) {
        //             toggleShow(target, false);
        //         }
        //     };
        //     document.addEventListener('click', target._clickOutsideHandler);

        //     target._stopPropHandler = (e) => e.stopPropagation();
        //     target.addEventListener('click', target._stopPropHandler);
        // }
    });
}
