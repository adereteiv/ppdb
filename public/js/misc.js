// [✓] Fetch
export async function fetchContent(url, targetSelector = null) {
    try {
        const response = await fetch(url);
		if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const content = await response.text();
        if (targetSelector) {
            const targetElement = document.querySelector(targetSelector);
            if (targetElement) {
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
        if (alert) {
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

    if (!copyButton || !userIdElement || !tooltiptext) return;
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
