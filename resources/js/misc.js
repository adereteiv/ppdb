// [✓] Fetch
export async function fetchContent(url, targetSelector = null) {
    try {
        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json, text/html",
            }
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({
                message: "Terjadi kesalahan.",
                type: "error"
            }));
            throw errorData;
        }

        const contentType = response.headers.get('content-type');

        if (contentType && contentType.includes('application/json')){
            return await response.json();;
        }

        const html = await response.text();
        if (targetSelector) {
            const targetElement = document.querySelector(targetSelector);
            if (targetElement) {
                targetElement.innerHTML = html;
            } else {
                console.error(`Target element '${targetSelector}' not found.`);
            }
        }
        return html;
    } catch (error) {
        console.error("Error fetching content:", error);
        if (error.retryAfter) {
            // Pass 'error' as mode (string), plus retryAfter seconds
            showAlert(error.message, 'error', 10000, 1000, error.retryAfter);
        } else {
            showAlert(error.message || "Terjadi kesalahan.", `alert ${error.type || 'error'}`);
        }
        return null;
    }
}
// [✓] Alert
export function alert(selector='.alert', delay=10000, fade=2000 ) {
    const alert = document.querySelector(selector);
    if (!alert) return;

    requestAnimationFrame(() => {
        alert.style.opacity = '1';
        alert.style.top = '4rem';
        alert.style.transition = 'opacity 0.5s ease, top 0.5s ease';
    });

    setTimeout(() => {
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), fade);
    }, delay);
}
// [] JS Alert
let currentAlertTimeout = null;
let currentFadeTimeout = null;

