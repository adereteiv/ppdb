import { fetchContent, tooltip } from "./misc.js";
import { debounce } from "./form1.js";

// Initial table state, without tableInteractions applied
let tableState = {
    page: 1,
    perPage: 10,
    search: '',
    sort: '',
    order: 'asc'
};

/** [✓] Works, if anything unexpected happens, check for route definition, most of the bugs I stub my toes on stems from that... which sucks
 * 1. Get data passed via api call, managed in route, again this is #1 bug defining factor, #2 would be the back-end
 * 2. renderTable(), populating table rows based on applied query (refer to @tableInteractions) via AJAX (refer to @fetchData)
 * 3. renderPagination(), dynamically distributes pagination links
 * 4. saveTableState(), in case admin performs tableInteractions()
 *
 * [✓] fetchData, use fetchContent()
 * [✓] renderTable
 * [✓] renderPagination
 * [✓] tableInteractions -> search, sort, per page
 * [✓] saveTableState
 * [✓] restoreTableState
 */
async function fetchData(overrideParams = {}) {
	tableState = { ...tableState, ...overrideParams };

    const query = new URLSearchParams(tableState).toString();
    const urlMapping = {
        '/admin/ppdb/aktif': '/admin/ppdb/aktif/data',
        '/admin/ppdb/arsip': '/admin/ppdb/arsip/data',
        '/admin/pengumuman': '/admin/pengumuman/data'
    };
    const base = urlMapping[window.location.pathname];
    const url = base ? `${base}?${query}` : null;

    const data = await fetchContent(url);

    try {
        if (data?.html) {
            renderTable(data.html);
            renderPagination(data.pagination);
            saveTableState();
        } else {
            console.warn("Incomplete response structure.");
        }
    } catch (error) {
        console.error("Error parsing JSON:", error);
    }
}

// renders the table based on tableInteractions and saved table state
function renderTable(html) {
	const target = document.getElementById("tableBody");
	if (!target) return;

	target.innerHTML = html;
	tooltip(); // Reinstate tooltip, karena ternyata mati

	// const activeHeader = document.querySelector(`th.sortable[data-sort="${tableState.sort}"]`);
	// if (activeHeader) {
    //     const text = activeHeader.textContent.trim().replace(/[↑↓]/g, '');
	// 	const arrow = tableState.order === "asc" ? "↑" : "↓";
	//     activeHeader.setAttribute("data-order", tableState.order);
	//     activeHeader.innerHTML = `${arrow} ${text}`;
	// }
     document.querySelectorAll("th.sortable").forEach(header => {
        const sortKey = header.getAttribute("data-sort");
        const text = header.textContent.trim().replace(/[↑↓]/g, '').trim();
        const isActive = sortKey === tableState.sort;
        const order = tableState.order;

        let arrow;
        if (isActive) {
            arrow = order === "asc"
                ? `<span style="color: inherit;">↑</span><span style="color: gray;">↓</span>`
                : `<span style="color: gray;">↑</span><span style="color: inherit;">↓</span>`;
        } else {
            arrow = `<span style="color: gray;">↑↓</span>`;
        }

        header.innerHTML = `${arrow} ${text}`;
        header.setAttribute("data-order", isActive ? order : "");
    });
}

// renders the pagination buttons
function renderPagination(paginationHtml) {
	const wrapper = document.getElementById("handlePagination");
    if (!wrapper) return;

	wrapper.innerHTML = paginationHtml;
	tooltip(); // Reinstate tooltip, karena ternyata mati

	wrapper.querySelectorAll('a.page-link[data-page]')?.forEach(link => {
		link.addEventListener('click', e => {
			e.preventDefault();
			const page = parseInt(link.dataset.page);
			if (!isNaN(page)) {
				fetchData({ page });
			}
		});
	});
}

// includes actions like search, sort, and row per page selector
function tableInteractions() {
    // Search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        const keyword = tableState.search;
        searchInput.value = keyword;
        if (keyword) {
            searchInput.focus();
        }
        searchInput.addEventListener('input', debounce(e => {
            fetchData({ page: 1, search: e.target.value });
        }, 300));
    }

    // Per page selector
    const perPageSelect = document.getElementById('perPageSelect');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', e => {
            fetchData({ page: 1, perPage: parseInt(e.target.value) });
        });
    }

    // Sorting
    document.querySelectorAll("th.sortable")?.forEach(header => {
        header.addEventListener("click", () => {
            const sort = header.getAttribute("data-sort");
            const currentOrder = header.getAttribute("data-order") || "asc";
            const newOrder = currentOrder === "asc" ? "desc" : "asc";

            document.querySelectorAll("th.sortable").forEach(h => {
                const text = h.textContent.trim().replace(/[↑↓]/g, '').trim();
                h.setAttribute("data-order", "");
                h.innerHTML = `<span style="color: gray;">↑↓</span> ${text}`;
            });

            const text = header.textContent.trim().replace(/[↑↓]/g, '').trim();
            const arrow = newOrder === "asc"
                ? `<span style="color: inherit;">↑</span><span style="color: gray;">↓</span>`
                : `<span style="color: gray;">↑</span><span style="color: inherit;">↓</span>`;
            // ? "↑" : "↓";
            header.setAttribute("data-order", newOrder);
            header.innerHTML = `${arrow} ${text}`;

            fetchData({ sort, order: newOrder, page: 1 });
        });
    });
}

// saves changes applied to the data table
function saveTableState() {
    // Save to URL
    const url = new URL(window.location.href);
    Object.entries(tableState).forEach(([key, value]) => {
        url.searchParams.set(key, value);
    });
    history.replaceState(null, '', url);

    // Save to sessionStorage
    sessionStorage.setItem('tableState', JSON.stringify(tableState));
}

// restores saved table state if any
function updatePerPageSelect() {
    const select = document.querySelector('#perPageSelect');
    if (select) select.value = tableState.perPage;
};
export function restoreTableState() {
    const urlParams = new URLSearchParams(window.location.search);
    const saved = sessionStorage.getItem('tableState');

    let restored = {};

    // Try from sessionStorage first
    if (saved) {
        restored = JSON.parse(saved);
    }

    // Override from URL if present
    for (const [key, value] of urlParams.entries()) {
        restored[key] = value;
    }

    // Normalize types
    tableState = {
	    page : parseInt(restored.page || 1),
	    perPage : parseInt(restored.perPage || 10),
	    search : restored.search || '',
	    sort : restored.sort || '',
	    order : restored.order || '',
    };

    fetchData();
    tableInteractions();
    updatePerPageSelect
}