export function showAlert(message, mode = 'error', delay = 10000, fade = 1000, expiry = null) {
    // Remove any existing alert
    const existing = document.querySelector('.reminder.alert, .reminder.flash');
    if (existing) {
        existing.remove();
        clearTimeout(currentAlertTimeout);
        clearTimeout(currentFadeTimeout);
    }

    // Create the alert wrapper div
    const alertDiv = document.createElement('div');
    alertDiv.setAttribute('x-data', '{ show: true }');
    alertDiv.setAttribute('x-show', 'show');
    alertDiv.className = `reminder flex flex-nowrap teks-putih justify-between margin-vertical`;

    const countdown = document.createElement('div');
    countdown.setAttribute('id', 'countdown');

    // Add mode-specific classes (matches x-flash-message logic)
    const modeClasses = {
        'error': ['alert', 'must', 'bg-redpowder'],
        'warn': ['alert', 'warn', 'bg-yellowpowder'],
        'success': ['alert', 'mild', 'bg-green'],
    };
    const iconMap = {
        'error': 'bi-x-circle',
        'warn': 'bi-exclamation-circle',
        'success': 'bi-check2-circle',
    };
    const classes = modeClasses[mode] || ['alert', 'bg-red'];
    alertDiv.classList.add(...classes);
    const iconClass = iconMap[mode] || 'bi-info-circle';

    let contentHTML = `
        <div class="flex-1 flex flex-nowrap">
            <span class="reminder-icon">
                <i class="bi ${iconClass}"></i>
            </span>
            <span>
                ${message}
                ${expiry !== null && !isNaN(expiry) ? `<b><span id="countdown">--:--</span></b>.` : ''}
            </span>
        </div>
    `;

    // Close button
    contentHTML += `
        <div>
            <button class="tombol-none" @click="show = false">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>`;

    alertDiv.innerHTML = contentHTML;
    document.body.appendChild(alertDiv);

    // Animate alert in
    requestAnimationFrame(() => {
        alertDiv.style.opacity = '1';
        alertDiv.style.top = '4rem';
        alertDiv.style.transition = 'opacity 0.5s ease, top 0.5s ease';
    });

    // Start countdown if expiry present
    if (expiry !== null && !isNaN(expiry)) {
        const countdownElement = alertDiv.querySelector('#countdown');
        const endTime = Date.now() + expiry * 1000;

        function updateTimer() {
            const now = Date.now();
            const diff = Math.max(0, Math.floor((endTime - now) / 1000));

            const minutes = Math.floor(diff / 60);
            const secs = diff % 60;
            countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

            if (diff > 0) {
                setTimeout(updateTimer, 1000);
            }
        }
        updateTimer();
    }

    // Set fade-out timers
    currentAlertTimeout = setTimeout(() => {
        alertDiv.style.opacity = '0';
        currentFadeTimeout = setTimeout(() => {
            alertDiv.remove();
            currentAlertTimeout = null;
            currentFadeTimeout = null;
        }, fade);
    }, delay);
}
/* [✓] Copy ID to Clipboard
<div>
    <button class="copyButton" data-target=".copyGroup1" data-tooltip="#tooltip1" data-label="Grup 1: ">Copy</button>
    <p class="copyGroup1">X</p>
    <p class="copyGroup1">Y</p>
    <p class="copyGroup1">Z</p>
    <span id="tooltip1">Salin</span>
</div>
*/
export function copyToClipboard() {
    const copyButtons = document.querySelectorAll(".copyButton");

    copyButtons.forEach((button) => {
        const targetSelector = button.dataset.target; // e.g., ".copyTargetGroup1"
        const tooltipSelector = button.dataset.tooltip; // e.g., "#tooltip1"
        const label = button.dataset.label || "";

        const targetElements = document.querySelectorAll(targetSelector);
        const tooltiptext = document.querySelector(tooltipSelector);

        if (!targetElements.length || !tooltiptext) return;

        button.addEventListener("click", () => {
            const copiedText = Array.from(targetElements)
                .map(el => el.textContent.trim())
                .join(", ");

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(copiedText)
                    .then(() => {
                        tooltiptext.textContent = `Berhasil menyalin ${label}${copiedText}!`;
                    })
                    .catch(() => {
                        tooltiptext.textContent = `Gagal menyalin!`;
                    });
            } else {
                const tempInput = document.createElement("textarea");
                tempInput.value = copiedText;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                tooltiptext.textContent = `Berhasil menyalin ${label}${copiedText}!`;
            }
        });

        button.addEventListener("mouseleave", () => {
            tooltiptext.textContent = "Salin";
        });
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

        if (!tooltipText) return;

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
/*
    Penggunaan (di dalam satu scope)
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
    if (!element) return;
    element.classList.remove(open ? 'close' : 'open');
    element.classList.add(open ? 'open' : 'close');
}
export function toggleStaticOpen() {
    document.querySelectorAll('[data-toggle-target]').forEach(item => {
        const group = item.getAttribute('data-toggle-group');
        const targetSelector = item.getAttribute('data-toggle-target');
        const mode = item.getAttribute('data-toggle-mode');

        if (!targetSelector) return;
        const target = document.querySelector(targetSelector);
        if (!target) {return console.warn("Target element not found.");};

        if (!target.classList.contains('open') && !target.classList.contains('close')) {
            target.classList.add('close');
        }

        if (item._toggleHandler) {
            item.removeEventListener('click', item._toggleHandler);
        }

        item._toggleHandler = (e) => {
            e.stopPropagation();

            if (group) {
                document.querySelectorAll(`[data-toggle-group="${group}"]`).forEach(el => {
                    const elTargetSelector = el.getAttribute('data-toggle-target');
                    const elTarget = document.querySelector(elTargetSelector);
                    if (el !== item) {
                        el.classList.remove('active');
                        if (elTarget) toggleShow(elTarget, false);
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

        // if (!target.dataset.persistent && !target._clickOutsideHandler) {
        //     target._clickOutsideHandler = (e) => {
        //         if (target.classList.contains('open') && !target.contains(e.target) && !item.contains(e.target)) {
        //             toggleShow(target, false);
        //         }
        //     };
        //     document.addEventListener('click', target._clickOutsideHandler);

        //     target._stopPropHandler = (e) => e.stopPropagation();
        //     target.addEventListener('click', target._stopPropHandler);
        // }
    });
}
